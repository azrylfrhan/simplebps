<?php $__env->startSection('content'); ?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />

<style>
    :root {
        --deep-blue: #004a69;
        --soft-blue: rgba(0, 74, 105, 0.1);
    }

    .welcome-card {
        background: linear-gradient(135deg, #004a69 0%, #006087 100%);
        border-radius: 15px;
        position: relative;
        overflow: hidden;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        right: -50px; top: -50px;
        width: 200px; height: 200px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
    }

    .pulse-urgent { animation: pulse-deep-blue 2s infinite; }
    @keyframes pulse-deep-blue {
        0% { box-shadow: 0 0 0 0 rgba(0, 74, 105, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(0, 74, 105, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 74, 105, 0); }
    }

    .table-hover-custom tbody tr { transition: all 0.2s; border-left: 3px solid transparent; }
    .table-hover-custom tbody tr:hover {
        background-color: #f0f7fa;
        transform: scale(1.01);
        border-left: 3px solid var(--deep-blue);
    }
    .card { border-radius: 12px; }
    .stat-icon {
        width: 48px; height: 48px;
        background: var(--soft-blue);
        color: var(--deep-blue);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    /* Custom Styling for FullCalendar */
    #calendar {
        max-height: 500px;
        font-size: 0.85rem;
    }
    .fc-header-toolbar { margin-bottom: 1rem !important; }
    .fc-button-primary { background-color: var(--deep-blue) !important; border-color: var(--deep-blue) !important; }
    .fc-day-today { background: var(--soft-blue) !important; }
</style>

<div class="container-fluid py-3">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card shadow-sm border-0 text-white">
                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="h4 fw-bold mb-1 text-white">Selamat Datang Kembali, <?php echo e($namaLengkap); ?>!</h1>
                        <p class="mb-0 opacity-75">
                            Dashboard manajemen lembur — Role: <strong><?php echo e(ucfirst(Auth::user()->role)); ?></strong>
                            <?php if(Auth::user()->tim): ?>
                            | Tim: <strong><?php echo e(Auth::user()->tim->nama_tim); ?></strong>
                            <?php else: ?>
                            | <strong>Pimpinan / Umum</strong>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="d-none d-md-block">
                        <i class="fas fa-chart-line fa-3x opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon me-3">
                            <i class="fas fa-users fa-lg"></i>
                        </div>
                        <div>
                            <div class="text-muted small text-uppercase fw-bold">Total Pegawai</div>
                            <div class="h3 fw-bold mb-0" style="color: var(--deep-blue);"><?php echo e($totalPegawai); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-body">
                    <label class="small fw-bold text-muted text-uppercase mb-2 d-block">Periode Laporan</label>
                    <form action="<?php echo e(route('dashboard')); ?>" method="GET">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-calendar-alt" style="color: var(--deep-blue);"></i></span>
                            <select name="tahun" class="form-select border-0 bg-light fw-bold" onchange="this.form.submit()" style="color: var(--deep-blue);">
                                <?php for($y = date('Y') + 1; $y >= 2024; $y--): ?>
                                    <option value="<?php echo e($y); ?>" <?php echo e($year == $y ? 'selected' : ''); ?>>Tahun <?php echo e($y); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <?php if(Auth::user()->role == 'admin'): ?>
            <div class="card shadow-sm mb-4 border-0 bg-light">
                <div class="card-body">
                    <h6 class="small fw-bold text-muted text-uppercase mb-3"><i class="fas fa-umbrella-beach me-2"></i>Libur Terdekat</h6>
                    <?php
                        $libur = \App\Models\HariLibur::where('tanggal', '>=', now())->orderBy('tanggal', 'asc')->first();
                    ?>
                    <?php if($libur): ?>
                        <div class="fw-bold text-danger mb-1 small"><?php echo e(\Carbon\Carbon::parse($libur->tanggal)->translatedFormat('d F Y')); ?></div>
                        <div class="small text-muted"><?php echo e($libur->keterangan); ?></div>
                    <?php else: ?>
                        <div class="small text-muted italic">Tidak ada data libur terdekat.</div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <div class="col-lg-9">
            <?php if(Auth::user()->role == 'kabag'): ?>
                <div class="card shadow-sm border-0 mb-4 h-100">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-tasks me-2"></i>Antrean Persetujuan Lembur</h6>
                        <?php if($pengajuanPending > 0): ?>
                            <span class="badge pulse-urgent px-3 py-2" style="background-color: var(--deep-blue); color: white;"><?php echo e($pengajuanPending); ?> Menunggu</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover-custom align-middle mb-0">
                                <thead class="bg-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th class="ps-4">PEGAWAI</th>
                                        <th>WAKTU ANTREAN</th>
                                        <th class="text-end pe-4">AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $terbaru; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark"><?php echo e($t->pegawai->nama_lengkap); ?></div>
                                            <div class="text-muted small">Lembur: <?php echo e(\Carbon\Carbon::parse($t->tanggal)->locale('id')->translatedFormat('d F Y')); ?></div>
                                        </td>
                                        <td>
                                            <span class="fw-medium small" style="color: var(--deep-blue);">
                                                <i class="far fa-clock me-1"></i> <?php echo e($t->created_at->diffForHumans()); ?>

                                            </span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <a href="<?php echo e(route('verifikasi.index')); ?>" class="btn btn-sm px-4 fw-bold text-white shadow-sm" style="background-color: var(--deep-blue); border-radius: 8px;">Verifikasi</a>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr><td colspan="3" class="text-center py-5 text-muted small">Tidak ada antrean pengajuan.</td></tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <?php elseif(Auth::user()->role == 'operator'): ?>
                <div class="card shadow-sm h-100 border-0">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-briefcase me-2"></i>Status Pengajuan Tim</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4"><div class="p-3 bg-warning bg-opacity-10 border-start border-4 border-warning rounded shadow-sm"><h6 class="mb-1 fw-bold text-warning">Pending</h6><h2 class="mb-0 fw-bold"><?php echo e($statsTim['pending']); ?></h2></div></div>
                            <div class="col-md-4"><div class="p-3 bg-success bg-opacity-10 border-start border-4 border-success rounded shadow-sm"><h6 class="mb-1 fw-bold text-success">Disetujui</h6><h2 class="mb-0 fw-bold"><?php echo e($statsTim['disetujui']); ?></h2></div></div>
                            <div class="col-md-4"><div class="p-3 bg-danger bg-opacity-10 border-start border-4 border-danger rounded shadow-sm"><h6 class="mb-1 fw-bold text-danger">Ditolak</h6><h2 class="mb-0 fw-bold"><?php echo e($statsTim['ditolak']); ?></h2></div></div>
                        </div>
                    </div>
                </div>

            <?php elseif(Auth::user()->role == 'admin'): ?>
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="m-0 fw-bold" style="color: var(--deep-blue);"><i class="fas fa-calendar-alt me-2"></i>Monitoring Kalender Lembur</h6>
                    </div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0"><h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-pie me-2" style="color: var(--deep-blue);"></i><?php echo e($judulChart2); ?></h6></div>
                <div class="card-body"><div style="height: 300px;"><canvas id="pieChart"></canvas></div></div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0"><h6 class="m-0 fw-bold text-dark"><i class="fas fa-chart-bar me-2" style="color: var(--deep-blue);"></i><?php echo e($chart1Title); ?> (<?php echo e($year); ?>)</h6></div>
                <div class="card-body"><div style="height: 300px;"><canvas id="barChart"></canvas></div></div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>

<script>
    // FullCalendar Configuration (Hanya untuk Admin)
    <?php if(Auth::user()->role == 'admin'): ?>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'id',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek'
            },
            // Logic: Ambil data dari backend atau definisikan static events
            events: [
                // Contoh integrasi data libur
                <?php $holidayData = \App\Models\HariLibur::all(); ?>
                <?php $__currentLoopData = $holidayData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $h): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    title: '<?php echo e($h->keterangan); ?>',
                    start: '<?php echo e($h->tanggal); ?>',
                    display: 'background',
                    backgroundColor: '#ffdbdb'
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                // Contoh integrasi titik lembur (agregat harian)
                <?php
                    $lemburDaily = \App\Models\PengajuanLembur::where('status', 'disetujui')
                                    ->select('tanggal', \DB::raw('count(*) as total'))
                                    ->groupBy('tanggal')->get();
                ?>
                <?php $__currentLoopData = $lemburDaily; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ld): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    title: '<?php echo e($ld->total); ?> Orang Lembur',
                    start: '<?php echo e($ld->tanggal); ?>',
                    color: '#004a69'
                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ]
        });
        calendar.render();
    });
    <?php endif; ?>

    // Charts Config (Shared)
    Chart.defaults.maintainAspectRatio = false;
    Chart.defaults.color = '#64748b';
    Chart.defaults.font.family = 'Plus Jakarta Sans, sans-serif';

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Orang', data: <?php echo json_encode($dataBar, 15, 512) ?>,
                backgroundColor: '#004a69', borderRadius: 8, hoverBackgroundColor: '#006087'
            }]
        },
        options: { scales: { y: { grid: { display: false }, beginAtZero: true, ticks: { stepSize: 1 } }, x: { grid: { display: false } } }, plugins: { legend: { display: false } } }
    });

    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut',
        data: {
            labels: <?php echo json_encode($labelPie, 15, 512) ?>,
            datasets: [{
                data: <?php echo json_encode($dataPie, 15, 512) ?>,
                backgroundColor: ['#004a69', '#0ea5e9', '#0284c7', '#38bdf8', '#7dd3fc', '#bae6fd'],
                borderWidth: 2, borderColor: '#ffffff'
            }]
        },
        options: { plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 25, font: { size: 11 } } } }, cutout: '75%' }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['title' => 'Dashboard'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/dashboard.blade.php ENDPATH**/ ?>