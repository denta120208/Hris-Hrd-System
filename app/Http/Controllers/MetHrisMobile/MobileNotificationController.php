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


class MobileNotificationController extends Controller
{


    protected $lvReq;


    function __construct()
    {

        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }

    public function TestsendNotifalluser(Request $request){
        $client = new \GuzzleHttp\Client();
        $fields = [
            "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
//            "contents" => ["en" => $request->contents],
//            "headings" => ["en" => $request->headings],
            "contents" => ["en" => "Test Notif"],
            "headings" => ["en" => "Test Notif"],
            "android_accent_color" => "009291",
            "include_player_ids" => ["f0ae598e-cff0-413c-a17a-dc5da158adc7"],
            "priority" => 10,
//            "included_segments" => ["Active Users", "Inactive Users"],
//            "small_icon" => "ic_notification_icon",
//            "android_background_layout" => [
//                "image" => "https://mbm.metropolitanland.com/assets/banner.jpg",
//                "headings_color" => "FFFFFFFF",
//                "contents_color" => "FFFFFFFF"
//            ],
//            "large_icon" => "ic_notification_icon"
            "data"=> [
                "status" => 1,
                "data" => "",
            ]
        ];
//        $header = [
//            "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
//            "Content-Type" => "text/html; charset=UTF-8"
//        ];
        $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Authorization' => 'Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1',
                'Content-Type' => 'application/json',
            ],
            'json' => $fields
        ]);
        
        print_r($fields);
    }


    public function postNotifUser($emp_number, $headings, $content){
        
        $user_mobile = DB::table("MH_USER_MOBILE")
                    ->where("EMP_NUMBER", $emp_number)
                    ->where("IS_ACTIVE", 1)
                    ->whereNotNull("PLAYER_ID")
                    ->first();
        
        if($user_mobile){
            if ($user_mobile->PLAYER_ID) {
                $client = new Client();
                $fields = [
                    "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
                    "contents" => ["en" => $content],
                    "headings" => ["en" => $headings],
                    "include_player_ids" => [$user_mobile->PLAYER_ID],
                    "priority" => 10,
        //            "small_icon" => "ic_notification_icon",
                    "android_accent_color" => "FF00ffaa",
        //            "android_background_layout" => [
        //                "image" => "https://hris2.metropolitanland.com/images/mobile/banner_hriscompessed.jpg",
        //                "headings_color" => "FFFFFFFF",
        //                "contents_color" => "FFFFFFFF"
        //            ],
        //            "large_icon" => "ic_notification_icon"
                ];
                $header = [
                    "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
                    "Content-Type" => "text/html; charset=UTF-8"
                ];
                $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
                        'headers' => [
                            'Authorization' => 'Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1',
                            'Content-Type' => 'application/json'],
                        'json' => $fields]
                );
            } else {
                $result = ["result" => $emp_number." is not logged in", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => $emp_number." is not logged in", "status" => 0];
            return response()->json($result, 200);
        }
    }


    public function requestTrainingNotification($training_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $training_request = DB::table("emp_trainning_request")
                            ->where("id", $training_id)
                            ->first();

        $training_topic = DB::table("trainning")
                        ->where("id", $training_request->trainning_id)
                        ->first();
        $emp = DB::table("employee")
            ->where("emp_number", $training_request->emp_number)
            ->first();
        $reportTo = DB::table("emp_reportto")
            ->where("erep_sub_emp_number", $training_request->emp_number)
            ->where("erep_reporting_mode", 1)
            ->get();

        if($reportTo){
            $desc = $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname." is requesting a training : ".$training_topic->name." Please check it out.";
            $title = "New Training Request";
            for($i=0;$i<count($reportTo);$i++){
                //getting data atasan

                $emp_report = DB::table("employee")
                    ->where("emp_number", $reportTo[$i]->erep_sup_emp_number)
                    ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                        "EMP_NUMBER" => $emp_report->emp_number,
                        "EMPLOYEE_ID" => $emp_report->employee_id,
                        "NOTIFICATION_TITLE" => $title,
                        "NOTIFICATION_DESC" => $desc,
                        "IS_READ" => 0,
                        "IS_DELETED" => 0,
                        "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 7,
                        "NOTIFICATION_TYPE_ID" => 3,
                        "MODULE_ID" => $training_id
                    ]);

                $this->postNotifUser($reportTo[$i]->erep_sup_emp_number, $title, $desc);


            }
        }
    }

    public function requestLeaveNotification($leave_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $leave = DB::table("emp_leave_request")
                ->where('id', $leave_id)
                ->first();
        $emp = DB::table("employee")
              ->where("emp_number", $leave->emp_number)
              ->first();

        $reportTo = DB::table("emp_reportto")
                    ->where("erep_sub_emp_number", $leave->emp_number)
                    ->where("erep_reporting_mode", 1)
                    ->get();

        if($reportTo){
            $desc = $emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname." is requesting a leave : ".$leave->comments.". Many days : ".$leave->length_days.". Please check it out.";
            $title = "New Leave Request";
            for($i=0;$i<count($reportTo);$i++){
                //getting data atasan

                $emp_report = DB::table("employee")
                            ->where("emp_number", $reportTo[$i]->erep_sup_emp_number)
                            ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                       "EMP_NUMBER" => $emp_report->emp_number,
                       "EMPLOYEE_ID" => $emp_report->employee_id,
                       "NOTIFICATION_TITLE" => $title,
                       "NOTIFICATION_DESC" => $desc,
                       "IS_READ" => 0,
                       "IS_DELETED" => 0,
                       "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 1,
                        "NOTIFICATION_TYPE_ID" => 1,
                        "MODULE_ID" => $leave_id
                    ]);

                $this->postNotifUser($reportTo[$i]->erep_sup_emp_number, $title, $desc);
                
                
            }
        }

    }

    public function approveTrainingNotification($approved_by,$training_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $training_request = DB::table("emp_trainning_request")
            ->where("id", $training_id)
            ->first();


        $emp_b = DB::table("employee")
            ->where("emp_number", $training_request->emp_number)
            ->first();

        $training_topic = DB::table("trainning")
            ->where("id", $training_request->trainning_id)
            ->first();

        $emp_a = DB::table("employee")
            ->where("emp_number", $approved_by)
            ->first();



        $desc = $emp_a->emp_firstname." ".$emp_a->emp_middle_name." ".$emp_a->emp_lastname." is approved your training : ".$training_topic->name." Please check it out.";
        $title = "Approved Training";
        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp_b->emp_number,
                "EMPLOYEE_ID" => $emp_b->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 8,
                "NOTIFICATION_TYPE_ID" => 3,
                "MODULE_ID" => $training_id
            ]);

        $this->postNotifUser($emp_b->emp_number, $title, $desc);
    }

    public function approveLeaveNotification($approved_by,$leave_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $leave = DB::table("emp_leave_request")
            ->where('id', $leave_id)
            ->first();
        $emp = DB::table("employee")
            ->where("emp_number", $leave->emp_number)
            ->first();

        $emp_approved = DB::table("employee")
            ->where("emp_number", $approved_by)
            ->first();
        $desc = $emp_approved->emp_firstname." ".$emp_approved->emp_middle_name." ".$emp_approved->emp_lastname." is approved your  leave : ".$leave->comments." Please check it out.";
        $title = "Approved Leave";

        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp->emp_number,
                "EMPLOYEE_ID" => $emp->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 2,
                "NOTIFICATION_TYPE_ID" => 1,
                "MODULE_ID" => $leave_id
            ]);
        $this->postNotifUser($leave->emp_number, $title, $desc);

    }

    public function rejectTrainingNotification($rejected_by,$leave_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $training_request = DB::table("emp_trainning_request")
            ->where("id", $leave_id)
            ->first();


        $emp_b = DB::table("employee")
            ->where("emp_number", $training_request->emp_number)
            ->first();

        $training_topic = DB::table("trainning")
            ->where("id", $training_request->trainning_id)
            ->first();

        $emp_a = DB::table("employee")
            ->where("emp_number", $rejected_by)
            ->first();



        $desc = $emp_a->emp_firstname." ".$emp_a->emp_middle_name." ".$emp_a->emp_lastname." is rejected your training : ".$training_topic->name." Please check it out.";
        $title = "Rejected Training";
        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp_b->emp_number,
                "EMPLOYEE_ID" => $emp_b->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 9,
                "NOTIFICATION_TYPE_ID" => 3,
                "MODULE_ID" => $leave_id
            ]);

        $this->postNotifUser($emp_b->emp_number, $title, $desc);
    }

    public function rejectLeaveNotification($rejected_by,$leave_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $leave = DB::table("emp_leave_request")
            ->where('id', $leave_id)
            ->first();
        $emp = DB::table("employee")
            ->where("emp_number", $leave->emp_number)
            ->first();

        $emp_approved = DB::table("employee")
            ->where("emp_number", $rejected_by)
            ->first();
        $desc = $emp_approved->emp_firstname." ".$emp_approved->emp_middle_name." ".$emp_approved->emp_lastname." is rejected your leave : ".$leave->comments." Please check it out.";
        $title = "Rejected Leave";

        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp->emp_number,
                "EMPLOYEE_ID" => $emp->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 3,
                "NOTIFICATION_TYPE_ID" => 1,
                "MODULE_ID" => $leave_id
            ]);
        $this->postNotifUser($leave->emp_number, $title, $desc);

    }

    public function approvedAttendanceNotification($approved_by, $att_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $att_request = DB::table("emp_attendance_request")
            ->where("id", $att_id)
            ->first();

        $emp = DB::table("employee")
            ->where("emp_number", $att_request->emp_number)
            ->first();
        $emp_approved = DB::table("employee")
            ->where("emp_number", $approved_by)
            ->first();
        $desc = $emp_approved->emp_firstname." ".$emp_approved->emp_middle_name." ".$emp_approved->emp_lastname." is approved your attendance request : ".$att_request->reason." Please check it out.";
        $title = "Approved Attendance";
        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp->emp_number,
                "EMPLOYEE_ID" => $emp->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 5,
                "NOTIFICATION_TYPE_ID" => 2,
                "MODULE_ID" => $att_id
            ]);

        $this->postNotifUser($att_request->emp_number, $title, $desc);
    }

    public function rejectAttendanceNotification($approved_by, $att_id){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $att_request = DB::table("emp_attendance_request")
            ->where("id", $att_id)
            ->first();

        $emp = DB::table("employee")
            ->where("emp_number", $att_request->emp_number)
            ->first();
        $emp_approved = DB::table("employee")
            ->where("emp_number", $approved_by)
            ->first();
        $desc = $emp_approved->emp_firstname." ".$emp_approved->emp_middle_name." ".$emp_approved->emp_lastname." is rejected your attendance request : ".$att_request->reason." Please check it out.";
        $title = "Rejected Attendance";
        DB::table("MH_NOTIFICATION")
            ->insert([
                "EMP_NUMBER" => $emp->emp_number,
                "EMPLOYEE_ID" => $emp->employee_id,
                "NOTIFICATION_TITLE" => $title,
                "NOTIFICATION_DESC" => $desc,
                "IS_READ" => 0,
                "IS_DELETED" => 0,
                "CREATED_AT" => $now,
                "NOTIFICATION_STATUS_ID" => 6,
                "NOTIFICATION_TYPE_ID" => 2,
                "MODULE_ID" => $att_id
            ]);

        $this->postNotifUser($att_request->emp_number, $title, $desc);
    }

    public function getAllNotificationNotRead(Request $request){
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->whereNotNull("PLAYER_ID")
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $notification = DB::table("MH_NOTIFICATION")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("IS_READ", 0 )
                ->where("IS_DELETED", 0)
                ->get();
        return response()->json($notification,200);
    }

    public function getAllNotification(Request $request){
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
            ->whereNotNull("PLAYER_ID")
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $notification = DB::table("MH_NOTIFICATION")
            ->leftjoin("MH_NOTIFICATION_STATUS", "MH_NOTIFICATION.NOTIFICATION_STATUS_ID","=","MH_NOTIFICATION_STATUS.NOTIFICATION_STATUS_ID")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("IS_DELETED", 0)
            ->orderBy("CREATED_AT", "desc")
            ->select("MH_NOTIFICATION.*", "MH_NOTIFICATION_STATUS.*")
            ->take(25)
            ->get();

        DB::table("MH_NOTIFICATION")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("IS_DELETED", 0)
            ->where("IS_READ", 0 )
            ->update([
               "IS_READ" => 1
            ]);

        return response()->json($notification,200);
    }





    public function getAllNotificationGeneral(){

        $notification = DB::table("MH_NOTIFICATION_GENERAL")
            ->where("IS_DELETE", 0)
            ->take(25)
            ->orderBy("CREATED_AT", "desc")
            ->get();
        return response()->json($notification,200);

    }
    public function clearAllNotification(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
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


        DB::table("MH_NOTIFICATION")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("IS_DELETED", 0)
            ->update([
                "IS_DELETED" => 1,
                "DELETED_AT" => $now
            ]);
        $notification = DB::table("MH_NOTIFICATION")
            ->leftjoin("MH_NOTIFICATION_STATUS", "MH_NOTIFICATION.NOTIFICATION_STATUS_ID","=","MH_NOTIFICATION_STATUS.NOTIFICATION_STATUS_ID")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("IS_DELETED", 0)
            ->orderBy("CREATED_AT", "desc")
            ->select("MH_NOTIFICATION.*", "MH_NOTIFICATION_STATUS.*")
            ->take(25)
            ->get();
        $result = ["result" => "Successfully clear notification.","status" => 1];
        return response()->json($result,200);
    }

    public function cronCheckAbsenPulang(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
    }


    public function cronCheckAttendance(){
        date_default_timezone_set('Asia/Jakarta');

       $yesterday =  date('Y-m-d',strtotime("-1 days"));
        $now = date('Y-m-d H:i:s');
        $now_date = date('d-m-Y');

        $attendance = DB::select("exec [cekAbsentnotvalid] '".$yesterday."'");
        $title = "Attendance not valid";
        $i = 0;
        for($i;$i<count($attendance);$i++){

            $emp = DB::table("employee")
                    ->where("employee_id", $attendance[$i]->employee_id)
                    ->first();

            $desc ="Hey ".$emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname.", it seems your attendance ".$now_date." is not valid. You need to make attendance request.";



            if($emp){
                $user_mobile = DB::table("MH_USER_MOBILE")
                    ->where("EMP_NUMBER", $emp->emp_number)
                    ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                        "EMP_NUMBER" => $emp->emp_number,
                        "EMPLOYEE_ID" => $emp->employee_id,
                        "NOTIFICATION_TITLE" => $title,
                        "NOTIFICATION_DESC" => $desc,
                        "IS_READ" => 0,
                        "IS_DELETED" => 0,
                        "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 10,
                        "NOTIFICATION_TYPE_ID" => 2
                    ]);

                if($user_mobile){

                    $this->postNotifUser($emp->emp_number, $title, $desc);


                } else {

                }

            } else {

            }

        }
