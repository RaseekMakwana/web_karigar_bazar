<?php
namespace App\Services;

use GuzzleHttp\Client;
// use Illuminate\Support\Facades\Http;

class RestApi
{
    public static function post($url, $data)
    {
        $client = new Client(['base_uri' => config('app.api_url')]); //GuzzleHttp\Client
        $headers = [];
        $response = $client->post($url, ['form_params' => $data]);
        $responseJSON = json_decode($response->getBody(), true);
        return $responseJSON;
    }
    public static function get($url)
    {
        $client = new Client(['base_uri' => config('app.api_url')]); //GuzzleHttp\Client
        $headers = [];
        $response = $client->get($url);
        $responseJSON = json_decode($response->getBody(), true);
        return $responseJSON;
    }

}
