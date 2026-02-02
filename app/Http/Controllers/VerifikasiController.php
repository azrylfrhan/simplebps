<?php

namespace App\Http\Controllers;

use App\Models\PengajuanLembur;
use Illuminate\Http\Request;

class VerifikasiController extends Controller
{
    public function index()
    {
        PengajuanLembur::where('status', 'pending')->update(['is_read_kabag' => true]);

        $pengajuan = PengajuanLembur::with(['pegawai.tim'])
            ->where('status', 'pending')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('verifikasi.index', compact('pengajuan'));
    }

    public function proses(Request $request)
    {
        $request->validate([
            'id'                 => 'required|exists:pengajuan_lembur,id',
            'aksi'               => 'required|in:disetujui,ditolak',
            'lama_jam_disetujui' => 'required_if:aksi,disetujui'
        ]);

        $p = PengajuanLembur::findOrFail($request->id);

        $p->update([
            'status'              => $request->aksi,
            'lama_jam_disetujui'  => $request->aksi == 'disetujui' ? $request->lama_jam_disetujui : null,
            'catatan_verifikator' => $request->catatan_verifikator,
            'is_read_operator'    => false,
        ]);

        return back()->with('success', 'Pengajuan berhasil diproses.');
    }

    public function riwayat(Request $request)
    {
        $bulan = $request->get('bulan');
        $tahun = $request->get('tahun');

        $query = PengajuanLembur::with(['pegawai.tim'])
            ->whereIn('status', ['disetujui', 'ditolak']);

        if ($bulan && $tahun) {
            $query->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun);
            $riwayat = $query->orderBy('updated_at', 'desc')->get();
        } else {
            $riwayat = collect();
        }

        $daftarTahun = PengajuanLembur::selectRaw('YEAR(tanggal) as tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('verifikasi.riwayat', compact('riwayat', 'bulan', 'tahun', 'daftarTahun'));
    }

    public function batalkanPersetujuan(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|max:255'
        ]);

        $pengajuan = PengajuanLembur::findOrFail($id);

        $pengajuan->update([
            'status'              => 'pending',
            'catatan_verifikator' => $request->alasan,
            'is_read_operator'    => false,
        ]);

        return back()->with('success', 'Persetujuan berhasil dibatalkan.');
    }
}
