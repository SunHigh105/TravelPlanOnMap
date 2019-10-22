<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use Auth;

class MyPageController extends Controller{
    public function mypage(){
        if(Auth::user()){
            return view('mypage');
        }else{
            return redirect('/');
        }
    }

    public function showRegisterdPlans(Request $request){
        $plans = DB::table('plan')
                ->where('user_id', $request->input('user_id'))
                ->orderBy('id', 'desc')
                ->get();
        logger($plans);
        return $plans;
    }

    public function editPlan(Request $request){
        logger('edit plan');
    }

    public function deletePlan(Request $request){
        // 目的地を削除
        logger($request->input('id'));
        DB::table('place')
            ->where('plan_id', $request->input('id'))
            ->delete();
        // プランを削除
        DB::table('plan')
            ->where('id', $request->input('id'))
            ->delete();
    }

    public function withdraw(){

    }
}