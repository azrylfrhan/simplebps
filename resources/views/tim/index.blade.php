@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Manajemen Tim</h1>
            <p class="text-muted small mb-0">Kelola struktur tim internal dan tentukan penanggung jawab setiap Tim.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #004a69;">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Tim Baru
                    </h5>
                    <form action="{{ route('tim.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nama Tim</label>
                            <input type="text" class="form-control border-soft bg-light" name="nama_tim" placeholder="Contoh: Keuangan" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Ketua Tim</label>
                            <input type="text" class="form-control border-soft bg-light" name="ketua_tim" placeholder="Nama lengkap ketua tim...">
                        </div>
                        <button type="submit" class="btn fw-bold text-white w-100 shadow-sm" style="background-color: #004a69; border-radius: 10px;">
                            <i class="fas fa-save me-1"></i> Simpan Tim
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold" style="color: #004a69;"><i class="fas fa-list me-2"></i>Daftar Tim</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #f8f9fa; color: #004a69;">
                                <tr class="small text-uppercase fw-bold">
                                    <th class="ps-4 py-3">Nama Tim</th>
                                    <th>Ketua Tim</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tim as $t)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="icon-box me-3">
                                                <i class="fas fa-briefcase"></i>
                                            </div>
                                            <div class="fw-bold text-dark">{{ $t->nama_tim }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">
                                            <i class="fas fa-user-tie me-1 opacity-50"></i>
                                            {{ $t->ketua_tim ?? 'Belum Ditentukan' }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm rounded-3 overflow-hidden border">
                                            <button class="btn btn-white btn-sm px-3 border-end" data-bs-toggle="modal" data-bs-target="#editModal-{{ $t->id }}" title="Edit">
                                                <i class="fas fa-edit text-warning"></i>
                                            </button>
                                            <form action="{{ route('tim.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus tim {{ $t->nama_tim }}? Pegawai di tim ini akan menjadi tanpa tim.');">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-white btn-sm px-3" title="Hapus">
                                                    <i class="fas fa-trash text-danger"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="editModal-{{ $t->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                            <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title fw-bold"><i class="fas fa-edit me-2"></i>Ubah Data Tim</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('tim.update', $t->id) }}" method="POST">
                                                @csrf @method('PUT')
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Tim</label>
                                                        <input type="text" name="nama_tim" value="{{ $t->nama_tim }}" class="form-control border-soft bg-light" required>
                                                    </div>
                                                    <div class="mb-0">
                                                        <label class="form-label small fw-bold text-muted text-uppercase">Ketua Tim</label>
                                                        <input type="text" name="ketua_tim" value="{{ $t->ketua_tim }}" class="form-control border-soft bg-light">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 p-4 pt-0">
                                                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <div class="py-3">
                                            <i class="fas fa-layer-group fa-3x mb-3 text-light"></i>
                                            <h6 class="text-muted fw-bold">Belum Ada Data Tim</h6>
                                            <p class="small text-muted">Silakan tambah Tim melalui form di samping.</p>
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
    </div>
</div>

<style>
    .icon-box {
        width: 35px; height: 35px; background-color: #e6f0f5; color: #004a69;
        border-radius: 8px; display: flex; align-items: center; justify-content: center;
        font-size: 0.9rem;
    }
    .border-soft { border: 1px solid #dee2e6; border-radius: 8px; }
    .btn-white { background-color: white; border: none; }
    .btn-white:hover { background-color: #f8f9fa; }
    .form-control:focus {
        border-color: #004a69;
        box-shadow: 0 0 0 0.2rem rgba(0, 74, 105, 0.15);
    }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }
</style>
@endsection
