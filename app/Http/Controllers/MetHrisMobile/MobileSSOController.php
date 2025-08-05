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


class MobileSSOController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();


    }

    public function doLoginSSO(Request $request)
    {
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        date_default_timezone_set('Asia/Jakarta');
        $db_sso = DB::connection("sqlsrv_sso");
        $now = date('Y-m-d H:i:s');

        $apps_ver  = DB::table("MH_APPS_VER")
            ->where("APPS_VER_CHAR", $request->APPS_VER)
            ->where("IS_ACTIVE", 1)
            ->first();
        date_default_timezone_set('Asia/Jakarta');
//
//        $user = DB::table('users')
//            ->where('email', $request->username)
//            ->where('banned', 0)
//            ->where('activated', 1)
//            ->first();
        $fieldType = filter_var($request->USERNAME, FILTER_VALIDATE_EMAIL) ? true : false;

//print_r($fieldType);
        if ($fieldType == true) {
            $user = $db_sso->table("users")
                ->where("email", $request->USERNAME)
                ->where("isactive", 1)
                ->first();
        } else {
            $user = $db_sso->table("users")
                ->where("NIK", $request->USERNAME)
                ->where("isactive", 1)
                ->first();
        }

//        if ($apps_ver) {

            if ($user) {
                $hash = Hash::check($request->PASSWORD, $user->password);
                if($hash == true){

                    $user_apps = $db_sso->table("SSO_USERS_APPS")
                        ->where("id_user", $user->id)
                        ->where("id_apps", 6)
                        ->select('id_user','level', 'project', 'assigment_project', 'mobile_menu', 'is_manage as is_managed', 'menus as permission')
                        ->first();

                    if($user_apps){

                    } else {
                        $result = ["result" => "Anda tidak memiliki akses ke HRIS.",
                            "status" => 0];
                        return response()->json($result, 200);
                    }
                    $user_profile =  $db_sso->table('users')
                        ->where('id', $user->id)
                        ->select('username', 'NIK', 'first_name', 'middle_name', 'last_name', 'email','ischangepassword')
                        ->first();
//print_r($user_profile); die;
                    $emp_data  = DB::table("employee")
                        ->where("employee_id", $user_profile->NIK)
                        ->where('termination_id', 0)
                        ->first();

                    if($emp_data){

                    } else {
                        $result = ["result" => "Your employee data not found.", "status" => 0];
                        return response()->json($result, 200);
                    }

                    // Login DB ml_HRIS
//                    $users = DB::table("users")
//                        ->where("username",   $user_profile->NIK)
//                        ->first();
//
//                    if($users){
//
//                    } else {
//                        $result = ["result" => "Your users data not found.", "status" => 0];
//                        return response()->json($result, 200);
//                    }
                    $full_name = $emp_data->emp_firstname." ".$emp_data->emp_middle_name." ".$emp_data->emp_lastname;
                    DB::table("MH_USER_LOGIN")
                        ->where("EMPLOYEE_ID", $user_profile->NIK)
                        ->where("IS_ACTIVE", 1)
                        ->update([
                            "IS_ACTIVE" => 0,
                            "UPDATED_AT" => $now
                        ]);

                    DB::table("MH_USER_LOGIN")
                        ->insert([
                            "EMPLOYEE_ID" => $emp_data->employee_id,
                            "DEVICE_UUID" => $request->DEVICE_UUID,
                            "DEVICE_PLATFORM" => $request->DEVICE_PLATFORM,
                            "DEVICE_MODEL" => $request->DEVICE_MODEL,
                            "DEVICE_MANUFACTURER" => $request->DEVICE_MANUFACTURER,
                            "CREATED_AT" => $now,
                            "IS_ACTIVE" => 1
                        ]);

                    $cek_user_mobile = DB::TABLE("MH_USER_MOBILE")
                        ->where("EMPLOYEE_ID", $request->USERNAME)
                        ->first();

                    if($cek_user_mobile){
                        DB::table("MH_USER_MOBILE")
                            ->where("EMPLOYEE_ID", $request->USERNAME)
                            ->update([
                                "DEVICE_UUID" => $request->DEVICE_UUID,
                                "DEVICE_SERIAL" => $request->DEVICE_SERIAL,
                                "PLAYER_ID" => $request->PLAYER_ID,
                                "DEVICE_MODEL" => $request->DEVICE_MODEL,
                                "DEVICE_MANUFACTURER" => $request->DEVICE_MANUFACTURER,
                                "DEVICE_PLATFORM" => $request->DEVICE_PLATFORM,
                                "DEVICE_VERSION" => $request->DEVICE_VERSION,
                                "IS_ACTIVE" => 1,
                                "LAST_LOGIN" => $now,
                                "EMP_FULLNAME" => $full_name
                            ]);
                    } else {
                        DB::table("MH_USER_MOBILE")
                            ->insert([
                                "DEVICE_UUID" => $request->DEVICE_UUID,
                                "DEVICE_SERIAL" => $request->DEVICE_SERIAL,
                                "PLAYER_ID" => $request->PLAYER_ID,
                                "DEVICE_MODEL" => $request->DEVICE_MODEL,
                                "DEVICE_MANUFACTURER" => $request->DEVICE_MANUFACTURER,
                                "DEVICE_PLATFORM" => $request->DEVICE_PLATFORM,
                                "DEVICE_VERSION" => $request->DEVICE_VERSION,
                                "IS_ACTIVE" => 1,
                                "LAST_LOGIN" => $now,
                                "EMP_NUMBER" => $emp_data->emp_number,
                                "EMPLOYEE_ID" => $emp_data->employee_id,
                                "EMP_FULLNAME" => $full_name
                            ]);
                    }
                    $member_array = explode(',', $user_apps->permission);
                    $is_parent = 0;
                    if(in_array("8", $member_array )){
                        $is_parent = 1;
                    } else {
                        $is_parent = 0;
                    }
                    $this->addMobileLog($emp_data->emp_number, "Login", "Login to apps.");

                    $result = ["result" => "Welcome ".$emp_data->emp_firstname." ". $emp_data->emp_middle_name." ".$emp_data->emp_lastname."!", "status" => 1,"EMP_DATA" => $emp_data,"IS_PARENT" => $is_parent];
                    return response()->json($result, 200);


                } else {
                    $result = ["result" => "Password does not match.", "status" => 2];
                    return response()->json($result, 200);                }
            } else {
                $result = ["result" => "User not found.", "status" => 0];

            }
//        } else {
//            $result = ["result" => "Apps version not valid.", "status" => 0];
//
//        }
        return response()->json($result, 200);


    }
}
