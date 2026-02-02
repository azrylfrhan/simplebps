<?php

namespace App\Http\Controllers;

use App\Models\Lembur;
use App\Models\Pegawai;
use App\Models\PengajuanLembur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $year = $request->get('tahun', date('Y'));
        $statsTim = ['pending' => 0, 'disetujui' => 0, 'ditolak' => 0];

        if ($user->role == 'admin' || $user->role == 'kabag') {
            $totalPegawai = Pegawai::count();
            $namaLengkap = ($user->role == 'admin') ? "Administrator" : ($user->pegawai->nama_lengkap ?? "Kepala Bagian");
            $chart1Title = "Jumlah Pegawai yang Lembur (Orang)";
            $chart1Select = DB::raw('COUNT(DISTINCT pegawai_id) as total');
        } else {
            $totalPegawai = Pegawai::where('tim_id', $user->tim_id)->count();
            $namaLengkap = $user->tim->ketua_tim ?? $user->username;
            $chart1Title = "Intensitas/Frekuensi Lembur Tim (Kali)";
            $chart1Select = DB::raw('COUNT(id) as total');

            $statsTim['pending'] = PengajuanLembur::where('status', 'pending')
                ->whereHas('pegawai', function ($q) use ($user) {
                    $q->where('tim_id', $user->tim_id);
                })->count();

            $statsTim['disetujui'] = PengajuanLembur::where('status', 'disetujui')
                ->whereHas('pegawai', function ($q) use ($user) {
                    $q->where('tim_id', $user->tim_id);
                })->count();

            $statsTim['ditolak'] = PengajuanLembur::where('status', 'ditolak')
                ->whereHas('pegawai', function ($q) use ($user) {
                    $q->where('tim_id', $user->tim_id);
                })->count();
        }

        $chartQuery = Lembur::select(DB::raw('MONTH(tanggal) as bulan'), $chart1Select)
            ->whereYear('tanggal', $year);

        if ($user->role == 'operator') {
            $chartQuery->whereHas('pegawai', function ($q) use ($user) {
                $q->where('tim_id', $user->tim_id);
            });
        }

        $monthlyData = $chartQuery->groupBy('bulan')->pluck('total', 'bulan')->toArray();
        $dataBar = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataBar[] = $monthlyData[$i] ?? 0;
        }

        $labelPie = [];
        $dataPie = [];
        $judulChart2 = "";

        if ($user->role == 'admin' || $user->role == 'kabag') {
            $judulChart2 = "Distribusi Lembur per Tim";
            $timStats = DB::table('lembur')
                ->join('pegawai', 'lembur.pegawai_id', '=', 'pegawai.id')
                ->join('tim', 'pegawai.tim_id', '=', 'tim.id')
                ->select('tim.nama_tim', DB::raw('count(lembur.id) as total'))
                ->whereYear('lembur.tanggal', $year)
                ->groupBy('tim.nama_tim')
                ->get();

            foreach ($timStats as $stat) {
                $labelPie[] = $stat->nama_tim;
                $dataPie[] = $stat->total;
            }
        } else {
            $judulChart2 = "Top 5 Pegawai Lembur Tim";
            $topPegawai = Lembur::with('pegawai')
                ->whereYear('tanggal', $year)
                ->whereHas('pegawai', function ($q) use ($user) {
                    $q->where('tim_id', $user->tim_id);
                })
                ->select('pegawai_id', DB::raw('count(*) as total'))
                ->groupBy('pegawai_id')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            foreach ($topPegawai as $p) {
                $labelPie[] = $p->pegawai->nama_lengkap ?? 'Pegawai';
                $dataPie[] = $p->total;
            }
        }

        $pengajuanPending = PengajuanLembur::where('status', 'pending')->count();
        $terbaru = PengajuanLembur::with('pegawai')
            ->where('status', 'pending')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalPegawai', 'year', 'dataBar', 'labelPie', 'dataPie',
            'judulChart2', 'namaLengkap', 'chart1Title', 'pengajuanPending',
            'terbaru', 'statsTim'
        ));
    }

    public function riwayatVerifikasi(Request $request)
    {
        $user = Auth::user();
        $bulan = $request->get('bulan', date('m'));
        $tahun = $request->get('tahun', date('Y'));

        $pengajuanPending = PengajuanLembur::where('status', 'pending')->count();
        $terbaru = PengajuanLembur::with(['pegawai.tim'])
            ->where('status', 'pending')
            ->orderBy('updated_at', 'desc')
            ->limit(5)
            ->get();

        return view('verifikasi.riwayat', compact('terbaru', 'pengajuanPending', 'bulan', 'tahun'));
    }
}
