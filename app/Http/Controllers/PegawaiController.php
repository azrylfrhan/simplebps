<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Tim;
use App\Exports\PegawaiTemplateExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            $pegawai = Pegawai::with('tim')->orderBy('nama_lengkap')->get();
            $tim = Tim::all();
        } else {
            $pegawai = Pegawai::with('tim')->where('tim_id', $user->tim_id)->orderBy('nama_lengkap')->get();
            $tim = collect();
        }

        return view('pegawai.index', compact('pegawai', 'tim'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan'      => 'required|string|max:255',
            'tim_id'       => 'nullable|exists:tim,id',
        ]);

        Pegawai::create([
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan'      => $request->jabatan,
            'tim_id'       => $request->tim_id,
        ]);

        return back()->with('success', 'Data pegawai berhasil ditambahkan.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jabatan'      => 'required|string|max:255',
            'tim_id'       => 'nullable|exists:tim,id',
        ]);

        $pegawai = Pegawai::findOrFail($request->id);
        $pegawai->update([
            'nama_lengkap' => $request->nama_lengkap,
            'jabatan'      => $request->jabatan,
            'tim_id'       => $request->tim_id ?: null,
        ]);

        return back()->with('success', 'Data diperbarui.');
    }

    public function destroy(Request $request)
    {
        try {
            Pegawai::destroy($request->id);
            return back()->with('success', 'Pegawai dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus. Mungkin ada data lembur terkait.');
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new PegawaiTemplateExport, 'template_pegawai.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate(['file_excel' => 'required|mimes:xlsx,xls']);

        try {
            $laporan = [
                'berhasil' => 0,
                'gagal'    => 0,
                'total'    => 0
            ];

            Excel::import(new class($laporan) implements ToModel, WithHeadingRow {
                private $laporan;

                public function __construct(&$laporan)
                {
                    $this->laporan = &$laporan;
                }

                public function model(array $row)
                {
                    $this->laporan['total']++;

                    $nama = $row['nama_lengkap'] ?? null;
                    if (!$nama) return null;

                    if (Pegawai::where('nama_lengkap', $nama)->exists()) {
                        $this->laporan['gagal']++;
                        return null;
                    }

                    $user = Auth::user();
                    $timId = $user->tim_id;

                    if ($user->role == 'admin') {
                        $namaTim = $row['tim'] ?? '';
                        if (!empty($namaTim)) {
                            $tim = Tim::where('nama_tim', $namaTim)->first();
                            $timId = $tim ? $tim->id : null;
                        } else {
                            $timId = null;
                        }
                    }

                    $this->laporan['berhasil']++;

                    return new Pegawai([
                        'nama_lengkap' => $nama,
                        'jabatan'      => $row['jabatan'] ?? '',
                        'tim_id'       => $timId
                    ]);
                }
            }, $request->file('file_excel'));

            $msg = "Import Selesai. Total: {$laporan['total']} baris. ";
            $msg .= "Berhasil disimpan: {$laporan['berhasil']}. ";
            $msg .= "Ditolak (Duplikat/Tim Salah): {$laporan['gagal']}.";

            $type = ($laporan['gagal'] > 0) ? 'warning' : 'success';

            return back()->with($type, $msg);
        } catch (\Exception $e) {
            return back()->with('error', 'Format file salah atau error system: ' . $e->getMessage());
        }
    }
}
