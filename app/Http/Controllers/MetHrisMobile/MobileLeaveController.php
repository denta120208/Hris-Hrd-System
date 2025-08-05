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
use App\Models\Master\Employee;
use GuzzleHttp\Client;
use App\Models\Leave\LeaveType, App\Models\Leave\LeaveEntitlement, App\Models\Leave\LeaveRequest, App\Models\Leave\LeaveStatus;
use Illuminate\Support\Facades\Crypt;

class MobileLeaveController extends Controller
{
//    protected $lvReq;
//    protected $emp;
//    protected $entitle;
//
//    function __construct(User $user, LeaveRequest $lvReq,Employee $emp,LeaveEntitlement $entitle)
//    {
//        //parent::__construct();
//        $this->lvReq = $lvReq;
//        $this->emp = $emp;
//        $this->user = $user;
//        $this->entitle = $entitle;
//        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
//        $this->beforeFilter('auth', ['except' => 'destroy']);
//
//    }
    
    protected $emp;
    protected $entitle;
    protected $lvReq;
    protected $lvType;
    protected $lvStat;
    public function __construct(Employee $emp,LeaveEntitlement $entitle, LeaveRequest $lvReq, LeaveType $lvType, LeaveStatus $lvStat){
        //parent::__construct();
        $this->beforeFilter('auth', ['except' => 'destroy']);
        $this->emp = $emp;
        $this->entitle = $entitle;
        $this->lvReq = $lvReq;
        $this->lvType = $lvType;
        $this->lvStat = $lvStat;
        
    }


    public function getLeaveTypeActive(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $leave_type = DB::table("leave_type")
            ->where("is_active", 1)
            ->get();
        return response()->json($leave_type, 200);
    }


