<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileAppSettingsController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();
        $this->lvReq = $lvReq;

        $this->user = $user;
        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }

    public function getAppsSettings(Request $request){
        $this->addMobileLog(0, "Get apps settings", "Get apps settings.");


//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $settings = DB::table("MH_APPS_SETTINGS")
                ->first();
        return response()->json($settings, 200);
    }


    public function getAppsHelp(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $settings = DB::table("MH_APPS_HELP")
            ->where("IS_ACTIVE", 1)
            ->get();
        return response()->json($settings, 200);
    }
}
