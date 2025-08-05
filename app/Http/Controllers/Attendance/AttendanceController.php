<?php

namespace App\Http\Controllers\Attendance;

use Illuminate\Http\Request;
use DB, Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Attendance\AttRecord, App\Models\Master\Employee, App\Models\Attendance\RequestAttendance;

class AttendanceController extends Controller{
    protected $emp;
    protected $att;
    protected $attR;

    public function __construct(Employee $emp, AttRecord $att, RequestAttendance $attR){
        $this->emp = $emp;
        $this->att = $att;
        $this->attR = $attR;

        parent::__construct();
    }

    public function index(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//        $attend = DB::connection('adms')->select("
//                select c.id,c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
//                from checkinout c INNER JOIN userinfo ui
//                ON c.userid = ui.userid
//                WHERE ui.title= '".$emp->employee_id."'
//                AND CAST(c.checktime as DATE) between DATE_ADD(NOW(), INTERVAL -31 DAY) AND NOW()
//                GROUP BY c.userid, CAST(c.checktime as DATE)
//                ORDER BY CAST(c.checktime as DATE) DESC
//            ");
        
        $attend = DB::select("Select a.id,FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
                                    convert(char(8),convert(time(0),a.comIn)) as comIn,
                                    convert(char(8),convert(time(0),a.comOut)) as comOut,
                                    cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) - 1 as workTime,
                                    FORMAT(DATEADD(HOUR,-1,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHours,
                                    FORMAT(DATEADD(HOUR,0,cast((cast(a.comDate as varchar)+' '+cast(a.comTotalHours as varchar)) as datetime)),'hh:mm:ss') as comTotalHoursOver,
                                    a.comIjin,b.job_title_code,a.is_claim_ot
                                from com_absensi_inout as a INNER JOIN employee as b ON a.comNIP = b.employee_id 
                                where a.comNIP = '".$emp->employee_id."'
                                and a.comDate between DATEADD(day, -30, getdate()) and GETDATE()
                                ORDER BY a.comDate DESC");
        
        $comijin = DB::select("select *
                        from com_master_perijinan
                        where module = 'IMP'");

//        $arr = array();
//        $now = strtotime(date('Y-m-d'));
//        //dd($now);
//        $last = strtotime(date('Y-m-d', strtotime('-30 days')));
//        for ( $i = $now; $i >= $last; $i = $i - 86400 ) {
//            $thisDate = date( 'Y-m-d', $i );
//            $attend = DB::connection('adms')->select("
//                select c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
//                from checkinout c INNER JOIN userinfo ui
//                ON c.userid = ui.userid
//                WHERE ui.title= '".$emp->employee_id."'
//                AND CAST(c.checktime as DATE) = '".$thisDate."'
//                GROUP BY c.userid, CAST(c.checktime as DATE)
//            ");
//            if($attend){
//                array_push($arr, $attend[0]);
//            }
//        }
        
        \DB::table('log_activity')->insert([
            'action' => 'View Attandence',
            'module' => 'Attandance',
            'sub_module' => 'View Attandence',
            'modified_by' => Session::get('name'),
            'description' => 'View Attendance ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, com_absensi_inout, com_master_perijinan'
        ]);
        
        return view('pages.attendance.index', compact('emp','attend','comijin'));
    }
    public function indexOld(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        //$attends = $this->att->where('employee_id',Session::get('username'))->orderBy('punch_in_utc_time', 'DESC')->take(100)->get();
        $attend = DB::connection('adms')->select("
            select c.id,c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
            from checkinout c INNER JOIN userinfo ui
            ON c.userid = ui.userid
            WHERE ui.title= '".$emp->employee_id."'
            GROUP BY c.userid, CAST(c.checktime as DATE)
            ORDER BY CAST(c.checktime as DATE) DESC
            LIMIT 30
            ");
        
        \DB::table('log_activity')->insert([
            'action' => 'View Attandence',
            'module' => 'Attandance',
            'sub_module' => 'View Attandence',
            'modified_by' => Session::get('name'),
            'description' => 'View Attendance ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, com_absensi_inout, com_master_perijinan'
        ]);
        return view('pages.attendance.indexold1', compact('emp', 'attend'));
    }
    public function approveAttendance(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $attends = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->join('attendance_status_req', 'emp_attendance_request.request_status', '=' ,'attendance_status_req.id')
            ->join('com_master_perijinan', 'emp_attendance_request.comIjin', '=' ,'com_master_perijinan.comIjin')
            ->where('emp_attendance_request.request_status', '1')
            ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->select('attendance_status_req.name','emp_attendance_request.*','emp_reportto.erep_sub_emp_number',
                     'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname',
                     'com_master_perijinan.keterangan')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Approve Attandance',
            'module' => 'Attandance',
            'sub_module' => 'View Approve Attandence',
            'modified_by' => Session::get('name'),
            'description' => 'View Approve Attendance ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_attendance_request, emp_reportto, attendance_status_req, com_master_perijinan'
        ]);
        return view('pages.attendance.approve', compact('emp', 'attends'));
    }
    public function getAttApv(Request $request){
        $now = date("Y-m-d H:i:s");
        $attreq = $this->attR->where('id', $request->id)->first();
//        $emp = $this->emp->where('emp_number', $attreq->emp_number)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Attandance Apv',
            'module' => 'Attandance',
            'sub_module' => 'Get Attandance Apv',
            'modified_by' => Session::get('name'),
            'description' => 'Get Attandance Apv, id ' . $attreq->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_attendance_request'
        ]);
        return response()->json($attreq);
    }
    public function setAttAppv(Request $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $AttR = $this->attR->where('id', $request->leave_id)->first();
        $empAttend = $this->emp->where('emp_number', $AttR->emp_number)->first();
        
        $attr_date = date_create($AttR->start_date);
        
        //dd($attr_date->format("Y-m-d"));
//        dd($AttR);
//        $this->att->where('id', $AttR->attendance_id)->update([
//            'punch_in_utc_time' => $AttR->start_date,
//            'punch_in_user_time' => $AttR->start_date,
//            'punch_out_utc_time' => $AttR->end_date,
//            'punch_out_user_time' => $AttR->end_date
//        ]);
        
        
        
        if($request->approval == 1)
        {
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
        }
        else if($request->approval == 2)
        {
            //dd($AttR->comIjin);
            
            \DB::table('log_activity')->insert([
                'action' => 'Approve Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'Approve Att Request : '.$AttR->attendance_id.' , tanggal: '.$attr_date->format("Y-m-d").', ijin: '.$request->comijin.' Request attendance By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
            
            $AttR->update([
                'request_status' => $request->approval,
                'approve_sup' => $emp->emp_number,
                'approve_sup_date' => $now
            ]);
            
            if ($AttR->attendance_id > 0)
            {
                DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where id = ".$AttR->attendance_id);
                
                DB::table('com_absensi_inout')
                    ->where('id','=',$AttR->attendance_id)
                    ->update([
                        'comIjin'=>$AttR->comIjin,
                        'comIjin_reason'=>$AttR->reason,
                        'source'=>'attendance',
                        'updatet_at'=>$now
                    ]);
            }
            else
            {
                $cekDataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$attr_date->format("Y-m-d"))
                            ->where('comNIP','=',$empAttend->employee_id)
                            ->count();
                
                if($cekDataAbsen > 0)
                {
                    $dataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$attr_date->format("Y-m-d"))
                            ->where('comNIP','=',$empAttend->employee_id)
                            ->first();
                    
                    DB::statement("INSERT INTO com_absensi_inout_hist    
                                    select * 
                                    from com_absensi_inout 
                                    where comNIP = '".$empAttend->employee_id."' "
                                    . " AND comDate = '".$attr_date->format("Y-m-d")."'");

                    DB::table('com_absensi_inout')
                            ->where('id','=',$dataAbsen->id)
                            ->update([
                                'comIjin'=>$AttR->comIjin,
                                'comIjin_reason'=>$AttR->reason,
                                'source'=>'attendance',
                                'updatet_at'=>$now
                            ]);
                    
                    $AttR->update([
                        'attendance_id' => $dataAbsen->id
                    ]);
                }
                else
                {
                    DB::table('com_absensi_inout')
                        ->insert([
                            'comNIP'=>$empAttend->employee_id,
                            'comIn'=>'08:00:00',
                            'comOut'=>'17:00:00',
                            'comDate'=>$attr_date->format("Y-m-d"),
                            'comDTIn'=>$attr_date->format("Y-m-d").' 08:00:00',
                            'comDTOut'=>$attr_date->format("Y-m-d").' 17:00:00',
                            'comTotalHours'=>'08:00:00',
                            'comIjin'=>$AttR->comIjin,
                            'comIjin_reason'=>$AttR->reason,
                            'source'=>'attendance',
                            'created_at'=>$now,
                            'updatet_at'=>$now,
                        ]);
                    
                    $dataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$attr_date->format("Y-m-d"))
                            ->where('comNIP','=',$empAttend->employee_id)
                            ->first();
                    
                    $AttR->update([
                        'attendance_id' => $dataAbsen->id
                    ]);
                }
            }
        }
        else if($request->approval == 3)
        {
            \DB::table('log_activity')->insert([
                'action' => 'Reject Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'Reject Att Request : '.$AttR->attendance_id.' , tanggal: '.$attr_date->format("Y-m-d").', ijin: '.$request->comijin.' Request attendance By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
            
            $AttR->update([
                'request_status' => $request->approval,
                'approve_sup' => $emp->emp_number,
                'approve_sup_date' => $now
            ]);
        }
        else
        {
            \DB::table('log_activity')->insert([
                'action' => 'Add Attendance Appr',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'tidak melakukan apapun',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
        }
        
        return redirect(route('appAtt'));
    }
    public function getAttLeave(Request $request){
        $now = date("Y-m-d H:i:s");
        print_r('<pre>');
        print_r($request->all());
        print_r('</pre>'); die;
//        $attends = $this->att->where('employee_id', $request->emp_id)->where('id', $request->id)->first();
        $tgl = date('Y-m-d', strtotime($request->id));
        $attend = DB::connection('adms')->select("
            select c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
            from checkinout c INNER JOIN userinfo ui
            ON c.userid = ui.userid 
            WHERE ui.title= '".$request->emp_id."'
            AND CAST(c.checktime as DATE) = '".$tgl."'
            GROUP BY c.userid, CAST(c.checktime as DATE)
        ");
        //dd($attend);
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Attandence Leave',
            'module' => 'Attandance',
            'sub_module' => 'Get Attandence Leave',
            'modified_by' => Session::get('name'),
            'description' => 'Get Attandence Leave ' . $attend->userid,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, com_absensi_inout, com_master_perijinan'
        ]);
        return response()->json([
            'punch_in_utc_time' => $attend[0]->waktuIn,
            'punch_out_utc_time' => $attend[0]->waktuOut
        ]);
    }
    public function setAttLeave(Requests\Attendance\AttendanceLeave $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        $reportto = DB::table('emp_reportto')
                ->where('erep_reporting_mode',1)
                ->where('erep_sub_emp_number',$emp->emp_number)
                ->first();
        if(empty($reportto)){
            return back()->withErrors(['error' => 'Report To belum lengkap! Silahkan hubungi HRD terkait untuk melengkapi data']);
        }
        $empSup = DB::table('employee')
                ->where('emp_number',$reportto->erep_sup_emp_number)
                ->first();
        
        if($request->comijin == ''){
            return back()->withErrors(['error' => 'Attendance Type cannot be empty!']);
        }
        
        if(empty($empSup->emp_work_email) || $empSup->emp_work_email == "" || $empSup->emp_work_email == NULL){
            return redirect(route('attendance'))->withErrors([
                            'error' => 'Data Employee Sup ('.$empSup->emp_firstname.' '.$empSup->emp_middle_name.' '.$empSup->emp_lastname.') Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
                ]);
        }

        try {
            \DB::beginTransaction();
            
            $dataAttenRecord = DB::select("Select a.id,FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
                                        convert(char(8),convert(time(0),a.comIn)) as comIn,
                                        convert(char(8),convert(time(0),a.comOut)) as comOut,
                                        cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as comTotalHours
                             from com_absensi_inout as a
                             where comNIP = '".$emp->employee_id."'
                             AND a.id = ".$request->leave_id."
                             ORDER BY a.comDate DESC");
            
            if($dataAttenRecord){
                $dataAtten = $dataAttenRecord[0];
                $cekDataAttReq = DB::table('emp_attendance_request')
                    ->where('attendance_id','=',$dataAtten->id)
                    ->where('request_status','=',1)
                    ->count();
            }else{
                return redirect(route('attendance'))->withErrors([
                        'error' => 'Data Attendance Record tidak dapat ditemukan.'
                    ]);
            }

            //dd($cekDataAttReq);

            if ($cekDataAttReq > 0)
            {
                return redirect(route('attendance'))->withErrors([
                        'error' => 'pengajuan ditemukan, anda tidak bisa mengajukan lagi.'
                    ]);
            }
            else
            {
                $attReqId = $this->attR->create([
                    'attendance_id' => $dataAtten->id,
                    'emp_number' => $emp->emp_number,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'comIjin' => $request->comijin,
                    'reason' => $request->reason,
                    'request_status' => 1,
                    'pnum' => Session::get('pnum'),
                    'ptype' => Session::get('ptype')
                ])->id;
                
                $this->sendEmailAddAttendance($emp->employee_id,$attReqId);

                \DB::table('log_activity')->insert([
                    'action' => 'Add Attendance Request',
                    'module' => 'Attendance',
                    'sub_module' => 'Request Leave',
                    'modified_by' => Session::get('name'),
                    'description' => 'ID Attendance : '.$dataAtten->id.', tanggal: '.$request->start_date.', ijin: '.$request->comijin.' Request attendance By : ' . trim(Session::get('name')),
                    'created_at' => $now,
                    'updated_at' => $now,
                    'table_activity' => 'emp_attendance_request'
                ]);
            }

            \DB::commit();
        } catch (QueryException $ex) {
            \DB::rollback();
            return redirect('/appAtt')->withErrors(['error' => 'Failed save data, errmsg : ' . $ex]);
        }

        return redirect(route('attendance'));
    }
    
    public function setAttLeaveWithoutAttend(Requests\Attendance\AttendanceLeave $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        $reportto = DB::table('emp_reportto')
                ->where('erep_reporting_mode',1)
                ->where('erep_sub_emp_number',$emp->emp_number)
                ->first();
        if(empty($reportto)){
            return back()->withErrors(['error' => 'Report To belum lengkap! Silahkan hubungi HRD terkait untuk melengkapi data']);
        }
        $empSup = DB::table('employee')
                ->where('emp_number',$reportto->erep_sup_emp_number)
                ->first();
        
        if($request->comijin == ''){
            return back()->withErrors(['error' => 'Attendance Type cannot be empty!']);
        }
        
        if(empty($empSup->emp_work_email) || $empSup->emp_work_email == "" || $empSup->emp_work_email == NULL){
            return redirect(route('attendance'))->withErrors([
                            'error' => 'Data Employee Sup ('.$empSup->emp_firstname.' '.$empSup->emp_middle_name.' '.$empSup->emp_lastname.') Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
                ]);
        }

        try {
            \DB::beginTransaction();

            $attReqId = $this->attR->create([
                'attendance_id' => 0,
                'emp_number' => $emp->emp_number,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'comIjin' => $request->comijin,
                'reason' => $request->reason,
                'request_status' => 1,
                'pnum' => Session::get('pnum'),
                'ptype' => Session::get('ptype')
            ])->id;
            
            $this->sendEmailAddAttendance($emp->employee_id,$attReqId);

            \DB::table('log_activity')->insert([
                'action' => 'Add Attendance Request',
                'module' => 'Attendance',
                'sub_module' => 'Request Leave',
                'modified_by' => Session::get('name'),
                'description' => 'ID Attendance : 0 , tanggal: '.$request->start_date.', ijin: '.$request->comijin.' Request attendance By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_attendance_request'
            ]);
            
            \DB::commit();
        } catch (QueryException $ex) {
            \DB::rollback();
            return redirect('/appAtt')->withErrors(['error' => 'Failed save data, errmsg : ' . $ex]);
        }

        return redirect(route('attendance'));
    }
    
    public function attSub(){
        $now = date("Y-m-d H:i:s");
        $yearstart = date('Y-m-d H:i:s', strtotime('Jan 01 23:59:59'));
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $attends = DB::table('emp_reportto')
            ->join('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
            ->join('attendance_record', 'employee.employee_id', '=' ,'attendance_record.employee_id')
            ->where('attendance_record.punch_in_user_time', '>=', $yearstart)
            ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->orderBy('emp_reportto.erep_sub_emp_number', 'ASC')
            ->orderBy('attendance_record.punch_in_user_time', 'ASC')
            ->select('attendance_record.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'Attendence Sub',
            'module' => 'Attandance',
            'sub_module' => 'Attendence Sub',
            'modified_by' => Session::get('name'),
            'description' => 'Attendence Sub ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto, attendance_record'
        ]);
        return view('pages.attendance.indexSub', compact('emp', 'attends'));
    }
    
    public function attendanceRequest() {
//        $attR = $this->attReq
//                ->leftJoin('employee', 'emp_attendance_request.emp_number', '=', 'employee.emp_number')
//                ->where('request_status',1)
//                ->select('emp_attendance_request.*', 'employee.employee_id', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')
//                ->get();
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        
        $attR = DB::select("select emp_attendance_request.*,
	FORMAT(emp_attendance_request.start_date, 'dd-MM-yyyy HH:mm:ss') as start_date1,
	FORMAT(emp_attendance_request.end_date, 'dd-MM-yyyy HH:mm:ss') as end_date1,
	attendance_status_req.name as status_name,
        com_master_perijinan.keterangan
from emp_attendance_request
LEFT JOIN attendance_status_req on emp_attendance_request.request_status =  attendance_status_req.id
LEFT JOIN com_master_perijinan ON emp_attendance_request.comIjin = com_master_perijinan.comIjin
where emp_number = ".$emp->emp_number);
        
                
        return view('pages.attendance.attReq',compact('attR'));
    }
}
