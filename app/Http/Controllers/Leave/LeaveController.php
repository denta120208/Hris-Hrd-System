<?php

namespace App\Http\Controllers\Leave;

use App\Models\Leave\Holiday;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session,
    App\Models\Master\Employee;
use App\Models\Leave\LeaveType,
    App\Models\Leave\LeaveEntitlement,
    App\Models\Leave\LeaveRequest,
    App\Models\Leave\LeaveStatus;
use App\Http\Controllers\MetHrisMobile\MobileNotificationController;

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

    public function index(Employee $emp) {
        
    }

    public function myLeave() {
        $yearEnd = date('Y-m-d H:i:s'); //, strtotime('Dec 31 23:59:59'));
//        print_r($yearEnd);die;
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        
        if ($emp->job_title_code > 16)
        {
            $balLeave = $this->entitle->where('emp_number', $emp->emp_number)->where('deleted', '0')->get();
        }
        else
        {
            $balLeave = $this->entitle->where('emp_number', $emp->emp_number)->where('deleted', '0')->where('to_date', '>=', $yearEnd)->get();
        }

        //$balLeave = $this->entitle->where('emp_number', $emp->emp_number)->where('to_date', '>=', $yearEnd)->get();
        return view('pages.leave.index', compact('emp', 'balLeave'));
    }

    public function getBal(Request $request) {
        $yearEnd = date('Y-m-d H:i:s'); //, strtotime('Dec 31 23:59:59'));
        $emp = $this->emp->where('employee_id', Session::get('username'))
                        ->where('termination_id','=',0)->first();
        
        if (($emp->job_title_code == 16 || $emp->job_title_code == 17 || $emp->job_title_code == 18) && $request->id == 4)
        {
            $no_of_days = $this->entitle->where('emp_number', $emp->emp_number)
//                ->where('to_date', '>=', $yearEnd)
                ->where('leave_type_id', $request->id)
                ->where('deleted', '=', 0)
                ->sum('no_of_days');

            $days_used = $this->entitle->where('emp_number', $emp->emp_number)
//                    ->where('to_date', '>=', $yearEnd)
                    ->where('leave_type_id', $request->id)
                    ->where('deleted', '=', 0)
                    ->sum('days_used');
        }
        else
        {
            $no_of_days = $this->entitle->where('emp_number', $emp->emp_number)
                ->where('to_date', '>=', $yearEnd)
                ->where('leave_type_id', $request->id)
                ->where('deleted', '=', 0)
                ->sum('no_of_days');

            $days_used = $this->entitle->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $yearEnd)
                    ->where('leave_type_id', $request->id)
                    ->where('deleted', '=', 0)
                    ->sum('days_used');
        }
        

        return response()->json([
                    'no_of_days' => $no_of_days,
                    'days_used' => $days_used,
                    'balance' => $no_of_days - $days_used
        ]);
    }

    public function applLeave() {
        $now = date("Y-m-d H:i:s");
        //dd(Session::get('username'));
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        $leaves = $this->lvReq->where('emp_number', $emp->emp_number)->orderBy('created_at', 'DESC')->get();

        $type = DB::select("Select *
                        from leave_type
                        where comIjin IN (Select comIjin from com_master_perijinan where module = 'CUTI')
                        and is_active = 1
                        ORDER BY name");

        \DB::table('log_activity')->insert([
            'action' => 'View Apply Leave',
            'module' => 'Leave',
            'sub_module' => 'View Apply Leave',
            'modified_by' => Session::get('name'),
            'description' => 'View Apply Leave ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.leave.form', compact('emp', 'leaves', 'type'));
    }

    public function saveLeave(Request $request) {
        $now = date("Y-m-d H:i:s");
        $sDate = date("Y-m-d", strtotime($request->start_date));
        $eDate = date('Y-m-d', strtotime($request->end_date));
        $emp = $this->emp->where('employee_id', Session::get('username'))
                ->where('termination_id','=',0)
                ->where(function ($query) {
                    $query->where('emp_status', 1)
                    ->orWhere('emp_status', 2);
                })
                ->first();

        $employee = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();

        if ($emp == null) {
            return redirect(route('applLeave'))->withErrors([
                        'error' => 'Status anda bukan karyawan tetap atau kontrak. Atau telah diterminate. Silahkan hubungi HRD terkait informasi status'
            ]);
        }

        // if(empty($request->emp_incharge)) {
        //     return redirect()->back()->withErrors("error", "Person InCharge cannot be empty!");
        // }

        if ($employee->job_title_code >= 16 && $request->leave_type_id == 4)
        {
            $leave_bal = $this->entitle->where('leave_type_id', $request->type)
                            ->where('emp_number', $emp->emp_number)
                            ->first();

            $leave_bal_no_of_days = $this->entitle->where('leave_type_id', $request->type)
                    ->where('emp_number', $emp->emp_number)
                    ->sum('no_of_days');

            $leave_bal_days_used = $this->entitle->where('leave_type_id', $request->type)
                    ->where('emp_number', $emp->emp_number)
                    ->sum('days_used');
        }
        else
        {
            $leave_bal = $this->entitle->where('leave_type_id', $request->type)
                            ->where('emp_number', $emp->emp_number)
                            ->where('to_date', '>=', $now)->first();

            $leave_bal_no_of_days = $this->entitle->where('leave_type_id', $request->type)
                    ->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $now)
                    ->sum('no_of_days');

            $leave_bal_days_used = $this->entitle->where('leave_type_id', $request->type)
                    ->where('emp_number', $emp->emp_number)
                    ->where('to_date', '>=', $now)
                    ->sum('days_used');
        }
        

        $emp_report_to = \DB::table('emp_reportto')->where('erep_sub_emp_number', $emp->emp_number)->where('emp_reportto.erep_reporting_mode', '1')->count();
        
        if(empty($emp_report_to)){
            return back()->withErrors(['error' => 'Report To belum lengkap! Silahkan hubungi HRD terkait untuk melengkapi data']);
        }
        
        $reportTo = DB::table("emp_reportto")
                ->where("erep_sub_emp_number", $emp->emp_number)
                ->where("erep_reporting_mode", 1)
                ->get();

        // Jika tidak ada work emailnya
        foreach ($reportTo as $key => $value) {
            $emp_sup = $this->emp->where('emp_number', $value->erep_sup_emp_number)->first();

            if (empty($emp_sup->emp_work_email) || $emp_sup->emp_work_email == "" || $emp_sup->emp_work_email == NULL) {
                return redirect(route('applLeave'))->withErrors([
                            'error' => 'Data Employee Sup ('.$emp_sup->emp_firstname.' '.$emp_sup->emp_middle_name.' '.$emp_sup->emp_lastname.') Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
                ]);
            }
        }
        // Jika tidak ada work emailnya
        if (empty($emp->emp_work_email) || $emp->emp_work_email == "" || $emp->emp_work_email == NULL) {
            return redirect(route('applLeave'))->withErrors([
                        'error' => 'Data Employee Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
            ]);
        }

        // Jika tidak ada data Report To nya
        if ($emp_report_to <= 0) {
            return redirect(route('applLeave'))->withErrors([
                        'error' => 'Data Employee Report To Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
            ]);
        }
        try {
            if (strtotime($request->start_date) <= strtotime($request->end_date)) {
                $days = (float) $this->calculateDays($sDate, $eDate, $emp->days_type);
            } else {
                return redirect(route('applLeave'))->withErrors([
                            'error' => 'Tanggal yang di masukan tidak benar.'
                ]);
            }

            $this->validate($request,
                    [
                        'type' => 'required',
                        'emp_incharge' => 'required'
                    ],
                    [
                        'type.required' => 'Please Choose Leave Type!',
                        'emp_incharge.required' => 'Person InCharge cannot be empty!'
                    ]
            );

            if ($request->ts1) {
                $days -= (float) 0.5;
            }

            if ($days == 0) {
                return redirect(route('applLeave'))->withErrors([
                            'error' => 'Jumlah cuti tidak boleh 0. Silahkan dicek kembali tanggal periode cuti.'
                ]);
            }

            if ($leave_bal) {
                if (($leave_bal_no_of_days - $leave_bal_days_used) >= $days) {
                    \DB::beginTransaction();
                    $id = $this->lvReq->create([
                        'leave_type_id' => $request->type,
                        'date_applied' => $now,
                        'emp_number' => $emp->emp_number,
                        'leave_status' => '3',
                        'person_in_charge' => $request->emp_incharge,
                        'comments' => $request->comments,
                        'length_days' => $days,
                        'from_date' => $sDate,
                        'end_date' => $eDate,
                        'created_at' => $now,
                        'created_by' => $emp->emp_number,
                        'pnum' => Session::get('pnum'),
                        'ptype' => Session::get('ptype')
                    ]);
                    
                    $this->sendEmailRequest('1', $emp->emp_number, $id->id, $request->emp_incharge);
                    $notif = new MobileNotificationController();
                    $notif->requestLeaveNotification($id->id);

                    \DB::table('log_activity')->insert([
                        'action' => 'Add Request Leave',
                        'module' => 'Leave',
                        'sub_module' => 'Request Leave',
                        'modified_by' => Session::get('name'),
                        'description' => 'ID Leave : ' . $id->id . ', Request Leave By : ' . trim(Session::get('name')),
                        'created_at' => $now,
                        'updated_at' => $now,
                        'table_activity' => 'emp_leave_request'
                    ]);
                    \DB::commit();
                }
            } else {
                return redirect(route('applLeave'))->withErrors([
                            'error' => 'Tidak ada jatah Cuti, Silahkan kontak HRD.'
                ]);
            }
        } catch (\Exception $ex) {
            \DB::rollback();
            return redirect(route('applLeave'))->withErrors(['error' => 'Failed request leave, errmsg : ' . $ex]);
        }

        return back();
    }

    public function apvLeave() {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $leaves = DB::table('emp_leave_request')
                        ->join('emp_reportto', 'emp_leave_request.emp_number', '=', 'emp_reportto.erep_sub_emp_number')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
                        ->where('emp_reportto.erep_reporting_mode', '1')
                        ->select('emp_leave_request.*', 'emp_reportto.erep_sub_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')
                        ->orderBy('emp_leave_request.created_at', 'desc')
                        ->get();
        //dd($leaves);

        \DB::table('log_activity')->insert([
            'action' => 'View Apv Leave',
            'module' => 'Leave',
            'sub_module' => 'View Apv Leave',
            'modified_by' => Session::get('name'),
            'description' => 'View Apv Leave ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.leave.apvLeave', compact('emp', 'leaves'));
    }

    public function setLeave(Request $request) {
        $now = date("Y-m-d H:i:s");
        $year = date("Y");

        try {
            \DB::beginTransaction();

            $leave = $this->lvReq->where('id', $request->leave_id)->first();

            $leaveType = $this->lvType->where('id', '=', $leave->leave_type_id)->first();

            //dd($leave->end_date);

            $begin = date_create($leave->from_date);
            $end = date_create($leave->end_date);

            $entitle = DB::select("
                SELECT * FROM leave_entitlement where leave_type_id = '" . $leave->leave_type_id . "'
                AND emp_number = '" . $leave->emp_number . "' AND YEAR(to_date) >= '" . $year . "'
                ");
            $emp = $this->emp->where('employee_id', Session::get('username'))->first();
            $empLeave = $this->emp->where('emp_number', $leave->emp_number)->first();
            if (empty($empLeave->emp_work_email) || $empLeave->emp_work_email == "" || $empLeave->emp_work_email == NULL) {
                \DB::rollback();
                return redirect(route('apvLeave'))->withErrors([
                            'error' => 'Data Employee Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
                ]);
            }
            $leave->comments .= " - Comments from " . $emp->emp_firstname . " " . $request->comments;
            $leave->leave_status = $request->leave_status;
            $taken = (float) $leave->length_days;
            //dd($taken);

            if ($request->leave_status == '4') {
                $leave->approved_at = $now;
                $leave->approved_by = Session::get('userId');
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
                //$i = $begin;
                //dd($begin->format("Y-m-d").' / '.$end->format("Y-m-d"));
                //dd((float)$leave->length_days == 0.5);

                if ((float) $leave->length_days == 0.5) {
                    //dd('test1');
                    if ($leaveType->comIjin <> 'CB') {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate', '=', $begin->format("Y-m-d"))
                                ->where('comNIP', '=', $empLeave->employee_id)
                                ->count();

                        if ($cekDataAbsen > 0) {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '" . $empLeave->employee_id . "' "
                                    . " AND comDate = '" . $begin->format("Y-m-d") . "'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate', '=', $begin->format("Y-m-d"))
                                    ->where('comNIP', '=', $empLeave->employee_id)
                                    ->update([
                                        'comIjin' => $leaveType->comIjin . ' CS',
                                        'comIjin_reason' => $leave->comments,
                                        'updatet_at' => $now
                            ]);
                        } else {
                            DB::table('com_absensi_inout')
                                    ->insert([
                                        'comNIP' => $empLeave->employee_id,
                                        'comIn' => '08:00:00',
                                        'comOut' => '17:00:00',
                                        'comDate' => $begin->format("Y-m-d"),
                                        'comDTIn' => $begin->format("Y-m-d") . ' 08:00:00',
                                        'comDTOut' => $begin->format("Y-m-d") . ' 17:00:00',
                                        'comTotalHours' => '08:00:00',
                                        'comIjin' => $leaveType->comIjin . ' CS',
                                        'comIjin_reason' => $leave->comments,
                                        'source' => 'leave',
                                        'created_at' => $now,
                                        'updatet_at' => $now,
                            ]);
                        }
                    } else {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate', '=', $begin->format("Y-m-d"))
                                ->where('comNIP', '=', $empLeave->employee_id)
                                ->count();

                        if ($cekDataAbsen > 0) {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '" . $empLeave->employee_id . "' "
                                    . " AND comDate = '" . $begin->format("Y-m-d") . "'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate', '=', $begin->format("Y-m-d"))
                                    ->where('comNIP', '=', $empLeave->employee_id)
                                    ->update([
                                        'comIjin' => 'CB',
                                        'comIjin_reason' => $leave->comments,
                                        'updatet_at' => $now
                            ]);
                        } else {
                            DB::table('com_absensi_inout')
                                    ->insert([
                                        'comNIP' => $empLeave->employee_id,
                                        'comIn' => '08:00:00',
                                        'comOut' => '17:00:00',
                                        'comDate' => $begin->format("Y-m-d"),
                                        'comDTIn' => $begin->format("Y-m-d") . ' 08:00:00',
                                        'comDTOut' => $begin->format("Y-m-d") . ' 17:00:00',
                                        'comTotalHours' => '08:00:00',
                                        'comIjin' => 'CB',
                                        'comIjin_reason' => $leave->comments,
                                        'source' => 'leave',
                                        'created_at' => $now,
                                        'updatet_at' => $now,
                            ]);
                        }
                    }
                } else {
                    //dd('test2');
                    for ($i = $begin; $i <= $end; $i->modify('+1 day')) {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate', '=', $i->format("Y-m-d"))
                                ->where('comNIP', '=', $empLeave->employee_id)
                                ->count();

                        if ($cekDataAbsen > 0) {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '" . $empLeave->employee_id . "' "
                                    . " AND comDate = '" . $i->format("Y-m-d") . "'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate', '=', $i->format("Y-m-d"))
                                    ->where('comNIP', '=', $empLeave->employee_id)
                                    ->update([
                                        'comIjin' => $leaveType->comIjin,
                                        'comIjin_reason' => $leave->comments,
                                        'updatet_at' => $now
                            ]);
                        } else {
                            //dd($i->format("Y-m-d"));
                            DB::table('com_absensi_inout')
                                    ->insert([
                                        'comNIP' => $empLeave->employee_id,
                                        'comIn' => '08:00:00',
                                        'comOut' => '17:00:00',
                                        'comDate' => $i->format("Y-m-d"),
                                        'comDTIn' => $i->format("Y-m-d") . ' 08:00:00',
                                        'comDTOut' => $i->format("Y-m-d") . ' 17:00:00',
                                        'comTotalHours' => '08:00:00',
                                        'comIjin' => $leaveType->comIjin,
                                        'comIjin_reason' => $leave->comments,
                                        'source' => 'leave',
                                        'created_at' => $now,
                                        'updatet_at' => $now,
                            ]);
                        }
                    }
                }
                $this->sendEmailApprove('2', $emp->emp_number, $request->leave_id);
            }
            else
            {
                $this->sendEmailReject('5', $emp->emp_number, $request->leave_id);
            }

            $leave->save();

            $notif = new MobileNotificationController();
            $notif->approveLeaveNotification($emp->emp_number, $leave->id);

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
                'description' => 'ID Leave : ' . $request->leave_id . ', ' . $statusLog . ' Leave By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            \DB::commit();
        } catch (QueryException $ex) {
            \DB::rollback();
            return redirect(route('apvLeave'))->withErrors([
                        'error' => 'Failed approve / reject leave, errmsg : ' . $ex
            ]);
        }

        return back();
    }

    public function balLeave() {
        $now = date("Y-m-d H:i:s");
        $yearEnd = date('Y-m-d H:i:s'); //, strtotime('Dec 31 23:59:59'));
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $leaves = DB::table('emp_reportto')
                        ->join('leave_entitlement', 'emp_reportto.erep_sub_emp_number', '=', 'leave_entitlement.emp_number')
                        ->join('employee', 'emp_reportto.erep_sub_emp_number', '=', 'employee.emp_number')
                        ->join('leave_type', 'leave_entitlement.leave_type_id', '=', 'leave_type.id')
                        ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
                        ->where('emp_reportto.erep_reporting_mode', '1')
                        ->where('leave_entitlement.to_date', '>=', $yearEnd)
                        ->orderBy('employee.emp_number', 'ASC')
                        ->select('leave_type.name', 'leave_entitlement.*', 'emp_reportto.erep_sub_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')->get();

        \DB::table('log_activity')->insert([
            'action' => 'View Bal Leave',
            'module' => 'Leave',
            'sub_module' => 'View Bal Leave',
            'modified_by' => Session::get('name'),
            'description' => 'View Bal Leave ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.leave.balLeave', compact('emp', 'leaves'));
    }

    public function cancel_Leave($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        $this->lvReq->where('emp_number', $emp->emp_number)->where('id', $id)->update([
            'leave_status' => '2'
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'Cancel Leave',
            'module' => 'Leave',
            'sub_module' => 'Cancel Leave',
            'modified_by' => Session::get('name'),
            'description' => 'Cancel Leave ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect(route('applLeave'));
    }

    // Calculate how many days Employee take for leave except Weekends and Holidays //
    public function calculateDays($start_date, $end_date, $days_type) {
        $day = array();
        $i = 0;
        $now = date('Y') . '-01-01';
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);

        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');
        $interval = $end->diff($start);

        // total days
        $days = $interval->days;

        // create an iterateable period of date (P1D equates to 1 day)
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

        if ($days_type == '1') {
            $holidays = Holiday::where('recurring', 1)
                ->orWhere(function ($query) use ($now, $end) {
                    $query->where('date', '>=', $now)
                        ->where('date', '<=', $end);
                })
                ->select('date')
                ->get();
        }
        else {
            // Khusus Orang Lapangan Hari Libur Nasional Saja
            $holidays = Holiday::where('recurring', 1)
                ->orWhere(function ($query) use ($now, $end) {
                    $query->where('date', '>=', $now)
                        ->where('date', '<=', $end);
                })
                ->where('holiday_id', 2) // Libur Nasional
                ->select('date')
                ->get();
        }

        foreach ($holidays as $holiday) {
            $day[$i] = $this->formatDate($holiday->date);
            $i++;
        }

        foreach ($period as $dt) {
            $curr = $dt->format('D');
            if ($days_type == '1') {
                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }
                else if (in_array($dt->format('Y-m-d'), $day)) { // substract if Holidays
                    $days--;
                }
            }
            else {
                if (in_array($dt->format('Y-m-d'), $day)) { // substract if Holidays
                    $days--;
                }
            }
        }

        return $days;
    }

    function formatDate($date, $format = 'Y-m-d') {
        $dat = \DateTime::createFromFormat($format, $date);
        $stat = $dat && $dat->format($format) === $date;
        if ($stat == false) {
            $finalDate = \DateTime::createFromFormat('M d Y h:i:s A', $date)->format($format);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    }
}
