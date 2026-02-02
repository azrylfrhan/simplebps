<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold" style="color: #004a69;">Verifikasi Pengajuan Lembur</h1>
            <p class="text-muted small mb-0">Tinjau dan proses permintaan lembur pegawai secara efisien.</p>
        </div>
        <div class="badge px-4 py-2 rounded-pill shadow-sm" style="background-color: rgba(0, 74, 105, 0.1); color: #004a69;">
            <i class="fas fa-hourglass-half me-2"></i> <?php echo e(count($pengajuan)); ?> Menunggu Tindakan
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3">Data Pegawai</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Estimasi</th>
                            <th>Maksud Lembur</th>
                            <th class="text-end pe-4">Konfirmasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $pengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box me-3">
                                        <?php echo e(strtoupper(substr($p->pegawai->nama_lengkap, 0, 1))); ?>

                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?php echo e($p->pegawai->nama_lengkap); ?></div>
                                        <div class="text-muted x-small fw-bold"><?php echo e($p->pegawai->tim->nama_tim ?? '-'); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="date-badge">
                                    <div class="date-day"><?php echo e(\Carbon\Carbon::parse($p->tanggal)->format('d')); ?></div>
                                    <div class="date-month"><?php echo e(\Carbon\Carbon::parse($p->tanggal)->locale('id')->translatedFormat('M Y')); ?></div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill px-3 py-2" style="background-color: #e6f0f5; color: #004a69;">
                                    <?php echo e($p->lama_jam_taksiran); ?> Jam
                                </span>
                            </td>
                            <td>
                                <div class="text-dark small" style="max-width: 250px; line-height: 1.4;">
                                    <?php echo e($p->maksud_lembur); ?>

                                </div>
                            </td>
                            <td class="text-end pe-4">
                                <div class="btn-group rounded-3 overflow-hidden border shadow-sm">
                                    <button class="btn btn-action btn-sm px-3 border-end" data-bs-toggle="modal" data-bs-target="#accModal<?php echo e($p->id); ?>" title="Setujui">
                                        <i class="fas fa-check" style="color: #004a69;"></i>
                                    </button>
                                    <button class="btn btn-action btn-sm px-3" data-bs-toggle="modal" data-bs-target="#tolakModal<?php echo e($p->id); ?>" title="Tolak">
                                        <i class="fas fa-times text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://illustrations.popsy.co/blue/document-sign.svg" alt="no-data" style="height: 150px;" class="mb-3">
                                <h6 class="text-muted">Semua pengajuan sudah selesai diproses.</h6>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
    .date-month { font-size: 0.65rem; color: #5a7d8e; text-uppercase; font-weight: bold; }
    .x-small { font-size: 0.7rem; }
    .btn-action { background-color: white; transition: all 0.2s; }
    .btn-action:hover { background-color: #f8f9fa; }
    .form-control:focus { border-color: #004a69; box-shadow: 0 0 0 0.2rem rgba(0, 74, 105, 0.25); }
</style>


<?php $__currentLoopData = $pengajuan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="modal fade" id="accModal<?php echo e($p->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?php echo e(route('verifikasi.proses')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($p->id); ?>">
                <input type="hidden" name="aksi" value="disetujui">
                <div class="modal-content border-0" style="border-radius: 15px;">
                    <div class="modal-header border-0 py-3" style="background-color: #004a69; color: white; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title fw-bold"><i class="fas fa-clipboard-check me-2"></i>Konfirmasi Persetujuan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="d-flex align-items-center mb-4 p-3 rounded-3" style="background-color: #f0f4f7;">
                            <div class="avatar-box me-3"><?php echo e(strtoupper(substr($p->pegawai->nama_lengkap, 0, 1))); ?></div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark"><?php echo e($p->pegawai->nama_lengkap); ?></h6>
                                <small class="text-muted">Diajukan: <?php echo e(\Carbon\Carbon::parse($p->tanggal)->translatedFormat('d F Y')); ?></small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold form-label" style="color: #004a69;">Rekomendasi Durasi (Jam)</label>
                            <div class="input-group">
                                <input type="number" name="lama_jam_disetujui" class="form-control form-control-lg fw-bold" value="<?php echo e($p->lama_jam_taksiran); ?>" style="color: #004a69;" required>
                                <span class="input-group-text text-white fw-bold" style="background-color: #004a69;">JAM</span>
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="fw-bold form-label">Catatan Tambahan (Opsional)</label>
                            <textarea name="catatan_verifikator" class="form-control" rows="3" placeholder="Silakan Diisi..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-pill px-5 fw-bold shadow-sm" style="background-color: #004a69; color: white;">Simpan & Setujui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div class="modal fade" id="tolakModal<?php echo e($p->id); ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="<?php echo e(route('verifikasi.proses')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="id" value="<?php echo e($p->id); ?>">
                <input type="hidden" name="aksi" value="ditolak">
                <div class="modal-content border-0" style="border-radius: 15px;">
                    <div class="modal-header border-0 py-3 bg-danger text-white" style="border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title fw-bold"><i class="fas fa-times-circle me-2"></i>Tolak Pengajuan</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-danger border-0 small mb-4">
                            Sebutkan alasan penolakan agar operator tim dapat memperbaiki pengajuan.
                        </div>
                        <div class="mb-0">
                            <label class="fw-bold form-label text-danger small text-uppercase">Alasan Penolakan (Wajib)</label>
                            <textarea name="catatan_verifikator" class="form-control border-danger" rows="4" required placeholder="Contoh: Maksud lembur kurang spesifik atau durasi tidak relevan."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-5 fw-bold shadow-sm">Kirim Penolakan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/verifikasi/index.blade.php ENDPATH**/ ?>