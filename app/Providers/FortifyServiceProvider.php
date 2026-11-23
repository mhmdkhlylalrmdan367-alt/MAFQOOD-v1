<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
        $request = request();
        if($request->is('admin/*')) {
            Config::set('fortify.guard', 'admin');
            Config::set('fortify.passwords', 'admins');
            Config::set('fortify.home', '/admin/dashboard');
            Config::set('fortify.prefix', 'admin');
        }
        else
            {
                Config::set('fortify.guard', 'web');
                Config::set('fortify.passwords', 'users');
                Config::set('fortify.home', '/');
                Config::set('fortify.prefix', '');
            }
    }

    public function boot(): void
    {
        // Fortify::authenticateUsing(function (Request $request) {
        //     $user = \App\Models\User::where('email', $request->input('email'))->first();
        //     if (!$user || !\Illuminate\Support\Facades\Hash::check($request->input('password'), $user->password) || !$user->is_active) {
        //         return null;
        //     }
        //     if ($request->routeIs('admin.login.store') && !$user->isAdmin()) {
        //         return null;
        //     }
        //     return $user;
        // });

        $this->app->bind(\Laravel\Fortify\Contracts\LoginResponse::class, function () {
            return new class implements \Laravel\Fortify\Contracts\LoginResponse {
                public function toResponse($request)
                {
                    if ($request->wantsJson()) {
                        return response()->json(['two_factor' => false]);
                    }
                    return $request->routeIs('admin.login.store')
                        ? redirect()->route('admin.dashboard')
                        : redirect()->intended(config('fortify.home'));
                }
            };
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        // Fortify::loginView(fn () => view('auth.login'));
        // Fortify::registerView(fn () => view('auth.register'));
        // Fortify::requestPasswordResetLinkView(fn () => view('auth.forgot-password'));
        // Fortify::resetPasswordView(fn (Request $request) => view('auth.reset-password', ['request' => $request]));
        // Fortify::verifyEmailView(fn () => view('auth.verify-email'));

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());
            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        //
        if(Config::get('fortify.guard')=='admin') {
            Fortify::ViewPrefix('auth.');
        }
        else {
            Fortify::ViewPrefix('front.auth.'); // Not yet
        }

    }
}