//        print_r("cron runinng");
        $result = ["result" => "Sending attendance not valid notification to ".count($attendance)." employee.", "status" => 1];
        return response()->json($result,200);
    }

    public function cronCheckNotificationLeave(){
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');

        $leave_request = DB::table('emp_leave_request')
            ->join('emp_reportto', 'emp_leave_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_leave_request.emp_number', '=' ,'employee.emp_number')
            ->join("leave_type","emp_leave_request.leave_type_id","=","leave_type.id")
            ->join('leave_status', 'leave_status.id','=', 'emp_leave_request.leave_status')
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_leave_request.leave_status', 3)
            //->take(10;
            ->select("emp_reportto.*")
            ->get();
        $i = 0;


        $title = "Leave Request";

        for($i;$i<count($leave_request);$i++){

            $emp = DB::table("employee")
                ->where("emp_number", $leave_request[$i]->erep_sup_emp_number)
                ->first();

            $desc ="Hey ".$emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname.", you have LEAVE request. Please check it out.";



            if($emp){
                $user_mobile = DB::table("MH_USER_MOBILE")
                    ->where("EMP_NUMBER", $emp->emp_number)
                    ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                        "EMP_NUMBER" => $emp->emp_number,
                        "EMPLOYEE_ID" => $emp->employee_id,
                        "NOTIFICATION_TITLE" => $title,
                        "NOTIFICATION_DESC" => $desc,
                        "IS_READ" => 0,
                        "IS_DELETED" => 0,
                        "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 1,
                        "NOTIFICATION_TYPE_ID" => 1
                    ]);

                if($user_mobile){

                    $this->postNotifUser($emp->emp_number, $title, $desc);


                } else {

                }

            } else {

            }

        }


