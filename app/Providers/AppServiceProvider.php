<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Pagination\Paginator;
use App\Models\User;
use App\Models\PengajuanLembur;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('kabag', function (User $user) {
            return $user->role === 'kabag';
        });

        Gate::define('operator', function (User $user) {
            return $user->role === 'operator';
        });

        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $counters = [
                    'operator_status' => 0,
                    'admin_spkl'      => 0,
                    'kabag_verif'     => 0,
                ];

                if ($user->role == 'operator') {
                    $counters['operator_status'] = PengajuanLembur::whereHas('pegawai', function($q) use ($user) {
                            $q->where('tim_id', $user->tim_id);
                        })
                        ->whereIn('status', ['disetujui', 'ditolak'])
                        ->where('is_read_operator', false)
                        ->count();
                }

                if ($user->role == 'admin') {
                    $counters['admin_spkl'] = PengajuanLembur::where('status', 'disetujui')
                        ->where('is_read_admin', false)
                        ->count();
                }

                if ($user->role == 'kabag') {
                    $counters['kabag_verif'] = PengajuanLembur::where('status', 'pending')
                        ->count();
                }

                $view->with('sideCounters', $counters);
            }
        });
    }
}
