<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Kelola Hari Libur</h1>
            <p class="text-muted small mb-0">Atur kalender libur nasional dan cuti bersama untuk validasi perhitungan lembur.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #004a69;">
                        <i class="fas fa-calendar-plus me-2"></i>Tambah Manual
                    </h5>
                    <form action="<?php echo e(route('kelola_hari_libur')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Tanggal Libur</label>
                            <input type="date" name="tanggal" class="form-control border-soft bg-light fw-bold" style="color: #004a69;" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Keterangan / Nama Hari</label>
                            <input type="text" name="keterangan" class="form-control border-soft bg-light" placeholder="Contoh: Idul Fitri 1447 H" required>
                        </div>
                        <button type="submit" class="btn fw-bold text-white w-100 shadow-sm" style="background-color: #004a69; border-radius: 10px;">
                            <i class="fas fa-save me-1"></i> Simpan Hari Libur
                        </button>
                    </form>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px; border-left: 5px solid #0dcaf0 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-circle bg-info text-white me-3">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-0" style="color: #004a69;">Sync Otomatis</h5>
                    </div>
                    <p class="small text-muted mb-4">
                        Ambil data hari libur resmi & cuti bersama tahun <strong><?php echo e(date('Y')); ?></strong> langsung dari API eksternal.
                    </p>

                    <form action="<?php echo e(route('hari_libur.sync')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-info text-white w-100 fw-bold shadow-sm" style="border-radius: 10px;" onclick="return confirm('Proses ini membutuhkan koneksi internet. Lanjutkan?')">
                            <i class="fas fa-cloud-download-alt me-2"></i> Tarik Data Online
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold" style="color: #004a69;"><i class="fas fa-calendar-alt me-2"></i>Daftar Hari Libur</h5>

                    <form action="<?php echo e(route('kelola_hari_libur')); ?>" method="GET" class="d-flex shadow-sm" style="border-radius: 8px; overflow: hidden;">
                        <input type="number" name="tahun" class="form-control form-control-sm border-0 bg-light fw-bold" value="<?php echo e($tahunSaring); ?>" style="width: 100px; color: #004a69;">
                        <button type="submit" class="btn btn-primary btn-sm border-0 px-3" style="background-color: #004a69;">
                            <i class="fas fa-filter"></i>
                        </button>
                    </form>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #f8f9fa; color: #004a69;">
                                <tr class="small text-uppercase fw-bold">
                                    <th class="ps-4 py-3">Hari & Tanggal</th>
                                    <th>Keterangan Libur</th>
                                    <th class="text-end pe-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $hariLibur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="date-box me-3 text-center">
                                                <div class="date-num"><?php echo e(\Carbon\Carbon::parse($h->tanggal)->format('d')); ?></div>
                                                <div class="date-month"><?php echo e(\Carbon\Carbon::parse($h->tanggal)->locale('id')->translatedFormat('M')); ?></div>
                                            </div>
                                            <div class="fw-bold text-dark">
                                                <?php echo e(\Carbon\Carbon::parse($h->tanggal)->locale('id')->translatedFormat('l')); ?>,<br>
                                                <span class="text-muted small fw-normal"><?php echo e(\Carbon\Carbon::parse($h->tanggal)->format('Y')); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="badge px-3 py-2 rounded-pill bg-light text-dark border shadow-sm fw-medium">
                                            <?php echo e($h->keterangan); ?>

                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="<?php echo e(route('hari_libur.delete')); ?>" method="POST" onsubmit="return confirm('Hapus hari libur ini?');" class="d-inline">
                                            <?php echo csrf_field(); ?>
                                            <input type="hidden" name="id" value="<?php echo e($h->id); ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle shadow-sm" style="width: 35px; height: 35px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 d-flex justify-content-center bg-light">
                        <?php echo e($hariLibur->appends(['tahun' => $tahunSaring])->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .date-box {
        width: 45px; height: 50px; background-color: #e6f0f5; color: #004a69;
        border-radius: 10px; border: 1px solid #d1dee5; padding: 2px;
    }
    .date-num { font-size: 1.1rem; font-weight: 800; line-height: 1.2; }
    .date-month { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; color: #5a7d8e; }

    .icon-circle {
        width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
    }
    .border-soft { border: 1px solid #dee2e6; border-radius: 10px; }
    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }
    .form-control:focus, .form-select:focus {
        border-color: #004a69;
        box-shadow: 0 0 0 0.2rem rgba(0, 74, 105, 0.15);
    }
    .page-link { color: #004a69; border-radius: 8px !important; margin: 0 3px; }
    .page-item.active .page-link { background-color: #004a69; border-color: #004a69; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/hari_libur/index.blade.php ENDPATH**/ ?>