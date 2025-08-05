<?php

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileAuthController extends Controller
{


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();
        $this->lvReq = $lvReq;

        $this->user = $user;
        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }



    public function doLogin(Request $request){
        //        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

//
//            $data = $request->data;
//        return response()->json($request->all(), 200);

        $apps_ver  = DB::table("MH_APPS_VER")
                    ->where("APPS_VER_CHAR", $request->APPS_VER)
                    ->where("IS_ACTIVE", 1)
                    ->first();
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');

        if($apps_ver){
            $emp_data  = DB::table("employee")
                ->where("employee_id", $request->USERNAME)
                ->first();

            if($emp_data){

            } else {
                $result = ["result" => "Your employee data not found.", "status" => 0];
            return response()->json($result, 200);
            }

            $users = DB::table("users")
                    ->where("username",  $request->USERNAME)
                    ->first();

            if($users){

            } else {
                $result = ["result" => "Your users data not found.", "status" => 0];
                return response()->json($result, 200);
            }

            if(Hash::check($request->PASSWORD, $users->password)){

            $full_name = $emp_data->emp_firstname." ".$emp_data->emp_middle_name." ".$emp_data->emp_lastname;
                DB::table("MH_USER_LOGIN")
                        ->where("EMPLOYEE_ID", $request->USERNAME)
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
                $member_array = explode(',', $users->permission);
                $is_parent = 0;
                if(in_array("8", $member_array )){
                    $is_parent = 1;
                } else {
                    $is_parent = 0;
                }
//                if($emp_data->job_title_code >= 10){
//                    $is_parent = 1;
//                } else {
//                    $is_parent = 0;
//                }

                $this->addMobileLog($emp_data->emp_number, "Login", "Login to apps.");

                $result = ["result" => "Welcome ".$emp_data->emp_firstname." ". $emp_data->emp_middle_name." ".$emp_data->emp_lastname."!", "status" => 1,"EMP_DATA" => $emp_data,"IS_PARENT" => $is_parent];
                return response()->json($result, 200);
            } else {
                $result = ["result" => "Password does not match.", "status" => 2];
                return response()->json($result, 200);
            }




        } else {
            $result = ["result" => "Your apps version is not valid", "status" => 0];
        }

        return response()->json($result, 200);

    }


    public function checkDataUserLogin(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()) {

        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $db_sso = DB::connection("sqlsrv_sso");

        // $users = DB::table("users")
        //     ->where("username", $request->employee_id)
        //     ->where("status", 1)
        //     ->first();

        $users = $db_sso->table("users")
            ->join("SSO_USERS_APPS", "users.id", "=", "SSO_USERS_APPS.id_user")
            ->where("id_apps", 6)
            ->where("NIK", $request->employee_id)
            ->where("users.isactive", 1)
            ->select('users.*', 'SSO_USERS_APPS.id_user', 'SSO_USERS_APPS.level', 'SSO_USERS_APPS.project', 'SSO_USERS_APPS.assigment_project', 'SSO_USERS_APPS.mobile_menu', 'SSO_USERS_APPS.is_manage as is_managed', 'SSO_USERS_APPS.menus as permission')
            ->first();

        if ($users) {

        } else {
            $result = ["result" => "User not found.", "status" => 2];
            return response()->json($result, 200);
        }

        $emp_data  = DB::table("employee")
            ->where('employee_id', $request->employee_id)
            ->where('termination_id', 0)
            ->first();

        if($emp_data){

        } else {
            $result = ["result" => "Your employee data not found.", "status" => 2];
            return response()->json($result, 200);
        }

        $apps_ver = DB::table("MH_APPS_VER")
            ->where("APPS_VER_CHAR", $request->apps_ver)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($apps_ver) {

        } else {
            $apps_verUser = DB::table("MH_APPS_VER")
                ->where("APPS_VER_CHAR", $request->apps_ver)
                ->first();

            if ($apps_verUser) {
                $result = [
                  "result" => $apps_verUser->APPS_VER_MAINTENANCE_DESC,
                   "status" => 3
                ];
                return response()->json($result, 200);
            } else {
                $result = [
                    "result" => "Versi aplikasi tidak sesuai. Silahkan update aplikasi.",
                    "status" => 3
                ];
                return response()->json($result, 200);
            }
        }



        $mobile = DB::table("MH_USER_MOBILE")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($mobile) {
            DB::table("MH_USER_MOBILE")
                ->where("EMPLOYEE_ID", $request->employee_id)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->update([
                   "LAST_LOGIN"  => $now,
                   "APPS_VERSION" => $request->apps_ver
                ]);
            $member_array = explode(',', $users->permission);
            $is_parent = 0;
            if(in_array("9", $member_array )){
                $is_parent = 1;
            } else {
                $is_parent = 0;
            }

            // $member = DB::table('employee')
            //     ->leftjoin('emp_picture', 'employee.emp_number','=','emp_picture.emp_number')
            //     ->rightjoin ('users', 'users.username', '=', 'employee.employee_id')
            //     ->where('users.username', $request->employee_id)
            //     ->select('employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname',
            //         'employee.emp_number', 'users.is_manage', 'users.username', 'users.name', 'employee.job_title_code', 'users.is_changepassword')
            //     ->first();

            $employee = DB::table('employee')
                ->where('employee_id', $request->employee_id)
                ->first();

            $sso = $db_sso->table('users')
                ->where('NIK', $request->employee_id)
                ->first();

            $img = DB::table("emp_picture")
                // ->where("emp_number", $member->emp_number)
                ->where("emp_number", $employee->emp_number)
                ->first();

            if($img){
                if($img->epic_picture_type == 2){
                    $picture =  base64_encode( $img->epic_picture );
                } else {
                    $picture = $img->epic_picture;
                }

                // $picture =  base64_encode( $img->epic_picture );
            } else {
                $picture = null;
            }

            // if($member->job_title_code >= 10){
            //     $is_parent = 1;
            // } else {
            //     $is_parent = 0;
            // }

            $emp_data = [
                // "emp_firstname" => $member->emp_firstname,
                // "emp_middle_name" => $member->emp_middle_name,
                // "emp_lastname" => $member->emp_lastname,
                // "emp_number" => $member->emp_number,
                // "is_managed" => $member->is_manage,
                "emp_firstname" => $employee->emp_firstname,
                "emp_middle_name" => $employee->emp_middle_name,
                "emp_lastname" => $employee->emp_lastname,
                "emp_number" => $employee->emp_number,
                "id_sso" => $sso->id,
                "is_changepassword" => $sso->ischangepassword,
                "picture" => $picture,
                // "is_changepassword" => $member->is_changepassword
            ];
            // $this->addMobileLog($member->emp_number, "Check data user login", "Check data user login.");
            $this->addMobileLog($employee->emp_number, "Check data user login", "Check data user login.");

            $result = ["result" => "User Active.", "status" => 1,"is_parent" => $is_parent, "emp_data" => $emp_data, "apps_ver" => "Apps version valid."];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You've been logged out.", "status" => 2];
            return response()->json($result, 200);
        }
    }


    public function testHash(Request $request){
        $users = DB::table("users")
            ->where("username", $request->employee_id)
            ->first();
        $test_pass = 'metland123';
        $bcyrpt = bcrypt($request->decrypt);
        $test_bcrypt = bcrypt($test_pass);

        print_r("Request decrpt == Users password");
        if(Hash::check($request->decrypt, $test_bcrypt)){
            print_r(" same");
            print_r($bcyrpt);
        } else {
            print_r(" not same");
        }

        print_r("\nRequest decrpt == Users password");

        if(Hash::check($request->decrypt, $users->password)){
            print_r(" same");
            print_r($bcyrpt);
        } else {
            print_r(" not same");
        }
    }


    public function doLogoutApps(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

//        $employee_mobile = DB::table("MH_USER_MOBILE")
//            ->where("EMP_NUMBER", $request->emp_number)
//            ->where("DEVICE_UUID", $request->device_uuid)
//            ->where("IS_ACTIVE", 1)
//            ->first();
//
//        if($employee_mobile){
//
//        } else {
//            $result = ["result" => "You're not logged in.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $emp_data = DB::table("employee")
                ->where("employee_id", $request->employee_id)
                ->first();

        DB::table("MH_USER_MOBILE")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->update([
                "IS_ACTIVE" => 0
            ]);
        DB::table("MH_USER_LOGIN")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->where("IS_ACTIVE", 1)
            ->update([
               "UPDATED_AT" => $now,
               "IS_ACTIVE" => 0
            ]);
        $this->addMobileLog($emp_data->emp_number, "Logout", "Log out from all devices.");

        $result = ["result" => "Successfully logged out.", "status" => 1];
           return response()->json($result, 200);
    }

}
