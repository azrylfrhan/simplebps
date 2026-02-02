@extends('layouts.app', [
    'bodyClass' => 'login-page-body',
    'title' => 'Ganti Password',
    'hideSidebar' => true
])

@section('content')
<div class="login-container">
    <h2>Buat Password Baru</h2>

    @if(Auth::user()->wajib_ganti_password == 1)
        <p class="text-white-50">Untuk keamanan, Anda harus membuat password baru.</p>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger text-start">
            <ul class="mb-0" style="padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ganti_password') }}">
        @csrf
        <div class="form-group">
            <input type="password" name="password_baru" placeholder="Password Baru (Min. 8 Karakter + Angka)" required minlength="8">
        </div>

        <div class="form-group">
            <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password Baru" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Password</button>
    </form>
</div>

@push('scripts')
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
@endpush
@endsection
