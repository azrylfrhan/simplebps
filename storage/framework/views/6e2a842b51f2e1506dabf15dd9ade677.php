<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'SIMPLE'); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="<?php echo e(asset('css/style-v2.css')); ?>">

    <style>
        .brand {
            display: flex;
            align-items: center;
            padding: 0 15px !important;
            gap: 12px;
        }

        .brand-content {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
            color: white;
        }

        .brand-title {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .brand-subtitle {
            font-size: 0.6rem;
            opacity: 0.8;
            font-weight: 400;
            white-space: normal;
            max-width: 160px;
        }

        body.sidebar-collapsed .brand-content {
            display: none !important;
        }

        body {
            overflow-x: hidden;
        }

        .sidebar {
            overflow: visible !important;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-nav {
            overflow-x: hidden !important;
            overflow-y: auto;
        }

        .sidebar-footer {
            position: absolute;
            top: 50%;
            right: 0;
            width: 0;
            height: 0;
            transform: translateY(-50%);
            background: transparent;
            padding: 0 !important;
            overflow: visible !important;
            z-index: 2000;
        }

        .btn-toggle {
            position: absolute;
            right: -17px;
            z-index: 2001;
        }
    </style>
</head>

<body class="<?php echo e(isset($bodyClass) ? $bodyClass : ''); ?> sidebar-collapsed">

    <?php if(Auth::check() && !request()->routeIs('ganti_password')): ?>

        <aside class="sidebar">
            <div class="brand">
                <img src="<?php echo e(asset('image/logoBps.png')); ?>" alt="Logo" class="brand-icon">
                <div class="brand-content">
                    <span class="brand-title">SIMPLE</span>
                    <span class="brand-subtitle">Sistem Informasi Manajemen Lembur</span>
                </div>
            </div>

            <nav class="sidebar-nav">
                <a href="<?php echo e(route('dashboard')); ?>"
                    class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-home fa-fw"></i><span class="nav-link-text">Dashboard</span>
                </a>

                <?php if(Auth::user()->role == 'operator'): ?>
                    <a href="<?php echo e(route('input_lembur')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('input_lembur') ? 'active' : ''); ?>">
                        <i class="fas fa-paper-plane fa-fw"></i><span class="nav-link-text">Ajukan Lembur</span>
                    </a>
                    <a href="<?php echo e(route('status_pengajuan')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('status_pengajuan') ? 'active' : ''); ?>">
                        <i class="fas fa-list-check fa-fw"></i>
                        <span class="nav-link-text">Status Pengajuan</span>
                        <?php if($sideCounters['operator_status'] > 0): ?>
                            <span class="badge-counter"><?php echo e($sideCounters['operator_status']); ?></span>
                        <?php endif; ?>
                    </a>
                <?php endif; ?>



                <?php if(Auth::user()->role == 'kabag'): ?>
                    <a href="<?php echo e(route('verifikasi.index')); ?>"
                        class="nav-link <?php echo e(Route::is('verifikasi.index') ? 'active' : ''); ?>">
                        <i class="fas fa-check-double fa-fw"></i>
                        <span class="nav-link-text">Verifikasi</span>
                        <?php if($sideCounters['kabag_verif'] > 0): ?>
                            <span class="badge-counter"><?php echo e($sideCounters['kabag_verif']); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('verifikasi.riwayat')); ?>"
                        class="nav-link <?php echo e(Route::is('verifikasi.riwayat') ? 'active' : ''); ?>">
                        <i class="fas fa-history fa-fw"></i><span class="nav-link-text">Riwayat</span>
                    </a>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                    <a href="<?php echo e(route('daftar_spkl')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('daftar_spkl') ? 'active' : ''); ?>">
                        <i class="fas fa-file-signature fa-fw"></i>
                        <span class="nav-link-text">Daftar SPKL</span>
                        <?php if($sideCounters['admin_spkl'] > 0): ?>
                            <span class="badge-counter"><?php echo e($sideCounters['admin_spkl']); ?></span>
                        <?php endif; ?>
                    </a>
                    <a href="<?php echo e(route('rekap_presensi')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('rekap_presensi') ? 'active' : ''); ?>">
                        <i class="fas fa-clipboard-check fa-fw"></i><span class="nav-link-text">Rekap Presensi</span>
                    </a>
                    <a href="<?php echo e(route('kelola_pegawai')); ?>"
                        class="nav-link <?php echo e(request()->routeIs('kelola_pegawai') ? 'active' : ''); ?>">
                        <i class="fas fa-users fa-fw"></i><span class="nav-link-text">Kelola Pegawai</span>
                    </a>

                    <?php
                        $isSetting =
                            request()->is('manajemen-akun*') ||
                            request()->is('tim*') ||
                            request()->is('kelola-hari-libur*') ||
                            request()->is('konfigurasi*');
                    ?>

                    <a class="nav-link parent-menu <?php echo e($isSetting ? 'active' : ''); ?>" data-bs-toggle="collapse"
                        href="#pengaturanCollapse" role="button" aria-expanded="<?php echo e($isSetting ? 'true' : 'false'); ?>">
                        <i class="fas fa-cog fa-fw"></i>
                        <span class="nav-link-text">Pengaturan</span>
                        <i class="fas fa-chevron-down ms-auto"></i> </a>

                    <div class="collapse <?php echo e($isSetting ? 'show' : ''); ?>" id="pengaturanCollapse">
                        <a href="<?php echo e(route('manajemen_akun')); ?>"
                            class="nav-link sub-menu <?php echo e(request()->routeIs('manajemen_akun') ? 'active' : ''); ?>">
                            <i class="fas fa-user-shield fa-fw"></i><span class="nav-link-text">Manajemen Akun</span>
                        </a>
                        <a href="<?php echo e(route('tim.index')); ?>"
                            class="nav-link sub-menu <?php echo e(request()->routeIs('tim.index') ? 'active' : ''); ?>">
                            <i class="fas fa-user-group fa-fw"></i><span class="nav-link-text">Manajemen Tim</span>
                        </a>
                        <a href="<?php echo e(route('kelola_hari_libur')); ?>"
                            class="nav-link sub-menu <?php echo e(request()->routeIs('kelola_hari_libur') ? 'active' : ''); ?>">
                            <i class="fas fa-calendar-alt fa-fw"></i><span class="nav-link-text">Kelola Hari Libur</span>
                        </a>
                        <a href="<?php echo e(route('konfigurasi')); ?>"
                            class="nav-link sub-menu <?php echo e(request()->routeIs('konfigurasi') ? 'active' : ''); ?>">
                            <i class="fas fa-pen-nib fa-fw"></i><span class="nav-link-text">Pengaturan TTD</span>
                        </a>
                    </div>
                <?php endif; ?>
            </nav>

            <div class="sidebar-footer">
                <button class="btn-toggle" id="sidebarToggle" type="button">
                    <i class="fas fa-chevron-left"></i>
                </button>
            </div>
        </aside>

        <div class="main-wrapper">
            <header class="top-header">
                <div class="ms-auto dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <?php
                            $displayName = Auth::user()->username;
                            if (Auth::user()->role == 'operator' && Auth::user()->tim) {
                                $displayName = Auth::user()->tim->ketua_tim ?? Auth::user()->username;
                            } elseif (Auth::user()->role == 'admin') {
                                $displayName = 'Administrator';
                            } elseif (Auth::user()->role == 'kabag') {
                                $displayName = 'Kabag Umum';
                            }
                        ?>
                        <i class="fas fa-user me-2"></i> <?php echo e($displayName); ?>

                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="<?php echo e(route('ganti_password')); ?>">Ganti Password</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>">Logout</a></li>
                    </ul>
                </div>
            </header>

            <main class="main-content">
                <h1 class="page-title"><?php echo e($title ?? ''); ?></h1>

                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?php echo e(session('success')); ?> <button
                            type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                <?php endif; ?>
                <?php if(session('error') || session('danger')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <?php echo e(session('error') ?? session('danger')); ?> <button type="button" class="btn-close"
                            data-bs-dismiss="alert"></button></div>
                <?php endif; ?>

                <?php echo $__env->yieldContent('content'); ?>
            </main>
        </div>
    <?php else: ?>
        <?php echo $__env->yieldContent('content'); ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('sidebarToggle');
            const body = document.querySelector('body');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    body.classList.toggle('sidebar-collapsed');
                });
            }
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\project_magang\resources\views/layouts/app.blade.php ENDPATH**/ ?>