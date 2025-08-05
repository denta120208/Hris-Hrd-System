<?php

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Mail;


class MobileAttendanceController extends Controller {

    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();

        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }


    public function getAttendancewithdateV2(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){  
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        $emp_id = '';


        if($request->employee_id_search == 'null'){
            $emp_id = $request->username;
        } else {
            $emp_id = $request->employee_id_search;
        }

        $attendances = DB::select("
            SELECT a.id, 
                FORMAT(a.comDate, 'dddd') AS day,
                CONVERT(datetime, a.comDate, 23) as date,
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comIn)) AS time_in, 
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comOut)) AS time_out, 
                CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) AS hours, 
                SUBSTRING(CONVERT(CHAR(8), a.comTotalHours, 108), 4, 2) AS minutes,
                a.comIjin, b.job_title_code, a.is_claim_ot,
                CASE 
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) >= 8
                    THEN 1
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) < 8
                        AND a.comIjin != ''
                    THEN 1
                    ELSE 0
                END AS status_hours
            FROM com_absensi_inout AS a
            INNER JOIN employee AS b
            ON a.comNIP = b.employee_id
            WHERE a.comNIP = '".$emp_id."'
            AND a.comDate >= '".$request->startdate."'
            AND a.comDate <= '".$request->enddate."'   
            ORDER BY a.comDate DESC
        ");

        if ($attendances) {
            $result = $attendances;
        } else {
            $result = [];
        }

        // START
        // $attendances = DB::table('attendance_record')->where('employee_id', $emp_id)
        //     ->where('punch_in_utc_time', '>=',$request->startdate.' 00:00:00')
        //     ->where('punch_in_utc_time', '<=',$request->enddate.' 23:59:59')
        //     ->orderBy('punch_in_utc_time', 'desc')
        //     ->get();
        // $i = 0;
        // //dd($attendance);
        // foreach($attendances as $attendance){
        //     $hari =   date('l', strtotime($attendance->punch_in_utc_time));
        //     $date = substr($attendance->punch_in_utc_time,0,10);
        //     $time_in = substr($attendance->punch_in_utc_time,11,8);
        //     $time_out = substr($attendance->punch_out_utc_time,11,8);


        //     // Declare and define two dates
        //     $date1 = strtotime($attendance->punch_in_utc_time);
        //     $date2 = strtotime($attendance->punch_out_utc_time);

        //     // Formulate the Difference between two dates
        //     $diff = abs($date2 - $date1);


        //     // To get the year divide the resultant date into
        //     // total seconds in a year (365*60*60*24)
        //     $years = floor($diff / (365*60*60*24));


        //     // To get the month, subtract it with years and
        //     // divide the resultant date into
        //     // total seconds in a month (30*60*60*24)
        //     $months = floor(($diff - $years * 365*60*60*24)
        //         / (30*60*60*24));


        //     // To get the day, subtract it with years and
        //     // months and divide the resultant date into
        //     // total seconds in a days (60*60*24)
        //     $days = floor(($diff - $years * 365*60*60*24 -
        //             $months*30*60*60*24)/ (60*60*24));


        //     // To get the hour, subtract it with years,
        //     // months & seconds and divide the resultant
        //     // date into total seconds in a hours (60*60)
        //     $hours = floor(($diff - $years * 365*60*60*24
        //             - $months*30*60*60*24 - $days*60*60*24)
        //         / (60*60));

        //     $minutes = floor(($diff - $years * 365*60*60*24
        //             - $months*30*60*60*24 - $days*60*60*24
        //             - $hours*60*60)/ 60);

        //     $arr[$i] = [
        //         "id" => $attendance->id,
        //         "day" => $hari,
        //         "date" => $date,
        //         "time_in" =>  $time_in,
        //         "time_out" => $time_out,
        //         "hours" => $hours,
        //         "minutes" => $minutes

        //     ];
        //     $status = 200;
        //     $i++;

        // }
        // if(empty($arr)){
        //     $result = [];
        // } else {
        //     $result = $arr;
        // }
        // FINISH

        return response()->json($result,200);
    }
    public function getAttendanceV2(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){
        // } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }
        // $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
        //     WHERE  employee_id = '".$request->username."' order by punch_in_utc_time desc");
        $emp_id = '';
        // $arr = array();

        if($request->employee_id_search == 'null'){
            $emp_id = $request->username;
        } else {
            $emp_id = $request->employee_id_search;
        }

        $setting = DB::table('MH_APPS_SETTINGS')
            ->first();

        $attendances = DB::select("
            SELECT a.id, 
                FORMAT(a.comDate, 'dddd') AS day,
                CONVERT(datetime, a.comDate, 23) as date,
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comIn)) AS time_in, 
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comOut)) AS time_out, 
                CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) AS hours, 
                SUBSTRING(CONVERT(CHAR(8), a.comTotalHours, 108), 4, 2) AS minutes,
                a.comIjin, b.job_title_code, a.is_claim_ot,
                CASE 
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) >= 8 
                    THEN 1 
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) < 8 
                        AND a.comIjin != '' 
                    THEN 1 
                    ELSE 0 
                END AS status_hours
            FROM com_absensi_inout AS a
            INNER JOIN employee AS b ON a.comNIP = b.employee_id
            WHERE a.comNIP = '".$emp_id."'
            AND a.comDate BETWEEN DATEADD(DAY, -30, getdate()) AND GETDATE()
            ORDER BY a.comDate DESC
        ");

        if ($attendances) {
            $result = $attendances;
        } else {
            $result = [];
        }
        return response()->json($result, 200);
        // $attendances = DB::table('attendance_record')->where('employee_id', $emp_id)
        //     ->orderBy('punch_in_utc_time', 'desc')
        //     ->take(25)
        //     ->get();
        //     $now = strtotime(date('Y-m-d'));
        //     $last = strtotime(date('Y-m-d', strtotime('-25 days')));

        // for ( $i = $now; $i >= $last; $i = $i - 86400 ) {
        //     $thisDate = date( 'Y-m-d', $i );
        //     $attend = DB::connection('adms')->select("
        //         select c.id, c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
        //         from checkinout c INNER JOIN userinfo ui
        //         ON c.userid = ui.userid 
        //         WHERE ui.title= '".$emp_id."'
        //         AND CAST(c.checktime as DATE) = '".$thisDate."'
        //         GROUP BY c.userid, CAST(c.checktime as DATE)
        //     ");
        // if($attend){
        //     $date_1 = new \DateTime($attend[0]->tanggal.' '.$attend[0]->waktuIn);
        //     $date_2 = new \DateTime($attend[0]->tanggal.' '.$attend[0]->waktuOut);
        //     $diff = $date_1->diff($date_2);
        //     $hours = $diff->h;
        //     $minutes = $diff->i;
        //     $arr[] = [
        //         "id" => $attend[0]->id,
        //         "day" => date('l', strtotime($thisDate)),
        //         "date" => $thisDate,
        //         "time_in" =>  $attend[0]->waktuIn,
        //         "time_out" => $attend[0]->waktuOut,
        //         "hours" => $hours,
        //         "minutes" => $minutes
        //     ];
        // array_push($attends, $attend[0]);
        //     }
        // }
        // batas
        // foreach($attendances as $attendance){
        //     $hari =   date('l', strtotime($attendance->punch_in_utc_time));
        //     $date = substr($attendance->punch_in_utc_time,0,10);
        //     $time_in = substr($attendance->punch_in_utc_time,11,8);
        //     $time_out = substr($attendance->punch_out_utc_time,11,8);
        //     // Declare and define two dates
        //     $date1 = strtotime($attendance->punch_in_utc_time);
        //     $date2 = strtotime($attendance->punch_out_utc_time);
        //     // Formulate the Difference between two dates
        //     $diff = abs($date2 - $date1);
        //     // To get the year divide the resultant date into
        //     // total seconds in a year (365*60*60*24)
        //     $years = floor($diff / (365*60*60*24));
        //     // To get the month, subtract it with years and
        //     // divide the resultant date into
        //     // total seconds in a month (30*60*60*24)
        //     $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        //     // To get the day, subtract it with years and
        //     // months and divide the resultant date into
        //     // total seconds in a days (60*60*24)
        //     $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
        //     // To get the hour, subtract it with years,
        //     // months & seconds and divide the resultant
        //     // date into total seconds in a hours (60*60)
        //     $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60));

        //     $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

        //     $arr[$i] = [
        //         "id" => $attendance->id,
        //         "day" => $hari,
        //         "date" => $date,
        //         "time_in" =>  $time_in,
        //         "time_out" => $time_out,
        //         "hours" => $hours,
        //         "minutes" => $minutes

        //     ];
        //     $status = 200;
        //     $i++;

        // }
        // $result = [
        //     "day" => $hari,
        // ];
        // print_r($arr); die;
        // return response()->json($arr,200);
    }


    public function getEmployeeAttendanceRequest(Request $request){
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

        $attendance_request = DB::table("emp_attendance_request")
                            ->where("emp_number", $request->emp_number)
                            ->where("request_status", 1)
                            ->get();
        return response()->json($attendance_request, 200);


    }


    public function getEmployeeAttendanceHistory(Request $request){
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

        $attendance_request = DB::table("emp_attendance_request")
            ->where("emp_number", $request->emp_number)
            ->where("request_status","!=", 1)
            ->get();
        return response()->json($attendance_request, 200);
    }

    public function addEmployeeAttendanceRequest(Request $request){
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

        $att_id = 0;
        if($request->attendance_id != 0){
            $att_id = $request->attendance_id;
        } else {
            $att_id = 0;
        }


        $sDateTrim = substr($request->start_date,0,10);
        $eDateTrim = substr($request->start_date,0,10);
        $sDate = $sDateTrim." 08:00:00";
        $eDate =  $eDateTrim." 17:00:00";

        DB::table("emp_attendance_request")
            ->insert([
               "attendance_id" => $att_id,
               "emp_number" => $request->emp_number,
               "start_date" => $sDate,
               "end_date" => $eDate,
               "reason" => $request->reason,
               "request_status" => 1,
               "comIjin" => $request->attendance_type,
            ]);
        $last_id = DB::getPdo()->lastInsertId();
        $this->addMobileLog($request->emp_number, "Attendance", "Add attendance request: ".$last_id);

        $result = ["result" => "Successfully add attendance request.", "status" => 1];
        return response()->json($result, 200);


    }


    public function cancelAttendanceRequest(Request $request){
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

        $att = DB::table("emp_attendance_request")
                ->where("id", $request->att_id)
                ->first();
        if($att){
            if($att->emp_number == $request->emp_number){
                DB::table("emp_attendance_request")
                    ->where("id", $request->att_id)
                    ->update([
                       "request_status" => 0
                    ]);
                $this->addMobileLog($request->emp_number, "Attendance", "Cancel attendance request: ".$request->att_id);

                $result = ["result" => "Successfully cancel attendance request.", "status" => 1];
                return response()->json($result, 200);
            } else {
                $result = ["result" => "Data not found.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
        return response()->json($result, 200);
    }


    public function getAtasanAttendanceRequest(Request $request){
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


        // if($employee_mobile){
        // } else {
        //     $result = ["result" => "You're not logged in.", "status" => 0];
        //     return response()->json($result, 200);
        // }


        $attendance_request = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_attendance_request.request_status', 1)
            //->take(10)
            ->select("emp_attendance_request.*",'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
//            ->orderBy('emp_attendance_request.attendance_id', 'desc')
            ->orderBy('emp_attendance_request.start_date', 'desc')
            ->get();
        return response()->json($attendance_request, 200);

    }


    public function approveAttendanceRequest (Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        $att = DB::table("emp_attendance_request")
            ->where("id", $request->att_id)
            ->first();

        if ($att) {
            $employee = DB::table("employee")
                ->where("emp_number", $att->emp_number)
                ->first();

            $att_date = date_create($att->start_date);
                
            DB::table("emp_attendance_request")
                ->where("id", $request->att_id)
                ->update([
                    "request_status" => 2,
                    "approve_sup" => $request->emp_number,
                    "approve_sup_date" => $now
                ]);

            if ($att->attendance_id > 0) {
                // $att_inout = DB::table("com_absensi_inout")
                //     ->where("id", $att->attendance_id)
                //     ->first();

                $att_inout = DB::select("
                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                    FROM com_absensi_inout
                    WHERE id = ".$att->attendance_id."
                ");

                DB::table("com_absensi_inout_hist")
                    ->insert([
                        "id" => $att_inout[0]->id,
                        "comNIP" => $att_inout[0]->comNIP,
                        "comIn" => $att_inout[0]->comIn,
                        "comOut" => $att_inout[0]->comOut,
                        "comDate" => $att_inout[0]->comDate,
                        "comDTIn" => $att_inout[0]->comDTIn,
                        "comDTOut" => $att_inout[0]->comDTOut,
                        "comTotalHours" => $att_inout[0]->comTotalHours,
                        "comIjin" => $att_inout[0]->comIjin,
                        "comIjin_reason" => $att_inout[0]->comIjin_reason,
                        "is_claim_ot" => $att_inout[0]->is_claim_ot,
                        "source" => $att_inout[0]->source,
                        "created_at" => $att_inout[0]->created_at,
                        "updatet_at" => $att_inout[0]->updatet_at,
                    ]);

                DB::table("com_absensi_inout")
                    ->where("id", $att->attendance_id)
                    ->update([
                        "comIjin" => $att->comIjin,
                        "comIjin_reason" => $att->reason,
                        "source" => "attendance",
                        "updatet_at" => $now
                    ]);

                $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                $result = ["result" => "Successfully approved attendance request.", "status" => 1];

            } else {
                $cek_data_absen = DB::table("com_absensi_inout")
                    ->where("comDate", $att_date->format("Y-m-d"))
                    ->where("comNIP", $employee->employee_id)
                    ->count();
                
                if ($cek_data_absen > 0) {
                    // $data_absen = DB::table("com_absensi_inout")
                    //     ->where("comDate", $att_date->format("Y-m-d"))
                    //     ->where("comNIP", $employee->employee_id)
                    //     ->first();

                    $data_absen = DB::select("
                        SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                        FROM com_absensi_inout
                        WHERE comDate = '".$att_date->format("Y-m-d")."'
                        AND comNIP = '".$employee->employee_id."'
                    ");
                    
                    DB::table("com_absensi_inout_hist")
                        ->insert([
                            "id" => $data_absen[0]->id,
                            "comNIP" => $data_absen[0]->comNIP,
                            "comIn" => $data_absen[0]->comIn,
                            "comOut" => $data_absen[0]->comOut,
                            "comDate" => $data_absen[0]->comDate,
                            "comDTIn" => $data_absen[0]->comDTIn,
                            "comDTOut" => $data_absen[0]->comDTOut,
                            "comTotalHours" => $data_absen[0]->comTotalHours,
                            "comIjin" => $data_absen[0]->comIjin,
                            "comIjin_reason" => $data_absen[0]->comIjin_reason,
                            "is_claim_ot" => $data_absen[0]->is_claim_ot,
                            "source" => $data_absen[0]->source,
                            "created_at" => $data_absen[0]->created_at,
                            "updatet_at" => $data_absen[0]->updatet_at,
                        ]);

                    DB::table("com_absensi_inout")
                        ->where("id", $data_absen[0]->id)
                        ->update([
                            "comIjin" => $att->comIjin,
                            "comIjin_reason" => $att->reason,
                            "source" => "attendance",
                            "updatet_at" => $now
                        ]);

                    DB::table("emp_attendance_request")
                        ->where("id", $request->att_id)
                        ->update([
                            "attendance_id" => $data_absen[0]->id, 
                        ]);

                    $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                    $result = ["result" => "Successfully approved attendance request.", "status" => 1];

                } else {
                    DB::table("com_absensi_inout")
                        ->insert([
                            "comNIP" => $employee->employee_id,
                            "comIn" => "08:00:00",
                            "comOut" => "17:00:00",
                            "comDate" => $att_date->format("Y-m-d"),
                            "comDTIn" => $att_date->format("Y-m-d")." 08:00:00",
                            "comDTOut" => $att_date->format("Y-m-d")." 17:00:00",
                            "comTotalHours" => "08:00:00",
                            "comIjin" => $att->comIjin,
                            "comIjin_reason" => $att->reason,
                            "source" => "attendance",
                            "created_at" => $now,
                            "updatet_at" => $now,
                        ]);

                    // $data_absen = DB::table("com_absensi_inout")
                    //     ->where("comDate", $att_date->format("Y-m-d"))
                    //     ->where("comNIP", $employee->employee_id)
                    //     ->first();

                    $data_absen = DB::select("
                        SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                        FROM com_absensi_inout
                        WHERE comDate = '".$att_date->format("Y-m-d")."'
                        AND comNIP = '".$employee->employee_id."'
                    ");

                    DB::table("com_absensi_inout_hist")
                        ->insert([
                            "id" => $data_absen[0]->id,
                            "comNIP" => $data_absen[0]->comNIP,
                            "comIn" => $data_absen[0]->comIn,
                            "comOut" => $data_absen[0]->comOut,
                            "comDate" => $data_absen[0]->comDate,
                            "comDTIn" => $data_absen[0]->comDTIn,
                            "comDTOut" => $data_absen[0]->comDTOut,
                            "comTotalHours" => $data_absen[0]->comTotalHours,
                            "comIjin" => $data_absen[0]->comIjin,
                            "comIjin_reason" => $data_absen[0]->comIjin_reason,
                            "is_claim_ot" => $data_absen[0]->is_claim_ot,
                            "source" => $data_absen[0]->source,
                            "created_at" => $data_absen[0]->created_at,
                            "updatet_at" => $data_absen[0]->updatet_at,
                        ]);

                    DB::table("emp_attendance_request")
                        ->where("id", $request->att_id)
                        ->update([
                            "attendance_id" => $data_absen[0]->id,
                        ]);

                    $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                    $result = ["result" => "Successfully approved attendance request.", "status" => 1];
                }
            }
        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
        $notif = new MobileNotificationController();
        $notif->approvedAttendanceNotification($request->emp_number,$request->att_id);
        return response()->json($result, 200);

        // PROSES APPROVE ATTENDANCE OLD
        // date_default_timezone_set('Asia/Jakarta');
        // $now = date('Y-m-d H:i:s');
        // // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        // //     $result = ["result" => "Apps key not valid.", "status" => 0];
        // //     return response()->json($result, 200);
        // // }

        // $att = DB::table("emp_attendance_request")
        //     ->where("id", $request->att_id)
        //     ->first();

        // if ($att) {
        //     DB::table("emp_attendance_request")
        //         ->where("id", $request->att_id)
        //         ->update([
        //             "request_status" => 2,
        //             "approve_sup" => $request->emp_number,
        //             "approve_sup_date" => $now
        //         ]);
        //     $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);

        //     $result = ["result" => "Successfully approved attendance request.", "status" => 1];
        // } else {
        //     $result = ["result" => "Data not found.", "status" => 0];
        //     return response()->json($result, 200);
        // }
        // $notif = new MobileNotificationController();
        // $notif->approvedAttendanceNotification($request->emp_number,$request->att_id);
        // return response()->json($result, 200);
    }

    public function approveAttendanceRequest1 (Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        $att = DB::table("emp_attendance_request")
            ->where("id", $request->att_id)
            ->first();

        if ($att) {
            $employee = DB::table("employee")
                ->where("emp_number", $att->emp_number)
                ->first();

            $att_date = date_create($att->start_date);
                
            DB::table("emp_attendance_request")
                ->where("id", $request->att_id)
                ->update([
                    "request_status" => 2,
                    "approve_sup" => $request->emp_number,
                    "approve_sup_date" => $now
                ]);

            if ($att->attendance_id > 0) {
                // $att_inout = DB::table("com_absensi_inout")
                //     ->where("id", $att->attendance_id)
                //     ->first();

                $att_inout = DB::select("
                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                    FROM com_absensi_inout
                    WHERE id = ".$att->attendance_id."
                ");

                DB::table("com_absensi_inout_hist")
                    ->insert([
                        "id" => $att_inout[0]->id,
                        "comNIP" => $att_inout[0]->comNIP,
                        "comIn" => $att_inout[0]->comIn,
                        "comOut" => $att_inout[0]->comOut,
                        "comDate" => $att_inout[0]->comDate,
                        "comDTIn" => $att_inout[0]->comDTIn,
                        "comDTOut" => $att_inout[0]->comDTOut,
                        "comTotalHours" => $att_inout[0]->comTotalHours,
                        "comIjin" => $att_inout[0]->comIjin,
                        "comIjin_reason" => $att_inout[0]->comIjin_reason,
                        "is_claim_ot" => $att_inout[0]->is_claim_ot,
                        "source" => $att_inout[0]->source,
                        "created_at" => $att_inout[0]->created_at,
                        "updatet_at" => $att_inout[0]->updatet_at,
                    ]);

                DB::table("com_absensi_inout")
                    ->where("id", $att->attendance_id)
                    ->update([
                        "comIjin" => $att->comIjin,
                        "comIjin_reason" => $att->reason,
                        "source" => "attendance",
                        "updatet_at" => $now
                    ]);

                $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                $result = ["result" => "Successfully approved attendance request.", "status" => 1];

            } else {
                $cek_data_absen = DB::table("com_absensi_inout")
                    ->where("comDate", $att_date->format("Y-m-d"))
                    ->where("comNIP", $employee->employee_id)
                    ->count();
                
                if ($cek_data_absen > 0) {
                    // $data_absen = DB::table("com_absensi_inout")
                    //     ->where("comDate", $att_date->format("Y-m-d"))
                    //     ->where("comNIP", $employee->employee_id)
                    //     ->first();

                    $data_absen = DB::select("
                        SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                        FROM com_absensi_inout
                        WHERE comDate = '".$att_date->format("Y-m-d")."'
                        AND comNIP = '".$employee->employee_id."'
                    ");
                    
                    DB::table("com_absensi_inout_hist")
                        ->insert([
                            "id" => $data_absen[0]->id,
                            "comNIP" => $data_absen[0]->comNIP,
                            "comIn" => $data_absen[0]->comIn,
                            "comOut" => $data_absen[0]->comOut,
                            "comDate" => $data_absen[0]->comDate,
                            "comDTIn" => $data_absen[0]->comDTIn,
                            "comDTOut" => $data_absen[0]->comDTOut,
                            "comTotalHours" => $data_absen[0]->comTotalHours,
                            "comIjin" => $data_absen[0]->comIjin,
                            "comIjin_reason" => $data_absen[0]->comIjin_reason,
                            "is_claim_ot" => $data_absen[0]->is_claim_ot,
                            "source" => $data_absen[0]->source,
                            "created_at" => $data_absen[0]->created_at,
                            "updatet_at" => $data_absen[0]->updatet_at,
                        ]);

                    DB::table("com_absensi_inout")
                        ->where("id", $data_absen[0]->id)
                        ->update([
                            "comIjin" => $att->comIjin,
                            "comIjin_reason" => $att->reason,
                            "source" => "attendance",
                            "updatet_at" => $now
                        ]);

                    DB::table("emp_attendance_request")
                        ->where("id", $request->att_id)
                        ->update([
                            "attendance_id" => $data_absen[0]->id, 
                        ]);

                    $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                    $result = ["result" => "Successfully approved attendance request.", "status" => 1];

                } else {
                    DB::table("com_absensi_inout")
                        ->insert([
                            "comNIP" => $employee->employee_id,
                            "comIn" => "08:00:00",
                            "comOut" => "17:00:00",
                            "comDate" => $att_date->format("Y-m-d"),
                            "comDTIn" => $att_date->format("Y-m-d")." 08:00:00",
                            "comDTOut" => $att_date->format("Y-m-d")." 17:00:00",
                            "comTotalHours" => "08:00:00",
                            "comIjin" => $att->comIjin,
                            "comIjin_reason" => $att->reason,
                            "source" => "attendance",
                            "created_at" => $now,
                            "updatet_at" => $now,
                        ]);

                    // $data_absen = DB::table("com_absensi_inout")
                    //     ->where("comDate", $att_date->format("Y-m-d"))
                    //     ->where("comNIP", $employee->employee_id)
                    //     ->first();

                    $data_absen = DB::select("
                        SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                        FROM com_absensi_inout
                        WHERE comDate = '".$att_date->format("Y-m-d")."'
                        AND comNIP = '".$employee->employee_id."'
                    ");

                    DB::table("com_absensi_inout_hist")
                        ->insert([
                            "id" => $data_absen[0]->id,
                            "comNIP" => $data_absen[0]->comNIP,
                            "comIn" => $data_absen[0]->comIn,
                            "comOut" => $data_absen[0]->comOut,
                            "comDate" => $data_absen[0]->comDate,
                            "comDTIn" => $data_absen[0]->comDTIn,
                            "comDTOut" => $data_absen[0]->comDTOut,
                            "comTotalHours" => $data_absen[0]->comTotalHours,
                            "comIjin" => $data_absen[0]->comIjin,
                            "comIjin_reason" => $data_absen[0]->comIjin_reason,
                            "is_claim_ot" => $data_absen[0]->is_claim_ot,
                            "source" => $data_absen[0]->source,
                            "created_at" => $data_absen[0]->created_at,
                            "updatet_at" => $data_absen[0]->updatet_at,
                        ]);

                    DB::table("emp_attendance_request")
                        ->where("id", $request->att_id)
                        ->update([
                            "attendance_id" => $data_absen[0]->id,
                        ]);

                    $this->addMobileLog($request->emp_number, "Attendance", "Approve attendance request: ".$request->att_id);
                    $result = ["result" => "Successfully approved attendance request.", "status" => 1];
                }
            }
        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
        $notif = new MobileNotificationController();
        $notif->approvedAttendanceNotification($request->emp_number,$request->att_id);
        return response()->json($result, 200);
    }


    public function rejectAttendanceRequest(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $att = DB::table("emp_attendance_request")
            ->where("id", $request->att_id)
            ->first();
        if($att){
            DB::table("emp_attendance_request")
                ->where("id", $request->att_id)
                ->update([
                    "request_status" => 4,
                    "approve_sup" => $request->emp_number,
                    "approve_sup_date" => $now
                ]);
            $result = ["result" => "Successfully rejected attendance request.", "status" => 1];
        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
        $this->addMobileLog($request->emp_number, "Attendance", "Reject attendance request: ".$request->att_id);

        $notif = new MobileNotificationController();
        $notif->rejectAttendanceNotification($request->emp_number,$request->att_id);
        return response()->json($result, 200);
    }

    public function signInAttendance(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

        $employee = DB::table('employee')
            ->where('emp_number', $request->emp_number)
            ->first();

        if ($employee) {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
                $check_location = DB::table('location')
                    ->where('id', $employee->location_id)
                    ->select('id', 'name', 'email_hrd_1', 'email_hrd_2', 'email_hrd_3', 'latitude_mobile', 'longitude_mobile')
                    ->first();

                if ($check_location->id == 1 || $check_location->id == 10 || $check_location->id == 25 || $check_location->id == 26) {
                    if ($request->lokasi_absen == 'Kantor Pusat' || $request->lokasi_absen == 'MGold' || $request->lokasi_absen == 'Recreation & Sport Facility' || $request->lokasi_absen == 'Koperasi Metland Maju Bersama') {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    }
                } else if ($check_location->id == 17 || $check_location->id == 18) {
                    if ($request->lokasi_absen == 'Plaza Metropolitan' || $request->lokasi_absen == 'Metland Hotel Bekasi') {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    }
                } else {
                    if ($check_location->name === $request->lokasi_absen) {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('comDate', $request->date)
                            ->where('comNIP', $employee->employee_id)
                            ->first();

                        if ($absensi_inout) {
                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$request->date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $total_hours[0]->id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP' => $employee->employee_id,
                                    'comIn' => $request->time_in,
                                    'comOut' => $request->time_in,
                                    'comDate' => $request->date,
                                    'comDTIn' => $now,
                                    'comDTOut' => $now,
                                    'comInLocation' => $request->lokasi_absen,
                                    'comTotalHours' => '00:00:00',
                                    'comIjin' => '',
                                    'is_claim_ot' => '0',
                                    'source' => 'MetHRIS',
                                    'created_at' => $now,
                                    'updatet_at' => $now,
                                ]);

                            $last_id = DB::getPdo()->lastInsertId();

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $last_id)
                                ->first();

                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkInAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-In Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });

                                $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        }
                    }
                }

                $absensi_inout = DB::table('com_absensi_inout')
                    ->where('comDate', $request->date)
                    ->where('comNIP', $employee->employee_id)
                    ->first();

                if ($absensi_inout) {
                    $total_hours = DB::select("
                        SELECT a.id,b.employee_id, b.emp_fullname,
                            FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                            CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                            CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                            RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                            RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                            RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                        FROM com_absensi_inout AS a 
                        INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                        INNER JOIN location AS c ON b.location_id = c.id
                        LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                        WHERE b.emp_number = ".$request->emp_number."
                        AND CONVERT(DATE, a.comDate) = '".$request->date."'
                        ORDER BY a.comDate DESC
                    ");

                    DB::table('com_absensi_inout')
                        ->where('id', $total_hours[0]->id)
                        ->update([
                            'comOut' => $request->time_out,
                            'comDTOut' => $now,
                            'comOutLocation' => $request->lokasi_absen,
                            'comTotalHours' => $total_hours[0]->comTotalHours,
                        ]);

                    $check_absensi_inout = DB::table('com_absensi_inout')
                        ->where('id', $absensi_inout->id)
                        ->first();

                    if ($check_absensi_inout) {
                        DB::table('com_absensi_inout_hist')
                            ->insert([
                                'id' => $check_absensi_inout->id,
                                'comNIP' => $check_absensi_inout->comNIP,
                                'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                'comDTIn' => $check_absensi_inout->comDTIn,
                                'comDTOut' => $check_absensi_inout->comDTOut,
                                'comInLocation' => $check_absensi_inout->comInLocation,
                                'comOutLocation' => $check_absensi_inout->comOutLocation,
                                'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                'comIjin' => $check_absensi_inout->comIjin,
                                'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                'source' => $check_absensi_inout->source,
                                'created_at' => $check_absensi_inout->created_at,
                                'updatet_at' => $check_absensi_inout->updatet_at,
                            ]);
    
                        $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");
    
                        $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                        return response()->json($result, 200);
                    }
                } else {
                    DB::table('com_absensi_inout')
                        ->insert([
                            'comNIP' => $employee->employee_id,
                            'comIn' => $request->time_in,
                            'comOut' => $request->time_in,
                            'comDate' => $request->date,
                            'comDTIn' => $now,
                            'comDTOut' => $now,
                            'comInLocation' => $request->lokasi_absen,
                            'comTotalHours' => '00:00:00',
                            'comIjin' => '',
                            'is_claim_ot' => '0',
                            'source' => 'MetHRIS',
                            'created_at' => $now,
                            'updatet_at' => $now,
                        ]);

                    $last_id = DB::getPdo()->lastInsertId();

                    $check_absensi_inout = DB::table('com_absensi_inout')
                        ->where('id', $last_id)
                        ->first();

                    if ($check_absensi_inout) {
                        DB::table('com_absensi_inout_hist')
                            ->insert([
                                'id' => $check_absensi_inout->id,
                                'comNIP' => $check_absensi_inout->comNIP,
                                'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                'comDTIn' => $check_absensi_inout->comDTIn,
                                'comDTOut' => $check_absensi_inout->comDTOut,
                                'comInLocation' => $check_absensi_inout->comInLocation,
                                'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                'comIjin' => $check_absensi_inout->comIjin,
                                'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                'source' => $check_absensi_inout->source,
                                'created_at' => $check_absensi_inout->created_at,
                                'updatet_at' => $check_absensi_inout->updatet_at,
                            ]);

                        $this->addMobileLog($request->emp_number, "Attendance Check-In", "Attendance check-in");

                        $result = ["result" => "Successfully Check-In Attendance.", "status" => 1];
                        return response()->json($result, 200);
                    }
                }
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "User not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function signOutAttendance(Request $request) {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
        $date = date('Y-m-d');

        $employee = DB::table('employee')
            ->where('emp_number', $request->emp_number)
            ->first();

        if ($employee) {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
                $check_location = DB::table('location')
                    ->where('id', $employee->location_id)
                    ->select('id', 'name', 'email_hrd_1', 'email_hrd_2', 'email_hrd_3', 'latitude_mobile', 'longitude_mobile')
                    ->first();

                if ($check_location->id == 1 || $check_location->id == 10 || $check_location->id == 25 || $check_location->id == 26) {
                    if ($request->lokasi_absen == 'Kantor Pusat' || $request->lokasi_absen == 'MGold' || $request->lokasi_absen == 'Recreation & Sport Facility' || $request->lokasi_absen == 'Koperasi Metland Maju Bersama') {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");
            
                                $result = ["result" => "Successfully Check-Out Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkOutAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-Out Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");

                                $result = [
                                    "result" => "Successfully Check-Out Attendance.",
                                    "status" => 1,
                                ];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    }
                } else if ($check_location->id == 17 || $check_location->id == 18) {
                    if ($request->lokasi_absen == 'Plaza Metropolitan' || $request->lokasi_absen == 'Metland Hotel Bekasi') {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");
            
                                $result = ["result" => "Successfully Check-Out Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkOutAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-Out Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");

                                $result = [
                                    "result" => "Successfully Check-Out Attendance.",
                                    "status" => 1,
                                ];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    }
                } else {
                    if ($check_location->name === $request->lokasi_absen) {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");
            
                                $result = ["result" => "Successfully Check-Out Attendance.", "status" => 1];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    } else {
                        $absensi_inout = DB::table('com_absensi_inout')
                            ->where('id', $request->id_absensi)
                            ->where('comNIP', $employee->employee_id)
                            ->first();
                            
                        if ($absensi_inout) {
                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->where('comNIP', $employee->employee_id)
                                ->update([
                                    'comOut' => $request->time_out,
                                    'comDTOut' => $now,
                                    'comOutLocation' => $request->lokasi_absen,
                                ]);

                            $total_hours = DB::select("
                                SELECT a.id,b.employee_id, b.emp_fullname,
                                    FORMAT (a.comDate, 'yyyy-MM-dd') AS comDate,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comIn)) AS comIn,
                                    CONVERT(CHAR(8),CONVERT(TIME(0),a.comOut)) AS comOut,
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) / 3600 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST((DATEDIFF(SECOND, comIn, comOut) % 3600) / 60 AS VARCHAR), 2) + ':' +
                                    RIGHT('0' + CAST(DATEDIFF(SECOND, comIn, comOut) % 60 AS VARCHAR), 2) AS comTotalHours
                                FROM com_absensi_inout AS a 
                                INNER JOIN employee AS b ON a.comNIP = b.employee_id 
                                INNER JOIN location AS c ON b.location_id = c.id
                                LEFT JOIN emp_ot_reqeuest AS d ON a.id = d.attendance_id
                                WHERE b.emp_number = ".$request->emp_number."
                                AND CONVERT(DATE, a.comDate) = '".$date."'
                                ORDER BY a.comDate DESC
                            ");

                            DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->update([
                                    'comTotalHours' => $total_hours[0]->comTotalHours,
                                ]);

                            $check_absensi_inout = DB::table('com_absensi_inout')
                                ->where('id', $absensi_inout->id)
                                ->first();
            
                            if ($check_absensi_inout) {
                                DB::table('com_absensi_inout_hist')
                                    ->insert([
                                        'id' => $check_absensi_inout->id,
                                        'comNIP' => $check_absensi_inout->comNIP,
                                        'comIn' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comIn)->format('H:i:s'),
                                        'comOut' => \DateTime::createFromFormat('M j Y h:i:s:uA', $check_absensi_inout->comOut)->format('H:i:s'),
                                        'comDate' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comDate)->format('Y-m-d'),
                                        'comDTIn' => $check_absensi_inout->comDTIn,
                                        'comDTOut' => $check_absensi_inout->comDTOut,
                                        'comInLocation' => $check_absensi_inout->comInLocation,
                                        'comOutLocation' => $check_absensi_inout->comOutLocation,
                                        'comTotalHours' => \DateTime::createFromFormat('M j Y h:i:s:A', $check_absensi_inout->comTotalHours)->format('H:i:s'),
                                        'comIjin' => $check_absensi_inout->comIjin,
                                        'is_claim_ot' => $check_absensi_inout->is_claim_ot,
                                        'source' => $check_absensi_inout->source,
                                        'created_at' => $check_absensi_inout->created_at,
                                        'updatet_at' => $check_absensi_inout->updatet_at,
                                    ]);

                                $first_name = $employee->emp_firstname;
                                $middle_name = $employee->emp_middle_name;
                                $last_name = $employee->emp_lastname;
                                $location = $request->lokasi_absen;

                                Mail::send('mails.checkOutAttendance', compact('first_name', 'middle_name', 'last_name', 'location'), function($message) use ($request) {
                                    // $message->to(trim($check_location->email_hrd_1, $check_location->email_hrd_2, $check_location->email_hrd_3));
                                    $message->to(trim('nada.araminta@metropolitanland.com'));
                                    $message->subject('Clock-Out Outside The Project');
                                    $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                                    // $message->replyTo('info@metlandcard.com', 'Metland Card');
                                });
            
                                $this->addMobileLog($request->emp_number, "Attendance Check-Out", "Attendance check-out");

                                $result = [
                                    "result" => "Successfully Check-Out Attendance.",
                                    "status" => 1,
                                ];
                                return response()->json($result, 200);
                            }
                        } else {
                            $result = ["result" => "Absent not found.", "status" => 0];
                            return response()->json($result, 200);
                        }
                    }
                }
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "User not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function checkLocationProject(Request $request) {
        $employee = DB::table('employee')
            ->where('emp_number', $request->emp_number)
            ->first();

        if ($employee) {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
                $location = DB::table("location")
                    ->where('id', $employee->location_id)
                    ->first();

                if ($location->id == 1 || $location->id == 10 || $location->id ==25 || $location->id ==29) {
                    $result = ["status" => 1];
                    return response()->json($result, 200);
                } else if ($location->id == 17 || $location->id == 18) {
                    $result = ["status" => 1];
                    return response()->json($result, 200);
                } else if ($location->name === $request->lokasi_absen) {
                    $result = ["status" => 1];
                    return response()->json($result, 200);
                } else {
                    $result = ["status" => 0];
                    return response()->json($result, 200);
                }

                // if ($location->name === $request->lokasi_absen) {
                //     $result = ["status" => 1];
                //     return response()->json($result, 200);
                // } else {
                //     $result = ["status" => 0];
                //     return response()->json($result, 200);
                // }
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "User not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function getAttendanceLocation(Request $request){
        $emp_id = '';

        if($request->employee_id_search == 'null'){
            $emp_id = $request->username;
        } else {
            $emp_id = $request->employee_id_search;
        }

        $attendances = DB::select("
            SELECT a.id, 
                FORMAT(a.comDate, 'dddd') AS day,
                CONVERT(datetime, a.comDate, 23) as date,
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comIn)) AS time_in, 
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comOut)) AS time_out, 
                CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) AS hours, 
                SUBSTRING(CONVERT(CHAR(8), a.comTotalHours, 108), 4, 2) AS minutes,
                a.comIjin, b.job_title_code, a.is_claim_ot,
                CASE 
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) >= 8 
                    THEN 1 
                    WHEN CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) < 8 
                        AND a.comIjin != '' 
                    THEN 1 
                    ELSE 0 
                END AS status_hours
            FROM com_absensi_inout AS a
            INNER JOIN employee AS b ON a.comNIP = b.employee_id
            WHERE a.comNIP = '".$emp_id."'
            AND CONVERT(DATE, a.comDate) = '".$request->date."'
            ORDER BY a.comDate DESC
        ");

        if ($attendances) {
            $result = [
                'data' => $attendances,
                'status' => 1,
            ];
        } else {
            $result = [
                'status' => 0,
            ];
        }
        return response()->json($result, 200);
    }

    public function getLocation() {
        $location = DB::table('location')
            ->whereIn('id', [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,21,22,23,24,29])
            ->select('id', 'name', 'country_code', 'province', 'city', 'latitude_mobile', 'longitude_mobile')
            ->get();

        $result = $location;
        return response()->json($result, 200);
    }
}

