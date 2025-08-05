<?php

namespace App\Http\Controllers\TerminationApproval;

use Illuminate\Http\Request;
use DB,
    Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee;

class TerminationApprovalController extends Controller {

    protected $emp;

    public function __construct(Employee $emp) {
        $this->emp = $emp;

        parent::__construct();
    }

    public function index() {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();

//        $termination = DB::table('emp_termination')
//                ->join('emp_reportto','emp_termination.emp_number','=','emp_reportto.erep_sub_emp_number')
//                ->join('employee','emp_termination.emp_number','=','employee.emp_number')
//                ->join('termination_reason','emp_termination.reason_id','=','termination_reason.id')
//                ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
//                ->where('emp_termination.status',1)
//                ->get(['emp_firstname','emp_lastname','emp_middle_name','termination_date','termination_reason.name','emp_termination.id']);

        $termination = DB::select("select
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    FORMAT (termination_date, 'yyyy-MM-dd') as termination_date,
                                    termination_reason.name,
                                    emp_termination.id 
                                from emp_termination
                                inner join emp_reportto on emp_termination.emp_number = emp_reportto.erep_sub_emp_number 
                                inner join employee on emp_termination.emp_number = employee.emp_number
                                inner join termination_reason on emp_termination.reason_id = termination_reason.id
                                where emp_reportto.erep_sup_emp_number = ".$emp->emp_number." and emp_termination.status = 1"
                . "ORDER BY emp_termination.id ASC");
        
        \DB::table('log_activity')->insert([
            'action' => 'View Termination Approval Index',
            'module' => 'Termination Approval',
            'sub_module' => 'View Termination Approval Index',
            'modified_by' => Session::get('name'),
            'description' => 'View Termination Approval Index, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto, termination_reason, emp_termination'
        ]);
        
        return view('pages.termination_approval.index', compact('termination'));
    }

    public function approveTermination($id, Request $request) {
        $now = date("Y-m-d H:i:s");

        \DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                array(
                    'status' => 2,
                    'approve_by' => $request->session()->get('name'),
                    'approve_at' => $now,
                )
        );
        
        \DB::table('log_activity')->insert([
                            'action' => 'Approve Request Resign',
                            'module' => 'Termination Approval',
                            'sub_module' => 'Approve Termination',
                            'modified_by' => Session::get('name'),
                            'description' => 'Termination ID : ' . $id . ', Approved By : ' . trim(Session::get('name')) . ', Termination Status = 2',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_termination'
                        ]);

        return redirect(route('terminationApproval'))->with('status','Termination request has been successfully approved');
    }

    public function rejectTermination($id, Request $request) {
        $now = date("Y-m-d H:i:s");

        $termination = DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                array(
                    'status' => 0,
//                    'approve_by' => $request->session()->get('name'),
//                    'approve_at' => $now,
                )
        );
        
        \DB::table('log_activity')->insert([
                            'action' => 'Reject Request Resign',
                            'module' => 'Termination Approval',
                            'sub_module' => 'Reject Termination',
                            'modified_by' => Session::get('name'),
                            'description' => 'Termination ID : ' . $id . ', Rejected By : ' . trim(Session::get('name')) . ', Termination Status = 0',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_termination'
                        ]);

        return redirect(route('terminationApproval'))->with('status','Termination request has been successfully rejected');
    }
}
