<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Pegawai;
use App\Models\PengajuanLembur;
use App\Models\HariLibur;
use App\Models\Konfigurasi;
use App\Exports\PresensiTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class LemburController extends Controller
{
    private function hitungDurasi($tanggal, $jamMulai, $jamSelesai, $hariLibur)
    {
        $date = Carbon::parse($tanggal);
        $isLibur = in_array($tanggal, $hariLibur);
        $isWeekend = $date->isWeekend();
        $day = $date->dayOfWeek;

        $start = Carbon::parse($tanggal . ' ' . $jamMulai);
        $end = Carbon::parse($tanggal . ' ' . $jamSelesai);

        $threshold = null;
        if (!$isLibur && !$isWeekend) {
            if ($day >= 1 && $day <= 4) {
                $threshold = Carbon::parse($tanggal . ' 16:00:00');
            } elseif ($day == 5) {
                $threshold = Carbon::parse($tanggal . ' 16:30:00');
            }
        }

        if ($threshold && $start->lt($threshold)) {
            $start = $threshold;
        }

        if ($end->gt($start)) {
            $diff = $end->diff($start);
            return $diff->format('%H:%I:%S');
        }

        return '00:00:00';
    }

    public function index()
    {
        $user = Auth::user();
        $timSdm = \App\Models\Tim::where('nama_tim', 'LIKE', '%SDM%')
                    ->orWhere('nama_tim', 'LIKE', '%Kepegawaian%')
                    ->first();

        $idTimSdm = $timSdm ? $timSdm->id : null;

        if ($user->tim_id == $idTimSdm && !is_null($idTimSdm)) {
            $pegawai = Pegawai::where('tim_id', $idTimSdm)
                ->orWhereNull('tim_id')
                ->orderBy('nama_lengkap')
                ->get();
        } else {
            $pegawai = Pegawai::where('tim_id', $user->tim_id)
                ->orderBy('nama_lengkap')
                ->get();
        }

        $hariLibur = HariLibur::pluck('tanggal')->toArray();

        return view('lembur.input', compact('pegawai', 'hariLibur'));
    }

    public function storePengajuan(Request $request)
    {
        $request->validate([
            'pegawai_id'    => 'required|exists:pegawai,id',
            'tanggal'       => 'required|date',
            'lama_jam'      => 'required|numeric|min:1|max:8',
            'maksud_lembur' => 'required|string'
        ]);

        $user = Auth::user();
        $pegawaiDibidik = Pegawai::findOrFail($request->pegawai_id);

        $isPimpinanAtauKabag = is_null($pegawaiDibidik->tim_id) || str_contains(strtolower($pegawaiDibidik->jabatan), 'kepala bagian');

        $status = $isPimpinanAtauKabag ? 'disetujui' : 'pending';
        $isReadKabag = $isPimpinanAtauKabag ? true : false;

        PengajuanLembur::create([
            'pegawai_id'         => $request->pegawai_id,
            'tanggal'            => $request->tanggal,
            'lama_jam_taksiran'  => $request->lama_jam,
            'lama_jam_disetujui' => $isPimpinanAtauKabag ? $request->lama_jam : null,
            'maksud_lembur'      => $request->maksud_lembur,
            'status'             => $status,
            'dibuat_oleh'        => $user->id,
            'is_read_kabag'      => $isReadKabag,
            'is_read_operator'   => true
        ]);

        $pesan = $isPimpinanAtauKabag
            ? 'Data lembur Pimpinan/Kabag berhasil disimpan otomatis.'
            : 'Pengajuan lembur anggota tim berhasil dikirim dan menunggu verifikasi.';

        return back()->with('success', $pesan);
    }

    public function statusPengajuan()
    {
        $user = Auth::user();

        PengajuanLembur::whereHas('pegawai', function ($q) use ($user) {
            $q->where('tim_id', $user->tim_id);
        })
            ->whereIn('status', ['disetujui', 'ditolak'])
            ->where('is_read_operator', false)
            ->update(['is_read_operator' => true]);

        $pengajuan = PengajuanLembur::with('pegawai')
            ->whereHas('pegawai', function ($q) use ($user) {
                $q->where('tim_id', $user->tim_id);
            })
            ->latest()
            ->get();

        return view('operator.status_pengajuan', compact('pengajuan'));
    }

    public function editPengajuan($id)
    {
        $pengajuan = PengajuanLembur::with('pegawai')->findOrFail($id);

        if ($pengajuan->status !== 'ditolak' || $pengajuan->pegawai->tim_id !== Auth::user()->tim_id) {
            return redirect()->route('status_pengajuan')->with('error', 'Akses ditolak.');
        }

        return view('operator.edit_pengajuan', compact('pengajuan'));
    }

    public function updatePengajuan(Request $request, $id)
    {
        $request->validate([
            'tanggal'           => 'required|date',
            'lama_jam_taksiran' => 'required|integer|min:1',
            'maksud_lembur'     => 'required|string|max:255'
        ]);

        $pengajuan = PengajuanLembur::findOrFail($id);

        if ($pengajuan->pegawai->tim_id !== Auth::user()->tim_id || $pengajuan->status !== 'ditolak') {
            return redirect()->route('status_pengajuan')->with('error', 'Akses ilegal.');
        }

        $pengajuan->update([
            'tanggal'             => $request->tanggal,
            'lama_jam_taksiran'   => $request->lama_jam_taksiran,
            'maksud_lembur'       => $request->maksud_lembur,
            'status'              => 'pending',
            'catatan_verifikator' => null,
            'is_read_kabag'       => false
        ]);

        return redirect()->route('status_pengajuan')->with('success', 'Pengajuan berhasil diperbaiki.');
    }

    public function daftarSpkl(Request $request)
    {
        PengajuanLembur::where('status', 'disetujui')->update(['is_read_admin' => true]);

        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $dataSpkl = PengajuanLembur::with('pegawai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'disetujui')
            ->orderBy('tanggal', 'asc')
            ->get();

        return view('lembur.daftar_spkl', compact('dataSpkl', 'bulan', 'tahun'));
    }

    public function cetakSpkl(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));

        $pengajuan = PengajuanLembur::with('pegawai')
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->where('status', 'disetujui')
            ->orderBy('tanggal', 'asc')
            ->get();

        $grouped = [];
        foreach ($pengajuan as $item) {
            $nama = $item->pegawai->nama_lengkap;
            $maksud = $item->maksud_lembur;
            $tgl = Carbon::parse($item->tanggal)->format('d');

            if (!isset($grouped[$nama])) {
                $grouped[$nama] = [
                    'jabatan'     => $item->pegawai->jabatan,
                    'data_lembur' => []
                ];
            }

            if (!isset($grouped[$nama]['data_lembur'][$maksud])) {
                $grouped[$nama]['data_lembur'][$maksud] = [];
            }
            $grouped[$nama]['data_lembur'][$maksud][] = $tgl;
        }

        $config = Konfigurasi::pluck('value', 'key')->toArray();

        return view('cetak.spkl', [
            'grouped'     => $grouped,
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'nomorSpkl'   => $request->get('nomor_spkl', 'SPKL-' . $bulan . '/KP.300/' . $tahun),
            'tempat'      => $config['tempat_ttd'] ?? 'Manado',
            'tanggal_ttd' => $config['tgl_spkl_manual'] ?? Carbon::now()->locale('id')->translatedFormat('d F Y'),
            'jabatan_ttd' => $config['jabatan_spkl'] ?? 'Kuasa Pengguna Anggaran',
            'nama_ttd'    => $config['nama_spkl'] ?? 'Nama Pejabat KPA',
        ]);
    }

    public function downloadTemplate()
    {
        return Excel::download(new PresensiTemplateExport, 'template_presensi_lembur.xlsx');
    }

    public function importPresensi(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls,csv']);

        try {
            $data = Excel::toCollection(new class {}, $request->file('file_excel'))[0];
            $berhasil = 0;
            $errors = [];

            foreach ($data as $index => $row) {
                if ($index == 0) continue;
                $barisKe = $index + 1;
                $namaExcel = trim($row[0]);
                if (empty($namaExcel)) continue;

                $pegawai = Pegawai::where('nama_lengkap', $namaExcel)->first();
                if (!$pegawai) {
                    $errors[] = "Baris $barisKe: Nama '$namaExcel' tidak ditemukan.";
                    continue;
                }

                try {
                    if (is_numeric($row[1])) {
                        $tanggal = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1]))->format('Y-m-d');
                    } else {
                        $tanggal = Carbon::createFromFormat('d/m/Y', $row[1])->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $errors[] = "Baris $barisKe: Format tanggal salah.";
                    continue;
                }

                try {
                    $jamMulai = is_numeric($row[2]) ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[2]))->format('H:i:s') : trim($row[2]);
                    $jamSelesai = is_numeric($row[3]) ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3]))->format('H:i:s') : trim($row[3]);
                } catch (\Exception $e) {
                    $errors[] = "Baris $barisKe: Format jam tidak valid.";
                    continue;
                }

                $ajuan = PengajuanLembur::where('pegawai_id', $pegawai->id)
                    ->where('tanggal', $tanggal)
                    ->where('status', 'disetujui')
                    ->first();

                if (!$ajuan) {
                    $errors[] = "Baris $barisKe: Tidak ada pengajuan 'Disetujui' untuk $namaExcel pada " . Carbon::parse($tanggal)->format('d/m/Y') . ".";
                    continue;
                }

                Lembur::updateOrCreate(
                    ['pegawai_id' => $pegawai->id, 'tanggal' => $tanggal],
                    [
                        'jam_mulai'     => $jamMulai,
                        'jam_selesai'   => $jamSelesai,
                        'maksud_lembur' => $ajuan->maksud_lembur,
                        'dibuat_oleh'   => Auth::id()
                    ]
                );
                $berhasil++;
            }

            $res = "Import selesai. $berhasil data diproses.";
            if (count($errors) > 0) {
                return redirect()->route('rekap_presensi')->with('success', $res)->with('import_errors', $errors);
            }
            return redirect()->route('rekap_presensi')->with('success', $res);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    private function sesuaikanJamMulai($tanggal, $jamMulai, $hariLibur)
    {
        $date = Carbon::parse($tanggal);
        $isLibur = in_array($tanggal, $hariLibur);
        $isWeekend = $date->isWeekend();
        $day = $date->dayOfWeek;

        $start = Carbon::parse($tanggal . ' ' . $jamMulai);

        if (!$isLibur && !$isWeekend) {
            if ($day >= 1 && $day <= 4) {
                $threshold = Carbon::parse($tanggal . ' 16:00:01');
                return ($start->lt($threshold)) ? '16:00:01' : $jamMulai;
            } elseif ($day == 5) {
                $threshold = Carbon::parse($tanggal . ' 16:30:01');
                return ($start->lt($threshold)) ? '16:30:01' : $jamMulai;
            }
        }
        return $jamMulai;
    }

    public function rekap(Request $request)
    {
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $hariLibur = HariLibur::pluck('tanggal')->toArray();

        $dataLembur = Lembur::with(['pegawai'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        foreach ($dataLembur as $item) {
            $item->jam_mulai_tampil = $this->sesuaikanJamMulai($item->tanggal, $item->jam_mulai, $hariLibur);
            $item->durasi_hitung = $this->hitungDurasi($item->tanggal, $item->jam_mulai, $item->jam_selesai, $hariLibur);
        }

        return view('lembur.rekap_presensi', compact('dataLembur', 'bulan', 'tahun', 'hariLibur'));
    }

    public function cetakRekap(Request $request)
    {
        $bulan = (int) $request->get('bulan', date('m'));
        $tahun = (int) $request->get('tahun', date('Y'));
        $hariLibur = HariLibur::pluck('tanggal')->toArray();

        $dataLemburRaw = Lembur::with(['pegawai'])
            ->whereMonth('tanggal', $bulan)
            ->whereYear('tanggal', $tahun)
            ->orderBy('pegawai_id', 'asc')
            ->orderBy('tanggal', 'asc')
            ->get();

        $groupedData = [];
        foreach ($dataLemburRaw as $item) {
            $item->jam_mulai_tampil = $this->sesuaikanJamMulai($item->tanggal, $item->jam_mulai, $hariLibur);
            $item->durasi_hitung = $this->hitungDurasi($item->tanggal, $item->jam_mulai, $item->jam_selesai, $hariLibur);

            $nama = $item->pegawai->nama_lengkap;
            $groupedData[$nama][] = $item;
        }

        $config = Konfigurasi::pluck('value', 'key')->toArray();

        return view('cetak.rekap_presensi_doc', [
            'groupedData' => $groupedData,
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'tempat'      => $config['tempat_ttd'] ?? 'Manado',
            'tanggal_ttd' => $config['tgl_rekap_manual'] ?? Carbon::now()->locale('id')->translatedFormat('d F Y'),
            'jabatan_ttd' => $config['jabatan_rekap'] ?? 'Ketua Tim SDM',
            'nama_ttd'    => $config['nama_rekap'] ?? 'Nama Pejabat',
        ]);
    }
}
