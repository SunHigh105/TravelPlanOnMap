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
    public function route(Request $request){
        $base = 'https://maps.googleapis.com/maps/api/directions/json?language=ja&';
        $url = $base.'origin='.$request->input('origin').'&destination='.$request->input('destination').'&key='.config('app.apikey');

        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', $url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Access-Control-Allow-Origin' => '*'
            ]
        ]);

        return $response->getBody();
    }
}
