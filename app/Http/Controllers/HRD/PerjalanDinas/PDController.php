<?php

namespace App\Http\Controllers\HRD\PerjalanDinas;

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
        $now = date('Y-m-d H:i:s');
        $requests = $this->pdReq->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Perjalanan Dinas index',
            'module' => 'Aministration',
            'sub_module' => 'Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Perjalanan Dinas index,' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_pd_request'
        ]);
        
        return view('pages.manage.perjalanan_dinas.index', compact('requests'));
    }
    public function addPD(PDRequest $pdReq){
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Add Perjalanan Dinas',
            'module' => 'Aministration',
            'sub_module' => 'Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Add Perjalanan Dinas,' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        return view('pages.manage.perjalanan_dinas.form', compact('pdReq'));
    }
    public function savePD(Request $request){
//        dd($request);
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', Session::get('username'))->first();
        $days = (float)$this->calculateDays($request->start_date, $request->end_date, 1);
        $id = $this->pdReq->create([
            'emp_number' => $emp->emp_number,
            'pd_length_day' => $days,
            'pd_start_date' => $request->start_date,
            'pd_end_date' => $request->end_date,
            'pd_status' => 2,
            'pd_reason' => $request->pd_reason,
            'pd_project_des' => $request->pd_project_des,
            'created_at' => $now,
            'created_by' => Session::get('username'),
            'approved_at' => $now,
            'approved_by' => Session::get('username')
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Save Perjalanan Dinas',
            'module' => 'Aministration',
            'sub_module' => 'Perjalanan Dinas',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Save Add Perjalanan Dinas, employee number '.$emp->emp_number ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_pd_request'
        ]);
        
        return redirect(route('perjalanDinasRequest'));
    }
}
