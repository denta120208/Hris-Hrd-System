<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session, DB, Log;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee, App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion, App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation;

class EducationController extends Controller{
    protected $emp;
    protected $train;
    protected $edu;
    public function __construct(Employee $emp, EmployeeTranning $train, EmpEducation $edu)
    {
        $this->emp = $emp;
        $this->train = $train;
        $this->edu = $edu;
        parent::__construct();
    }
    public function index(){
        $now = date('Y-m-d H:i:s');
        $datas = DB::select("
SELECT * FROM   
(
    select ed.slug, e.emp_number, p.name AS project, p.id as project_id FROM education ed INNER JOIN emp_education eed
	ON ed.id = eed.education_id INNER JOIN employee e
	ON eed.emp_number = e.emp_number INNER JOIN location p
	ON e.pnum = p.pnum AND e.ptype = p.ptype
	WHERE e.termination_id = 0 AND  e.pnum IS NOT NULL
) t
PIVOT(
    COUNT(emp_number) 
    FOR slug IN (
        [sd], 
        [smp],
         [sma],  
         [d1],
         [d3],
         [d4],
         [s1],
         [s2],
         [s3]
        )
) AS pivot_table
 ORDER BY project Desc
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Education Index',
            'module' => 'Report',
            'sub_module' => 'Education Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Education Index, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'education, emp_education'
        ]);
        
        return view('pages.manage.reports.education_emp.index', compact('datas'));
    }
    public function detail($id){
        $now = date('Y-m-d H:i:s');
        $datas = DB::select("select ed.id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname, ed.name FROM education ed INNER JOIN emp_education eed
            ON ed.id = eed.education_id INNER JOIN employee e
            ON eed.emp_number = e.emp_number INNER JOIN location p
            ON e.pnum = p.pnum AND e.ptype = p.ptype
            WHERE e.termination_id = 0 AND  e.pnum IS NOT NULL AND p.id =  '".$id."'
	        ORDER BY ed.id
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Education detail',
            'module' => 'Report',
            'sub_module' => 'Education Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Education Detail, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_education'
        ]);
        
        return view('pages.manage.reports.education_emp.detail', compact('datas'));
    }
    public function search_emp(Request $request){
        $now = date('Y-m-d H:i:s');
        $where = '';
        $search_name = 0;
        if($request->emp_name != ''){
            $search_name = 1;
        }
        foreach($request->except('_token') as $key => $val){
            if($request->$key){
                if($key == 'emp_name'){
//                    $where .= "e.emp_firstname LIKE '%".$val."%' OR e.emp_middle_name LIKE '%".$val."%' OR e.emp_lastname LIKE '%".$val."%' OR ";
                }else if($key == 'employee_id'){
                    $where .= "e.".$key." LIKE '%".$val."%' AND ";
                }else if($key == 'education_id'){
                    $where .= "eed.".$key." LIKE '%".$val."%' AND ";
                }else if($key == 'institute'){
                    $where .= "eed.".$key." LIKE '%".$val."%' AND ";
                }else if($key == 'major'){
                    $where .= "eed.".$key." LIKE '%".$val."%' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        if(empty($where) && $search_name == 0 ) {
            return redirect('hrd/rEducation')->withErrors([
                'error' => 'Harap Isi Parameter Search Terlebih Dahulu!'
            ]);
        }
        else {
            if($where != ''){
                $emps = DB::select("
                    SELECT e.emp_number, e.employee_id, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
                    eed.institute, eed.major, ed.name
                    FROM employee e INNER JOIN emp_education eed
                    ON e.emp_number = eed.emp_number INNER JOIN education ed
                    ON eed.education_id = ed.id WHERE ".$where."
                ");
            }else{
                $emps = DB::select("
                    SELECT e.emp_number, e.employee_id, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
                    eed.institute, eed.major, ed.name
                    FROM employee e INNER JOIN emp_education eed
                    ON e.emp_number = eed.emp_number INNER JOIN education ed
                    ON eed.education_id = ed.id
                ");
            }
            
            
            $emps = collect($emps);
        
            if($request->emp_name != ''){
               $emps = $emps->filter(function($emp) use($request) {
                   $emp_name = '';
                   if($emp->emp_firstname != ''){
                       $emp_name .= $emp->emp_firstname;
                   }
                   if($emp->emp_middle_name != ''){
                       $emp_name .= ' '.$emp->emp_middle_name;
                   }
                   if($emp->emp_lastname != ''){
                       $emp_name .= ' '.$emp->emp_lastname;
                   }
                    if(str_contains(strtolower($emp_name),strtolower($request->emp_name))) {
                        return $emp;
                    }
                })->values()->toArray();
            }
        }
        
        
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Search Employee',
            'module' => 'Report',
            'sub_module' => 'Education Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Search Employee, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_education'
        ]);
        
        return view('pages.manage.reports.education_emp.search', compact('emps'));
    }
}
