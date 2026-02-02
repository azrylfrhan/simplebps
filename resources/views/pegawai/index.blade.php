@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Kelola Pegawai</h1>
            <p class="text-muted small mb-0">Manajemen Data Pegawai</p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #0dcaf0; border:none; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-2"></i> Import Excel
            </button>
            <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #004a69; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fas fa-user-plus me-2"></i> Tambah Pegawai
            </button>
        </div>
    </div>

    {{-- TABEL DAFTAR PEGAWAI --}}
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-bold" style="color: #004a69;"><i class="fas fa-users me-2"></i>Daftar Pegawai Terdaftar</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3">Informasi Pegawai</th>
                            <th>Jabatan</th>
                            <th>Tim</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawai as $p)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box-sm me-3">
                                            {{ strtoupper(substr($p->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <div class="fw-bold text-dark">{{ $p->nama_lengkap }}</div>
                                    </div>
                                </td>
                                <td><span class="small text-muted">{{ $p->jabatan }}</span></td>
                                <td>
                                    @if($p->tim_id)
                                        <span class="badge px-3 py-2 rounded-pill" style="background-color: #e6f0f5; color: #004a69;">
                                            <i class="fas fa-tag me-1 small"></i> {{ $p->tim->nama_tim }}
                                        </span>
                                    @else
                                        <span class="badge px-3 py-2 rounded-pill bg-light text-muted border">Pimpinan</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                        <button class="btn btn-white btn-sm px-3 border-end" data-bs-toggle="modal" data-bs-target="#editModal-{{ $p->id }}" title="Ubah Data">
                                            <i class="fas fa-edit text-warning"></i>
                                        </button>
                                        <button class="btn btn-white btn-sm px-3" data-bs-toggle="modal" data-bs-target="#hapusModal-{{ $p->id }}" title="Hapus">
                                            <i class="fas fa-trash text-danger"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-friends fa-3x mb-3 opacity-25"></i>
                                    <h6>Belum ada data pegawai.</h6>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-plus me-2"></i>Tambah Pegawai Manual</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('pegawai.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                        <input type="text" class="form-control border-soft bg-light" name="nama_lengkap" placeholder="Nama Lengkap & Gelar" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Jabatan</label>
                        <input type="text" class="form-control border-soft bg-light" name="jabatan" placeholder="Contoh: Pranata Komputer Ahli Pertama" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted text-uppercase">Penempatan Tim</label>
                        <select name="tim_id" class="form-select border-soft bg-light">
                            <option value="">-- Tanpa Tim (Pimpinan) --</option>
                            @foreach($tim as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_tim }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">Simpan Pegawai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0 py-3 text-white" style="background-color: #0dcaf0; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-import me-2"></i>Import Massal via Excel</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-3">1. Unduh Format</label>
                    <a href="{{ route('pegawai.template') }}" class="btn btn-outline-success w-100 fw-bold" style="border-radius: 10px; border-style: dashed;">
                        <i class="fas fa-download me-2"></i> Download Template Pegawai.xlsx
                    </a>
                </div>
                <hr>
                <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-3">2. Unggah File</label>
                        <input class="form-control border-soft py-2" type="file" name="file_excel" required accept=".xlsx, .xls">
                    </div>
                    <div class="modal-footer border-0 p-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-info rounded-pill px-5 fw-bold text-white shadow-sm">Mulai Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($pegawai as $p)
    <div class="modal fade" id="editModal-{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">Edit Pegawai</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('pegawai.update') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <input type="hidden" name="id" value="{{ $p->id }}">
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nama Lengkap</label>
                            <input type="text" class="form-control border-soft bg-light" name="nama_lengkap" value="{{ $p->nama_lengkap }}" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Jabatan</label>
                            <input type="text" class="form-control border-soft bg-light" name="jabatan" value="{{ $p->jabatan }}" required>
                        </div>
                        <div class="mb-0">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tim</label>
                            <select class="form-select border-soft bg-light" name="tim_id">
                                <option value="">-- Pimpinan --</option>
                                @foreach($tim as $t)
                                    <option value="{{ $t->id }}" {{ $t->id == $p->tim_id ? 'selected' : '' }}>{{ $t->nama_tim }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="hapusModal-{{ $p->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-body p-4 text-center">
                    <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
                    <p class="mb-4 small">Hapus data <b>{{ $p->nama_lengkap }}</b>?</p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 rounded-pill" data-bs-dismiss="modal">Batal</button>
                        <form action="{{ route('pegawai.delete') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="id" value="{{ $p->id }}">
                            <button type="submit" class="btn btn-danger w-100 rounded-pill">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

<style>
    .avatar-box-sm {
        width: 38px; height: 38px; background-color: #004a69; color: white;
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.9rem;
    }
    .border-soft { border: 1px solid #dee2e6; border-radius: 10px; }
    .btn-white { background-color: white; border: none; }
    .btn-white:hover { background-color: #f8f9fa; }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }
</style>
@endsection
