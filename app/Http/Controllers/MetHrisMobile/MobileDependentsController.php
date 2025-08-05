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


class MobileDependentsController extends Controller
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


    public function getEmployeeDependents(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0 ) {
                // $dependents = DB::table('emp_dependents')
                //     ->where('emp_number', $request->emp_number)
                //     ->get();

                $dependents = DB::select("
                    SELECT id, emp_number, emp_number_old, ed_seqno, ed_name, ed_relationship_type, ed_relationship, CONVERT(VARCHAR, ed_date_of_birth, 20) AS ed_date_of_birth
                    FROM emp_dependents
                    WHERE emp_number = ".$request->emp_number."
                ");
            } else {
                // $dependents = DB::table('emp_dependents')
                //     ->where('emp_number', $request->emp_number_search)
                //     ->get();

                $dependents = DB::select("
                    SELECT id, emp_number, emp_number_old, ed_seqno, ed_name, ed_relationship_type, ed_relationship, CONVERT(VARCHAR, ed_date_of_birth, 20) AS ed_date_of_birth
                    FROM emp_dependents
                    WHERE emp_number = ".$request->emp_number."
                ");
            }

            if (empty($dependents)) {
                $result = [];
            } else {
                $result = $dependents;
            }
            return response()->json($result,200);
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

            if ($request->emp_number_search == 0 ) {
                // $dependents = DB::table('emp_dependents')
                //     ->where('emp_number', $request->emp_number)
                //     ->get();

                $dependents = DB::select("
                    SELECT id, emp_number, emp_number_old, ed_seqno, ed_name, ed_relationship_type, ed_relationship, CONVERT(VARCHAR, ed_date_of_birth, 20) AS ed_date_of_birth
                    FROM emp_dependents
                    WHERE emp_number = ".$request->emp_number."
                ");
            } else {
                // $dependents = DB::table('emp_dependents')
                //     ->where('emp_number', $request->emp_number_search)
                //     ->get();

                $dependents = DB::select("
                    SELECT id, emp_number, emp_number_old, ed_seqno, ed_name, ed_relationship_type, ed_relationship, CONVERT(VARCHAR, ed_date_of_birth, 20) AS ed_date_of_birth
                    FROM emp_dependents
                    WHERE emp_number = ".$request->emp_number."
                ");
            }

            if (empty($dependents)) {
                $result = [];
            } else {
                $result = $dependents;
            }
            return response()->json($result,200);
        }
    }


    public function addEmployeeDependents(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        $r_type = "";

        if($request->relationship_type == 1){
            $r_type = "child";
        } else {
            $r_type = "other";
        }
        $sec_no = 0;
        $dependents = DB::table('emp_dependents')
            ->where('emp_number', $request->emp_number)
            ->orderBy("id", "desc")->first();
        if($dependents){
           $sec_no = $dependents->ed_seqno + 1;
        } else {
            $sec_no = 1;
        }

        DB::table('emp_dependents')
            ->insert([
               "emp_number" => $request->emp_number,
                "ed_seqno" => $sec_no,
                "ed_name" => $request->ed_name,
                "ed_relationship_type" => $request->ed_relationship_type,
                "ed_relationship" => $request->ed_relationship,
                "ed_date_of_birth" => $request->ed_date_of_birth
            ]);
        $last_id = DB::getPdo()->lastInsertId();

        $this->addMobileLog($request->emp_number, "Dependents", "Add Dependents data : ".$last_id);

        $result = ["result" => "Successfully add new dependents.", "status" => 1];
        return response()->json($result, 200);

    }


    public function deleteEmployeeDependents(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $depend_data =  DB::table("emp_dependents")
            ->where('id', $request->depend_id)
            ->first();
        if($depend_data){
            if($depend_data->emp_number == $request->emp_number){
                DB::table("emp_dependents")
                    ->where('id', $request->depend_id)
                    ->delete();
                $this->addMobileLog($request->emp_number, "Dependents", "Delete dependents data : ".$request->depend_id);

                $result = ["result" => "Successfully delete dependents data.", "status" => 1];
            } else {
                $result = ["result" => "This is not your data.", "status" => 0];

            }
        } else {
            $result = ["result" => "Dependents data not found.", "status" => 0];

        }

        return response()->json($result, 200);
    }

    public function updateEmployeeDependents(Request $request){
//                if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $dependents = DB::table('emp_dependents')
            ->where('id', $request->depend_id)
            ->first();

        if($dependents->emp_number == $request->emp_number){

        } else {
            $result = ["result" => "This isn't your data.", "status" => 0];
            return response()->json($result, 200);
        }

        $r_type = "";

        if($request->relationship_type == 1){
            $r_type = "child";
        } else {
            $r_type = "other";
        }

        DB::table("emp_dependents")
            ->where('id', $request->depend_id)
            ->update([
                "ed_name" => $request->ed_name,
                "ed_relationship_type" => $request->ed_relationship_type,
                "ed_relationship" => $request->ed_relationship,
                "ed_date_of_birth" => $request->ed_date_of_birth
            ]);
        $this->addMobileLog($request->emp_number, "Dependents", "Update dependents data : ".$request->depend_id);

        $result = ["result" => "Successfully update new dependents.", "status" => 1];
        return response()->json($result, 200);
    }
}
