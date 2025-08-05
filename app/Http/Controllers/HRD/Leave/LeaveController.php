<?php

namespace App\Http\Controllers\HRD\Leave;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session,
    App\Models\Master\Employee,
    App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeaveType,
    App\Models\Leave\LeaveRequest,
    App\Models\Leave\LeaveStatus;

class LeaveController extends Controller {

    protected $emp;
    protected $entitle;
    protected $lvReq;
    protected $lvType;
    protected $lvStat;

    public function __construct(Employee $emp, LeaveEntitlement $entitle, LeaveRequest $lvReq, LeaveType $lvType, LeaveStatus $lvStat) {
        $this->emp = $emp;
        $this->entitle = $entitle;
        $this->lvReq = $lvReq;
        $this->lvType = $lvType;
        $this->lvStat = $lvStat;
        parent::__construct();
    }

    public function leaveEmp() {
        $now = date("Y-m-d H:i:s");
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }
        $dataLeave = 0;
        $type = DB::select("Select *
                        from leave_type
                        where comIjin IN (Select comIjin from com_master_perijinan where module = 'CUTI')
                        and is_active = 1
                        ORDER BY name");
//$yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
//        if(Session::get('pnum') == '1803' && Session::get('ptype') == '01'){
//            $leave = DB::select("
//                SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
//                lt.name, l.from_date, l.to_date, l.id
//                FROM employee e INNER JOIN leave_entitlement l
//                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
//                ON l.leave_type_id = lt.id
//                WHERE e.termination_id = 0
//                AND (l.no_of_days - l.days_used) > 0
//                AND l.deleted = '0'
//                ORDER BY e.employee_id
//            ");
//
////            $leave = DB::select("            
////                SELECT e.emp_number,e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
////                lt.name, l.from_date, l.to_date, l.id
////                FROM employee e INNER JOIN leave_entitlement l
////                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
////                ON l.leave_type_id = lt.id
////                WHERE l.to_date >= '".$yearEnd."' AND e.termination_id = 0
////                AND l.deleted = '0' AND (l.no_of_days - l.days_used) > 0
////                ORDER BY e.employee_id
////            ");
//        }else{
//            $leave = DB::select("
//                SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
//                lt.name, l.from_date, l.to_date, l.id
//                FROM employee e INNER JOIN leave_entitlement l
//                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
//                ON l.leave_type_id = lt.id
//                WHERE e.termination_id = 0
//                AND (l.no_of_days - l.days_used) > 0 AND l.deleted = '0' 
//                AND e.pnum = '".Session::get('pnum')."' AND e.ptype = '".Session::get('ptype')."'
//                ORDER BY e.employee_id
//            ");
//            
////            $leave = DB::select("            
////                SELECT e.emp_number,e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
////                    lt.name, l.from_date, l.to_date, l.id
////                FROM employee e INNER JOIN leave_entitlement l
////                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
////                ON l.leave_type_id = lt.id
////                WHERE l.to_date = '".$yearEnd."' AND e.termination_id  = 0
////                AND l.deleted = '0' AND (l.no_of_days - l.days_used) > 0
////                AND e.pnum = '".Session::get('pnum')."' AND e.ptype = '".Session::get('ptype')."'
////                ORDER BY e.employee_id
////            ");
//        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Leave Employee',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Leave Employee ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.leave.index', compact('dataLeave', 'type'));
    }