//
//        $attendance_request = DB::table('emp_attendance_request')
//            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
//            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
//            ->where('emp_reportto.erep_reporting_mode', '1')
//            ->where('emp_attendance_request.request_status', 1)
//            //->take(10)
//            ->select("emp_attendance_request.*",'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
//            ->count();
//
//        $training = DB::table('emp_trainning_request')
//            ->join('emp_reportto', 'emp_trainning_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
//            ->join('employee', 'emp_trainning_request.emp_number', '=' ,'employee.emp_number')
//            ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
//            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
//            ->where('emp_reportto.erep_reporting_mode', '1')
//            ->where('emp_trainning_request.training_status', 1)
//            //->take(10)
//            ->select("emp_trainning_request.*","trainning.name as name","trainning_vendor.vendor_name as vendor_name", 'emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
//            ->count();

        $result = ["result" => "Sending leave request notification to ".count($leave_request)." employee.", "status" => 1];

        return response()->json($result,200);
    }


    public function cronCheckNotificationTraining(){
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');
        $training_request = DB::table('emp_trainning_request')
            ->join('emp_reportto', 'emp_trainning_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_trainning_request.emp_number', '=' ,'employee.emp_number')
            ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_trainning_request.training_status', 1)
            //->take(10)
            ->select("emp_reportto.*")
            ->get();

        $i = 0;


        $title = "Training Request";

        for($i;$i<count($training_request);$i++){

            $emp = DB::table("employee")
                ->where("emp_number", $training_request[$i]->erep_sup_emp_number)
                ->first();

            $desc ="Hey ".$emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname.", you have TRAINING request. Please check it out.";



            if($emp){
                $user_mobile = DB::table("MH_USER_MOBILE")
                    ->where("EMP_NUMBER", $emp->emp_number)
                    ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                        "EMP_NUMBER" => $emp->emp_number,
                        "EMPLOYEE_ID" => $emp->employee_id,
                        "NOTIFICATION_TITLE" => $title,
                        "NOTIFICATION_DESC" => $desc,
                        "IS_READ" => 0,
                        "IS_DELETED" => 0,
                        "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 7,
                        "NOTIFICATION_TYPE_ID" => 3
                    ]);

                if($user_mobile){

                    $this->postNotifUser($emp->emp_number, $title, $desc);


                } else {

                }

            } else {

            }

        }


