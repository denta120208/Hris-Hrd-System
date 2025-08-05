<?php

namespace App\Http\Controllers\HRD\Attendance;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session,
    App\Models\Master\Employee,
    App\Models\Attendance\AttRecord;
use App\Models\Attendance\RequestAttendance,
    App\Models\Attendance\StatusReqAttendance;

class AttController extends Controller {

    protected $emp;
    protected $att;
    protected $attReq;
    protected $attStatus;

    public function __construct(Employee $emp, AttRecord $att, RequestAttendance $attReq, StatusReqAttendance $attStatus) {
        $this->emp = $emp;
        $this->att = $att;
        $this->attReq = $attReq;
        $this->attStatus = $attStatus;
        parent::__construct();
    }

    public function inout_index() {
        $now = date('Y-m-d');
        $nowLog = date("Y-m-d H:i:s");
        //dd(Session::get('project'));
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        
        $attR = DB::connection('sqlsrv')
                ->select("Select a.id,b.employee_id,
                            b.emp_firstname, b.emp_middle_name, b.emp_lastname,
                            FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
                            convert(char(8),convert(time(0),a.comIn)) as comIn,
                            convert(char(8),convert(time(0),a.comOut)) as comOut,
                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as workTimeOver,
                            FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
                            a.comIjin,b.job_title_code,a.is_claim_ot,b.emp_number,d.attendance_id
                    from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
                    INNER JOIN location as c ON b.location_id = c.id
                    LEFT JOIN emp_ot_reqeuest as d ON a.id = d.attendance_id
                    where c.pnum = '".Session::get('pnum')."' AND  c.ptype = '".Session::get('ptype')."'
                    and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
                    ORDER BY a.comDate DESC");
        
//        $attR = DB::connection('sqlsrv')
//                ->select("Select a.id,b.employee_id,
//                            (b.emp_firstname+' '+b.emp_middle_name+' '+b.emp_lastname) as emp_fullname,
//                            FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
//                            convert(char(8),convert(time(0),a.comIn)) as comIn,
//                            convert(char(8),convert(time(0),a.comOut)) as comOut,
//                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
//                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as workTimeOver,
//                            FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
//                            a.comIjin,b.job_title_code,a.is_claim_ot,b.emp_number,d.attendance_id
//                    from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
//                    INNER JOIN location as c ON b.location_id = c.id
//                    LEFT JOIN emp_ot_reqeuest as d ON a.id = d.attendance_id
//                    where c.pnum = '".Session::get('pnum')."' AND  c.ptype = '".Session::get('ptype')."'
//                    and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
//                    ORDER BY a.comDate DESC");
        
//        dd("Select a.id,FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
//                                convert(char(8),convert(time(0),a.comIn)) as comIn,
//                                convert(char(8),convert(time(0),a.comOut)) as comOut,
//                                cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
//                                FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
//                                a.comIjin,b.job_title_code,a.is_claim_ot
//                            from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
//                            INNER JOIN location as c ON b.location_id = c.id
//                            where c.pnum = '".Session::get('pnum')."' AND  c.ptype = '".Session::get('ptype')."'
//                            and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
//                            ORDER BY a.comDate DESC");
//        
//        $attR = DB::select("
//            SELECT att.*, e.emp_firstname, e.emp_middle_name, e.emp_lastname
//            FROM attendance_record att INNER JOIN employee e
//            ON att.employee_id = e.employee_id
//            WHERE CAST(att.punch_in_utc_time AS date) = '" . $now . "' AND 
//            e.pnum = " . Session::get('pnum') . " AND e.ptype = " . Session::get('ptype') . "
//            ORDER BY att.punch_in_utc_time DESC
//        ");
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Inout Index',
            'module' => 'Attendance',
            'sub_module' => 'In/out',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Inout Index, ',
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee, attendance_record'
        ]);

//        $comijin = DB::select("select *
//                        from com_master_perijinan
//                        where comIjin NOT IN ('CB','CS','CL','CT','CH','CK')");

