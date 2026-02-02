<?php $__env->startSection('content'); ?>
<div class="login-container">
    <h2>Buat Password Baru</h2>

    <?php if(Auth::user()->wajib_ganti_password == 1): ?>
        <p class="text-white-50">Untuk keamanan, Anda harus membuat password baru.</p>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger text-start">
            <ul class="mb-0" style="padding-left: 20px;">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('ganti_password')); ?>">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <input type="password" name="password_baru" placeholder="Password Baru (Min. 8 Karakter + Angka)" required minlength="8">
        </div>

        <div class="form-group">
            <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password Baru" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Password</button>
    </form>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.querySelector('form').addEventListener('submit', function(e) {
        const pw1 = document.querySelector('input[name="password_baru"]').value;
        const pw2 = document.querySelector('input[name="konfirmasi_password"]').value;

        const hasLetter = /[a-zA-Z]/.test(pw1);
        const hasNumber = /[0-9]/.test(pw1);

        if (pw1 !== pw2) {
            e.preventDefault();
            alert('Konfirmasi password tidak cocok.');
        } else if (pw1.length < 8) {
            e.preventDefault();
            alert('Password minimal 8 karakter.');
        } else if (!hasLetter || !hasNumber) {
            e.preventDefault();
            alert('Password harus mengandung kombinasi huruf dan angka.');
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', [
    'bodyClass' => 'login-page-body',
    'title' => 'Ganti Password',
    'hideSidebar' => true
], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\project_magang\resources\views/auth/ganti_password.blade.php ENDPATH**/ ?>