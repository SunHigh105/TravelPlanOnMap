<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RouteController extends Controller
{
    public function place(Request $request){
        $client = new \GuzzleHttp\Client();
        $base = 'https://maps.googleapis.com/maps/api/geocode/json?language=ja&';
        $place = $request->input('place');
        $apikey = config('app.apikey');
        $url = $base.'address='.$place.'&key='.$apikey;
        $response = $client->request('GET', $url);
        echo $response->getBody();
    }

    public function route(Request $request){
        $client = new \GuzzleHttp\Client();
        $base = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&';
        $origin = $request->input('origin');
        $destination = $request->input('destination');
        $apikey = config('app.apikey');
        $url = $base.'origin='.$origin.'&destination='.$destination.'&key='.$apikey;
        $response = $client->request('GET', $url);
        echo $response->getBody();

    }
}