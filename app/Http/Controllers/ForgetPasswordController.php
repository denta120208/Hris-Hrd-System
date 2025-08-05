<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ForgetPasswordController extends Controller{
    public function __construct(){
        //$this->middleware('auth')->except(['forgot_password', 'forgotPassword']);
    }

    public function index(){

        return view('pages.users.forgotPass');
    }
    public function setForgotPass(Request $request){
        try{
            $emp = DB::table('employee')->where('employee_id', $request->username)->firstOrFail();

            return view('pages.users.forgotPass');
        }catch (\ErrorException $e){

            return redirect()->route('redeem.cre9ate', ['card_no' => $request->card_no]);
        }
    }
}
