<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class ClaveUnicaController extends Controller
{
    public function autenticar(){
        $url_base = "https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize";
        $client_id = '469d4d77d9f44eb3bc2555039716e1ab';
        $redirect_uri = urlencode("https://i.saludiquique.cl/test/claveunica/callback");
        $state = csrf_token();
        $scope = 'openid+run+name';
        $url=$url_base.urlencode('?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&scope='.$scope.'&response_type=code&state='.$state);
        header("Location:$url");
        die($url);
    }

    public function callback(Request $request) {
        //https://example.com/?code=5fb3b172913448acadce6b011af1e75e&state=abcdefgh
        $code = $request->input('code');
        $state = $request->input('state'); // token
        //
        // echo $code;
        // echo ' - ';
        // echo $state;

        $url_base = "https://accounts.claveunica.gob.cl/openid/token/";
        $client_id = '469d4d77d9f44eb3bc2555039716e1ab';
        $client_secret = '7e2c1ce635824857a2b0bd85d13f09c4';
        $redirect_uri = urlencode("https://i.saludiquique.cl/test/claveunica/callback");
        $state = csrf_token();
        $scope = 'openid+run+name+email';

        $response = Http::asForm()->post($url_base, [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'redirect_uri' => $redirect_uri,
            'grant_type' => 'authorization_code',
            'code' => $code,
            'state' => csrf_token(),
        ]);

        $array = json_decode($response, true);
        //dd($array);

        $url_base = "https://www.claveunica.gob.cl/openid/userinfo/";
        $response = Http::withToken($array['access_token'])->post($url_base);
	
	echo '<pre>';
	print_r($response->json());
	echo '</pre>';
    }

    /*
    Paso 3
    curl -i 'https://www.claveunica.gob.cl/openid/userinfo/' -X POST -H 'authorization: Bearer TOKEN'
{
"access_token": "05455fc179dc42de8d412eade36d7d55",
"refresh_token": "5472166ac1674a038af70a5505f173dc",
"token_type": "bearer",
"expires_in": 3600,
"id_token": "eyJhbGciOiJSUzI1NiIsImtpZCI6ImM1YWE4YjcyZGZjNmJhMGRiNWQyM2Q5NjEwN2MxMDZkIn0.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmNsYXZldW5pY2EuZ29iLmNsL29wZW5pZCIsInN1YiI6IjI1OTQiLCJhdWQiOiI0NjlkNGQ3N2Q5ZjQ0ZWIzYmMyNTU1MDM5NzE2ZTFhYiIsImV4cCI6MTU4NTY0OTc4NSwiaWF0IjoxNTg1NjQ5MTg1LCJhdXRoX3RpbWUiOjE1ODU2NDkxODQsImF0X2hhc2giOiJCS3cxWHB1d1VnT09mMFR1VmlLeXR3In0.j1BO7O1dO49CyNp5yxyGOLj-rIqhn9Z65dd0XCblkt3zqN-EhBxgBHtLuYBRq_JHtqEnRu-eLvbQD3qwWEQQ2y18KzRHAeXILH2T3QzBrZk5T5muCeFdk1gTkoWlOPEyj0Eshhy_dTvQ8JDlfVmCr2kmTc2Zesyimd3uUSjWEi4"
}

    Paso 2

    client_id: Este parámetro se obtiene al Activar la Institución.
    client_secret: Este parámetro se obtiene al Activar la Institución
    redirect_uri: En este parámetro debe ir la URI de tu aplicación (la misma del Paso 2).
    grant_type: Este parámetro es parte de la lógica utilizada por OpenID Connect y siempre debe ser authorization_code.
    code: En este parámetro debe ir el código de acceso obtenido en el Paso 3.
    state: En este parámetro debe ir el mismo Token único de sesión que fue indicado en el Paso 1.

    curl -i 'https://accounts.claveunica.gob.cl/openid/token/'
    -H 'content-type: application/x-www-form-urlencoded; charset=UTF-8'
    --data '
    client_id=CLIENT_ID&
    client_secret=CLIENT_SECRET&
    redirect_uri=URI_REDIRECT_ENCODEADA&
    grant_type=authorization_code&
    code=CODE&
    state=STATE'


    Paso 1

    https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize%3F
    client_id%3D66a493258641428ea9797fbe33fc8b27%26
    redirect_uri%3Dhttps%253A%252F%252Fwww.chileatiende.gob.cl%252Flogin%252Fclaveunica%252Fcallback%26
    scope%3Dopenid%2Brun%2Bname%2Bemail%26
    response_type%3Dcode%26
    state%3D3xTq6GayWkY6Er1eY4tvfMbnRWYqWOT1ibjyifr5

    https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize%3F
    client_id%3Da4b81d3aa23c457998312c0a980ebc4f%26
    redirect_uri%3Dhttps%253A%252F%252Fi.saludiquique.cl%252Fclaveunica%252Fcallback%26
    scope%3Dopenid%2Brun%2Bname%26
    response_type%3Dcode%26
    state%3DD2983NTMGbk4onKE27AMaYARCyqEIWQy8fhKRbPP

    después de urldecode():

    https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize?
    client_id=66a493258641428ea9797fbe33fc8b27&
    redirect_uri=https%3A%2F%2Fwww.chileatiende.gob.cl%2Flogin%2Fclaveunica%2Fcallback&
    scope=openid+run+name+email&
    response_type=code&
    state=3xTq6GayWkY6Er1eY4tvfMbnRWYqWOT1ibjyifr5


    redirect_uri doble encodeada, aplicada urldecode de nuevo
    https://www.chileatiende.gob.cl/login/claveunica/callback
    */

    // $x = [
    //     'client_id' => 'a4b81d3aa23c457998312c0a980ebc4f',
    //     'response_type' => 'code',
    //     'scope' => 'openid run name',
    //     'redirect_uri' => urlencode('https://i.saludiquique.cl/claveunica/callback'),
    //     'state' => csrf_token()
    // ];
    // https://accounts.claveunica.gob.cl/openid/authorize?client_id=a4b81d3aa23c457998312c0a980ebc4f&response_type=code&scope=openid%20run%20name&redirect_uri=https%3A%2F%2Fi.saludiquique.cl%2Fclaveunica%2Fcallback&state=WzkTyAiC3UPD62jZfxVpa4OVoUg0PX1W0VRAXTNv
    // print_r($x);
    // die($x);

    // $client = new Client([
    //     // Base URI is used with relative requests
    //     'base_uri' => 'https://accounts.claveunica.gob.cl',
    //     // You can set any number of default request options.
    //     //'timeout'  => 2.0,
    // ]);
    // //$response = $client->request('GET', 'authorize');
    // ///$response = $client->get('authorize');
    //
    // $client->request('GET', 'openid/authorize', [
    //     'query' => [
    //         'client_id' => 'a4b81d3aa23c457998312c0a980ebc4f',
    //         'response_type' => 'code',
    //         'scope' => 'openid run name',
    //         'redirect_uri' => urlencode('https://i.saludiquique.cl/claveunica/callback'),
    //         'state' => csrf_token()
    //     ]
    // ]);
    //
    //
    // $client_id = 'a4b81d3aa23c457998312c0a980ebc4f';
    // $redirect_uri = urlencode('https://i.saludiquique.cl/claveunica/callback');
    // $state = csrf_token();
    // $scope = 'openid run name';
    //
    // //header("Location: https://accounts.claveunica.gob.cl/openid/authorize?client_id=".$client_id."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state);
    //
    // $url = "Location: https://accounts.claveunica.gob.cl/openid/authorize?client_id=".$client_id."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=".$state;
    //
    // $ch = curl_init();
    //
    // //Set the URL that you want to GET by using the CURLOPT_URL option.
    // curl_setopt($ch, CURLOPT_URL, $url);
    //
    // //Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //
    // //Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
    // curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    //
    // //Execute the request.
    // $data = curl_exec($ch);
    //
    // //Close the cURL handle.
    // curl_close($ch);
    //
    // //Print the data out onto the page.
    // echo $data;

    /*
    client_id: a4b81d3aa23c457998312c0a980ebc4f
    response_type: code
    scope: openid run name
    redirect_uri: https://i.saludiquique.cl/claveunica/callback
    state: csrf_token()
    URI: https://accounts.claveunica.gob.cl/openid/authorize?client_id=123&redirect_uri=https%3A%2F%2Fexample.com&response_type=code&scope=openid run name&state=abcdefgh
    */

}
