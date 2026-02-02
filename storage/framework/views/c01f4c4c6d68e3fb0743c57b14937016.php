<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rekap Presensi Lembur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; padding: 30px 0; font-family: Arial, sans-serif; }
        .paper-preview { background-color: white; width: 210mm; min-height: 297mm; margin: 0 auto; padding: 15mm; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .judul-rekap { text-align: center; font-weight: bold; font-size: 11pt; margin-bottom: 20px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; font-size: 8.5pt; table-layout: fixed; margin-bottom: 30px; }
        table, th, td { border: 1px solid black; }
        th { background-color: #f2f2f2; text-align: center; padding: 5px; vertical-align: middle; }
        td { padding: 4px; vertical-align: middle; word-wrap: break-word; }
        .col-no { width: 30px; text-align: center; }
        .col-nama { width: 170px; }
        .signature-section { margin-top: 30px; display: flex; justify-content: flex-end; }
        .signature-box { text-align: center; min-width: 300px; font-size: 10pt; }
        @media print {
            @page { size: A4 portrait; margin: 0; }
            body { background-color: white; padding: 0; }
            .paper-preview { box-shadow: none; margin: 0; width: 100%; padding: 10mm; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
    <div class="paper-preview">
        <div class="judul-rekap">
            Rekap Presensi Lembur Pegawai BPS Provinsi Sulawesi Utara<br>
            Periode Bulan <?php echo e(\Carbon\Carbon::parse($tahun . '-' . $bulan . '-01')->locale('id')->translatedFormat('F')); ?> <?php echo e($tahun); ?>

        </div>

        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-nama">Nama</th>
                    <th class="col-tgl">Tanggal Pelaksanaan</th>
                    <th class="col-hari">Hari</th>
                    <th class="col-jam">Presensi Masuk</th>
                    <th class="col-jam">Presensi Pulang</th>
                    <th class="col-lama">Lamanya Lembur</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php $__currentLoopData = $groupedData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nama => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <?php if($index == 0): ?>
                            <td rowspan="<?php echo e(count($items)); ?>" style="text-align: center;"><?php echo e($no++); ?></td>
                            <td rowspan="<?php echo e(count($items)); ?>"><?php echo e($nama); ?></td>
                        <?php endif; ?>
                        <td style="text-align: center;"><?php echo e(\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')); ?></td>
                        <td style="text-align: center;">
                            <?php echo e(\Carbon\Carbon::parse($item->tanggal)->locale('id')->translatedFormat('l')); ?>

                        </td>

                        <td class="text-center">
                            <?php echo e($item->jam_mulai_tampil); ?>

                        </td>
                        <td style="text-align: center;"><?php echo e($item->jam_selesai); ?></td>
                        <td style="text-align: center; font-weight: bold;">
                            <?php echo e($item->durasi_hitung); ?>

                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <div class="signature-section">
            <div class="signature-box">
                <p class="mb-0"><?php echo e($tempat); ?>, <?php echo e($tanggal_ttd); ?></p>
                <p class="mb-0"><?php echo e($jabatan_ttd); ?></p>
                <p class="mb-0">BPS Provinsi Sulawesi Utara</p>
                <div style="height: 70px;"></div>
                <p class="mb-0 fw-bold"><?php echo e($nama_ttd); ?></p>
            </div>
        </div>
    </div>

    <div class="no-print" style="display: flex; justify-content: center; margin-top: 30px; margin-bottom: 50px; width: 100%;">
        <button onclick="window.print()" class="btn btn-primary btn-lg px-5 shadow">
            <i class="fas fa-print me-2"></i> Cetak
        </button>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\project_magang\resources\views/cetak/rekap_presensi_doc.blade.php ENDPATH**/ ?>