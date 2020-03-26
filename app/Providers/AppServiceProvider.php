<?php
/*
  Actualizar el archivo /provider/AppServiceProvider.php según las variables de entorno utilizadas
  - env('APP_ENV')
  - env('APP_URL')
  - env('CLAVEUNICA_REDIRECT')
  - env('CLAVEUNICA_CLIENT_ID')
  - env('CLAVEUNICA_SECRET_ID')
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootClaveUnicaSocialite();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function bootClaveUnicaSocialite()
    {
        $socialite = $this->app->make('Laravel\Socialite\Contracts\Factory');
        $socialite->extend('claveunica',function ($app) use ($socialite) {
                $redirect = env('APP_ENV') == 'local' ? env('APP_URL') . env('CLAVEUNICA_REDIRECT') : secure_url(env('APP_URL') . env('CLAVEUNICA_REDIRECT'));

                $config = [
                    'client_id' => env('CLAVEUNICA_CLIENT_ID') ,
                    'client_secret' => env('CLAVEUNICA_SECRET_ID'),
                    'redirect' => $redirect
                ];

                return $socialite->buildProvider(\App\Socialite\Two\ClaveUnicaProvider::class, $config);
            }
        );
    }
}
