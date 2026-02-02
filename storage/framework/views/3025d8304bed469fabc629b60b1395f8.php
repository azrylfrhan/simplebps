<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak SPKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; padding: 30px 0; font-family: calibri, sans-serif; margin: 0; font-size: 11pt; line-height: 1.5;}
        .container-surat {
            background-color: white; width: 210mm; min-height: 297mm;
            margin: 0 auto; padding: 10mm; box-shadow: 0 0 10px rgba(0,0,0,0.1);
            display: flex; flex-direction: column; position: relative;
        }
        .container-surat table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .container-surat .table-bordered th, .container-surat .table-bordered td { border: 1px solid black !important; padding: 8px; }
        .container-surat thead th {
            background-color: #FFE599 !important; text-align: center; vertical-align: middle !important;
            padding: 10px 5px; font-weight: bold; -webkit-print-color-adjust: exact;
        }
        .container-surat ul {
            list-style-type: none;
            padding-left: 0 !important;
            margin: 0;
        }
        .container-surat ul li {
            position: relative;
            padding-left: 15px;
            text-align: justify;
            margin-bottom: 8px;
            line-height: 1.4;
        }
        .container-surat ul li::before {
            content: "-";
            position: absolute;
            left: 0;
        }
        .container-surat td { vertical-align: top; }

        .signature-section { margin-top: auto; display: flex; justify-content: flex-end; }
        .signature-box { text-align: center; min-width: 250px; }

        @media print {
            body { background-color: white; padding: 0; }
            .container-surat { box-shadow: none; margin: 0; width: 100%; padding: 10mm; }
            .no-print { display: none !important; }
            @page { size: portrait; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="container-surat">
        <div class="d-flex align-items-center mb-4">
            <img src="<?php echo e(asset('image/logoBps.png')); ?>" alt="Logo BPS" style="width: 80px;" class="me-3">
            <div>
                <h5 class="mb-0 fw-bold" style="color: #0056b3; font-style: italic;">BADAN PUSAT STATISTIK</h5>
                <h5 class="mb-0 fw-bold" style="color: #0056b3; font-style: italic;">PROVINSI SULAWESI UTARA</h5>
            </div>
        </div>

        <div class="text-center mb-4">
            <h6 class="mb-1"><b><u>SURAT PERINTAH KERJA LEMBUR</u></b></h6>
            <p class="mb-0"><b>Nomor : <?php echo e($nomorSpkl); ?></b></p>
        </div>

        <p>Sehubungan dengan adanya kegiatan lembur yang akan dilakukan oleh pegawai BPS Provinsi Sulawesi Utara, dengan ini kami memerintahkan pegawai - pegawai tersebut di bawah ini:</p>

        <table class="table-bordered"> <thead>
        <tr>
            <th style="width: 5%;">No.</th>
            <th style="width: 25%;">Nama</th>
            <th style="width: 25%;">Jabatan</th>
            <th style="width: 20%;">Tanggal Pelaksanaan</th>
            <th style="width: 25%;">Maksud Lembur</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; ?>
        <?php $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nama => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $rowCount = count($item['data_lembur']); ?>
            <?php $__currentLoopData = $item['data_lembur']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $maksud => $tanggalList): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <?php if($loop->first): ?>
                        <td rowspan="<?php echo e($rowCount); ?>" style="text-align: center; vertical-align: middle;"><?php echo e($no++); ?></td>
                        <td rowspan="<?php echo e($rowCount); ?>" style="vertical-align: middle;"><?php echo e($nama); ?></td>
                        <td rowspan="<?php echo e($rowCount); ?>" style="vertical-align: middle;"><?php echo e($item['jabatan']); ?></td>
                    <?php endif; ?>
                    <td style="text-align: center; vertical-align: middle;">
                        <?php echo e(implode(', ', $tanggalList)); ?> <?php echo e(\Carbon\Carbon::create()->month($bulan)->locale('id')->translatedFormat('F')); ?> <?php echo e($tahun); ?>

                    </td>
                    <td style="vertical-align: middle;">- <?php echo e($maksud); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

        <p>Untuk menyelesaikan pekerjaan tersebut dengan pengawasan penuh dari Kepala Bagian Umum, segala biaya yang timbul berkenaan dengan pelaksanaan kerja lembur tersebut dibebankan pada DIPA BPS Provinsi Sulawesi Utara Tahun Anggaran <?php echo e($tahun); ?>.</p>
        <p>Demikian untuk dilaksanakan dengan penuh tanggung jawab dengan tetap menjaga integritas dan kode etik.</p>

        <div class="signature-section">
            <div class="signature-box">
                <p class="mb-0"><?php echo e($tempat); ?>, <?php echo e($tanggal_ttd); ?></p>
                <p class="mb-0"><?php echo e($jabatan_ttd); ?></p>
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
<?php /**PATH C:\laragon\www\project_magang\resources\views/cetak/spkl.blade.php ENDPATH**/ ?>