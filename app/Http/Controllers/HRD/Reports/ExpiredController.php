<?php

namespace App\Http\Controllers\HRD\Reports;

use App\Models\Master\Employee;
use Illuminate\Http\Request;

use App\Http\Requests;
use Session, DB, Log;
use App\Http\Controllers\Controller;

class ExpiredController extends Controller{

    protected $emp;
    public function __construct(Employee $emp){
        $this->emp = $emp;
        parent::__construct();
    }
    public function age_exp(){
        $now = date('Y-m-d H:i:s');
        $reports = NULL;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Age Exp',
            'module' => 'Report',
            'sub_module' => 'Expired',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Age Exp ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.reports.expired.rAgeExp', compact('reports'));
    }
    public function rAgeExp(Request $request){
        $now = date('Y-m-d H:i:s');
        $reports = DB::select("
            select a.employee_id,concat(rtrim(a.emp_firstname),' ',rtrim(a.emp_middle_name),' ',rtrim(a.emp_lastname)) as emp_name,d.name,
            DATEDIFF(YEAR, a.emp_birthday, '".$request->start_date."') AS Age, e.job_title, e.id AS job_id
            from employee a
            inner join hs_hr_emp_locations c on a.emp_number=c.emp_number
            inner join location d on c.location_id=d.id
            INNER JOIN job_title e ON a.job_title_code = e.id
            where a.termination_id = 0 and a.emp_status=1 AND a.emp_birthday IS NOT NULL
            AND DATEDIFF(YEAR, a.emp_birthday, '".$request->start_date."') >= 50
            order by e.id
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View r Age Exp',
            'module' => 'Report',
            'sub_module' => 'Expired',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View r Age Exp ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, location, hs_hr_emp_locations, job_title'
        ]);
        
        return view('pages.manage.reports.expired.rAgeExp', compact('reports'));
    }
    public function contract_exp(){
        $now = date('Y-m-d H:i:s');
        $reports = NULL;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Contract Exp',
            'module' => 'Report',
            'sub_module' => 'Expired',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Contract Exp ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.reports.expired.rContractExp', compact('reports'));
    }
    public function rContractExp(Request $request){
        $now = date('Y-m-d H:i:s');
        print_r($request->all()); die;
        $reports = DB::select("
            select a.employee_id,concat(rtrim(a.emp_firstname),' ',rtrim(a.emp_middle_name),' ',rtrim(a.emp_lastname)) as emp_name,d.name,b.econ_extend_end_date,
            b.econ_extend_start_date, DATEDIFF(YEAR, a.emp_birthday, '".$request->start_date."') AS Age
            from employee a
            inner join emp_contract b on a.emp_number=b.emp_number
            inner join hs_hr_emp_locations c on a.emp_number=c.emp_number
            inner join location d on c.location_id=d.id
            where a.emp_status=2 and a.termination_id = 0
            AND DATEDIFF(YEAR, b.econ_extend_end_date, '".$request->start_date."') <= 37
            order by d.name
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View r Age Exp',
            'module' => 'Report',
            'sub_module' => 'Expired',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View r Age Exp ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, location, hs_hr_emp_locations, job_title'
        ]);
        
        return view('pages.manage.reports.expired.rContractExp', compact('reports'));
    }
}
