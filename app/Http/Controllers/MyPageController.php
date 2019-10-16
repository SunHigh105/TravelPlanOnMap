<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
}