    public function getLeaveWithType(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $yearEnd2 = date('Y-m-d H:i:s');
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
        $emp = DB::table('employee')->where('emp_number', $request->emp_number)->first();
//        $balLeaves = DB::table('leave_entitlement')
//            ->join('leave_type','leave_entitlement.leave_type_id', '=','leave_type.id')
//            ->where('emp_number',  $request->emp_number)
//            ->where('to_date' ,'>=', $yearEnd)
//            ->where('deleted', 0)
//            ->where('leave_type_id', $request->leave_type_id)
//            ->select('leave_entitlement.id','leave_type.name','leave_entitlement.no_of_days', 'leave_entitlement.days_used', 'leave_entitlement.from_date', 'leave_entitlement.to_date', 'leave_type_id')
//            ->get();
        if (($emp->job_title_code >= 16) && $request->leave_type_id == 4)
        {
            $entitle = DB::select("
                SELECT leave_type_id,b.name,sum(no_of_days) AS no_of_days, sum(days_used) AS days_used,  sum(no_of_days)- sum(days_used) AS balance, days_type
                FROM leave_entitlement  a 
                INNER JOIN leave_type b
                ON a. leave_type_id = b.id
                JOIN employee c
                ON a.emp_number = c.emp_number
                WHERE leave_type_id = '" . $request->leave_type_id . "'
                AND a.emp_number = '" . $request->emp_number . "'
                GROUP BY leave_type_id, b.name, days_type
            ");
        }
        else
        {
            $entitle = DB::select("
                SELECT leave_type_id,b.name,sum(no_of_days) AS no_of_days, sum(days_used) AS days_used,  sum(no_of_days)- sum(days_used) AS balance, days_type
                FROM leave_entitlement  a 
                INNER JOIN leave_type b
                ON a. leave_type_id = b.id
                JOIN employee c
                ON a.emp_number = c.emp_number
                WHERE leave_type_id = '" . $request->leave_type_id . "'
                AND a.emp_number = '" . $request->emp_number . "'
                AND to_date >= '" . $yearEnd2 . "'
                GROUP BY leave_type_id, b.name, days_type
            ");
        }
        

        $i = 0;

        if (empty($entitle)) {
            $arr = [];
        } else {
            $arr = $entitle[0];

        }

        return response()->json($arr, 200);
    }

    public function getLeaveEmp(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $yearEnd2 = date('Y-m-d H:i:s');
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        $emp = DB::table('employee')->where('emp_number', $request->emp_number)->first();
        
        if ($emp->job_title_code >= 16)
        {
//            $balLeaves = DB::table('leave_entitlement')
//                ->join('leave_type', 'leave_entitlement.leave_type_id', '=', 'leave_type.id')
//                ->where('emp_number', $request->emp_number)
//                ->where('to_date', '>=', $yearEnd2)
//                ->where('deleted', 0)
//                ->select('leave_entitlement.id', 'leave_type.name', 'leave_entitlement.no_of_days', 'leave_entitlement.days_used', 'leave_entitlement.from_date', 'leave_entitlement.to_date', 'leave_type_id')
//                ->orderBy('leave_entitlement.leave_type_id', 'asc')
//                ->get();
            
            $balLeaves = DB::select("
                select *
                    from (
                            Select a.id, c.name, a.no_of_days, a.days_used, a.from_date, a.to_date, a.leave_type_id
                            from leave_entitlement as a INNER JOIN employee as b ON a.emp_number = b.emp_number
                            INNER JOIN leave_type as c ON a.leave_type_id = c.id
                            where job_title_code IN (16,17,18)
                            and b.termination_id IN (0)
                            and a.leave_type_id = 4
                            and a.emp_number = ".$request->emp_number."
                            UNION ALL
                            Select a.id, c.name, a.no_of_days, a.days_used, a.from_date, a.to_date, a.leave_type_id
                            from leave_entitlement as a INNER JOIN employee as b ON a.emp_number = b.emp_number
                            INNER JOIN leave_type as c ON a.leave_type_id = c.id
                            where job_title_code IN (16,17,18)
                            and b.termination_id IN (0)
                            and a.leave_type_id = 1
                            and a.to_date >= GETDATE()
                            and a.emp_number = ".$request->emp_number."
                    ) as a
                ORDER BY a.from_date"
            );

        }
        else
        {
            $balLeaves = DB::table('leave_entitlement')
                ->join('leave_type', 'leave_entitlement.leave_type_id', '=', 'leave_type.id')
                ->where('emp_number', $request->emp_number)
                ->where('to_date', '>=', $yearEnd2)
                ->where('deleted', 0)
                ->select('leave_entitlement.id', 'leave_type.name', 'leave_entitlement.no_of_days', 'leave_entitlement.days_used', 'leave_entitlement.from_date', 'leave_entitlement.to_date', 'leave_type_id')
                ->orderBy('leave_entitlement.leave_type_id', 'asc')
                ->get();

        }
        
        $i = 0;

        if (empty($balLeaves)) {
            $arr = [];
        } else {
            foreach ($balLeaves as $balLeave) {
                $noofdays = $balLeave->no_of_days;
                $daysused = $balLeave->days_used;
                $total = $noofdays - $daysused;

                $arr[$i] = [
                    "id" => $balLeave->id,
                    "leave_type" => $balLeave->name,
                    "valid_from" => $balLeave->from_date,
                    "valid_to" => $balLeave->to_date,
                    "no_of_days" => $balLeave->no_of_days,
                    "days_used" => $balLeave->days_used,
                    "total_cuti" => $total,
                    "leave_type_id" => $balLeave->leave_type_id
                ];
                $status = 200;
                $i++;

            }
        }

        return response()->json($arr, 200);

    }

    public function addEmployeeLeave(Request $request)
    {
        $now = date("Y-m-d H:i:s");
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        $member = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        //$user = DB::table('users')->where('id', $request->user_id);
        $member_name = DB::table('users')->where('id', $request->emp_num);
        if (empty($member)) {

            $result = (["result" => "Tidak Ada Employee",
                "status" => 0]);
        } else {


            DB::table('leave_entitlement')->insert([
                'emp_number' => $request->emp_number,
                'no_of_days' => $request->no_of_days,
                'days_used' => 0,
                'leave_type_id' => $request->leave_type,
                'from_date' => $request->valid_from,
                'to_date' => $request->valid_to,
                'credited_date' => $now,
                'entitlement_type' => 1,
                'deleted' => 0,
                'created_by_id' => $request->user_id,
                'created_by_name' => $member_name->name
            ]);

            $result = (["result" => "Berhasil Menambahkan",
                "status" => 1]);

        }

        return response()->json($result, 200);
    }


    public function applyEmployeeLeave(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $now = date("Y-m-d H:i:s");
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_num)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();
//
//        $request = $request->all();
//
//        $request = array_filter($request);
//        $request = json_decode($request);
//        dd($request->emp_number);
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        //$now = date("Y-m-d H:i:s");
        $sDate = date("Y-m-d", strtotime($request->start_date));
        $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        
        $empreport = DB::table('emp_reportto')->where('erep_sub_emp_number', $request->emp_num)
            ->where('erep_reporting_mode', '1')
            ->first();
        
        $empreport_username = DB::table('employee')
            ->where('emp_number', $empreport->erep_sup_emp_number)
            ->first();
//        $player_id = DB::table('user_phone')
//            ->where('employee_id', $empreport_username->employee_id)
//            ->first();
        // dd ($player_id);
        $days = 0;
        $eDate = date('Y-m-d', strtotime($request->end_date));
        if ($request->half_day == 1) {
            $days = (float)0.5;
        } else {
            $days = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);

        }
//        print_r($emp->emp_number); die;
//        $id = DB::table('emp_leave_request')->insert([
//            'leave_type_id' => $request->type,
//            'date_applied' => $request->start_date,
//            'emp_number' => $request->emp_num,
//            'leave_status' => '3',
//            'comments' => $request->comments,
//            'length_days' => $days,
//            'from_date' => $request->start_date,
//            'end_date' => $request->end_date,hi
//            'created_at' => $now,
//            'created_by' => $request->emp_num
//        ]);

//        DB::table('emp_leave_request')->insert([
//            'leave_type_id' => $request->leave_type_id,
//            'date_applied' => $request->start_date,
//            'emp_number' => $emp->emp_number,
//            'leave_status' => '3',
//            'comments' => $request->comments,
//            'length_days' => $days,
//            'from_date' => $request->start_date,
//            'end_date' => $request->end_date,
//            'created_at' => $now,
//            'created_by' => $emp->emp_number,
//            'person_in_charge' => $request->pic_emp_number,
//            'pnum' => $emp->pnum,
//            'ptype' => $emp->ptype
//        ]);
        $id = $this->lvReq->create([
            'leave_type_id' => $request->leave_type_id,
            'date_applied' => $request->start_date,
            'emp_number' => $emp->emp_number,
            'leave_status' => '3',
            'comments' => $request->comments,
            'length_days' => $days,
            'from_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_at' => $now,
            'created_by' => $emp->emp_number,
            'person_in_charge' => $request->pic_emp_number,
            'pnum' => $emp->pnum,
            'ptype' => $emp->ptype
        ]);

//        $request_id = DB::getPdo()->lastInsertId();
//        print_r('<pre>');
//        print_r($request->emp_num);
//        print_r('</pre>'); die;
        $this->addMobileLog($request->emp_num, "Apply Leave", "Employee apply leave.");
        
        DB::table('MH_USER_LOG')
            ->insert([
                'EMP_NUMBER' => $request->emp_num,
                'LOG_TITLE' => 'Apply Leave',
                'LOG_DESC' => 'Employee apply leave.',
                'CREATED_AT' => $now,
            ]);
//        $this->sendEmailRequest('1',$emp->emp_number, $id->id);
        $notif = new MobileNotificationController();
        $notif->requestLeaveNotification($id->id);
        $result = ([
            "result" => "Successfully apply leave.",
            "status" => 1,
        ]);
        $this->sendEmailRequest('1',$request->emp_num, $id->id,$request->pic_emp_number);

        return response()->json($result, 200);
    }
    
