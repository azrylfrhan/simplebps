<?php $__env->startSection('content'); ?>
<style>
    body.login-page-body {
        background: radial-gradient(circle at center, #005a82 0%, #004a69 100%) !important;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .login-container {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 50px 40px;
        width: 100%;
        max-width: 420px;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        text-align: center;
        transition: transform 0.3s ease;
    }

    .login-logo {
        filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));
        transition: all 0.5s ease;
    }
    .login-logo:hover {
        transform: rotate(5deg) scale(1.1);
    }

    .app-name {
        font-size: 2.5rem;
        font-weight: 800;
        letter-spacing: 4px;
        background: linear-gradient(to bottom, #ffffff, #b0d4e3);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-top: 10px;
    }

    .form-group {
        position: relative;
        margin-bottom: 20px;
    }

    .form-group i {
        position: absolute;
        left: 20px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.6);
        transition: color 0.3s;
    }

    .form-group input {
        width: 100%;
        padding: 15px 15px 15px 55px;
        background: rgba(255, 255, 255, 0.08);
        border: 2px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        color: white;
        font-size: 1rem;
        transition: all 0.3s;
        outline: none;
    }

    .form-group input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .form-group input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #00a8ff;
        box-shadow: 0 0 15px rgba(0, 168, 255, 0.3);
    }

    .form-group input:focus + i {
        color: #00a8ff;
    }

    .btn-login {
        background: linear-gradient(45deg, #007bff, #00a8ff);
        border: none;
        border-radius: 15px;
        padding: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s;
        box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
    }

    .btn-login:hover {
        background: linear-gradient(45deg, #00a8ff, #007bff);
        transform: translateY(-2px);
        box-shadow: 0 15px 25px rgba(0, 123, 255, 0.4);
        color: white;
    }

    .footer-text {
        color: rgba(255, 255, 255, 0.5);
        font-size: 0.75rem;
        line-height: 1.5;
        margin-top: 30px;
    }
</style>

<div class="login-container">
    <div class="mb-5">
        <img src="<?php echo e(asset('image/logoBps.png')); ?>" alt="Logo BPS" class="login-logo" style="width: 90px;">
        <h1 class="app-name mb-0">SIMPLE</h1>
        <p class="text-white-50 small fw-light">Sistem Informasi Manajemen Lembur Pegawai</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger border-0 bg-danger text-white text-start py-2 mb-4" style="font-size: 0.85rem; border-radius: 12px; background: rgba(220, 53, 69, 0.2) !important; backdrop-filter: blur(5px);">
            <ul class="mb-0 ps-3">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required autofocus>
            <i class="fas fa-user"></i>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
            <i class="fas fa-lock"></i>
        </div>

        <button type="submit" class="btn btn-login btn-primary w-100">
            Login <i class="fas fa-sign-in-alt ms-2"></i>
        </button>
    </form>

    <div class="footer-text">
        &copy; <?php echo e(date('Y')); ?> Badan Pusat Statistik<br>
        Provinsi Sulawesi Utara
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', ['bodyClass' => 'login-page-body', 'title' => 'Login'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\PENGOLAHAN2-SP2020\Downloads\al magang\Project\project-magang\resources\views/auth/login.blade.php ENDPATH**/ ?>