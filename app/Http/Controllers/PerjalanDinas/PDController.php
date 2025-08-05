<?php

namespace App\Http\Controllers\PerjalanDinas;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\PerjanalanDinas\PDRequest, App\Models\PerjanalanDinas\PDStatus;

class PDController extends Controller{
    protected $emp;
    protected $pdReq;
    protected $pdStatus;
    public function __construct(Employee $emp, PDRequest $pdReq, PDStatus $pdStatus){
        $this->emp = $emp;
        $this->pdReq = $pdReq;
        $this->pdStatus = $pdStatus;
        parent::__construct();
    }
    public function index(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $requests = $this->pdReq->where('emp_number', $emp->emp_number)->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Perjalanan Dinas',
            'module' => 'Perjalanan Dinas',
            'sub_module' => 'View Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'View Perjalanan Dinas ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        return view('pages.perjalanan_dinas.index', compact('emp', 'requests'));
    }
    public function applPD(PDRequest $pdReq){
        $now = date("Y-m-d H:i:s");
        \DB::table('log_activity')->insert([
            'action' => 'View Apply Perjalnan Dinas',
            'module' => 'Perjalanan Dinas',
            'sub_module' => 'View Apply Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'View Apply Perjalnan Dinas',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        return view('pages.perjalanan_dinas.form', compact('pdReq'));
    }
    public function savePD(Request $request){
        $now = date("Y-m-d H:i:s");
        if(Session::get('is_manage') == 1) {
            $emp = $this->emp->where('employee_id', Session::get('nik'))->first();
        }
        else {
            $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        }
        $days = (float)$this->calculateDays($request->start_date, $request->end_date, 1);

        $id = $this->pdReq->create([
            'emp_number' => $emp->emp_number,
            'pd_length_day' => $days,
            'pd_start_date' => $request->start_date,
            'pd_end_date' => $request->end_date,
            'pd_status' => 1,
            'pd_reason' => $request->pd_reason,
            'pd_project_des' => $request->pd_project_des,
            'created_at' => $now,
            'created_by' => $emp->emp_number
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Save Perjalanan Dinas',
            'module' => 'Perjalanan Dinas',
            'sub_module' => 'Save Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'Save Perjalanan Dinas ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        return redirect(route('perjalanDinasRequest'));
    }
    public function apvPD(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $pds = DB::table('emp_pd_request')
            ->join('emp_reportto', 'emp_pd_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_pd_request.emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->select('emp_pd_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Approve Perjalanan Dinas',
            'module' => 'Perjalanan Dinas',
            'sub_module' => 'View Approve Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'View Approve Perjalanan Dinas ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        return view('pages.perjalanan_dinas.apvPD', compact('emp', 'pds'));
    }
    public function setPD(Request $request){
        $now = date("Y-m-d H:i:s");
        $pd = $this->pdReq->where('id', $request->id)->where('pd_status', 1)->firstOrFail();
        $pd->pd_status = $request->pd_status;
        $pd->pd_reason .= ' + '.Session::get('username')." : ".$request->pd_reason;
        $pd->approved_at = date('Y-m-d H:i:s');
        $pd->approved_by = Session::get('username');
        $pd->save();
        
        \DB::table('log_activity')->insert([
            'action' => 'Set Perjalanan Dinas',
            'module' => 'Perjalanan Dinas',
            'sub_module' => 'Set Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'Set Perjalanan Dinas, id ' . $pd->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        return redirect(route('perjalanDinasAppv'));
    }
}
