<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
class ClaveUnicaController extends Controller
{
    public function autenticar(){
        $url_base = "https://accounts.claveunica.gob.cl/accounts/login/?next=/openid/authorize";
        $client_id = 'a4b81d3aa23c457998312c0a980ebc4f';
        $redirect_uri = urlencode('https://i.saludiquique.cl/claveunica/callback');
        $state = csrf_token();
        $scope = 'openid+run+name';
        $url=$url_base.urlencode('?client_id='.$client_id.'&redirect_uri='.$redirect_uri.'&scope='.$scope.'&response_type=code&state='.$state);
        header("Location:$url");
    }

    public function callback(Request $request) {
        //https://example.com/?code=5fb3b172913448acadce6b011af1e75e&state=abcdefgh
        $code = $request->input('code');
        $state = $request->input('state'); // token

        echo $code;
        echo ' - ';
        echo $state;
    }

    /*
    Esteban: esta URL la obtuve al visitar chileatiende, clickeando en login

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