    public function applyEmployeeLeave1(Request $request){
        $now = date("Y-m-d H:i:s");
        $sDate = date("Y-m-d", strtotime($request->start_date));
        $eDate = date('Y-m-d', strtotime($request->end_date));
        
        $days = 0;
        //$leaveController = new \App\Http\Controllers\Leave\LeaveController();
        
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_num)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();
        
        if(count($employee_mobile) <= 0)
        {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        
        $emp = $this->emp->where('emp_number', $request->emp_num)
            ->where(function ($query) {
                $query->where('emp_status', 1)
                ->orWhere('emp_status', 2);
            })
            ->first();

        if($emp->job_title_code >= 16) { // DIRECTOR Ke Atas
            if($request->leave_type_id == 4) { // Cuti Besar
                $leave_bal = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->first();
    
                $leave_bal_no_of_days = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->sum('no_of_days');
    
                $leave_bal_days_used = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->sum('days_used');
            }
            else {
                $leave_bal = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $now)
                    ->first();

                $leave_bal_no_of_days = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $now)
                    ->sum('no_of_days');

                $leave_bal_days_used = $this->entitle->where('leave_type_id', $request->leave_type_id)
                    ->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $now)
                    ->sum('days_used');
            }
        }
        else {
            $leave_bal = $this->entitle->where('leave_type_id', $request->leave_type_id)
                ->where('emp_number', $emp->emp_number)
                ->where('to_date', '>=', $now)->first();
    
            $leave_bal_no_of_days = $this->entitle->where('leave_type_id', $request->leave_type_id)
                ->where('emp_number', $emp->emp_number)
                ->where('to_date', '>=', $now)
                ->sum('no_of_days');
    
            $leave_bal_days_used = $this->entitle->where('leave_type_id', $request->leave_type_id)
                ->where('emp_number', $emp->emp_number)
                ->where('to_date', '>=', $now)
                ->sum('days_used');
        }

        $emp_report_to = \DB::table('emp_reportto')->where('erep_sub_emp_number', $emp->emp_number)->count();

        // Jika tidak ada work emailnya
        if(empty($emp->emp_work_email) || $emp->emp_work_email == "" || $emp->emp_work_email == NULL) {
            $result = ["result" => "You're work email not found, please complete your personal data.", "status" => 0];
            return response()->json($result, 200);
        }

        // Jika tidak ada data Report To nya
        if($emp_report_to <= 0) {
            $result = ["result" => "you're superior is not set, please contact HR Department.", "status" => 0];
            return response()->json($result, 200);
        }
        try {
            if ($request->half_day == 1) 
            {
                $eDate1 = $sDate;
                $days = (float)$this->calculateDays($sDate, $eDate1, $emp->days_type);
                $days -= (float)0.5;
            }
            else
            {
                if(strtotime($request->start_date) <= strtotime($request->end_date)){
                //$days = (float)$leaveController->calculateDays($sDate, $eDate, $emp->days_type);
                    $days = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);
                } else{
                    $result = ["result" => "you're input date are wrong", "status" => 0];
                    return response()->json($result, 200);
                }
            }
                        
//            $this->validate($request,
//                [
//                    'type' => 'required',
//                    'emp_incharge' => 'required'
//                ],
//                [
//                    'type.required' => 'Please Choose Leave Type!',
//                    'emp_incharge.required' => 'Person InCharge cannot be empty!'
//                ]
//            );
    
