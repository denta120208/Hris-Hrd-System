<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MetHrisMobile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileUserController extends Controller
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

    public function getUserProfile(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $employee_mobile = DB::table("MH_USER_MOBILE")
                        ->where("EMPLOYEE_ID", $request->employee_id)
                        ->where("DEVICE_UUID", $request->device_uuid)
                        ->where("IS_ACTIVE", 1)
                        ->first();


        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $member = DB::table('employee')
            ->leftjoin('emp_picture', 'employee.emp_number','=','emp_picture.emp_number')
            ->rightjoin ('users', 'users.username', '=', 'employee.employee_id')
            ->where('users.username', $request->employee_id)
            ->select('employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname', 'employee.emp_number', 'users.is_manage', 'users.username', 'users.name')
            ->first();


        $img = DB::table("emp_picture")
            ->where("emp_number", $member->emp_number)
            ->first();

        //dd($member);
        if(empty($member)){
            $result = (["result" => "Member Tidak Ada"]);

        } else {
//              $picture =  base64_encode( $member_picture->epic_picture );
            $result = ([
                "emp_firstname" => $member->emp_firstname,
                "emp_middle_name" => $member->emp_middle_name,
                "emp_lastname" => $member->emp_lastname,
                "emp_number" => $member->emp_number,
                "is_managed" => $member->is_manage,
                "employee_id" => $member->username,
                "name" => $member->name,
//                "picture" => $img->epic_picture
//                "picture" =>$picture
            ]);

        }

        return response()->json($result,200);

    }

    public function getUserPicture(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();


        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $member = DB::table('employee')
            ->leftjoin('emp_picture', 'employee.emp_number','=','emp_picture.emp_number')
            ->rightjoin ('users', 'users.username', '=', 'employee.employee_id')
            ->where('users.username', $request->employee_id)
            ->select('employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname', 'employee.emp_number', 'users.is_manage', 'users.username', 'users.name')
            ->first();


        $img = DB::table("emp_picture")
            ->where("emp_number", $member->emp_number)
            ->first();

        //dd($member);
        if(empty($member)){
            $result = (["result" => "Member Tidak Ada"]);

        } else {

            if($img->epic_picture_type == 2){
                $picture =  base64_encode( $img->epic_picture );
            } else {
                $picture = $img->epic_picture;
            }

            $result = [
             "picture" =>$picture
            ];

        }

        return response()->json($result,200);

    }


    public function getAttendanceV2(Request $request){
//                if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();


        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }


        $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
            WHERE  employee_id = '".$request->employee_id."' order by punch_in_utc_time desc");
        $attendances = DB::table('attendance_record')->where('employee_id', $request->employee_id)
            ->orderBy('punch_in_utc_time', 'desc')
            ->take(25)
            ->get();
        $i = 0;
        foreach($attendances as $attendance){

            $hari =   date('l', strtotime($attendance->punch_in_utc_time));
            $date = substr($attendance->punch_in_utc_time,0,10);
            $time_in = substr($attendance->punch_in_utc_time,11,8);
            $time_out = substr($attendance->punch_out_utc_time,11,8);


            // Declare and define two dates
            $date1 = strtotime($attendance->punch_in_utc_time);
            $date2 = strtotime($attendance->punch_out_utc_time);

            // Formulate the Difference between two dates
            $diff = abs($date2 - $date1);


            // To get the year divide the resultant date into
            // total seconds in a year (365*60*60*24)
            $years = floor($diff / (365*60*60*24));


            // To get the month, subtract it with years and
            // divide the resultant date into
            // total seconds in a month (30*60*60*24)
            $months = floor(($diff - $years * 365*60*60*24)
                / (30*60*60*24));


            // To get the day, subtract it with years and
            // months and divide the resultant date into
            // total seconds in a days (60*60*24)
            $days = floor(($diff - $years * 365*60*60*24 -
                    $months*30*60*60*24)/ (60*60*24));


            // To get the hour, subtract it with years,
            // months & seconds and divide the resultant
            // date into total seconds in a hours (60*60)
            $hours = floor(($diff - $years * 365*60*60*24
                    - $months*30*60*60*24 - $days*60*60*24)
                / (60*60));

            $minutes = floor(($diff - $years * 365*60*60*24
                    - $months*30*60*60*24 - $days*60*60*24
                    - $hours*60*60)/ 60);

            $arr[$i] = [
                "id" => $attendance->id,
                "day" => $hari,
                "date" => $date,
                "time_in" =>  $time_in,
                "time_out" => $time_out,
                "hours" => $hours,
                "minutes" => $minutes

            ];
            $status = 200;
            $i++;

        }


        $result = [
            "day" => $hari,
        ];

        return response()->json($arr,200);

    }


    public function getAttendanceNowV2(Request $request){
//                if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMPLOYEE_ID", $request->employee_id)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();


        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

//        $now = date("Y-m-d H:i:s");
        $now = date("Y-m-d");
        $date = DB::select("
            SELECT a.id,FORMAT(a.comDate, 'dddd') AS 'day', 
                CONVERT(datetime, a.comDate, 23) AS date,
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comIn)) AS time_in,
                CONVERT(CHAR(8), CONVERT(TIME(0), a.comOut)) AS time_out,
                CAST(CONVERT(CHAR(2), CONVERT(TIME(0), a.comTotalHours)) AS INT) AS hours,
                a.comIjin, b.job_title_code, a.is_claim_ot
            FROM com_absensi_inout AS a
            INNER JOIN employee AS b
            ON a.comNIP = b.employee_id
            WHERE a.comNIP = '".$employee_mobile->EMPLOYEE_ID."'
            AND a.comDate = '".$now."'
        ");
