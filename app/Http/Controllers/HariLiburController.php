<?php

namespace App\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HariLiburController extends Controller
{
    public function index(Request $request)
    {
        $tahunSaring = $request->get('tahun', date('Y'));

        $hariLibur = HariLibur::whereYear('tanggal', $tahunSaring)
            ->orderBy('tanggal', 'desc')
            ->paginate();

        return view('hari_libur.index', compact('hariLibur', 'tahunSaring'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'    => 'required|date|unique:hari_libur,tanggal',
            'keterangan' => 'required'
        ]);

        HariLibur::create($request->all());

        return back()->with('success', 'Hari libur ditambahkan.');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:hari_libur,id'
        ]);

        HariLibur::destroy($request->id);

        return back()->with('success', 'Hari libur berhasil dihapus.');
    }

    public function sync()
    {
        try {
            $tahun = date('Y');
            $response = Http::get("https://dayoffapi.vercel.app/api?year=$tahun");

            if ($response->failed()) {
                return back()->with('error', 'Gagal menghubungi server API. Pastikan ada koneksi internet.');
            }

            $data = $response->json();
            $count = 0;

            foreach ($data as $libur) {
                $tanggal = $libur['tanggal'];
                $keterangan = $libur['keterangan'];

                $exists = HariLibur::where('tanggal', $tanggal)->exists();
                if (!$exists) {
                    HariLibur::create([
                        'tanggal'    => $tanggal,
                        'keterangan' => $keterangan
                    ]);
                    $count++;
                }
            }

            return back()->with('success', "Sinkronisasi berhasil. $count hari libur baru ditambahkan untuk tahun $tahun.");
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
