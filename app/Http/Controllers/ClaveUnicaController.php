<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ClaveUnicaController extends Controller
{
    public function autenticar(){

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

        header("Location: https://accounts.claveunica.gob.cl/openid/authorize?client_id=a4b81d3aa23c457998312c0a980ebc4f&response_type=code&scope=openid%20run%20name&redirect_uri=https%3A%2F%2Fi.saludiquique.cl%2Fclaveunica%2Fcallback&state=WzkTyAiC3UPD62jZfxVpa4OVoUg0PX1W0VRAXTNv");

        //dd($client);

        /*
        client_id: a4b81d3aa23c457998312c0a980ebc4f
        response_type: code
        scope: openid run name
        redirect_uri: https://i.saludiquique.cl/claveunica/callback
        state: csrf_token()
        URI: https://accounts.claveunica.gob.cl/openid/authorize?client_id=123&redirect_uri=https%3A%2F%2Fexample.com&response_type=code&scope=openid run name&state=abcdefgh
        */
    }


    public function callback(Request $request) {
        //https://example.com/?code=5fb3b172913448acadce6b011af1e75e&state=abcdefgh
        $code = $request->input('code');
        $state = $request->input('state'); // token

        echo $code;
        echo ' - ';
        echo $state;

    }
}
