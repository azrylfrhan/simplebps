<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin() {
        if (Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request) {
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->status == 'nonaktif') {
            Auth::logout();
            return back()->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi Admin.');
        }

        if ($user->wajib_ganti_password == 1) {
            return redirect()->route('ganti_password');
        }

        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    return back()->with('error', 'Username atau password salah.');
}

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('info', 'Anda telah berhasil logout.');
    }

    public function showGantiPassword() {
        return view('auth.ganti_password');
    }

    public function gantiPassword(Request $request) {
    $request->validate([
        'password_baru' => [
            'required',
            'min:8',

            Password::min(8)->letters()->numbers(),
        ],
        'konfirmasi_password' => 'required|same:password_baru'
    ], [

        'konfirmasi_password.same' => 'Konfirmasi password tidak cocok dengan password baru.',
    ]);

    $user = Auth::user();
    /** @var \App\Models\User $user */
    $user->password = Hash::make($request->password_baru);
    $user->wajib_ganti_password = 0;
    $user->status = 'aktif';
    $user->save();

    Auth::logout();
    return redirect()->route('login')->with('success', 'Password berhasil diubah. Silakan login kembali.');
}
}