    public function searchLeaveEmp(Request $request) {
        $now = date("Y-m-d H:i:s");
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }
        $yearEnd = date('Y-m-d H:i:s'); //, strtotime('Dec 31'));
        $dataLeave = 1;
        $where = '';
        $search_name = 0;
        if ($request->empName != ''){
            $search_name = 1;
        }
        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'empName') {
//                    $where .= "(e.emp_fullname LIKE '%" . $val . "%') AND ";
                } else if ($key == 'employee_id') {
                    $where .= "e." . $key . " LIKE '%" . $val . "%' AND ";
                } else if ($key == 'leave_type_id') {
                    if ($val >= 1) {
                        $where .= "l." . $key . " = '" . $val . "' AND ";
                    }
                } else if ($key == 'eeo_cat_code') {
                    $where .= "e." . $key . " = '" . $val . "' AND ";
                } else {
                    //$where .= "";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        
        

        if (Session::get('pnum') == '1804' && Session::get('ptype') == '01') {
            
        } else {
            if($where == ''){
                $where .= "e.pnum = '" . Session::get('pnum') . "' AND e.ptype = '" . Session::get('ptype') . "'";                  
            }else{
                $where .= "AND e.pnum = '" . Session::get('pnum') . "' AND e.ptype = '" . Session::get('ptype') . "'";  
            }
        }

//         dd("SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
//         lt.name, l.from_date, l.to_date, l.id
//         FROM employee e INNER JOIN leave_entitlement l
//         ON e.emp_number = l.emp_number INNER JOIN leave_type lt
//         ON l.leave_type_id = lt.id
//         WHERE ".$where."
//           AND l.to_date >= '".$yearEnd."' AND e.termination_id = 0 
//         AND l.deleted = '0'
//         ORDER BY e.employee_id");

        if ($where == '' && $search_name == 0) {
            return redirect(route('hrd.leave'))->withErrors(['error' => 'Harap Isi Parameter Search Terlebih Dahulu!']);
        }

//        dd("SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname, (l.no_of_days - l.days_used) as balance,
//            lt.name, FORMAT(l.from_date,'dd-MM-yyyy') as from_date, FORMAT(l.to_date,'dd-MM-yyyy') as to_date, l.id
//            FROM employee e INNER JOIN leave_entitlement l
//            ON e.emp_number = l.emp_number INNER JOIN leave_type lt
//            ON l.leave_type_id = lt.id
//            WHERE " . $where . "
//            AND l.to_date >= '" . $yearEnd . "' AND e.termination_id = 0
//            AND l.deleted = '0'
//            ORDER BY e.employee_id");
        
        if($where == ''){
            $leave = DB::select("
                SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname,l.no_of_days,l.days_used, (l.no_of_days - l.days_used) as balance,
                lt.name, FORMAT(l.from_date,'dd-MM-yyyy') as from_date, FORMAT(l.to_date,'dd-MM-yyyy') as to_date, l.id,l.leave_type_id
                FROM employee e INNER JOIN leave_entitlement l
                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
                ON l.leave_type_id = lt.id
                WHERE l.to_date >= '" . $yearEnd . "' AND e.termination_id = 0
                AND l.deleted = '0'
                ORDER BY e.employee_id
            ");
            
        }else{
           $leave = DB::select("
                SELECT e.emp_number, e.employee_id,e.emp_firstname,e.emp_middle_name,e.emp_lastname,l.no_of_days,l.days_used, (l.no_of_days - l.days_used) as balance,
                lt.name, FORMAT(l.from_date,'dd-MM-yyyy') as from_date, FORMAT(l.to_date,'dd-MM-yyyy') as to_date, l.id,l.leave_type_id
                FROM employee e INNER JOIN leave_entitlement l
                ON e.emp_number = l.emp_number INNER JOIN leave_type lt
                ON l.leave_type_id = lt.id
                WHERE " . $where . "
                AND l.to_date >= '" . $yearEnd . "' AND e.termination_id = 0
                AND l.deleted = '0'
                ORDER BY e.employee_id
            "); 
        }
        
        $leave = collect($leave);
        
        if($request->empName != ''){
           $leave = $leave->filter(function($leave) use($request) {
               $emp_name = '';
               if($leave->emp_firstname != ''){
                   $emp_name .= $leave->emp_firstname;
               }
               if($leave->emp_middle_name != ''){
                   $emp_name .= ' '.$leave->emp_middle_name;
               }
               if($leave->emp_lastname != ''){
                   $emp_name .= ' '.$leave->emp_lastname;
               }
                if(str_contains(strtolower($emp_name),strtolower($request->empName))) {
                    return $leave;
                }
            })->values()->toArray();
        }
        
        //dd($leave);

        $type = DB::select("Select *
                        from leave_type
                        where comIjin IN (Select comIjin from com_master_perijinan where module = 'CUTI')
                        and is_active = 1
                        ORDER BY name");

        \DB::table('log_activity')->insert([
            'action' => 'HRD Search Leave Employee',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Search Leave Employee ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, leave_entitlement'
        ]);

        return view('pages.manage.leave.index', compact('leave', 'dataLeave', 'type'));
    }

    public function apvLeave() {
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $leaves = DB::table('emp_leave_request')
                        ->join('emp_reportto', 'emp_leave_request.emp_number', '=', 'emp_reportto.erep_sub_emp_number')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_leave_request.leave_status', '3')
                        ->where('emp_reportto.erep_reporting_mode', '1')
                        ->select('emp_leave_request.*', 'emp_reportto.erep_sub_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')->get();
        return view('pages.manage.leave.apvLeave', compact('emp', 'leaves'));
    }

    public function setAppLeave(Request $request) {
        $now = date("Y-m-d H:i:s");
        $year = date("Y");
        try {
            \DB::beginTransaction();

            $leave = $this->lvReq->where('id', $request->leave_id)->first();
            $entitle = DB::select("
                SELECT * FROM leave_entitlement where leave_type_id = '" . $leave->leave_type_id . "'
                AND emp_number = '" . $leave->emp_number . "' AND YEAR(to_date) = '" . $year . "'
                ");
            $emp = $this->emp->where('employee_id', Session::get('username'))->first();
            $leave->leave_status = $request->leave_status;
            $taken = (float) $leave->length_days;
            if ($request->leave_status == '4') {
                $leave->approved_at = $now;
                $leave->approved_by = '1';
                $leave->pnum = Session::get('pnum');
                $leave->ptype = Session::get('ptype');
                $left = $tmp = 0;
                foreach ($entitle as $row) { // length_days
                    $left = (float) $row->no_of_days - $row->days_used;
                    if ($taken >= 0) {
                        $taken -= $left;
                        if ($taken >= 0 && $left >= 0) {
                            DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $left)]);
                            $tmp = $taken;
                        } else if ($taken < 0 && $left >= 0) {
                            DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + ($taken + $left))]);
                        } else {
                            DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $tmp)]);
                        }
                    }
                }
            }
            $leave->save();

            if ($request->leave_status == "4") {
                $statusLog = "Approve";
            } else {
                $statusLog = "Reject";
            }

            \DB::table('log_activity')->insert([
                'action' => 'Set ' . $statusLog . ' Leave',
                'module' => 'Leave',
                'sub_module' => $statusLog . ' Leave',
                'modified_by' => Session::get('name'),
                'description' => 'ID Leave : ' . $request->leave_id . ', ' . $statusLog . ' Leave By : ' . trim(Session::get('name')) . ' (HRD)',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            \DB::commit();
        } catch (QueryException $ex) {
            \DB::rollback();
            return redirect(route('hrd.leaveEmp'))->withErrors([
                        'error' => 'Failed approve / reject leave, errmsg : ' . $ex
            ]);
        }

        return back();
    }

    public function leaveHis() {
        $now = date("Y-m-d H:i:s");
        if (Session::get('pnum') == '1804' && Session::get('ptype') == '01') {
            $leaves = DB::table('emp_leave_request')
                            ->join('emp_reportto', 'emp_leave_request.emp_number', '=', 'emp_reportto.erep_sub_emp_number')
                            ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                            ->join('leave_type', 'emp_leave_request.leave_type_id', '=', 'leave_type.id')
                            ->where('emp_leave_request.leave_status', '3')
                            ->where('emp_reportto.erep_reporting_mode', '1')
                            ->where('created_at','>=','2024-10-16 00:00:00')
                            ->where('employee.termination_id', '=', 0)
                            ->select('emp_leave_request.*', 'emp_reportto.erep_sub_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'leave_type.name AS leave_type_name')->get();
        } else {
            $leaves = DB::table('emp_leave_request')
                            ->join('emp_reportto', 'emp_leave_request.emp_number', '=', 'emp_reportto.erep_sub_emp_number')
                            ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                            ->join('leave_type', 'emp_leave_request.leave_type_id', '=', 'leave_type.id')
                            ->where('emp_leave_request.leave_status', '3')
                            ->where('emp_reportto.erep_reporting_mode', '1')
                            ->where('created_at','>=','2024-10-16 00:00:00')
                            ->where('employee.pnum', Session::get('pnum'))->where('employee.ptype', Session::get('ptype'))
                            ->where('employee.termination_id', '=', 0)
                            ->select('emp_leave_request.*', 'emp_reportto.erep_sub_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'leave_type.name AS leave_type_name')->get();
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Leave History',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Leave History,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, leave_entitlement'
        ]);

        return view('pages.manage.leave.hisLeave', compact('leaves'));
    }

    public function getLeaveEmp(Request $request) {
        $now = date("Y-m-d H:i:s");
        $leave = $this->entitle->join('employee', 'leave_entitlement.emp_number', '=', 'employee.emp_number')
                        ->leftjoin('leave_type', 'leave_entitlement.leave_type_id', '=', 'leave_type.id')
                        ->where('leave_entitlement.emp_number', $request->emp_number)
                        ->where('leave_entitlement.id', $request->leave_id)
                        ->where('leave_type.is_active', '1')
                        ->select('leave_type.name', 'leave_entitlement.*', 'employee.employee_id', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Leave Employee',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Leave Employee,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, leave_entitlement'
        ]);

        return response()->json($leave);
    }

    public function setLeaveEmp(Request $request) {
        $now = date('Y-m-d');
        $nowLog = date("Y-m-d H:i:s");
        
        $dateFromYear = date('Y', strtotime($request->from_date)); 
        //dd($dateFromYear);
        //dd($nowYear);
        
        $dataEmp = $this->emp->where('emp_number','=',$request->emp_id)->first();
        //dd($dataEmp);
        
        $sumCBEmp =  DB::table('leave_entitlement')
                ->where('leave_type_id','=',4)
                ->where('emp_number','=', $request->emp_id)
                ->where('deleted','=', 0)
                ->whereBetween('from_date',[$request->from_date,$request->to_date])
                ->SUM('no_of_days');
        
//        dd("Select SUM(no_of_days) as no_of_days
//            from leave_entitlement
//            where emp_number = ".$request->emp_id."
//            and leave_type_id = 4
//            and deleted = 0
//            and from_date between '".$request->from_date."' and '".$request->to_date."'");
        
//               
        
        $sumCTEmp = DB::table('leave_entitlement')
                ->where('leave_type_id','=',1)
                ->where('emp_number','=', $request->emp_id)
                ->where('deleted','=', 0)
                ->whereBetween('from_date',[$dateFromYear.'-01-01',$dateFromYear.'-12-31'])
                ->SUM('no_of_days');
        
        $sumCutiBersama = DB::table('holiday')
                ->whereBetween('date',[$dateFromYear.'-01-01',$dateFromYear.'-12-31'])
                ->where('holiday_id','=',1)
                ->count();
        
        $CTCurrentYear = 12 - $sumCutiBersama;
        
        // dd($dateFromYear);
        
        if (Session::get('email') == 'manager.hrd@metland.com') {
            if ($request->leave_type_id == 1 && ($sumCTEmp + $request->no_of_days) > 12 )
            {
                //dd('test 3');
                return redirect(route('hrd.leave'))->withErrors([
                        'error' => 'Cuti Tahunan '.$dateFromYear.' Sudah Lebih Dari 12 Hari, Input Data Ditolak'
                    ]);
            }
        }
        else {
            if ($request->leave_type_id == 4 && ($sumCBEmp + $request->no_of_days) > 25)
            {
                //dd('test 1');
                return redirect(route('hrd.leave'))->withErrors([
                        'error' => 'Cuti Besar Sudah Lebih Dari 25 Hari, Input Data Ditolak'
                    ]);
            }
            elseif ($dataEmp->days_type == 1 && $request->leave_type_id == 1 && ($sumCTEmp + $request->no_of_days) > $CTCurrentYear )
            {
                //dd('test 2');
                return redirect(route('hrd.leave'))->withErrors([
                        'error' => 'Cuti Tahunan '.$dateFromYear.' Sudah Lebih Dari'.$CTCurrentYear.' Hari, Input Data Ditolak'
                    ]);
            }
            elseif ($dataEmp->days_type == 0 && $request->leave_type_id == 1 && ($sumCTEmp + $request->no_of_days) > 12 )
            {
                //dd('test 3');
                return redirect(route('hrd.leave'))->withErrors([
                        'error' => 'Cuti Tahunan '.$dateFromYear.' Sudah Lebih Dari 12 Hari, Input Data Ditolak'
                    ]);
            }
        }
        
        try {
            if (empty($request->no_of_days)) {
                return redirect(route('hrd.leave'))->withErrors([
                            'error' => 'Number Of Leave tidak boleh kosong'
                ]);
            } elseif ($request->leave_type_id > 0) {
                try {
                    \DB::beginTransaction();

                    $this->entitle->updateOrCreate(
                            ['id' => $request->leave_id],
                            [
                                'emp_number' => $request->emp_id,
                                'no_of_days' => $request->no_of_days,
                                'leave_type_id' => $request->leave_type_id,
                                'from_date' => $request->from_date,
                                'to_date' => $request->to_date,
                                'credited_date' => $now,
                                'created_by_id' => Session::get('userid'),
                                'created_by_name' => Session::get('username')
                    ]);

                    \DB::commit();
                } catch (QueryException $ex) {
                    \DB::rollback();
                    return redirect(route('hrd.leave'))->withErrors([
                                'error' => 'Failed add data, errmsg : ' . $ex
                    ]);
                }

                \DB::table('log_activity')->insert([
                    'action' => 'HRD Set Leave Employee',
                    'module' => 'Leave',
                    'sub_module' => 'Leave Employee',
                    'modified_by' => Session::get('name'),
                    'description' => 'HRD Set Leave Employee, employee number ' . $request->emp_id,
                    'created_at' => $nowLog,
                    'updated_at' => $nowLog,
                    'table_activity' => 'employee, leave_entitlement'
                ]);

                return redirect(route('hrd.leave'));
            } else {
                return redirect(route('hrd.leave'))->withErrors([
                            'error' => 'Leave Type tidak boleh kosong'
                ]);
            }
        } catch (\ErrorException $e) {
            print_r($e);
            die;
        }
    }

    public function dedLeaveEmp(Request $request) {
        $now = date('Y-m-d H:i:s');
        $entitlement = $this->entitle->where('id', $request->leave_idDed)->first();
        $this->lvReq->insert([
            // 'leave_type_id' => $request->leave_idDed,
            'leave_type_id' => '26',
            'date_applied' => $now,
            'emp_number' => $entitlement->emp_number,
            'comments' => $request->reason,
            'length_days' => $request->days_ded,
            'leave_status' => '5',
            'created_at' => $now,
            'created_by' => Session::get('userid'),
            'approved_at' => $now,
            'approved_by' => Session::get('userid'),
        ]);
        $entitlement->days_used = $entitlement->days_used + $request->days_ded;
//        print_r($entitlement); die;
        $entitlement->save();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Ded Leave Employee',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Ded Leave Employee, leave entitle id ' . $request->leave_idDed . ', employee number ' . $entitlement->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'leave_entitlement'
        ]);

        return redirect(route('hrd.leave'));
    }

    public function delLeaveEmp($id) {
        $now = date("Y-m-d H:i:s");
        $this->entitle->where('id', $id)->update(['deleted' => '1']);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Leave Employee',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Leave Employee, leave entitle id ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'leave_entitlement'
        ]);

        return redirect(route('hrd.leave'));
    }

    public function getLeave() {
        $now = date("Y-m-d H:i:s");
        $leaveTypes = $this->lvType->where('is_active', '1')->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Leave',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Leave ,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'leave_type'
        ]);

        return view('pages.manage.leave.leaveType', compact('leaveTypes'));
    }

    public function setLeaveType(Request $request) {
        $now = date("Y-m-d H:i:s");
        $lev = $this->lvType->where('id', $request->id)->first();
        if (empty($lev)) {
            $this->lvType->insert([
                'name' => $request->name,
                'comIjin' => $request->comIjin
            ]);
        } else {
            $this->lvType->where('id', $request->id)->update([
                'name' => $request->name,
                'comIjin' => $request->comIjin
            ]);
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Leave Type',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Leave Type, leave type id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'leave_type'
        ]);

        return redirect(route('hrd.getLeave'));
    }

    public function delLeaveType($id) {
        $now = date("Y-m-d H:i:s");
        $this->lvType->where('id', $id)->update(['is_active' => '0']);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Leave Type',
            'module' => 'Leave',
            'sub_module' => 'Leave Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Leave Type, leave type id ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'leave_type'
        ]);

        return redirect(route('hrd.getLeave'));
    }

    public function leaveHistory() {
        $now = date("Y-m-d H:i:s");
        //dd(Session::get('username'));
        $leaves = [];

        \DB::table('log_activity')->insert([
            'action' => 'View Leave History',
            'module' => 'Leave',
            'sub_module' => 'View Apply Leave',
            'modified_by' => Session::get('name'),
            'description' => 'View Leave History by ' . Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.manage.leave.leaveHistory', compact('leaves'));
    }

    public function searchLeaveHistory(Request $request) {
        $now = date("Y-m-d H:i:s");
        //dd(Session::get('username'));
//        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id', '=', 0)->first();
//        $leaves = $this->lvReq->where('emp_number', $emp->emp_number)->orderBy('created_at', 'DESC')->get();

        $where = '';
        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'start_date') {
                    $where .= "a.date_applied >= '" . $val . "' AND ";
                } else if ($key == 'end_date') {
                    $where .= "a.date_applied <= '" . $val . "' AND ";
                } else if ($key == 'comNIP') {
                    $where .= "emp.employee_id LIKE '%" . $val . "%' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        if (empty($where)) {
            return redirect(route('hrd.leaveHistory'))->withErrors([
                        'error' => 'Harap Isi Parameter Search Terlebih Dahulu!'
            ]);
        } else {
            $leaves = DB::select("select 
	emp.employee_id,
	emp.emp_firstname,
	emp.emp_middle_name,
	emp.emp_lastname,
	b.name as entitlement_name,
        FORMAT (a.date_applied, 'yyyy-MM-dd') as date_applied,
        FORMAT (a.from_date, 'yyyy-MM-dd') as from_date,
	FORMAT (a.end_date, 'yyyy-MM-dd') as end_date,
	a.length_days,
	c.name as status_name,
	pic.emp_firstname as pic_firstname,
	pic.emp_middle_name as pic_middle_name,
	pic.emp_lastname as pic_lastname,
	a.comments,
	a.date_applied
from emp_leave_request as a
left join leave_type as b on a.leave_type_id = b.id
left join leave_status as c on a.leave_status = c.id
join employee as pic on a.person_in_charge = pic.emp_number
join employee as emp on a.emp_number = emp.emp_number
where " . $where. " AND a.leave_status NOT IN (1,2) ORDER BY FORMAT (a.date_applied, 'yyyy-MM-dd')");
        }

        \DB::table('log_activity')->insert([
            'action' => 'Search Leave History',
            'module' => 'Leave',
            'sub_module' => 'View Apply Leave',
            'modified_by' => Session::get('name'),
            'description' => 'Search Leave History by ' . Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.manage.leave.leaveHistory', compact('leaves'));
    }
}
