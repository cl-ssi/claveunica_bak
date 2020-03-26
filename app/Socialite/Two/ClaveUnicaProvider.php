<?php
/*Si no se crea este archivo al instalar la librería debe agregarse el mismo en /socialite/Two/ClaveUnicaProvider.php, en caso contrario solo se debe colocar la url */
namespace App\Socialite\Two;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;
//use Log;

class ClaveUnicaProvider extends AbstractProvider implements ProviderInterface
{
    protected $scopes = ['openid', 'run', 'name', 'email'];
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://accounts.claveunica.gob.cl/openid/authorize', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://accounts.claveunica.gob.cl/openid/token';
    }

    /**
     * Get the POST fields for the token request.
     *
     * @param  string  $code
     * @return array
     */
    protected function getTokenFields($code)
    {
        return array_add(
            parent::getTokenFields($code), 'grant_type', 'authorization_code'
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->post('https://www.claveunica.gob.cl/openid/userinfo', [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['RolUnico']['numero'],
            'first_name' => implode(' ',$user['name']['nombres']),
            'last_name' => implode(' ', $user['name']['apellidos']),
            'run' => $user['RolUnico']['numero'],
            'dv' => $user['RolUnico']['DV']
        ]);
    }
}
