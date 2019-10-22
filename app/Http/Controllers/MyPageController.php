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
}