//            if($request->ts1){
//                $days -= (float) 0.5;
//            }
            
            if($leave_bal){
                if ($request->half_day == 1) 
                {
                    \DB::beginTransaction();
                            $id = $this->lvReq->create([
                                'leave_type_id' => $request->leave_type_id,
                                'date_applied' => $request->start_date,
                                'emp_number' => $emp->emp_number,
                                'leave_status' => '3',
                                'person_in_charge' => $request->pic_emp_number,
                                'comments' => $request->comments,
                                'length_days' => $days,
                                'from_date' => $request->start_date,
                                'end_date' => $request->start_date,
                                'created_at' => $now,
                                'created_by' => $emp->emp_number,
                                'pnum' => $emp->pnum,
                                'ptype' => $emp->ptype
                            ]);
                            $this->sendEmailRequest('1',$request->emp_num, $id->id,$request->pic_emp_number);
                            //$this->sendEmailRequest('1',$emp->emp_number, $id->id,$request->emp_incharge);
                            $notif = new MobileNotificationController();
                            $notif->requestLeaveNotification($id->id);

    //                        \DB::table('log_activity')->insert([
    //                            'action' => 'Add Request Leave',
    //                            'module' => 'Leave',
    //                            'sub_module' => 'Request Leave',
    //                            'modified_by' => Session::get('email'),
    //                            'description' => 'ID Leave : ' . $id->id . ', Request Leave By : ' . trim(Session::get('name')),
    //                            'created_at' => $now,
    //                            'updated_at' => $now,
    //                            'table_activity' => 'emp_leave_request'
    //                        ]);
                        \DB::commit();
                        $this->addMobileLog($request->emp_num, "Apply Leave", "Employee apply leave.");
                }
                else
                {
                    if(($leave_bal_no_of_days - $leave_bal_days_used) >= $days){
                        \DB::beginTransaction();
                            $id = $this->lvReq->create([
                                'leave_type_id' => $request->leave_type_id,
                                'date_applied' => $request->start_date,
                                'emp_number' => $emp->emp_number,
                                'leave_status' => '3',
                                'person_in_charge' => $request->pic_emp_number,
                                'comments' => $request->comments,
                                'length_days' => $days,
                                'from_date' => $request->start_date,
                                'end_date' => $request->end_date,
                                'created_at' => $now,
                                'created_by' => $emp->emp_number,
                                'pnum' => $emp->pnum,
                                'ptype' => $emp->ptype
                            ]);
                            $this->sendEmailRequest('1',$request->emp_num, $id->id,$request->pic_emp_number);
                            //$this->sendEmailRequest('1',$emp->emp_number, $id->id,$request->emp_incharge);
                            $notif = new MobileNotificationController();
                            $notif->requestLeaveNotification($id->id);

    //                        \DB::table('log_activity')->insert([
    //                            'action' => 'Add Request Leave',
    //                            'module' => 'Leave',
    //                            'sub_module' => 'Request Leave',
    //                            'modified_by' => Session::get('email'),
    //                            'description' => 'ID Leave : ' . $id->id . ', Request Leave By : ' . trim(Session::get('name')),
    //                            'created_at' => $now,
    //                            'updated_at' => $now,
    //                            'table_activity' => 'emp_leave_request'
    //                        ]);
                        \DB::commit();
                        $this->addMobileLog($request->emp_num, "Apply Leave", "Employee apply leave.");
                    }
                }
                
            }else{
                $result = ["result" => "Your Leave Entitlement Not Found, please contact HR Department  ", "status" => 0];
                return response()->json($result, 200);
            }
        } catch (QueryException $ex) {
            \DB::rollback();
            $result = ["result" => "Failed request leave, errmsg : " . $ex, "status" => 0];
            return response()->json($result, 200);

//            return redirect(route('applLeave'))->withErrors([
//                'error' => 'Failed request leave, errmsg : ' . $ex
//            ]);
        }
        
        $result = ([
            "result" => "Successfully apply leave.",
            "status" => 1,
        ]);

        return response()->json($result, 200);
    }

    public function getAllPIC(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        
//        $employee = DB::table('employee')
//            ->get();
//
//        $pic = DB::select("select top 25 employee_id, emp_number ,emp_fullname  from employee
//            where emp_fullname like '%" . $request->search_value . "%' order by emp_fullname ");
//
//        return response()->json($pic, 200);
        
        $employee = collect(
            DB::table('employee')
                ->where('termination_id', 0)
                ->get()
        );

        $search_value = $request->search_value;

        // Jika search_value null atau kosong, kembalikan semua data
        if (is_null($search_value) || $search_value === '') {
            return response()->json($employee->values(), 200);
        }

        // Jika search_value tidak null, lakukan filtering berdasarkan emp_fullname
        $filtered_employee = $employee->filter(function ($emp) use ($search_value) {
            return stripos($emp->emp_fullname, $search_value) !== false; // stripos untuk case-insensitive search
        });

        // Mengembalikan data yang difilter dalam format JSON
        return response()->json($filtered_employee->values(), 200);
    }


    public function getEmployeeLeaveRequest(Request $request)
    {
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
//        $leave_request = DB::table("emp_leave_request")
//                        ->join("leave_status", "emp_leave_request.leave_status","=", "leave_status.id")
//                        ->join("leave_type","emp_leave_request.leave_type_id","=","leave_type.id")
//                        ->leftJoin("emp_leave_request", "employee.emp_number","=", "emp_leave_request.person_in_charge")
//                        ->where("emp_leave_request.emp_number", $request->emp_number)
//                        ->where("emp_leave_request.leave_status", 3)
//                        ->select("emp_leave_request.*", "leave_status.name as status_name","leave_type.name as leave_type_name","employee.emp_fullname")
//                        ->orderBy("emp_leave_request.date_applied", "desc")
//                        ->get();

        $leave_request = DB::select("select a.*, c.emp_firstname, c.emp_lastname, c.emp_middle_name, 
			d.name as leave_type_name, e.name as status_name, f.emp_fullname from emp_leave_request a
			inner join employee c
			on a.emp_number = c.emp_number
			inner join leave_type d
			on a.leave_type_id = d.id
			inner join leave_status e
			on a.leave_status = e.id
			left join employee f
			on a.person_in_charge = f.emp_number
			where a.leave_status = 3
			and a.emp_number =" . $request->emp_number);
        
        if(empty($leave_request)){
            $result = [];

        } else {
//            foreach ($leave_request as $key => $leaveRequest) {
//                $leave_request[$key]->pic_name = $leaveRequest->emp_fullname;
//                unset($leave_request[$key]->emp_fullname);
//            }
//            
//            for($i=0;$i<count($leave_request); $i++){
//                $res[$i] = [
//                    "data" => $leave_request[$i],
//                ];
//
//            }
//            $result = $res;
            foreach ($leave_request as $key => $leaveRequest) {
                $leave_request[$key]->pic_name = $leaveRequest->emp_fullname;
                unset($leave_request[$key]->emp_fullname);
            }
        }

//        if ($leave_request) {
//            $result = $leave_request;
//        } else {
//            $result = [];
//        }
        return response()->json($leave_request, 200);


    }

    public function getEmployeeLeaveHistory(Request $request)
    {
        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
//        $leave_request = DB::table("emp_leave_request")
//            ->join("leave_status", "emp_leave_request.leave_status","=", "leave_status.id")
//            ->join("leave_type","emp_leave_request.leave_type_id","=","leave_type.id")
//            ->where("emp_leave_request.emp_number", $request->emp_number)
//            ->whereNotIn("emp_leave_request.leave_status",[3])
//            ->select("emp_leave_request.*", "leave_status.name as status_name","leave_type.name as leave_type_name")
//            ->get();

        $leave_request = DB::select("select a.*, c.emp_firstname, c.emp_lastname, c.emp_middle_name, 
			d.name as leave_type_name, e.name as status_name, f.emp_fullname from emp_leave_request a
			inner join employee c
			on a.emp_number = c.emp_number
			inner join leave_type d
			on a.leave_type_id = d.id
			inner join leave_status e
			on a.leave_status = e.id
			left join employee f
			on a.person_in_charge = f.emp_number
			where a.leave_status not in (3)
			and a.emp_number =" . $request->emp_number);
        
//        if(empty($leave_request)){
//            $result = [];
//
//        } else {
//            foreach ($leave_request as $key => $leaveRequest) {
//                $leave_request[$key]->pic_name = $leaveRequest->emp_fullname;
//                unset($leave_request[$key]->emp_fullname);
//            }
//            
//            for($i=0;$i<count($leave_request); $i++){
//                $res[$i] = [
//                    "data" => $leave_request[$i],
//                ];
//
//            }
//            $result = $res;
//        }
        
        if (empty($leave_request)) {
            $result = [];
        } else {
            foreach ($leave_request as $key => $leaveRequest) {
                $leave_request[$key]->pic_name = $leaveRequest->emp_fullname;
                unset($leave_request[$key]->emp_fullname);
            }
            $result = $leave_request;
        }

//        if ($leave_request) {
//            $result = $leave_request;
//        } else {
//            $result = [];
//        }
        return response()->json($result, 200);
    }


    public function cancelEmployeeLeaveRequest(Request $request)
    {
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
        if ($employee_mobile) {

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        $leave = DB::table("emp_leave_request")
            ->where("id", $request->request_id)
            ->first();

        if ($leave) {
            if ($leave->emp_number == $request->emp_number) {

            } else {
                $result = ["result" => "This is not your data.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "Leave data not found.", "status" => 0];
            return response()->json($result, 200);
        }

        DB::table("emp_leave_request")
            ->where("id", $request->request_id)
            ->update([
                "leave_status" => 2
            ]);
        $this->addMobileLog($request->emp_number, "Cancel Leave", "Employee cancel leave.");
        $result = ["result" => "Successfully cancel your leave request.", "status" => 1];
        return response()->json($result, 200);

    }


    public function getAtasanLeaveRequest(Request $request)
    {
//        $employee_mobile = DB::table("MH_USER_MOBILE")
//            ->where("EMP_NUMBER", $request->emp_number)
//            ->where("DEVICE_UUID", $request->device_uuid)
//            ->where("IS_ACTIVE", 1)
//            ->first();
////
////        $request = $request->all();
////
////        $request = array_filter($request);
////        $request = json_decode($request);
////        dd($request->emp_number);
//        if($employee_mobile){
//
//        } else {
//            $result = ["result" => "You're not logged in.", "status" => 0];
//            return response()->json($result, 200);
//        }
//        $leaves = DB::table('emp_leave_request')
//            ->join('emp_reportto', 'emp_leave_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
//            ->join('employee', 'emp_leave_request.emp_number', '=' ,'employee.emp_number')
//            ->join("leave_type","emp_leave_request.leave_type_id","=","leave_type.id")
//            ->join('leave_status', 'leave_status.id','=', 'emp_leave_request.leave_status')
////            ->leftJoin("emp_leave_request", "employee.emp_number","=", "emp_leave_request.person_in_charge")
//            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
//            ->where('emp_reportto.erep_reporting_mode', '1')
//            ->select('emp_leave_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname',
//                'leave_status.name as status_name',"leave_type.name as leave_type_name")
//            ->where('emp_leave_request.leave_status', 3)
//            //->take(10)
//            ->orderBy('emp_leave_request.created_at', 'desc')
//            ->get();

        $leaves = DB::select("
			select a.*, b.erep_sub_emp_number, c.emp_firstname, c.emp_lastname, c.emp_middle_name,
			d.name as leave_type_name, e.name as status_name, f.emp_fullname from emp_leave_request a
			inner join emp_reportto b
			on a.emp_number = b.erep_sub_emp_number
			inner join employee c
			on a.emp_number = c.emp_number
			inner join leave_type d
			on a.leave_type_id = d.id
			inner join leave_status e
			on a.leave_status = e.id
			left join employee f
			on a.person_in_charge = f.emp_number
			where a.leave_status = 3
			and b.erep_sup_emp_number = '" . $request->emp_number . "'
			and b.erep_reporting_mode = 1");

//        if (empty($leaves)) {
//            $result = [];
//        } else {
//            $result = $leaves;
//        }
        
        if (empty($leaves)) {
            $result = [];
        } else {
            $result = array_map(function ($leave) {
                $leave = (array) $leave;
                $leave['pic_name'] = $leave['emp_fullname'];
                unset($leave['emp_fullname']);
                return $leave;
            }, $leaves);
        }
    
        return response()->json($result, 200);

    }


    public function approveEmployeeLeave (Request $request) {
        $now = date("Y-m-d H:i:s");
        $year = date("Y");

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_num)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            // $leave = DB::TABLE("emp_leave_request")
            //     ->where('id', $request->leave_id)
            //     ->first();

            $leave = DB::table("emp_leave_request")
                ->where("id", $request->leave_id)
                ->where("leave_status", 3)
                ->first();

            $leave_type = DB::table("leave_type")
                ->where("id", $leave->leave_type_id)
                ->first();

            $begin = date_create($leave->from_date);
            $end = date_create($leave->end_date);

            if ($leave) {
                $entitle = DB::select("
                    SELECT *
                    FROM leave_entitlement
                    WHERE leave_type_id = '".$leave->leave_type_id."'
                    AND emp_number = '".$leave->emp_number."'
                    AND YEAR(to_date) >= '".$year."'
                ");

                $empparent = DB::table('employee')
                    ->where('emp_number', $request->emp_num)
                    ->first();

                if (empty($empparent->emp_middle_name)) {
                    $member_name = $empparent->emp_firstname.' '.$empparent->emp_lastname;
                } else {
                    $member_name = $empparent->emp_firstname.' '.$empparent->emp_middle_name.' '.$empparent->emp_lastname;
                }

                $employeereq_id = DB::table('employee')
                    ->where('emp_number', $leave->emp_number)
                    ->first();

                $emp = DB::table('employee')
                    ->where('emp_number', $request->emp_num)
                    ->first();

                // $leave->comments .= " - Comments from " . $emp->emp_firstname . " " . $request->comments;
                // $leave->leave_status = $request->leave_status;

                $taken = (float)$leave->length_days;
                // $comments= '';
                $comments = $leave->comments." - Comments from ".$emp->emp_firstname." ".$request->comments;

                if ($request->leave_status == '4') {
                    // $leave->approved_at = $now;
                    // $leave->approved_by = $emp->emp_number;
                    $left = $tmp = 0;
                    foreach ($entitle as $row) { // length_days
                        $left = (float)$row->no_of_days - $row->days_used;
                        if ($taken >= 0) {
                            $taken -= $left;
                            if ($taken >= 0 && $left >= 0) {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $left),
                                    ]);
                                $tmp = $taken;
                            } else if ($taken < 0 && $left >= 0) {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $taken + $left),
                                    ]);
                            } else {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $tmp),
                                    ]);
                            }
                        }
                    }

                    if ((float)$leave->length_days == 0.5) {
                        if ($leave_type->comIjin != 'CB') {
                            $cek_data_absen = DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->count();

                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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
                                    ->where("comDate", $begin->format("Y-m-d"))
                                    ->where("comNIP", $employeereq_id->employee_id)
                                    ->update([
                                        "comIjin" => $leave_type->comIjin." CS",
                                        "comIjin_reason" => $leave->comments,
                                        "updatet_at" => $now,
                                    ]);
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $begin->format("Y-m-d"),
                                    "comDTIn" => $begin->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $begin->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => $leave_type->comIjin." CS",
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        } else {
                            $cek_data_absen = DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->count();

                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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

                                DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->update([
                                    'comIjin' => "CB",
                                    'comIjin_reason' => $leave->comments,
                                    'updatet_at' => $now
                                ]);
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $begin->format("Y-m-d"),
                                    "comDTIn" => $begin->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $begin->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => "CB",
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        }
                    } else {
                        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                            $cek_data_absen = DB::table("com_absensi_inout")
                                ->where("comDate", $i->format("Y-m-d"))
                                ->where("comNIP", $employeereq_id->employee_id)
                                ->count();
    
                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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

                                DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->update([
                                    'comIjin' => $leave_type->comIjin,
                                    'comIjin_reason' => $leave->comments,
                                    'updatet_at' => $now
                                ]);
    
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $i->format("Y-m-d"),
                                    "comDTIn" => $i->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $i->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => $leave_type->comIjin,
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        }
                    }
                    // $this->sendEmailApprove('2', $emp->emp_number, $request->leave_id);
                }

                DB::TABLE("emp_leave_request")
                    ->where('id', $request->leave_id)
                    ->where('leave_status' , 3)
                    ->update([
                        'approved_at' => $now,
                        'approved_by' =>  $emp->emp_number,
                        'leave_status' => 4,
                        'comments' => $comments
                    ]);
                // $leave->save();

                $this->addMobileLog($request->emp_num, "Approve Leave", $request->emp_num . " is approved leave :" . $request->leave_id);

                $request_id = $request->leave_id;
                    $notif = new MobileNotificationController();
                    $notif->approveLeaveNotification(54,  $request->leave_id);

                $result = ["result" => "Successfully approve leave.",
                    "status" => 1,
                    "member_name" => $member_name
                ];

            } else {
                $result = ["result" => "Leave request not found / already given action.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        return response()->json($result, 200);

    // PROSES APPROVE CUTI OLD
// //        $employee_mobile = DB::table("MH_USER_MOBILE")
// //            ->where("EMP_NUMBER", $request->emp_number)
// //            ->where("DEVICE_UUID", $request->device_uuid)
// //            ->where("IS_ACTIVE", 1)
// //            ->first();
// //
// //        if($employee_mobile){
// //
// //        } else {
// //            $result = ["result" => "You're not logged in.", "status" => 0];
// //            return response()->json($result, 200);
// //        }
//         $now = date("Y-m-d H:i:s");
//         $year = date("Y");
// //        $leave = DB::TABLE("emp_leave_request")->where('id', $request->leave_id)->first();
//                     $leave = DB::TABLE("emp_leave_request")
//                         ->where('id', $request->leave_id)
//                         ->where('leave_status' , 3)
//                         ->first();
//                     if($leave){

//                     } else {
//                          $result = ["result" => "Leave request not found / already given action.", "status" => 0];
//                          return response()->json($result, 200);
//                     }

// //            $leave = $this->lvReq->where('id',$request->leave_id)->first();
//         $entitle = DB::select("
//             SELECT * FROM leave_entitlement where leave_type_id = '".$leave->leave_type_id."'
//             AND emp_number = '".$leave->emp_number."' AND YEAR(to_date) >= '".$year."'
//             ");


// //            print_r($entitle);die;
//         $empparent = DB::table('employee')
//             ->where('emp_number', $request->emp_num)
//             ->first();

//         if (empty($empparent->emp_middle_name)) {
//             $member_name = $empparent->emp_firstname . ' ' . $empparent->emp_lastname;
//         } else {
//             $member_name = $empparent->emp_firstname . ' ' . $empparent->emp_middle_name . ' ' . $empparent->emp_lastname;
//         }

//         $employeereq_id = DB::table('employee')
//             ->where('emp_number', $leave->emp_number)
//             ->first();

//         $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
// //        $leave->comments .= " - Comments from " . $emp->emp_firstname . " " . $request->comments;
// //        $leave->leave_status = $request->leave_status;
//         $taken = (float)$leave->length_days;
// //            $comments= '';
//             $comments = $leave->comments." - Comments from " . $emp->emp_firstname . " " . $request->comments;

//         if ($request->leave_status == '4') {
// //            $leave->approved_at = $now;
// //            $leave->approved_by = $emp->emp_number;
//             $left = $tmp = 0;
//             foreach ($entitle as $row) { // length_days
//                 $left = (float)$row->no_of_days - $row->days_used;
//                 if ($taken >= 0) {
//                     $taken -= $left;
//                     if ($taken >= 0 && $left >= 0) {
//                         DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $left)]);
//                         $tmp = $taken;
//                     } else if ($taken < 0 && $left >= 0) {
//                         DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $taken + $left)]);
//                     } else {
//                         DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $tmp)]);
//                     }
//                 }
//             }
//             //     $this->sendEmailApprove('2', $emp->emp_number, $request->leave_id);
//         }

//             DB::TABLE("emp_leave_request")
//                 ->where('id', $request->leave_id)
//                 ->where('leave_status' , 3)
//                 ->update([
//                     'approved_at' => $now,
//                     'approved_by' =>  $emp->emp_number,
//                     'leave_status' => 4,
//                     'comments' => $comments
//                 ]);
// //        $leave->save();

//         $this->addMobileLog($request->emp_number, "Approve Leave", $request->emp_num . "is approved leave :" . $request->leave_id);

//         $request_id = $request->leave_id;
//             $notif = new MobileNotificationController();
//             $notif->approveLeaveNotification(54,  $request->leave_id);

//         $result = ["result" => "Successfully approve leave.",
//             "status" => 1,
//             "member_name" => $member_name
//         ];

//         return response()->json($result, 200);
    }

    public function approveEmployeeLeave1 (Request $request) {
        $now = date("Y-m-d H:i:s");
        $year = date("Y");

        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_num)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            // $leave = DB::TABLE("emp_leave_request")
            //     ->where('id', $request->leave_id)
            //     ->first();

            $leave = DB::table("emp_leave_request")
                ->where("id", $request->leave_id)
                ->where("leave_status", 3)
                ->first();

            $leave_type = DB::table("leave_type")
                ->where("id", $leave->leave_type_id)
                ->first();

            $begin = date_create($leave->from_date);
            $end = date_create($leave->end_date);

            if ($leave) {
                $entitle = DB::select("
                    SELECT *
                    FROM leave_entitlement
                    WHERE leave_type_id = '".$leave->leave_type_id."'
                    AND emp_number = '".$leave->emp_number."'
                    AND YEAR(to_date) >= '".$year."'
                ");

                $empparent = DB::table('employee')
                    ->where('emp_number', $request->emp_num)
                    ->first();

                if (empty($empparent->emp_middle_name)) {
                    $member_name = $empparent->emp_firstname.' '.$empparent->emp_lastname;
                } else {
                    $member_name = $empparent->emp_firstname.' '.$empparent->emp_middle_name.' '.$empparent->emp_lastname;
                }

                $employeereq_id = DB::table('employee')
                    ->where('emp_number', $leave->emp_number)
                    ->first();

                $emp = DB::table('employee')
                    ->where('emp_number', $request->emp_num)
                    ->first();

                // $leave->comments .= " - Comments from " . $emp->emp_firstname . " " . $request->comments;
                // $leave->leave_status = $request->leave_status;

                $taken = (float)$leave->length_days;
                // $comments= '';
                $comments = $leave->comments." - Comments from ".$emp->emp_firstname." ".$request->comments;

                if ($request->leave_status == '4') {
                    // $leave->approved_at = $now;
                    // $leave->approved_by = $emp->emp_number;
                    $left = $tmp = 0;
                    foreach ($entitle as $row) { // length_days
                        $left = (float)$row->no_of_days - $row->days_used;
                        if ($taken >= 0) {
                            $taken -= $left;
                            if ($taken >= 0 && $left >= 0) {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $left),
                                    ]);
                                $tmp = $taken;
                            } else if ($taken < 0 && $left >= 0) {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $taken + $left),
                                    ]);
                            } else {
                                DB::table('leave_entitlement')
                                    ->where('id', $row->id)
                                    ->update([
                                        'days_used' => ($row->days_used + $tmp),
                                    ]);
                            }
                        }
                    }

                    if ((float)$leave->length_days == 0.5) {
                        if ($leave_type->comIjin != 'CB') {
                            $cek_data_absen = DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->count();

                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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
                                    ->where("comDate", $begin->format("Y-m-d"))
                                    ->where("comNIP", $employeereq_id->employee_id)
                                    ->update([
                                        "comIjin" => $leave_type->comIjin." CS",
                                        "comIjin_reason" => $leave->comments,
                                        "updatet_at" => $now,
                                    ]);
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $begin->format("Y-m-d"),
                                    "comDTIn" => $begin->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $begin->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => $leave_type->comIjin." CS",
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        } else {
                            $cek_data_absen = DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->count();

                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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

                                DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->update([
                                    'comIjin' => "CB",
                                    'comIjin_reason' => $leave->comments,
                                    'updatet_at' => $now
                                ]);
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $begin->format("Y-m-d"),
                                    "comDTIn" => $begin->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $begin->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => "CB",
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        }
                    } else {
                        for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                            $cek_data_absen = DB::table("com_absensi_inout")
                                ->where("comDate", $i->format("Y-m-d"))
                                ->where("comNIP", $employeereq_id->employee_id)
                                ->count();
    
                            if ($cek_data_absen > 0) {
                                $att_inout = DB::select("
                                    SELECT id, comNIP, CONVERT(VARCHAR, comIn, 8) AS comIn, CONVERT(VARCHAR, comOut, 8) AS comOut, CONVERT(VARCHAR, comDate, 23) AS comDate, comDTIn, comDTOut, CONVERT(VARCHAR, comTotalHours, 8) AS comTotalHours, comIjin, comIjin_reason, is_claim_ot, source, created_at, updatet_at
                                    FROM com_absensi_inout
                                    WHERE comNIP = '".$employeereq_id->employee_id."'
                                    AND comDate = '".$begin->format("Y-m-d")."'
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

                                DB::table('com_absensi_inout')
                                ->where('comDate', $begin->format("Y-m-d"))
                                ->where('comNIP', $employeereq_id->employee_id)
                                ->update([
                                    'comIjin' => $leave_type->comIjin,
                                    'comIjin_reason' => $leave->comments,
                                    'updatet_at' => $now
                                ]);
    
                            } else {
                                DB::table("com_absensi_inout")
                                ->insert([
                                    "comNIP" => $employeereq_id->employee_id,
                                    "comIn" => "08:00:00",
                                    "comOut" => "17:00:00",
                                    "comDate" => $i->format("Y-m-d"),
                                    "comDTIn" => $i->format("Y-m-d")." 08:00:00",
                                    "comDTOut" => $i->format("Y-m-d")." 17:00:00",
                                    "comTotalHours" => "08:00:00",
                                    "comIjin" => $leave_type->comIjin,
                                    "comIjin_reason" => $leave->comments,
                                    "source" => "leave",
                                    "created_at" => $now,
                                    "updatet_at" => $now,
                                ]);
                            }
                        }
                    }
                    // $this->sendEmailApprove('2', $emp->emp_number, $request->leave_id);
                }

                DB::TABLE("emp_leave_request")
                    ->where('id', $request->leave_id)
                    ->where('leave_status' , 3)
                    ->update([
                        'approved_at' => $now,
                        'approved_by' =>  $emp->emp_number,
                        'leave_status' => 4,
                        'comments' => $comments
                    ]);
                // $leave->save();

                $this->addMobileLog($request->emp_number, "Approve Leave", $request->emp_num . "is approved leave :" . $request->leave_id);

                $request_id = $request->leave_id;
                    $notif = new MobileNotificationController();
                    $notif->approveLeaveNotification(54,  $request->leave_id);

                $result = ["result" => "Successfully approve leave.",
                    "status" => 1,
                    "member_name" => $member_name
                ];

            } else {
                $result = ["result" => "Leave request not found / already given action.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        return response()->json($result, 200);
    }


    public function rejectEmployeeLeave(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
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

        $leave_data = DB::table("emp_leave_request")
            ->where('id', $request->leave_id)
            ->where('leave_status', 3)
            ->first();
        $comments = '';
        if ($leave_data) {
            $leave = $this->lvReq->where('id', $request->leave_id)->first();
            $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
            $comments .= " - Comments from " . $emp->emp_firstname . " " . $request->comments;
            DB::table("emp_leave_request")
                ->where('id', $request->leave_id)
                ->where('leave_status', 3)
                ->update([
                    "leave_status" => 1,
                    "comments" => $comments,
                    "approved_at" => $now,
                    "approved_by" => $emp->emp_number
                ]);

            $request_id = $request->leave_id;
            $this->addMobileLog($request->emp_number, "Approve Leave", $request->emp_num . "is rejected leave :" . $request->leave_id);

            $notif = new MobileNotificationController();
            $notif->rejectLeaveNotification($request->emp_num, $request_id);
            $result = ["result" => "Successfully reject leave.",
                "status" => 1];
        } else {
            $result = ["result" => "Leave data not found.",
                "status" => 0];
        }


        return response()->json($result, 200);
    }
}
