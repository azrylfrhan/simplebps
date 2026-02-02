@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold" style="color: #004a69;">Riwayat Verifikasi</h1>
            <p class="text-muted small mb-0">Tinjau kembali rekam jejak persetujuan dan penolakan lembur pegawai.</p>
        </div>
        @if(request('bulan') && request('tahun'))
        <div class="badge px-4 py-2 rounded-pill shadow-sm" style="background-color: rgba(0, 74, 105, 0.1); color: #004a69;">
            <i class="fas fa-history me-2"></i> {{ count($riwayat) }} Data Ditemukan
        </div>
        @endif
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-header bg-white py-3" style="border-radius: 15px 15px 0 0;">
            <h6 class="m-0 fw-bold" style="color: #004a69;"><i class="fas fa-filter me-2"></i>Filter Riwayat Lembur</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('verifikasi.riwayat') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Pilih Bulan</label>
                    <select name="bulan" class="form-select border-soft" required>
                        <option value="">-- Pilih Bulan --</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Pilih Tahun</label>
                    <select name="tahun" class="form-select border-soft" required>
                        <option value="">-- Pilih Tahun --</option>
                        @foreach($daftarTahun as $t)
                            <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn fw-bold text-white w-100 shadow-sm" style="background-color: #004a69; border-radius: 10px;">
                        <i class="fas fa-search me-1"></i> Tampilkan Riwayat
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(request('bulan') && request('tahun'))
    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3">Pegawai</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Durasi</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $r)
                            @php
                                $tanggalLembur = \Carbon\Carbon::parse($r->tanggal);
                                $sekarang = \Carbon\Carbon::now();
                                $belumLewatDuaHari = $sekarang->diffInDays($tanggalLembur, false) >= -2;
                                $isBulanBerjalan = $tanggalLembur->isCurrentMonth() && $tanggalLembur->isCurrentYear();
                                $bolehBatal = ($r->status == 'disetujui') && $belumLewatDuaHari && $isBulanBerjalan;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box me-3">
                                            {{ strtoupper(substr($r->pegawai->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">{{ $r->pegawai->nama_lengkap }}</div>
                                            <div class="text-muted x-small fw-bold text-uppercase">{{ $r->pegawai->tim->nama_tim ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="date-badge">
                                        <div class="date-day">{{ $tanggalLembur->format('d') }}</div>
                                        <div class="date-month">{{ $tanggalLembur->locale('id')->translatedFormat('M Y') }}</div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill px-3 py-2" style="background-color: #e6f0f5; color: #004a69;">
                                        {{ $r->lama_jam_disetujui }} Jam
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($r->status == 'disetujui')
                                        <span class="badge bg-success px-3 py-2 rounded-pill text-white"><i class="fas fa-check-circle me-1"></i> Disetujui</span>
                                    @elseif($r->status == 'ditolak')
                                        <span class="badge bg-danger px-3 py-2 rounded-pill text-white"><i class="fas fa-times-circle me-1"></i> Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill"><i class="fas fa-clock me-1"></i> Pending</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                        <button class="btn btn-white btn-sm px-3 border-end" data-bs-toggle="collapse" data-bs-target="#detail{{ $r->id }}" title="Lihat Detail">
                                            <i class="fas fa-eye" style="color: #004a69;"></i>
                                        </button>

                                        @if($r->status == 'disetujui')
                                            @if($bolehBatal)
                                                <button class="btn btn-white btn-sm px-3" data-bs-toggle="modal" data-bs-target="#modalBatal{{ $r->id }}" title="Batalkan Persetujuan">
                                                    <i class="fas fa-undo text-warning"></i>
                                                </button>
                                            @else
                                                <button class="btn btn-white btn-sm px-3 disabled" title="Masa pembatalan berakhir">
                                                    <i class="fas fa-undo text-muted"></i>
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            <tr class="collapse" id="detail{{ $r->id }}">
                                <td colspan="5" class="p-0 border-0">
                                    <div class="p-4 bg-light border-start border-4" style="border-color: #004a69 !important;">
                                        <div class="row g-4">
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-2" style="color: #004a69;">Maksud Lembur</h6>
                                                <p class="text-muted small mb-0">{{ $r->maksud_lembur ?? 'Tidak ada deskripsi.' }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 class="fw-bold mb-2" style="color: #004a69;">Catatan Verifikator</h6>
                                                <p class="text-muted small mb-0">{{ $r->catatan_verifikator ?? 'Tidak ada catatan.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            @if($bolehBatal)
                            <div class="modal fade" id="modalBatal{{ $r->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <form action="{{ route('verifikasi.batalkan', $r->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-undo-alt me-2"></i>Batalkan Persetujuan</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <p>Apakah Anda yakin ingin membatalkan persetujuan lembur untuk <strong>{{ $r->pegawai->nama_lengkap }}</strong>?</p>
                                                <div class="mb-3">
                                                    <label class="form-label fw-bold small text-uppercase" style="color: #004a69;">Alasan Pembatalan</label>
                                                    <textarea name="alasan" class="form-control border-soft" rows="3" required placeholder="Tuliskan alasan pembatalan..."></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-0 p-4 pt-0">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold shadow-sm">Ya, Batalkan</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @endif
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <i class="fas fa-folder-open fa-4x mb-3" style="color: #dee2e6;"></i>
                                    <h6 class="text-muted fw-bold">Data tidak ditemukan</h6>
                                    <p class="small text-muted">Tidak ada riwayat verifikasi untuk periode yang dipilih.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @else
    {{-- Tampilan saat belum pilih periode --}}
    <div class="text-center py-5 shadow-sm bg-white" style="border-radius: 15px;">
        <i class="fas fa-calendar-alt fa-5x mb-4" style="color: #e9ecef;"></i>
        <h5 class="fw-bold" style="color: #004a69;">Pilih Periode Riwayat</h5>
        <p class="text-muted">Silakan tentukan bulan dan tahun untuk menampilkan data riwayat verifikasi.</p>
    </div>
    @endif
</div>

<style>
    .avatar-box {
        width: 38px; height: 38px; background-color: #004a69; color: white;
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.9rem;
    }
    .date-badge {
        background-color: #f0f4f7; border: 1px solid #d1dee5; border-radius: 10px; padding: 5px 10px; display: inline-block;
    }
    .date-day { font-size: 1.1rem; font-weight: 800; color: #004a69; line-height: 1; }
    .date-month { font-size: 0.65rem; color: #5a7d8e; text-transform: uppercase; font-weight: bold; }
    .x-small { font-size: 0.7rem; }
    .btn-white { background-color: white; border: none; }
    .btn-white:hover { background-color: #f8f9fa; }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }
    .border-soft { border: 1px solid #dee2e6; border-radius: 8px; }
</style>
@endsection
