<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Daftar Pengajuan SPKL</h1>
            <p class="text-muted small mb-0">Daftar lembur yang telah disetujui dan siap untuk dicetak sebagai dokumen SPKL.</p>
        </div>
        <div class="mt-3 mt-sm-0">
            <a href="<?php echo e(route('cetak_spkl', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" target="_blank" class="btn fw-bold text-white shadow-sm px-4" style="background-color: #dc3545; border-radius: 10px;">
                <i class="fas fa-print me-2"></i> Cetak Dokumen SPKL
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
        <div class="card-body p-4">
            <form action="<?php echo e(route('daftar_spkl')); ?>" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted text-uppercase">Bulan Pelaksanaan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt" style="color: #004a69;"></i></span>
                        <select name="bulan" class="form-select border-0 bg-light fw-bold" style="color: #004a69;">
                            <?php $__currentLoopData = range(1, 12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e(sprintf('%02d', $m)); ?>" <?php echo e($bulan == $m ? 'selected' : ''); ?>>
                                <?php echo e(Carbon\Carbon::create()->month($m)->locale('id')->translatedFormat('F')); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Tahun</label>
                    <input type="number" name="tahun" class="form-control border-0 bg-light fw-bold" style="color: #004a69;" value="<?php echo e($tahun); ?>">
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
                        <?php $__empty_1 = true; $__currentLoopData = $dataSpkl; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?php echo e($i+1); ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-box-sm me-3">
                                        <?php echo e(strtoupper(substr($s->pegawai->nama_lengkap, 0, 1))); ?>

                                    </div>
                                    <div class="fw-bold text-dark"><?php echo e($s->pegawai->nama_lengkap); ?></div>
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge px-3 py-2" style="background-color: #e6f0f5; color: #004a69; border-radius: 8px;">
                                    <i class="far fa-calendar-check me-1"></i>
                                    <?php echo e(\Carbon\Carbon::parse($s->tanggal)->locale('id')->translatedFormat('d F Y')); ?>

                                </span>
                            </td>
                            <td>
                                <div class="text-muted small" style="line-height: 1.5;">
                                    <?php echo nl2br(e($s->maksud_lembur)); ?>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="py-3">
                                    <i class="fas fa-file-invoice fa-3x mb-3" style="color: #dee2e6;"></i>
                                    <h6 class="text-muted">Tidak ada data pengajuan yang disetujui untuk periode ini.</h6>
                                </div>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/lembur/daftar_spkl.blade.php ENDPATH**/ ?>