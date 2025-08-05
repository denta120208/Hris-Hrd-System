<?php

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;
use Psy\Util\Json;


class MobileEmergencyContactController extends Controller
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


    public function getEmergencyContact(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        if ($request->atasan_status == 1) {
            if( $request->emp_number_search == 0) {
                $eec = DB::table('emp_emergency_contacts')->where('emp_number', $request->emp_number)->orderBy('eec_seqno')->get();
            } else {
                $eec = DB::table('emp_emergency_contacts')->where('emp_number', $request->emp_number_search)->orderBy('eec_seqno')->get();
            }
            return response()->json($eec,200);
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

            if( $request->emp_number_search == 0) {
                $eec = DB::table('emp_emergency_contacts')->where('emp_number', $request->emp_number)->orderBy('eec_seqno')->get();
            } else {
                $eec = DB::table('emp_emergency_contacts')->where('emp_number', $request->emp_number_search)->orderBy('eec_seqno')->get();
            }
            return response()->json($eec,200);
        }
    }


    public function addDataEmergencyContact(Request $request){
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

        $eec = DB::table('emp_emergency_contacts')->where('emp_number', $request->emp_number)->orderBy('eec_seqno', 'desc')->first();
        $new_sec = 0;
        if ($eec){
            $new_sec = $eec->eec_seqno + 1;
        } else {
            $new_sec = 1;
        }
        DB::table("emp_emergency_contacts")
            ->insert([
               "emp_number" => $request->emp_number,
               "eec_seqno" => $new_sec,
               "eec_name" => $request->name,
               "eec_relationship" => $request->relationship,
               "eec_home_no" => $request->home_no,
               "eec_mobile_no" => $request->mobile_no,
               "eec_office_no" => $request->office_no
            ]);
        $last_id = DB::getPdo()->lastInsertId();

        $this->addMobileLog($request->emp_number, "Emergency Contact", "Add new emergency contact : ".$last_id);

        $result = ["result" => "Successfully add new emergency contact.", "status" => 1];
        return response()->json($result, 200);
    }

    public function deleteDataEmergencyContact(Request $request){
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


        $eec_data =  DB::table("emp_emergency_contacts")
            ->where('id', $request->eec_id)
            ->first();
        if($eec_data){
            if($eec_data->emp_number == $request->emp_number){
                DB::table("emp_emergency_contacts")
                    ->where('id', $request->eec_id)
                    ->delete();

//                $this->addMobileLog($request->emp_number, "Emergency Contact", "Delete emergency contact : ".$eec_data->eec_id);

                $result = ["result" => "Successfully delete emergency contact.", "status" => 1];
            } else {
                $result = ["result" => "This is not your data.", "status" => 0];

            }
        } else {
            $result = ["result" => "Emergency data not found.", "status" => 0];

        }

        return response()->json($result, 200);


    }


    public function updateDataEmergencyContact(Request $request){
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
//
//        $request = $request->all();
//
//        $request = array_filter($request);
//        $request = json_decode($request);
//        dd($request->emp_number);
        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $eec_data =DB::table('emp_emergency_contacts')->where('id', $request->eec_id)->first();

        if($eec_data->emp_number == $request->emp_number){

        } else {
            $result = ["result" => "This is not you data.", "status" => 0 ];
        }

        DB::table("emp_emergency_contacts")
            ->where('id', $request->eec_id)
            ->update([
                "eec_name" => $request->name,
                "eec_relationship" => $request->relationship,
                "eec_home_no" => $request->home_no,
                "eec_mobile_no" => $request->mobile_no,
                "eec_office_no" => $request->office_no
            ]);

        $this->addMobileLog($request->emp_number, "Emergency Contact", "Update emergency contact : ".$request->eec_id);

        $result = ["result" => "Successfully update emergency contact.", "status" => 1];
        return response()->json($result, 200);
    }
}
