<?php $__env->startSection('content'); ?>
<style>
    .row-libur { background-color: #fceaea !important; color: #721c24 !important; }
    .row-weekend { background-color: #fffbeb !important; color: #856404 !important; }

    .avatar-box-sm {
        width: 32px; height: 32px; background-color: #004a69; color: white;
        border-radius: 6px; display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.8rem;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 74, 105, 0.02) !important;
        transition: all 0.2s ease;
    }

    .border-soft { border: 1px solid #dee2e6; border-radius: 10px; }

    @media print {
        .no-print { display: none !important; }
    }
</style>

<div class="container-fluid py-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h1 mb-1 fw-bold" style="color: #004a69;">Rekap Presensi Lembur</h1>
            <p class="text-muted small mb-0">Laporan kehadiran lembur pegawai berdasarkan periode yang dipilih.</p>
        </div>
        <div class="mt-3 mt-sm-0 d-flex gap-2">
            <button class="btn fw-bold text-white shadow-sm px-4" style="background-color: #004a69; border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#importModal">
                <i class="fas fa-file-import me-2"></i> Import Data
            </button>
            <a href="<?php echo e(route('cetak_rekap', ['bulan' => $bulan, 'tahun' => $tahun])); ?>" target="_blank" class="btn fw-bold text-white shadow-sm px-4" style="background-color: #dc3545; border-radius: 10px;">
                <i class="fas fa-file-pdf me-2"></i> Cetak PDF
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4 no-print" style="border-radius: 15px;">
        <div class="card-body px-4 py-3">
            <form action="<?php echo e(route('rekap_presensi')); ?>" method="GET" class="row g-3 align-items-center">
                <div class="col-md-auto me-3">
                    <span class="fw-bold small text-uppercase text-muted"><i class="fas fa-filter me-2"></i>Filter :</span>
                </div>
                <div class="col-md-3">
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
                <div class="col-md-2">
                    <input type="number" name="tahun" class="form-control border-0 bg-light fw-bold text-center" style="color: #004a69;" value="<?php echo e($tahun); ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm" style="border-radius: 10px; background-color: #004a69; border: none;">
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
        <div class="card-header bg-white py-3 border-0">
            <h6 class="mb-0 fw-bold" style="color: #004a69;">
                <i class="fas fa-list-alt me-2"></i>Data Presensi: <?php echo e(Carbon\Carbon::create()->month((int)$bulan)->locale('id')->translatedFormat('F')); ?> <?php echo e($tahun); ?>

            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f8f9fa; color: #004a69;">
                        <tr class="small text-uppercase fw-bold">
                            <th class="ps-4 py-3" width="5%">No</th>
                            <th class="text-center" width="20%">Tanggal</th>
                            <th>Nama Pegawai</th>
                            <th class="text-center">Masuk</th>
                            <th class="text-center">Pulang</th>
                            <th class="text-center">Durasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $dataLembur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $carbonDate = \Carbon\Carbon::parse($item->tanggal);
                                $tglString = $carbonDate->format('Y-m-d');
                                $isLibur = in_array($tglString, $hariLibur);
                                $isWeekend = $carbonDate->isWeekend();

                                $class = '';
                                if ($isLibur) $class = 'row-libur';
                                elseif ($isWeekend) $class = 'row-weekend';
                            ?>
                            <tr class="<?php echo e($class); ?>">
                                <td class="ps-4 fw-bold text-muted"><?php echo e($index + 1); ?></td>
                                <td class="text-center">
                                    <div class="fw-bold" style="color: #004a69;"><?php echo e($carbonDate->locale('id')->translatedFormat('l')); ?></div>
                                    <small class="text-muted"><?php echo e($carbonDate->format('d/m/Y')); ?></small>
                                    <?php if($isLibur): ?>
                                        <div class="mt-1"><span class="badge bg-danger" style="font-size: 9px; letter-spacing: 0.5px;">LIBUR</span></div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-box-sm me-3">
                                            <?php echo e(strtoupper(substr($item->pegawai->nama_lengkap, 0, 1))); ?>

                                        </div>
                                        <div class="fw-bold text-dark"><?php echo e($item->pegawai->nama_lengkap); ?></div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border fw-normal"><?php echo e($item->jam_mulai_tampil ?? $item->jam_mulai); ?></span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border fw-normal"><?php echo e($item->jam_selesai); ?></span>
                                </td>
                                <td class="text-center fw-bold" style="color: #004a69;">
                                    <?php echo e($item->durasi_hitung); ?>

                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <h6>Tidak ada data untuk periode ini.</h6>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 15px;">
            <div class="modal-header border-0 py-3 text-white" style="background-color: #004a69; border-radius: 15px 15px 0 0;">
                <h5 class="modal-title fw-bold"><i class="fas fa-file-upload me-2"></i>Import Data Presensi</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-4">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-3">Langkah 1: Siapkan File</label>
                    <a href="<?php echo e(route('download_template')); ?>" class="btn btn-outline-success w-100 fw-bold py-2" style="border-radius: 10px; border-style: dashed;">
                        <i class="fas fa-file-excel me-2"></i> Download Template Excel
                    </a>
                </div>

                <hr class="my-4">

                <form action="<?php echo e(route('lembur.import')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-3">Langkah 2: Unggah File</label>
                        <input class="form-control border-soft py-2" type="file" name="file_excel" required accept=".xlsx, .xls">
                    </div>
                    <div class="modal-footer border-0 p-0">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn rounded-pill px-5 fw-bold text-white shadow-sm" style="background-color: #004a69;">
                            Mulai Proses Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PENGOLAHAN2-SP2020\Downloads\al magang\Project\project-magang\resources\views/lembur/rekap_presensi.blade.php ENDPATH**/ ?>