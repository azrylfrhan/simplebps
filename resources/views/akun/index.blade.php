@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold" style="color: #004a69;">Manajemen Akun</h1>
            <p class="text-muted small mb-0">Kelola hak akses pengguna, role sistem, dan pengaturan kata sandi.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #004a69; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="fas fa-plus-circle me-2"></i> Tambah Akun Baru
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3">Username</th>
                            <th>Role Akses</th>
                            <th>Tim</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $u->username }}</div>
                            </td>
                            <td>
                                @php
                                    $roleColor = [
                                        'admin' => '#004a69',
                                        'kabag' => '#6610f2',
                                        'operator' => '#0dcaf0'
                                    ];
                                @endphp
                                <span class="badge px-3 py-2 rounded-pill text-uppercase" style="background-color: {{ $roleColor[$u->role] ?? '#6c757d' }}; font-size: 0.65rem;">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td>
                                <div class="small fw-medium {{ $u->tim ? 'text-dark' : 'text-muted italic' }}">
                                    {{ $u->tim->nama_tim ?? 'Tidak Terikat Tim' }}
                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <button class="btn btn-white btn-sm px-3 border shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#editModal{{ $u->id }}">
                                        <i class="fas fa-edit me-1 text-primary"></i> Edit
                                    </button>

                                    <form action="{{ route('akun.reset') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $u->id }}">
                                        <button type="submit" class="btn btn-white btn-sm px-3 border shadow-sm rounded-pill">
                                            <i class="fas fa-sync-alt me-1 text-warning"></i> Reset
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $u->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <form action="{{ route('akun.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                                        <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                                            <h5 class="modal-title fw-bold">Edit Akun</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4 text-start">
                                            <input type="hidden" name="id" value="{{ $u->id }}">
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                                                <input type="text" name="username" class="form-control" value="{{ $u->username }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label small fw-bold text-muted text-uppercase">Role</label>
                                                <select name="role" class="form-select role-select-edit" data-user-id="{{ $u->id }}" required>
                                                    <option value="operator" {{ $u->role == 'operator' ? 'selected' : '' }}>Ketua Tim (Operator)</option>
                                                    <option value="kabag" {{ $u->role == 'kabag' ? 'selected' : '' }}>Kepala Bagian Umum (Verifikator)</option>
                                                    <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Kepegawaian (Admin)</option>
                                                </select>
                                            </div>
                                            <div class="mb-0" id="tim-container-{{ $u->id }}" style="display: {{ $u->role == 'operator' ? 'block' : 'none' }};">
                                                <label class="form-label small fw-bold text-muted text-uppercase">Tim</label>
                                                <select name="tim_id" class="form-select">
                                                    <option value="">-- Pilih Tim --</option>
                                                    @foreach($tim as $t)
                                                        <option value="{{ $t->id }}" {{ $u->tim_id == $t->id ? 'selected' : '' }}>{{ $t->nama_tim }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 p-4 pt-0">
                                            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">Update Akun</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('akun.store') }}" method="POST">
            @csrf
            <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
                <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                    <h5 class="modal-title fw-bold">Tambah Akun Baru</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Silakan Diisi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Role</label>
                        <select name="role" id="role-tambah" class="form-select" required>
                            <option value="operator">Ketua Tim (Operator)</option>
                            <option value="kabag">Kepala Bagian Umum (Verifikator)</option>
                            <option value="admin">Kepegawaian (Admin)</option>
                        </select>
                    </div>
                    <div class="mb-0" id="tim-container-tambah">
                        <label class="form-label small fw-bold text-muted text-uppercase">Tim</label>
                        <select name="tim_id" class="form-select">
                            <option value="">-- Pilih Tim --</option>
                            @foreach($tim as $t)
                                <option value="{{ $t->id }}">{{ $t->nama_tim }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">Simpan Akun</button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    .btn-white { background-color: white; color: #6c757d; border: 1px solid #dee2e6 !important; transition: 0.2s; }
    .btn-white:hover { background-color: #f8f9fa; color: #004a69; border-color: #004a69 !important; }
    .italic { font-style: italic; }
</style>
@endsection

@push('scripts')
<script>
    document.getElementById('role-tambah').addEventListener('change', function() {
        document.getElementById('tim-container-tambah').style.display = (this.value === 'operator') ? 'block' : 'none';
    });

    document.querySelectorAll('.role-select-edit').forEach(select => {
        select.addEventListener('change', function() {
            const userId = this.getAttribute('data-user-id');
            const container = document.getElementById('tim-container-' + userId);
            container.style.display = (this.value === 'operator') ? 'block' : 'none';
        });
    });
</script>
@endpush
