<?php

namespace MedSchoolCoach\LumenAuth0;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use MedSchoolCoach\LumenAuth0\Contracts\TokenVerifier;
use MedSchoolCoach\LumenAuth0\Contracts\Verifier;
use MedSchoolCoach\LumenAuth0\Models\User;

/**
 * Class Auth0ServiceProvider
 * @package MedSchoolCoach\LumenAuth0
 */
class Auth0ServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/auth0.php'), 'auth0');
        $this->app->singleton(Auth0Verifier::class, function () {
            return new Auth0Verifier();
        });
        $this->app->singleton(Verifier::class, function () {
            return new Auth0Verifier();
        });
    }

    /**
     * Bootstrap the application services.
     *
     * @param  Auth0Verifier  $verifier
     *
     * @return void
     */
    public function boot(Auth0Verifier $verifier)
    {
        $this->app['auth']->viaRequest('jwt', function (Request $request) use ($verifier) {
            $token = $request->bearerToken();

            if (empty($token) || ! $verifier->check($token)) {
                return null;
            }

            if ($user = $verifier->getInfo($token)) {
                return new User($user);
            }
        });
    }
}
