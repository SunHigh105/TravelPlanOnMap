<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Plan;
use App\Place;
// use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Foundation\Bus\DispatchesJobs;
// use Illuminate\Routing\Controller as BaseController;
// use Illuminate\Foundation\Validation\ValidatesRequests;
// use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PlanController extends Controller
{
    public function registPlan(Request $request){
        // $items = $request->input('hour');
        logger($request);
        DB::table('plan')->insert([
            'plan_title' => $request->input('plan_title'),
            'start_time_h' => $request->input('hour'),
            'start_time_m' => $request->input('minute'),
            'user_id' => $request->input('user_id'),
            'created_at'=> date("Y/m/d H:i:s"),
        ]);
    }

    public function registPlace(Request $request){
        logger($request);
        // plan_idを取得 末尾のid
        $plan_id = DB::table('plan')->orderBy('id','desc')->first();
        $items = $request->all();
        logger($items);
        foreach($items as $item){
            DB::table('place')->insert([
                'index' => $item['index'],
                'plan_id' => $plan_id->id,
                'place' => $item['place'],
                'time' => $item['time']
            ]);
        }
    }

    public function showPlan(){
        $plans = DB::table('plan')
                ->leftJoin('users', 'plan.user_id', '=', 'users.id')
                ->select('plan.*', 'users.name')
                ->orderBy('plan.id','desc')
                ->get();
        logger($plans);
        return $plans;
    }

    public function getPlaces(Request $request){
        $places = DB::table('place')
                    ->where('plan_id', $request->input('plan_id'))
                    ->orderBy('index', 'asc')->get();
        logger($places);
        return $places;
    }
}