//        $date = DB::connection('adms')->select("
//                select c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
//                from checkinout c INNER JOIN userinfo ui
//                ON c.userid = ui.userid 
//                WHERE ui.title= '".$employee_mobile->EMPLOYEE_ID."'
//                AND CAST(c.checktime as DATE) = '".$now."'
//                GROUP BY c.userid, CAST(c.checktime as DATE)
//            ");
//        $i = 0;
//            $date_1 = new DateTime($attendance->tanggal.' '.$attendance->waktuIn);
//            $date_2 = new DateTime($attendance->tanggal.' '.$attendance->waktuOut);
//            $diff = $date_1->diff($date_2);
//            $hours = $diff->h;
//            $minutes = $diff->i;
//            $arr[$i] = [
//                "id" => $attendance->userid,
//                "day" => date('l', strtotime($attendance->tanggal)),
//                "date" => $attendance->tanggal,
//                "time_in" =>  $attendance->waktuIn,
//                "time_out" => $attendance->waktuOut,
//                "hours" => $hours,
//                "minutes" => $minutes
//            ];
//        $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
//            WHERE cast(punch_in_utc_time AS date) = '".$now."' AND employee_id = '".$request->employee_id."' order by  punch_in_utc_time desc");
//
//        $datedays = DB::select("SELECT punch_in_utc_time as date from attendance_record
//            WHERE cast(punch_in_utc_time AS date) = '".$now."' AND employee_id = '".$request->employee_id."' order by  punch_in_utc_time desc");
//
//        $time = DB::select("SELECT convert(VARCHAR(8),punch_in_utc_time,108)as time  from attendance_record
//            WHERE cast(punch_in_utc_time AS date)  = '".$now."' AND employee_id = '".$request->employee_id."'");
//
//        if($date){
//            $new_date =  Carbon::createFromFormat('m-d-Y',$date[0]->date)->format('Y-m-d');
//
//        }

        if (empty($date)){
            $result = ["days" =>"Absent not found"];
        } else {
            //$hari =   date('l', strtotime( $date[0]->tanggal));
            //dd($hari);
//            print_r($hari); die;
            $result = [
                "days" => $date[0]->day,
                "date" => $date[0]->date,
                "time" => $date[0]->time_in,
                "time_out" => $date[0]->time_out,
            ];

        }

        return response()->json($result,200);


    }



    public function getPersonelDetailsV2(Request $request){
        // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        if ($request->atasan_status == 1) {
            if ($request->employee_id_search == 'null') {
                // $member = DB::table('employee')
                //     ->leftJoin("nationality", "employee.nation_code","=","nationality.id")
                //     ->leftJoin("emp_agama", "employee.agama","=","emp_agama.id")
                //     ->where('employee_id',  $request->employee_id)
                //     ->select("employee.*","nationality.name as COUNTRY_NAME","emp_agama.name as AGAMA_NAME")
                //     ->first();

                $member = DB::select("
                    SELECT employee.*, CONVERT(datetime, employee.emp_dri_lice_exp_date, 23) as dri_lice_convert, CONVERT(datetime, employee.emp_birthday, 23) as dob_convert, nationality.name AS COUNTRY_NAME, emp_agama.name AS AGAMA_NAME
                    FROM employee
                    LEFT JOIN nationality
                    ON employee.nation_code = nationality.id
                    LEFT JOIN emp_agama
                    ON employee.agama = emp_agama.id
                    WHERE employee.employee_id = '".$request->employee_id."'
                ");
            } else {
                // $member = DB::table('employee')
                //     ->leftJoin("nationality", "employee.nation_code","=","nationality.id")
                //     ->leftJoin("emp_agama", "employee.agama","=","emp_agama.id")
                //     ->where('employee_id',  $request->employee_id)
                //     ->select("employee.*","nationality.name as COUNTRY_NAME","emp_agama.name as AGAMA_NAME")
                //     ->first();

                $member = DB::select("
                    SELECT employee.*, CONVERT(datetime, employee.emp_dri_lice_exp_date, 23) as dri_lice_convert, CONVERT(datetime, employee.emp_birthday, 23) as dob_convert, nationality.name AS COUNTRY_NAME, emp_agama.name AS AGAMA_NAME
                    FROM employee
                    LEFT JOIN nationality
                    ON employee.nation_code = nationality.id
                    LEFT JOIN emp_agama
                    ON employee.agama = emp_agama.id
                    WHERE employee.employee_id = '".$request->employee_id."'
                ");
            }

            if (empty($member)) {
                $result = (["result" => "Data tidak di temukan.","status" => 0]);
            } else {
                $img = DB::table("emp_picture")
                    ->where("emp_number", $member[0]->emp_number)
                    ->first();

                if($img){

                    if($img->epic_picture_type == 2){
                        $picture =  base64_encode( $img->epic_picture );
                    } else {
                        $picture = $img->epic_picture;
                    }
                    // $picture =  base64_encode( $img->epic_picture );
                    $result = ["member" => $member[0], "picture" => $picture];

                } else {
                    $result = ["member" => $member[0], "picture" => []];

                }

            }

            return response()->json($result,200);
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
                // $member = DB::table('employee')
                //     ->leftJoin("nationality", "employee.nation_code","=","nationality.id")
                //     ->leftJoin("emp_agama", "employee.agama","=","emp_agama.id")
                //     ->where('employee_id',  $request->employee_id)
                //     ->select("employee.*","nationality.name as COUNTRY_NAME","emp_agama.name as AGAMA_NAME")
                //     ->first();

                $member = DB::select("
                    SELECT employee.*, CONVERT(datetime, employee.emp_dri_lice_exp_date, 23) as dri_lice_convert, CONVERT(datetime, employee.emp_birthday, 23) as dob_convert, nationality.name AS COUNTRY_NAME, emp_agama.name AS AGAMA_NAME
                    FROM employee
                    LEFT JOIN nationality
                    ON employee.nation_code = nationality.id
                    LEFT JOIN emp_agama
                    ON employee.agama = emp_agama.id
                    WHERE employee.employee_id = '".$request->employee_id."'
                ");
            } else {
                // $member = DB::table('employee')
                //     ->leftJoin("nationality", "employee.nation_code","=","nationality.id")
                //     ->leftJoin("emp_agama", "employee.agama","=","emp_agama.id")
                //     ->where('employee_id',  $request->employee_id)
                //     ->select("employee.*","nationality.name as COUNTRY_NAME","emp_agama.name as AGAMA_NAME")
                //     ->first();

                $member = DB::select("
                    SELECT employee.*, CONVERT(datetime, employee.emp_dri_lice_exp_date, 23) as dri_lice_convert, CONVERT(datetime, employee.emp_birthday, 23) as dob_convert, nationality.name AS COUNTRY_NAME, emp_agama.name AS AGAMA_NAME
                    FROM employee
                    LEFT JOIN nationality
                    ON employee.nation_code = nationality.id
                    LEFT JOIN emp_agama
                    ON employee.agama = emp_agama.id
                    WHERE employee.employee_id = '".$request->employee_id."'
                ");
            }

            if (empty($member)) {
                $result = (["result" => "Data tidak di temukan.","status" => 0]);
            } else {
                $img = DB::table("emp_picture")
                    ->where("emp_number", $member[0]->emp_number)
                    ->first();

                if($img){

                    if($img->epic_picture_type == 2){
                        $picture =  base64_encode( $img->epic_picture );
                    } else {
                        $picture = $img->epic_picture;
                    }
                    // $picture =  base64_encode( $img->epic_picture );
                    $result = ["member" => $member[0], "picture" => $picture];

                } else {
                    $result = ["member" => $member[0], "picture" => []];

                }

            }

            return response()->json($result,200);
        }
    }


    public function getEmployeeJobV2(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $emp_jobinfo = DB::select("
                    select  b.name as location_name, c.name subunit_name,d.job_description, d. job_title, e.name as emp_status_name,f.econ_extend_start_date, f.econ_extend_end_date,joined_date, * from employee a
                    left join location b
                    on a.location_id = b.id
                    left join subunit c
                    on a.work_station = c.id
                    left join job_title d
                    on a.job_title_code =  d.id
                    left join employment_status e
                    on a.emp_status = e.id
                    left join emp_contract f
                    on a.emp_number = f.emp_number
                    where a.emp_number = ".$request->emp_number
                );
            } else {
                $emp_jobinfo = DB::select("
                    select  b.name as location_name, c.name subunit_name,d.job_description, d. job_title, e.name as emp_status_name,f.econ_extend_start_date, f.econ_extend_end_date,joined_date, * from employee a
                    left join location b
                    on a.location_id = b.id
                    left join subunit c
                    on a.work_station = c.id
                    left join job_title d
                    on a.job_title_code =  d.id
                    left join employment_status e
                    on a.emp_status = e.id
                    left join emp_contract f
                    on a.emp_number = f.emp_number
                    where a.emp_number = ".$request->emp_number_search
                );
            }

            if ($emp_jobinfo) {
                $result = $emp_jobinfo[0];
            } else {
                $result = [];
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

            if ($request->emp_number_search == 0) {
                $emp_jobinfo = DB::select("
                    select  b.name as location_name, c.name subunit_name,d.job_description, d. job_title, e.name as emp_status_name,f.econ_extend_start_date, f.econ_extend_end_date,joined_date, * from employee a
                    left join location b
                    on a.location_id = b.id
                    left join subunit c
                    on a.work_station = c.id
                    left join job_title d
                    on a.job_title_code =  d.id
                    left join employment_status e
                    on a.emp_status = e.id
                    left join emp_contract f
                    on a.emp_number = f.emp_number
                    where a.emp_number = ".$request->emp_number
                );
            } else {
                $emp_jobinfo = DB::select("
                    select  b.name as location_name, c.name subunit_name,d.job_description, d. job_title, e.name as emp_status_name,f.econ_extend_start_date, f.econ_extend_end_date,joined_date, * from employee a
                    left join location b
                    on a.location_id = b.id
                    left join subunit c
                    on a.work_station = c.id
                    left join job_title d
                    on a.job_title_code =  d.id
                    left join employment_status e
                    on a.emp_status = e.id
                    left join emp_contract f
                    on a.emp_number = f.emp_number
                    where a.emp_number = ".$request->emp_number_search
                );
            }

            if ($emp_jobinfo) {
                $result = $emp_jobinfo[0];
            } else {
                $result = [];
            }
            return response()->json($result,200);
        }
    }

    public function getEmployeeReportToV2(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $reports = DB::table('emp_reportto')
                    ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
                    ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
                    ->where('emp_reportto.erep_sub_emp_number', $request->emp_number)
                    ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname',
                        'employee.emp_middle_name','employee.emp_lastname')->get();
            } else {
                $reports = DB::table('emp_reportto')
                    ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
                    ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
                    ->where('emp_reportto.erep_sub_emp_number', $request->emp_number_search)
                    ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname',
                        'employee.emp_middle_name','employee.emp_lastname')->get();
            }

            if (empty($reports)) {
                $result = [];
            } else {
                $result = $reports;
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

            if ($request->emp_number_search == 0) {
                $reports = DB::table('emp_reportto')
                    ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
                    ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
                    ->where('emp_reportto.erep_sub_emp_number', $request->emp_number)
                    ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname',
                        'employee.emp_middle_name','employee.emp_lastname')->get();
            } else {
                $reports = DB::table('emp_reportto')
                    ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
                    ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
                    ->where('emp_reportto.erep_sub_emp_number', $request->emp_number_search)
                    ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname',
                        'employee.emp_middle_name','employee.emp_lastname')->get();
            }

            if (empty($reports)) {
                $result = [];
            } else {
                $result = $reports;
            }

            return response()->json($result,200);
        }
    }



    public function userChangePassword(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $db_sso = DB::connection("sqlsrv_sso");
        $now = date('Y-m-d H:i:s');

        // if ($request->header('APP-ID') == $this->getMobileAppsID()) { } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            $emp = DB::table("employee")
                ->where("emp_number", $request->emp_number)
                ->first();

            $user = $db_sso->table("users")
                ->where('NIK', $emp->employee_id)
                ->where('isactive', 1)
                ->first();

            if ($user) {
                if(Hash::check($request->old_password, $user->password)){
                    $new_password = Hash::make($request->new_password);

                    $db_sso->table("users")
                        ->where("NIK", $emp->employee_id)
                        ->update([
                            "password" =>  $new_password,
                            "update_password_at" => $now,
                            "ischangepassword" => 1,
                        ]);
        
                    DB::table("MH_USER_MOBILE")
                        ->where("EMPLOYEE_ID", $emp->employee_id)
                        ->where("DEVICE_UUID", $request->device_uuid)
                        ->where("IS_ACTIVE", 1)
                        ->update([
                            "IS_ACTIVE" => 0
                        ]);

                    $result = ["result" => "Successfully change your password.", "status" => 1];
                } else {
                    $result = ["result" => "Old password does not match.", "status" => 0];
                }
                $this->addMobileLog($request->emp_number, "Change Password", "Change password.");
                return response()->json($result,200);
            } else {
                $result = ["result" => "User not found.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        // OLD
        // date_default_timezone_set('Asia/Jakarta');
        // $now = date('Y-m-d H:i:s');

        // // if ($request->header('APP-ID') == $this->getMobileAppsID()) { } else {
        // //     $result = ["result" => "Apps key not valid.", "status" => 0];
        // //     return response()->json($result, 200);
        // // }

        // $employee_mobile = DB::table("MH_USER_MOBILE")
        //     ->where("EMP_NUMBER", $request->emp_number)
        //     ->where("DEVICE_UUID", $request->device_uuid)
        //     ->where("IS_ACTIVE", 1)
        //     ->first();

        // if ($employee_mobile) {
        // } else {
        //     $result = ["result" => "You're not logged in.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        // $emp = DB::table("employee")
        //     ->where("emp_number", $request->emp_number)
        //     ->first();
        // $user = DB::TABLE("users")
        //     ->where("username", $emp->employee_id)
        //     ->first();
        // $bcrypt_password = bcrypt($request->new_password);

        // if(Hash::check($request->old_password, $user->password)){
        //     DB::TABLE("users")
        //         ->where("username", $emp->employee_id)
        //         ->update([
        //             "decrypt" => $request->new_password,
        //             "updated_at" => $now,
        //             "password" => $bcrypt_password
        //         ]);

        //     DB::table("MH_USER_MOBILE")
        //         ->where("EMPLOYEE_ID", $emp->employee_id)
        //         ->where("DEVICE_UUID", $request->device_uuid)
        //         ->where("IS_ACTIVE", 1)
        //         ->update([
        //            "IS_ACTIVE" => 0
        //         ]);
        //     $result = ["result" => "Successfully change your password.", "status" => 1];
        // } else {
        //     $result = ["result" => "Old password does not match.", "status" => 0];
        // }
        // $this->addMobileLog($request->emp_number, "Change Password", "Change password.");
        // return response()->json($result,200);
    }

    public function userChangePassword1(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $db_sso = DB::connection("sqlsrv_sso");
        $now = date('Y-m-d H:i:s');

        // if ($request->header('APP-ID') == $this->getMobileAppsID()) { } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            $emp = DB::table("employee")
                ->where("emp_number", $request->emp_number)
                ->first();

            $user = $db_sso->table("users")
                ->where('NIK', $emp->employee_id)
                ->where('isactive', 1)
                ->first();

            if ($user) {
                if(Hash::check($request->old_password, $user->password)){
                    $new_password = Hash::make($request->new_password);

                    $db_sso->table("users")
                        ->where("NIK", $emp->employee_id)
                        ->update([
                            "password" =>  $new_password,
                            "update_password_at" => $now,
                            "ischangepassword" => 1,
                        ]);
        
                    DB::table("MH_USER_MOBILE")
                        ->where("EMPLOYEE_ID", $emp->employee_id)
                        ->where("DEVICE_UUID", $request->device_uuid)
                        ->where("IS_ACTIVE", 1)
                        ->update([
                            "IS_ACTIVE" => 0
                        ]);

                    $result = ["result" => "Successfully change your password.", "status" => 1];
                } else {
                    $result = ["result" => "Old password does not match.", "status" => 0];
                }
                $this->addMobileLog($request->emp_number, "Change Password", "Change password.");
                return response()->json($result,200);
            } else {
                $result = ["result" => "User not found.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }


    public function userChangePasswordFirstTime(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $db_sso = DB::connection("sqlsrv_sso");
        $now = date('Y-m-d H:i:s');

        // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

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

        $emp = DB::table("employee")
            ->where("emp_number", $request->emp_number)
            ->first();

        $user = $db_sso->table("users")
            ->where('NIK', $emp->employee_id)
            ->where('isactive', 1)
            ->first();

        if($user->is_changepassword == 0){
            $new_password = Hash::make($request->new_password);

           $db_sso->table("users")
                ->where("username", $emp->employee_id)
                ->update([
                    "password" =>  $new_password,
                    "update_password_at" => $now,
                    "ischangepassword" => 1,
                ]);

//            DB::table("MH_USER_MOBILE")
//                ->where("EMPLOYEE_ID", $emp->employee_id)
//                ->where("DEVICE_UUID", $request->device_uuid)
//                ->where("IS_ACTIVE", 1)
//                ->update([
//                    "IS_ACTIVE" => 0
//                ]);
            $result = ["result" => "Successfully change your password.", "status" => 1];
        } else {
            $result = ["result" => "Old password does not match.", "status" => 0];
        }

        $this->addMobileLog($request->emp_number, "Change Password", "Change password first time.");
        return response()->json($result,200);

        // OLD
//         date_default_timezone_set('Asia/Jakarta');
//         $now = date('Y-m-d H:i:s');
//         if($request->header('APP-ID') == $this->getMobileAppsID()){

//         } else {
//             $result = ["result" => "Apps key not valid.", "status" => 0];
//             return response()->json($result, 200);
//         }

//         $employee_mobile = DB::table("MH_USER_MOBILE")
//             ->where("EMP_NUMBER", $request->emp_number)
//             ->where("DEVICE_UUID", $request->device_uuid)
//             ->where("IS_ACTIVE", 1)
//             ->first();

//         if($employee_mobile){

//         } else {
//             $result = ["result" => "You're not logged in.", "status" => 0];
//             return response()->json($result, 200);
//         }


//         $emp = DB::table("employee")
//             ->where("emp_number", $request->emp_number)
//             ->first();
//         $user = DB::TABLE("users")
//             ->where("username", $emp->employee_id)
//             ->first();
//         $bcrypt_password = bcrypt($request->new_password);
//         if($user->is_changepassword == 0){
//             DB::TABLE("users")
//                 ->where("username", $emp->employee_id)
//                 ->update([
//                     "decrypt" => $request->new_password,
//                     "updated_at" => $now,
//                     "password" => $bcrypt_password,
//                     "is_changepassword" => 1
//                 ]);

// //            DB::table("MH_USER_MOBILE")
// //                ->where("EMPLOYEE_ID", $emp->employee_id)
// //                ->where("DEVICE_UUID", $request->device_uuid)
// //                ->where("IS_ACTIVE", 1)
// //                ->update([
// //                    "IS_ACTIVE" => 0
// //                ]);
//             $result = ["result" => "Successfully change your password.", "status" => 1];
//         } else {
//             $result = ["result" => "Old password does not match.", "status" => 0];
//         }

//         $this->addMobileLog($request->emp_number, "Change Password", "Change password first time.");
//         return response()->json($result,200);
    }

    public function userChangePasswordFirstTime1(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $db_sso = DB::connection("sqlsrv_sso");
        $now = date('Y-m-d H:i:s');

        // if($request->header('APP-ID') == $this->getMobileAppsID()){ } else {
        //     $result = ["result" => "Apps key not valid.", "status" => 0];
        //     return response()->json($result, 200);
        // }

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

        $emp = DB::table("employee")
            ->where("emp_number", $request->emp_number)
            ->first();

        $user = $db_sso->table("users")
            ->where('NIK', $emp->employee_id)
            ->where('isactive', 1)
            ->first();

        if($user->is_changepassword == 0){
            $new_password = Hash::make($request->new_password);

           $db_sso->table("users")
                ->where("username", $emp->employee_id)
                ->update([
                    "password" =>  $new_password,
                    "update_password_at" => $now,
                    "ischangepassword" => 1,
                ]);

//            DB::table("MH_USER_MOBILE")
//                ->where("EMPLOYEE_ID", $emp->employee_id)
//                ->where("DEVICE_UUID", $request->device_uuid)
//                ->where("IS_ACTIVE", 1)
//                ->update([
//                    "IS_ACTIVE" => 0
//                ]);
            $result = ["result" => "Successfully change your password.", "status" => 1];
        } else {
            $result = ["result" => "Old password does not match.", "status" => 0];
        }

        $this->addMobileLog($request->emp_number, "Change Password", "Change password first time.");
        return response()->json($result,200);
    }

    public function getAllRequestAtasan(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $leave_request = DB::table('emp_leave_request')
            ->join('emp_reportto', 'emp_leave_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_leave_request.emp_number', '=' ,'employee.emp_number')
            ->join("leave_type","emp_leave_request.leave_type_id","=","leave_type.id")
            ->join('leave_status', 'leave_status.id','=', 'emp_leave_request.leave_status')
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_leave_request.leave_status', 3)
            //->take(10)
            ->count();

        $attendance_request = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_attendance_request.request_status', 1)
            //->take(10)
            ->select("emp_attendance_request.*",'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->count();

        $training = DB::table('emp_trainning_request')
            ->join('emp_reportto', 'emp_trainning_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_trainning_request.emp_number', '=' ,'employee.emp_number')
            ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_trainning_request.training_status', 1)
            //->take(10)
            ->select("emp_trainning_request.*","trainning.name as name","trainning_vendor.vendor_name as vendor_name", 'emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->count();


        $result = [
          "leave_request" => $leave_request,
          "attendance_request" => $attendance_request,
          "training_request" => $training
        ];
        return response()->json($result,200);
    }
}
