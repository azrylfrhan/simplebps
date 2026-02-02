<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Input Pengajuan Lembur</h1>
            <p class="text-muted small mb-0">Formulir pengajuan lembur pegawai untuk verifikasi sistem.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold" style="color: #004a69;"><i class="fas fa-edit me-2"></i>Formulir Data Lembur</h6>
                </div>
                <div class="card-body p-4">
                    <form action="<?php echo e(route('simpan_pengajuan')); ?>" method="POST">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Nama Pegawai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-user" style="color: #004a69;"></i></span>
                                <select name="pegawai_id" class="form-select border-soft bg-light <?php $__errorArgs = ['pegawai_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <option value="">-- Pilih Pegawai --</option>
                                    <?php $__currentLoopData = $pegawai; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($p->id); ?>" <?php echo e(old('pegawai_id') == $p->id ? 'selected' : ''); ?>>
                                            <?php echo e($p->nama_lengkap); ?>

                                            <?php if(is_null($p->tim_id)): ?> (Pimpinan) <?php else: ?> <?php endif; ?>
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php $__errorArgs = ['pegawai_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Lembur</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt" style="color: #004a69;"></i></span>
                                        <input type="date" name="tanggal" id="tanggal" class="form-control border-soft bg-light fw-bold" style="color: #004a69;" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label small fw-bold text-muted text-uppercase">Lama Lembur (Jam)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="fas fa-stopwatch" style="color: #004a69;"></i></span>
                                        <input type="number" name="lama_jam" class="form-control border-soft bg-light fw-bold" style="color: #004a69;" min="1" max="8" placeholder="Contoh: 3" required>
                                        <span class="input-group-text bg-light border-0 small fw-bold text-muted">JAM</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Maksud / Uraian Tugas</label>
                            <textarea name="maksud_lembur" class="form-control border-soft bg-light" rows="4" placeholder="Silakan diisi" required></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary fw-bold py-2 shadow-sm" style="background-color: #004a69; border: none; border-radius: 10px;">
                                <i class="fas fa-paper-plane me-2"></i> Kirim Pengajuan Lembur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-soft { border: 1px solid #dee2e6; border-radius: 8px; }
    .form-control:focus, .form-select:focus {
        border-color: #004a69;
        box-shadow: 0 0 0 0.2rem rgba(0, 74, 105, 0.15);
        background-color: #ffffff;
    }
    .input-group-text { border: 1px solid #dee2e6; }
    .x-small { font-size: 0.75rem; }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.getElementById('tanggal').addEventListener('change', function() {
        console.log("Tanggal dipilih: " + this.value);
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/lembur/input.blade.php ENDPATH**/ ?>