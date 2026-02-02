@extends('layouts.app')

@section('content')
<style>
    :root {
        --deep-blue: #004a69;
        --soft-blue: #e6f0f5;
    }

    .config-card {
        background: #ffffff;
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .config-header {
        background: transparent;
        border-bottom: 1px solid #f0f0f0;
        padding: 20px 25px;
    }

    .config-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--deep-blue);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-label {
        font-weight: 700;
        font-size: 0.8rem;
        color: #64748b;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 0.95rem;
        background-color: #f8fafc;
        transition: all 0.2s;
    }

    .form-control:focus {
        border-color: var(--deep-blue);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(0, 74, 105, 0.1);
    }

    .info-banner {
        background: var(--soft-blue);
        border-radius: 12px;
        padding: 15px 20px;
        border-left: 4px solid var(--deep-blue);
        margin-bottom: 30px;
    }

    .btn-save {
        background: var(--deep-blue);
        border: none;
        padding: 15px 45px;
        border-radius: 12px;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(0, 74, 105, 0.2);
        transition: all 0.3s;
    }

    .btn-save:hover {
        background: #00364d;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0, 74, 105, 0.3);
    }

    .icon-box-ttd {
        width: 40px;
        height: 40px;
        background: var(--soft-blue);
        color: var(--deep-blue);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container-fluid py-4">
    <div class="mb-4 d-sm-flex align-items-center justify-content-between">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: var(--deep-blue);">Pengaturan Dokumen</h1>
            <p class="text-muted small mb-0">Kelola detail penandatangan untuk SPKL dan Rekap Presensi secara terpusat.</p>
        </div>
    </div>

    <form action="{{ route('konfigurasi.update') }}" method="POST">
        @csrf

        <div class="info-banner d-flex align-items-center shadow-sm">
            <div class="icon-box-ttd me-3">
                <i class="fas fa-info-circle fs-5"></i>
            </div>
            <span class="text-secondary small fw-medium">Data ini akan muncul otomatis sebagai footer pada dokumen cetak (PDF/Print). Pastikan gelar, nama, dan jabatan sudah sesuai.</span>
        </div>

        <div class="row g-4">
            <div class="col-12">
                <div class="config-card p-4">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <h6 class="config-title"><i class="fas fa-map-marker-alt"></i> Tempat Penetapan</h6>
                            <p class="text-muted small mb-0">Kota tempat dokumen ditandatangani.</p>
                        </div>
                        <div class="col-md-8">
                            <input type="text" name="tempat_ttd" class="form-control" value="{{ $config['tempat_ttd'] ?? 'Manado' }}" placeholder="Contoh: Manado" style="color: var(--deep-blue);">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="config-card overflow-hidden">
                    <div class="config-header">
                        <h6 class="config-title"><i class="fas fa-file-signature text-primary"></i> Pejabat Penanda Tangan SPKL</h6>
                    </div>
                    <div class="config-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan_spkl" class="form-control" value="{{ $config['jabatan_spkl'] ?? '' }}" placeholder="Contoh: Kuasa Pengguna Anggaran">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_spkl" class="form-control" value="{{ $config['nama_spkl'] ?? '' }}" style="color: var(--deep-blue);">
                        </div>
                        <div>
                            <label class="form-label">Custom Tanggal (Opsional)</label>
                            <input type="text" name="tgl_spkl_manual" class="form-control" value="{{ $config['tgl_spkl_manual'] ?? '' }}" placeholder="Contoh: 15 Agustus 2025">
                            <div class="form-text x-small mt-2"><i class="fas fa-question-circle"></i> Kosongkan jika ingin menggunakan tanggal hari ini secara otomatis.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="config-card overflow-hidden">
                    <div class="config-header">
                        <h6 class="config-title"><i class="fas fa-user-check text-primary"></i> Pejabat Penanda Tangan Rekap</h6>
                    </div>
                    <div class="config-body p-4">
                        <div class="mb-3">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan_rekap" class="form-control" value="{{ $config['jabatan_rekap'] ?? '' }}" placeholder="Contoh: Ketua Tim SDM">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap & Gelar</label>
                            <input type="text" name="nama_rekap" class="form-control" value="{{ $config['nama_rekap'] ?? '' }}" style="color: var(--deep-blue);">
                        </div>
                        <div>
                            <label class="form-label">Custom Tanggal (Opsional)</label>
                            <input type="text" name="tgl_rekap_manual" class="form-control" value="{{ $config['tgl_rekap_manual'] ?? '' }}" placeholder="Contoh: 15 Agustus 2025">
                            <div class="form-text x-small mt-2"><i class="fas fa-question-circle"></i> Kosongkan jika ingin menggunakan tanggal hari ini secara otomatis.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end mt-5 mb-4">
            <button type="submit" class="btn btn-save text-white shadow">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