//
//        $attendance_request = DB::table('emp_attendance_request')
//            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
//            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
//            ->where('emp_reportto.erep_reporting_mode', '1')
//            ->where('emp_attendance_request.request_status', 1)
//            //->take(10)
//            ->select("emp_attendance_request.*",'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
//            ->count();
//


        $result = ["result" => "Sending training request notification to ".count($training_request)." employee.", "status" => 1];

        return response()->json($result,200);
    }

    public function cronCheckNotificationAttendance(){
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');
//        DB::table("MH_NOTIFICATION")
//            ->insert([
//                "EMP_NUMBER" =>123456789,
//                "EMPLOYEE_ID" =>1111111111111111111,
//                "NOTIFICATION_TITLE" => 'test',
//                "NOTIFICATION_DESC" => 'test',
//                "IS_READ" => 0,
//                "IS_DELETED" => 0,
//                "CREATED_AT" => $now,
//                "NOTIFICATION_STATUS_ID" => 4,
//                "NOTIFICATION_TYPE_ID" => 2
//            ]);
//        print_r("crontab jalan");
//
//        die;
        $attendance_request = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_attendance_request.request_status', 1)
            //->take(10)
            ->select("emp_reportto.*")
            ->get();



        $i = 0;


        $title = "Attendance Request";

        for($i;$i<count($attendance_request);$i++){

            $emp = DB::table("employee")
                ->where("emp_number", $attendance_request[$i]->erep_sup_emp_number)
                ->first();

            $desc ="Hey ".$emp->emp_firstname." ".$emp->emp_middle_name." ".$emp->emp_lastname.", you have ATTENDANCE request. Please check it out.";



            if($emp){
                $user_mobile = DB::table("MH_USER_MOBILE")
                    ->where("EMP_NUMBER", $emp->emp_number)
                    ->first();
                DB::table("MH_NOTIFICATION")
                    ->insert([
                        "EMP_NUMBER" => $emp->emp_number,
                        "EMPLOYEE_ID" => $emp->employee_id,
                        "NOTIFICATION_TITLE" => $title,
                        "NOTIFICATION_DESC" => $desc,
                        "IS_READ" => 0,
                        "IS_DELETED" => 0,
                        "CREATED_AT" => $now,
                        "NOTIFICATION_STATUS_ID" => 4,
                        "NOTIFICATION_TYPE_ID" => 2
                    ]);

                if($user_mobile){

                    $this->postNotifUser($emp->emp_number, $title, $desc);


                } else {

                }

            } else {

            }

        }






        $result = ["result" => "Sending attendance request notification to ".count($attendance_request)." employee.", "status" => 1];

        return response()->json($result,200);
    }

    public function cronCheckBirthday(){

        $emp_data = DB::select("exec cekEmpBirthday");
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');
        for($i=0;$i<count($emp_data);$i++){
            $emp = DB::table("employee")
                ->where("emp_number", $emp_data[$i]->emp_number)
                ->first();
            $title = "Happy Birthday";
            $desc = "Happy Birthday to you, ".$emp->emp_fullname."! wish you all the best.";

            DB::table("MH_NOTIFICATION")
                ->insert([
                    "EMP_NUMBER" => $emp->emp_number,
                    "EMPLOYEE_ID" => $emp->employee_id,
                    "NOTIFICATION_TITLE" => $title,
                    "NOTIFICATION_DESC" => $desc,
                    "IS_READ" => 0,
                    "IS_DELETED" => 0,
                    "CREATED_AT" => $now,
                    "NOTIFICATION_STATUS_ID" => 11,
                    "NOTIFICATION_TYPE_ID" => 0
                ]);
            $this->postNotifUser($emp->emp_number,$title, $desc);
        }
        $result = ["result" => "Sending attendance request notification to ".count($emp_data)." employee.", "status" => 1];

        return response()->json($result,200);
    }


}
