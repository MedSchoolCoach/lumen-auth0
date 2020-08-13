<?php

namespace MedSchoolCoach\LumenAuth0;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
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
        $this->app->configure('auth0');
        $this->mergeConfigFrom(realpath(__DIR__.'/../config/auth0.php'), 'auth0');

        $this->app->singleton(TokenVerifier::class, function (Application $app) {
            return new Auth0TokenVerifier(
                auth0_config('domain'),
                auth0_config('audience'),
                auth0_config_client('client_id'),
                auth0_config('jwks_uri'),
                $app->make(CacheRepository::class));
        });

        $this->app->singleton(Verifier::class, Auth0Verifier::class);

        $this->app->routeMiddleware([
            'auth0'      => \MedSchoolCoach\LumenAuth0\Http\Middleware\Auth0Middleware::class,
            'auth0Admin' => \MedSchoolCoach\LumenAuth0\Http\Middleware\Auth0AdminMiddleware::class,
        ]);
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

            return new User($verifier->getInfo($token));
        });
    }
}