        $comijin = DB::table('com_master_perijinan')
                ->where('module','=','IMP')
                ->get();
        
        //dd($comijin);

        return view('pages.manage.attendance.index', compact('attR', 'comijin', 'emp'));
    }

    public function search_emp(Request $request) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
//        $where = '';
//        foreach($request->except('_token') as $key => $val){
//            if($request->$key){
//                if($key == 'date_filter'){
//                    $where .= "CAST(att.punch_in_utc_time AS date) = '".$val."' AND ";
//                }else if($key == 'emp_name'){
//                    $where .= "e.emp_firstname LIKE '%".$val."%' OR e.emp_middle_name LIKE '%".$val."%' OR e.emp_lastname LIKE '%".$val."%' OR ";
//                }else if($key == 'employee_id'){
//                    $where .= 'e.'.$key." LIKE '%".$val."%' AND ";
//                }else if($key == 'termination_id'){
//                    if($val == 1){
//                        $where .= 'e.'.$key." IS NULL AND ";
//                    }else{
//                        $where .= $key." IS NOT NULL AND ";
//                    }
//                }else{
//                    $where .= 'e.'.$key." = '".$val."' AND ";
//                }
//            }
//        }
//        $where = rtrim($where, ' AND ');
//        $where = rtrim($where, ' OR ');
        $where = '';
        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'start_date') {
                    $where .= "a.comDate >= '" . $val . "' AND ";
                } else if ($key == 'end_date') {
                    $where .= "a.comDate <= '" . $val . "' AND ";
                } else if ($key == 'comDisplayName') {
//                    $where .= "b.emp_firstname LIKE '%" . $val . "%' OR b.emp_middle_name LIKE '%" . $val . "%' OR b.emp_lastname LIKE '%" . $val . "%' OR ";
//                    $where .= "cm.comDisplayName LIKE '%" . $val . "%' AND ";
                } else if ($key == 'comNIP') {
                    $where .= "a.comNIP LIKE '%" . $val . "%' AND ";
                } else if ($key == 'comProjectID') {
                    $where .= "b.emp_number LIKE '%" . $val . "%' AND ";
//                    $where .= "cm.comDeptID LIKE '%" . $val . "%' AND ";
                }
            }
        }
        if(empty($request->start_date) || empty($request->end_date)){
            return redirect(route('hrd.inout'))->withErrors([
                        'error' => 'Harap Isi Parameter Start Date dan End Date Terlebih Dahulu!'
            ]);
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        if (empty($where)) {
            return redirect(route('hrd.inout'))->withErrors([
                        'error' => 'Harap Isi Parameter Search Terlebih Dahulu!'
            ]);
        } else {
//            $attR = DB::select("
//                SELECT att.*, e.emp_firstname, e.emp_middle_name, e.emp_lastname
//                FROM attendance_record att INNER JOIN employee e
//                ON att.employee_id = e.employee_id
//                WHERE ".$where." AND e.pnum = ".Session::get('pnum')." AND e.ptype = ".Session::get('ptype')."
//                ORDER BY att.punch_in_utc_time DESC
//            ");
//            $attR = DB::select("Select a.id,b.employee_id,
//                            (b.emp_firstname+' '+b.emp_middle_name+' '+b.emp_lastname) as emp_fullname,
//                            FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
//                            convert(char(8),convert(time(0),a.comIn)) as comIn,
//                            convert(char(8),convert(time(0),a.comOut)) as comOut,
//                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
//                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as workTimeOver,
//                            FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
//                            a.comIjin,b.job_title_code,a.is_claim_ot,b.emp_number,d.attendance_id
//                    from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
//                    INNER JOIN location as c ON b.location_id = c.id
//                    LEFT JOIN emp_ot_reqeuest as d ON a.id = d.attendance_id
//                    where " . $where . "
//                    and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
//                    ORDER BY a.comDate DESC");
            $attR = DB::select("Select a.id,b.employee_id,
                            b.emp_firstname, b.emp_middle_name, b.emp_lastname,
                            FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
                            convert(char(8),convert(time(0),a.comIn)) as comIn,
                            convert(char(8),convert(time(0),a.comOut)) as comOut,
                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
                            cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as workTimeOver,
                            FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
                            a.comIjin,b.job_title_code,a.is_claim_ot,b.emp_number,d.attendance_id
                    from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
                    INNER JOIN location as c ON b.location_id = c.id
                    LEFT JOIN emp_ot_reqeuest as d ON a.id = d.attendance_id
                    where " . $where . "
                    and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
                    ORDER BY a.comDate DESC");
            
            $attR = collect($attR);

            if($request->comDisplayName != ''){
               $attR = $attR->filter(function($attR) use($request) {
                   $emp_name = '';
                   if($attR->emp_firstname != ''){
                       $emp_name .= $attR->emp_firstname;
                   }
                   if($attR->emp_middle_name != ''){
                       $emp_name .= ' '.$attR->emp_middle_name;
                   }
                   if($attR->emp_lastname != ''){
                       $emp_name .= ' '.$attR->emp_lastname;
                   }
                    if(str_contains(strtolower($emp_name),strtolower($request->comDisplayName))) {
                        return $attR;
                    }
                })->values()->toArray();
            }
        }
        
        $otReq = DB::select("select *
                        from emp_ot_reqeuest");

        $comijin = DB::select("select *
                        from com_master_perijinan");

        \DB::table('log_activity')->insert([
            'action' => 'HRD Search Employee',
            'module' => 'Attendance',
            'sub_module' => 'In/out',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Search Employee, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, attendance_record'
        ]);

        return view('pages.manage.attendance.index', compact('attR', 'comijin', 'emp'));
    }

    public function attReq() {
        $now = date("Y-m-d H:i:s");
        $attR = $this->attReq->join('employee', 'emp_attendance_request.emp_number', '=', 'employee.emp_number')
                ->where('employee.pnum', Session::get('pnum'))
                ->where('employee.ptype', Session::get('ptype'))   
                ->where('emp_attendance_request.request_status',1)
                ->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Attendance Request',
            'module' => 'Attendance',
            'sub_module' => 'In/out',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Attendance Request, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, attendance_record'
        ]);

        return view('pages.manage.attendance.requestList', compact('attR'));
    }

    public function appAtt($id) {
        $now = date("Y-m-d H:i:s");
        $req = $this->attReq->where('id', $id)->first();
        $rec = $this->att->where('id', $req->attendance_id)->first();
        $inDate = date('Y-m-d', strtotime($rec->punch_in_utc_time));
        $outDate = date('Y-m-d', strtotime($rec->punch_out_utc_time));
        $req->request_status = '3';
        $req->save();

        $rec->punch_in_note = $rec->punch_in_utc_time;
        $rec->punch_out_note = $rec->punch_out_utc_time;
        $rec->punch_in_utc_time = $inDate . ' 08:00:00';
        $rec->punch_out_utc_time = $outDate . ' 17:00:00';
        $rec->state = $id;
//        print_r($rec->punch_out_note); die;
        $rec->save();

        \DB::table('log_activity')->insert([
            'action' => 'HRD App Attendance',
            'module' => 'Attendance',
            'sub_module' => 'In/out',
            'modified_by' => Session::get('name'),
            'description' => 'HRD App Attendance, attendance request id ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'attendance_record,  attendance'
        ]);

        return redirect(route('hrd.attReq'));
    }

    public function setAttAppLeave(Requests\HRD\Attendance\setAttAppLeave $request) {
        
        if($request->comijin == ''){
            return redirect(route('hrd.inout'))->withErrors(['error' => 'Attendance Type cannot be empty!']);
        }
        
        $now = date("Y-m-d H:i:s");
        $requestAttendanceExist = $this->attReq->where('emp_number', $request->emp_number)->where('start_date', $request->start_date)->where('request_status', '1')->first();
//        dd($AttR);
//        $this->att->where('id', $AttR->attendance_id)->update([
//            'punch_in_utc_time' => $AttR->start_date,
//            'punch_in_user_time' => $AttR->start_date,
//            'punch_out_utc_time' => $AttR->end_date,
//            'punch_out_user_time' => $AttR->end_date
//        ]);

        if ($requestAttendanceExist) {
            \DB::table('log_activity')->insert([
                'action' => 'No Action Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'tidak memlih status',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
            return redirect(route('hrd.inout'))->withErrors([
                        'error' => 'Terdapat request attendance yang sedang berjalan'
            ]);
        } else {
            $this->attReq->create([
                'attendance_id' => $request->attendance_id,
                'emp_number' => $request->employee_number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'comIjin' => $request->comijin,
                'reason' => $request->reason,
                'request_status' => 2,
                'pnum' => Session::get('pnum'),
                'ptype' => Session::get('ptype'),
                'approve_hr' => Session::get('name'),
                'approve_hr_date' => $now
            ]);

            DB::table('com_absensi_inout')
                    ->where('id', '=', $request->attendance_id)
                    ->update([
                        'comIjin' => $request->comijin,
                        'source' => 'attendance-hrd',
                        'updatet_at' => $now
            ]);

            \DB::table('log_activity')->insert([
                'action' => 'HRD Attendance App Leave',
                'module' => 'Attendance',
                'sub_module' => 'In/out',
                'modified_by' => Session::get('name'),
                'description' => 'HRD Attendance App Leave, attendance attandence id ' . $request->attendance_id,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'attendance_record,  attendance'
            ]);
        }

        return redirect(route('hrd.inout'));
    }

    public function setAttLeave(Requests\HRD\Attendance\setAttLeave $request) {
        
        if($request->comijin == ''){
            return redirect(route('hrd.inout'))->withErrors(['error' => 'Attendance Type cannot be empty!']);
        }

        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        $date = date("Y-m-d", strtotime($request->date));
        $requestAttendanceExist = $this->attReq->where('emp_number', $request->emp_number)->where('start_date', $date)->where('request_status', '1')->first();

        if ($requestAttendanceExist) {
            \DB::table('log_activity')->insert([
                'action' => 'No Action Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'Terdapat request attendance yang sedang berjalan',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
            return redirect(route('hrd.inout'))->withErrors([
                        'error' => 'Terdapat request attendance yang sedang berjalan'
            ]);
        } else {
            //dd($AttR->comIjin);
//            $AttR->update([
//                'request_status' => $request->approval,
//                'approve_sup' => $emp->emp_number,
//                'approve_sup_date' => $now
//            ]);
            $dataAbsen = DB::table('com_absensi_inout')
                    ->where('comDate', '=', $date)
                    ->where('comNIP', '=', $emp->employee_id)
                    ->first();

            if ($dataAbsen) {
                $idAbsen = $dataAbsen->id;
                DB::statement("INSERT INTO com_absensi_inout_hist    
                                    select * 
                                    from com_absensi_inout 
                                    where comNIP = '" . $emp->employee_id . "' "
                        . " AND comDate = '" . $date . "'");

                DB::table('com_absensi_inout')
                        ->where('comDate', '=', $date)
                        ->where('comNIP', '=', $emp->employee_id)
                        ->update([
                            'comIjin' => $request->comijin,
                            'comIjin_reason'=>$request->reason,
                            'source' => 'attendance-hrd',
                            'updatet_at' => $now
                ]);

                $this->attReq->create([
                    'attendance_id' => $idAbsen,
                    'emp_number' => $request->emp_number,
                    'start_date' => $date,
                    'end_date' => $date,
                    'comIjin' => $request->comijin,
                    'reason' => $request->reason,
                    'request_status' => 2,
                    'pnum' => Session::get('pnum'),
                    'ptype' => Session::get('ptype'),
                    'approve_hr' => Session::get('name'),
                    'approve_hr_date' => $now
                ]);
            } else {
                DB::table('com_absensi_inout')
                        ->insert([
                            'comNIP' => $emp->employee_id,
                            'comIn' => '08:00:00',
                            'comOut' => '17:00:00',
                            'comDate' => $date,
                            'comDTIn' => $date . ' 08:00:00',
                            'comDTOut' => $date . ' 17:00:00',
                            'comTotalHours' => '08:00:00',
                            'comIjin' => $request->comijin,
                            'comIjin_reason'=>$request->reason,
                            'source' => 'attendance-hrd',
                            'created_at' => $now,
                            'updatet_at' => $now,
                ]);

                $dataAbsen = DB::table('com_absensi_inout')
                        ->where('comDate', '=', $date)
                        ->where('comNIP', '=', $emp->employee_id)
                        ->first();

                $this->attReq->create([
                    'attendance_id' => $dataAbsen->id,
                    'emp_number' => $request->emp_number,
                    'start_date' => $date,
                    'end_date' => $date,
                    'comIjin' => $request->comijin,
                    'reason' => $request->reason,
                    'request_status' => 2,
                    'pnum' => Session::get('pnum'),
                    'ptype' => Session::get('ptype'),
                    'approve_hr' => Session::get('name'),
                    'approve_hr_date' => $now
                ]);
            }

            \DB::table('log_activity')->insert([
                'action' => 'Approve Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'Approve Att Request : ' . $dataAbsen->id . ' , tanggal: ' . $date . ', ijin: ' . $request->comijin . ' Request attendance By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
        }

        return redirect(route('hrd.inout'));
    }
    
    public function attReqList() {
//        $attR = $this->attReq
//                ->leftJoin('employee', 'emp_attendance_request.emp_number', '=', 'employee.emp_number')
//                ->where('request_status',1)
//                ->select('emp_attendance_request.*', 'employee.employee_id', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')
//                ->get();
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        
        if (Session::get('project') == 'HO') {
            $attR = DB::select("select emp_attendance_request.*,
	FORMAT(emp_attendance_request.start_date, 'dd-MM-yyyy HH:mm:ss') as start_date1,
	FORMAT(emp_attendance_request.end_date, 'dd-MM-yyyy HH:mm:ss') as end_date1,
	employee.employee_id, 
	employee.emp_firstname, 
	employee.emp_middle_name, 
	employee.emp_lastname,
	attendance_status_req.name as status_name,
        com_master_perijinan.keterangan
from emp_attendance_request
LEFT JOIN employee ON emp_attendance_request.emp_number = employee.emp_number
LEFT JOIN attendance_status_req on emp_attendance_request.request_status =  attendance_status_req.id
LEFT JOIN com_master_perijinan ON emp_attendance_request.comIjin = com_master_perijinan.comIjin
where employee.emp_status in (1,2,5) and emp_attendance_request.request_status = 1");
        } else {
            $attR = DB::select("select emp_attendance_request.*,
	FORMAT(emp_attendance_request.start_date, 'dd-MM-yyyy HH:mm:ss') as start_date1,
	FORMAT(emp_attendance_request.end_date, 'dd-MM-yyyy HH:mm:ss') as end_date1,
	employee.employee_id, 
	employee.emp_firstname, 
	employee.emp_middle_name, 
	employee.emp_lastname,
	attendance_status_req.name as status_name,
        com_master_perijinan.keterangan
from emp_attendance_request
LEFT JOIN employee ON emp_attendance_request.emp_number = employee.emp_number
LEFT JOIN attendance_status_req on emp_attendance_request.request_status =  attendance_status_req.id
LEFT JOIN com_master_perijinan ON emp_attendance_request.comIjin = com_master_perijinan.comIjin
where employee.emp_status in (1,2,5) and emp_attendance_request.request_status = 1 and employee.location_id = ".$project->id);
        }
        
                
        return view('pages.manage.attendance.attendanceRequestList',compact('attR'));
    }
}
