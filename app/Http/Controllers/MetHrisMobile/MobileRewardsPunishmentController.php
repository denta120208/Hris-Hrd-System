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


class MobileRewardsPunishmentController extends Controller
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


    public function getEmployeeRewards(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $rewards = DB::table('emp_rewards')
                    ->join('rewards', 'emp_rewards.rewards_id', '=','rewards.id')
                    ->where('emp_rewards.emp_number', $request->emp_number)
                    ->get();
            } else {
                $rewards = DB::table('emp_rewards')
                    ->join('rewards', 'emp_rewards.rewards_id', '=','rewards.id')
                    ->where('emp_rewards.emp_number', $request->emp_number_search)
                    ->get();
            }

            if ($rewards) {
                $result = $rewards;
            } else {
                $result = [];
            }
            return response()->json($result, 200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->emp_number_search == 0) {
                $rewards = DB::table('emp_rewards')
                    ->join('rewards', 'emp_rewards.rewards_id', '=','rewards.id')
                    ->where('emp_rewards.emp_number', $request->emp_number)
                    ->get();
            } else {
                $rewards = DB::table('emp_rewards')
                    ->join('rewards', 'emp_rewards.rewards_id', '=','rewards.id')
                    ->where('emp_rewards.emp_number', $request->emp_number_search)
                    ->get();
            }

            if ($rewards) {
                $result = $rewards;
            } else {
                $result = [];
            }
            return response()->json($result, 200);
        }
    }

    public function getEmployeePromotions(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $rewards = DB::table('emp_promotions')
                    ->where('emp_number', $request->emp_number)
                    ->get();
            } else {
                $rewards = DB::table('emp_promotions')
                    ->where('emp_number', $request->emp_number_search)
                    ->get();
            }

            if ($rewards) {
                $result = $rewards;
            } else {
                $result = [];
            }

            return response()->json($result, 200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->emp_number_search == 0) {
                $rewards = DB::table('emp_promotions')
                    ->where('emp_number', $request->emp_number)
                    ->get();
            } else {
                $rewards = DB::table('emp_promotions')
                    ->where('emp_number', $request->emp_number_search)
                    ->get();
            }

            if ($rewards) {
                $result = $rewards;
            } else {
                $result = [];
            }

            return response()->json($result, 200);
        }
    }


    public function getEmployeePunishments(Request $request){
        // if ($request->header('APP-ID') == $this->getMobileAppsID()) {
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        if ($request->atasan_status == 1) {
            if ($request->employee_id_search == 'null') {
                $punishments = DB::table('emp_punishment_request')
                    ->join('emp_punishment', 'emp_punishment_request.id', '=', 'emp_punishment.punish_request_id')
                    ->where("emp_punishment_request.emp_id", $request->employee_id)
                    ->orderBy("hrd_approved_at", "desc")
                    ->get();
            } else {
                $punishments = DB::table('emp_punishment_request')
                    ->join('emp_punishment', 'emp_punishment_request.id', '=', 'emp_punishment.punish_request_id')
                    ->where("emp_punishment_request.emp_id", $request->employee_id_search)
                    ->orderBy("hrd_approved_at", "desc")
                    ->get();
            }

            if($punishments){
                $result = $punishments;
            } else {
                $result = [];
            }

            return response()->json($result, 200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMPLOYEE_ID", $request->employee_id)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->employee_id_search == 'null') {
                $punishments = DB::table('emp_punishment_request')
                    ->join('emp_punishment', 'emp_punishment_request.id', '=', 'emp_punishment.punish_request_id')
                    ->where("emp_punishment_request.emp_id", $request->employee_id)
                    ->orderBy("hrd_approved_at", "desc")
                    ->get();
            } else {
                $punishments = DB::table('emp_punishment_request')
                    ->join('emp_punishment', 'emp_punishment_request.id', '=', 'emp_punishment.punish_request_id')
                    ->where("emp_punishment_request.emp_id", $request->employee_id_search)
                    ->orderBy("hrd_approved_at", "desc")
                    ->get();
            }

            if($punishments){
                $result = $punishments;
            } else {
                $result = [];
            }

            return response()->json($result, 200);
        }
    }
}