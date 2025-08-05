<?php

namespace App\Http\Controllers\Resign;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session;
use App\Models\Master\Employee;

class ResignController extends Controller {

    protected $emp;

    public function __construct(Employee $emp) {
        $this->emp = $emp;

        parent::__construct();
    }

    public function requestResign(Request $request) {
        $session_name = $request->session()->get('name');
        $now = date("Y-m-d H:i:s");

        \DB::table('emp_termination')->insert([
            'reason_id' => $request->reason_id,
            'termination_date' => $request->termination_date,
            'note' => $request->note,
            'status' => 1,
            'request_by' => $session_name,
            'request_at' => $now,
            'emp_number' => $request->emp_number,
            'emp_number_old' => $request->emp_number_old,
        ]);
        
        $termination = DB::table('emp_termination')->orderBy('id', 'desc')->first();
        
        \DB::table('log_activity')->insert([
                            'action' => 'Create Request Resign',
                            'module' => 'Resign',
                            'sub_module' => 'Request Resign',
                            'modified_by' => Session::get('name'),
                            'description' => 'Termination ID : ' . $termination->id . ', Request Resign By : ' . trim(Session::get('name')) . ', Termination Status = 1',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_termination'
                        ]);
        return redirect('personal')->with('status','Termination request has been sent');
    }

    public function printExitFormInterview() {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date("Y-m-d H:i:s");

        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    FORMAT (employee.emp_birthday, 'yyyy-MM-dd') as emp_birthday,
                                    employee.emp_street1,
                                    employee.city_code,
                                    employee.employee_id,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date,
                                    emp_dept.name as dept_name,
                                    employment_status.name as status_name,
                                    employee_sup.emp_firstname as sup_firstname,
                                    employee_sup.emp_middle_name as sup_middle_name, 
                                    employee_sup.emp_lastname as sup_lastname,
                                    FORMAT (termination_date, 'yyyy-MM-dd') as termination_date,
                                    emp_termination.id 
                                from employee
                                left join emp_termination on employee.emp_number = emp_termination.emp_number
                                left join emp_dept on employee.dept_id = emp_dept.id
                                left join employment_status on employee.emp_status = employment_status.id
                                left join emp_reportto on employee.emp_number = emp_reportto.erep_sub_emp_number
                                left join employee as employee_sup on emp_reportto.erep_sup_emp_number = employee_sup.emp_number
                                where emp_termination.status = 3 and employee.employee_id = '".Session::get('username')."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'Print Exit Form',
            'module' => 'Resign',
            'sub_module' => 'Exit Form',
            'modified_by' => Session::get('name'),
            'description' => 'Print File Exit Form , accessed by '. Session::get('name'),
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        return view('prints.pdfFormExitInterview', compact('employee','now'));
    }
}
