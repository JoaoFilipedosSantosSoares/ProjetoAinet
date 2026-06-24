<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        Fortify::loginView(function () {
            return view('account.login.index');
        });

        Fortify::registerView(function () {
            return view('account.register.index');
        });

        Fortify::verifyEmailView(function () {
            return view('account.register.verify-email');
        });
        Fortify::resetPasswordView(function (Request $request) {

            if (!$request->route('token') || !$request->has('email')) {
                return redirect()->route('login')
                    ->withErrors(['email' => 'Link de redefinição inválido ou expirado.']);
            }

            return view('account.login.reset-password', [
                'request' => $request,
                'token' => $request->route('token'),
            ]);
        });

        if (class_exists(Fortify::class)) {
            Fortify::authenticateUsing(function (Request $request) {
                $user = User::where('email', $request->email)->first();

                if ($user && Hash::check($request->password, $user->password)) {

                    if ($user->blocked == 1) {
                        throw ValidationException::withMessages([
                            'email' => ['A sua conta encontra-se bloqueada. Contacte o administrador.'],
                        ]);
                    }

                    return $user;
                }
            });
        }


        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('FunShirt - Confirma o teu endereço de e-mail')
                ->greeting('Olá, ' . $notifiable->name . '!')
                ->line('Obrigado por criares conta na FunShirt. Para começares a encomendar as tuas t-shirts personalizadas, precisamos apenas que confirmes o teu e-mail.')
                ->action('Verificar Conta', $url)
                ->line('Se não criaste nenhuma conta no nosso website, podes ignorar este e-mail com segurança.')
                ->salutation('A equipa da FunShirt!');
        });


        ResetPassword::toMailUsing(function (object $notifiable, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ], false));

            $expireTime = config('auth.passwords.' . config('auth.defaults.passwords') . '.expire');

            return (new MailMessage)
                ->subject('Recuperação de Password - ' . config('app.name'))
                ->greeting('Olá!')
                ->line('Recebemos um pedido para redefinir a password da tua conta.')
                ->action('Redefinir Password', $url)
                ->line('Este link de recuperação vai expirar em ' . $expireTime . ' minutos.')
                ->line('Se não pediste isto, podes ignorar este e-mail em segurança.')
                ->salutation('Cumprimentos, Equipa do ' . config('app.name'));
        });


        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');

            return Limit::perMinute(10)->by(
                ($credentialId ?: $request->session()->getId()) . '|' . $request->ip()
            );
        });
    }
}
