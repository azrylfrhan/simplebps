@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Daftar Pengajuan SPKL</h1>
            <p class="text-muted small mb-0">Daftar lembur yang telah disetujui dan siap untuk dicetak sebagai dokumen SPKL.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="{{ route('cetak_spkl', ['bulan' => $bulan, 'tahun' => $tahun]) }}" target="_blank" class="btn fw-bold text-white shadow-sm px-4" style="background-color: #dc3545; border-radius: 10px;">
                <i class="fas fa-print me-2"></i> Cetak Dokumen SPKL
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="{{ route('daftar_spkl') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Bulan Pelaksanaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt" style="color: #004a69;"></i></span>
                        <select name="bulan" class="form-select border-0 bg-light fw-bold" style="color: #004a69;">
                            @foreach(range(1, 12) as $m)
                            <option value="{{ sprintf('%02d', $m) }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Tahun</label>
                    <input type="number" name="tahun" class="form-control border-0 bg-light fw-bold" style="color: #004a69;" value="{{ $tahun }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-light w-100 fw-bold border" style="border-radius: 10px; color: #004a69;">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3" width="5%">No</th>
                            <th width="30%">Nama Pegawai</th>
                            <th class="text-center" width="20%">Tanggal Pelaksanaan</th>
                            <th>Maksud Lembur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataSpkl as $i => $s)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">{{ $i+1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box-sm me-3">
                                        {{ strtoupper(substr($s->pegawai->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-dark">{{ $s->pegawai->nama_lengkap }}</div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge px-3 py-2" style="background-color: #e6f0f5; color: #004a69; border-radius: 8px;">
                                    <i class="far fa-calendar-check me-1"></i>
                                    {{ \Carbon\Carbon::parse($s->tanggal)->locale('id')->translatedFormat('d F Y') }}
                                </span>
                            </td>
                            <td>
                                <div class="text-muted small" style="line-height: 1.5;">
                                    {!! nl2br(e($s->maksud_lembur)) !!}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-3">
                                    <i class="fas fa-file-invoice fa-3x mb-3" style="color: #dee2e6;"></i>
                                    <h6 class="text-muted">Tidak ada data pengajuan yang disetujui untuk periode ini.</h6>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-box-sm {
        width: 32px; height: 32px; background-color: #004a69; color: white;
        border-radius: 6px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.8rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }
    .form-select:focus, .form-control:focus {
        border: 1px solid #004a69 !important;
        box-shadow: none;
    }
</style>
@endsection
