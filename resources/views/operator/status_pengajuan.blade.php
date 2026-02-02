@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Status Pengajuan Tim</h1>
            <p class="text-muted small mb-0">Daftar diurutkan dari yang paling baru diajukan.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="tabelStatusLembur">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3">Pegawai</th>
                            <th class="text-center">Tanggal Lembur</th>
                            <th class="text-center">Durasi (Jam)</th>
                            <th class="text-center">Status</th>
                            <th>Catatan Kabag</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengajuan as $p)
                            @php $needsAction = ($p->status == 'pending' && $p->catatan_verifikator); @endphp
                            <tr style="{{ $needsAction ? 'background-color: #fff9e6;' : '' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box-sm me-3">
                                            {{ strtoupper(substr($p->pegawai->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $p->pegawai->nama_lengkap }}</div>
                                            <div class="text-muted x-small">Diajukan: {{ $p->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{{ \Carbon\Carbon::parse($p->tanggal)->translatedFormat('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-light text-dark border fw-normal px-3">
                                        {{ $p->lama_jam_taksiran }} J
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($p->status == 'disetujui')
                                        <span class="badge bg-success px-3 py-2 rounded-pill">Disetujui</span>
                                    @elseif($p->status == 'ditolak')
                                        <span class="badge bg-danger px-3 py-2 rounded-pill">Ditolak</span>
                                    @else
                                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill">Menunggu</span>
                                    @endif
                                </td>
                                <td><span class="small text-muted italic">{{ Str::limit($p->catatan_verifikator ?? '-', 50) }}</span></td>
                                <td class="text-end pe-4">
                                    @if($p->status == 'ditolak' || $needsAction)
                                        <a href="{{ route('pengajuan.edit', $p->id) }}" class="btn btn-warning btn-sm fw-bold px-3 rounded-pill shadow-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @else
                                        <i class="fas fa-lock text-muted opacity-25"></i>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-5">Belum ada pengajuan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .avatar-box-sm {
        width: 35px; height: 35px; background-color: #004a69; color: white;
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.85rem;
    }
    .x-small { font-size: 0.7rem; }
    .italic { font-style: italic; }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        if ($.fn.DataTable) {
            $('#tabelStatusLembur').DataTable({
                "ordering": false,
                "pageLength": 10,
                "language": {
                    "search": "Cari Pegawai:",
                    "zeroRecords": "Data tidak ditemukan"
                }
            });
        }
    });
</script>
@endpush
@endsection
