<?php $__env->startSection('content'); ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark py-3">
                <h6 class="m-0 fw-bold"><i class="fas fa-edit me-2"></i>Perbaiki Pengajuan Lembur</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    <h6 class="fw-bold mb-1"><i class="fas fa-exclamation-circle me-1"></i> Catatan Penolakan:</h6>
                    <p class="mb-0 italic">"<?php echo e($pengajuan->catatan_verifikator); ?>"</p>
                </div>

                <form action="<?php echo e(route('pengajuan.update', $pengajuan->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4 p-3 bg-light rounded border">
                        <label class="small text-muted text-uppercase fw-bold d-block mb-1">Pegawai Terkait</label>
                        <h5 class="fw-bold mb-0 text-dark"><?php echo e($pengajuan->pegawai->nama_lengkap); ?></h5>
                        <input type="hidden" name="pegawai_id" value="<?php echo e($pengajuan->pegawai_id); ?>">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Tanggal Lembur</label>
                            <input type="date" name="tanggal" class="form-control" value="<?php echo e($pengajuan->tanggal); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Estimasi Jam</label>
                            <div class="input-group">
                                <input type="number" name="lama_jam_taksiran" class="form-control" value="<?php echo e($pengajuan->lama_jam_taksiran); ?>" required>
                                <span class="input-group-text">Jam</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Perbaikan Maksud Lembur</label>
                        <textarea name="maksud_lembur" class="form-control" rows="4" required placeholder="Jelaskan detail pekerjaan yang dilakukan..."><?php echo e($pengajuan->maksud_lembur); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="<?php echo e(route('status_pengajuan')); ?>" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-warning px-4 fw-bold shadow-sm">Kirim Ulang Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Edit Pengajuan'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/operator/edit_pengajuan.blade.php ENDPATH**/ ?>