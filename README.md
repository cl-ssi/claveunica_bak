Probado en laravel 5.8

Librerías para el composer.json

"laravel/socialite": "^4.1",
"ivan-novakov/php-openid-connect-client": "dev-master",

Agregar en el cofig.php
config / app.php
    Laravel\Socialite\SocialiteServiceProvider::class,
    'Socialite' => Laravel\Socialite\Facades\Socialite::class,

Agregar en el routes.php
Route::any('/claveunica/autenticar', 'Auth\LoginController@redirectToProvider')->name('login.claveunica');
Route::any('/claveunica/validar', 'Auth\LoginController@handleProviderCallback')->name('login.claveunica.callback');
