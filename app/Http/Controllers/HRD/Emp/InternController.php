<?php

namespace App\Http\Controllers\HRD\Emp;

use Illuminate\Http\Request;

use App\Http\Requests, Session, DB, Log;
use App\Http\Controllers\Controller;
use App\Models\Master\Location;
use App\Models\Master\Employee, App\Models\Master\EmergencyContact, App\Models\Master\Dependents;
use App\Models\Master\JobMaster, App\Models\Master\Qualification, App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation;
use App\Models\Employee\EmployeeDW;

class InternController extends Controller{
    protected $emp;
    protected $empDW;
    protected $eec;
    protected $ed;
    protected $job;
    protected $qlt;
    protected $train;
    protected $edu;
    public function __construct(Employee $emp,EmployeeDW $empDW, EmergencyContact $eec, Dependents $ed, JobMaster $job, Qualification $qlt, EmployeeTranning $train, EmpEducation $edu){
        $this->emp = $emp;
        $this->empDW = $empDW ;
        $this->eec = $eec;
        $this->ed = $ed;
        $this->job = $job;
        $this->qlt = $qlt;
        $this->train = $train;
        $this->edu = $edu;
        parent::__construct();
    }
    public function index() {
        $now = date("Y-m-d H:i:s");
        if($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error',"You Unauthorize to Access");
        }
        
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $username = Session::get('username');
        
        if(Session::get('project') == 'HO') {
            $emps = $this->emp->where('termination_id','=',0)->whereNotNull('emp_status')->whereIn('emp_status', array(3,4))->orderBy('joined_date', 'DESC')->get();
        }
        else {
            $emps = $this->emp->where('termination_id','=',0)->whereNotNull('emp_status')->where('location_id', $project->id)->whereIn('emp_status', array(3,4))->orderBy('joined_date', 'DESC')->get();
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Intern Index',
            'module' => 'Master',
            'sub_module' => 'Intern',
            'modified_by' => Session::get('name'),
            'description' => 'View Intern Index, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return view('pages.manage.intern.index', compact('emps','username'));
    }
    public function search_emp(Request $request){
        $where = '';
        foreach($request->except('_token') as $key => $val){
            if($request->$key){
                if($key == 'emp_name'){
                    $where .= "emp_firstname LIKE '%".$val."%' OR emp_middle_name LIKE '%".$val."%' OR emp_lastname LIKE '%".$val."%' OR ";
                }else if($key == 'employee_id'){
                    $where .= $key." LIKE '%".$val."%' AND ";
                }else if($key == 'termination_id'){
                    if($val == 1){
                        $where .= $key." IN (0) AND ";
                    }else{
                        $where .= $key." NOT IN (0) AND ";
                    }
                }else{
                    $where .= $key." = '".$val."' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        $emps = DB::select("
            SELECT * FROM employee WHERE emp_status = '4' ".$where."
        ");
//        print_r($where); die;
        return view('pages.manage.intern.index', compact('emps'));
    }
    public function search_emp_intern(Request $request) {
        $where = '';
        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'emp_name') {
//                    $where .= "(emp_firstname LIKE '%" . $val . "%' OR emp_middle_name LIKE '%" . $val . "%' OR emp_lastname LIKE '%" . $val . "%') AND ";
                } else if ($key == 'employee_id') {
                    $where .= $key . " LIKE '%" . $val . "%' AND ";
                } else if ($key == 'termination_id') {
                    if ($val == 1) {
                        $where .= "(".$key . " IN (0) OR " . $key . " = 0)";
                    } else {
                        $where .= "(".$key . " NOT IN (0) AND " . $key . " NOT IN (0))";
                    }
                } else {
                    $where .= $key . " = '" . $val . "' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        $project = DB::table('location')->where('code', Session::get('project'))->first();
//        $emps = DB::select("
//            SELECT * FROM employee WHERE " . $where . "
//        ");
        if (Session::get('project') == 'HO') {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (4,3)
                ");
            } else {

                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (4,3) and " . $where . "
                ");
            }
        } else {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (4,3) and location_id = " . $project->id
                );
            } else {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (4,3) and location_id = " . $project->id . " and " . $where . "
                ");
            }
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
        return view('pages.manage.intern.index', compact('emps'));
    }
    
    public function addIntern(Requests\HRD\Employee\AddIntern $request) {
        \DB::beginTransaction();

        $now = date("Y-m-d H:i:s");
        $project = Location::where('id', '=', $request->location_id)->first();

        if(!empty($request->TXT_REPORT_TO_DATATABLE)) {
            $report_to_table = json_decode($request->TXT_REPORT_TO_DATATABLE);
        }
        else {
            $report_to_table = [];
        }

        $dataCounter = DB::table('counter_doc')->where('id', '=', 1)->first();

        $cekDataTitle = $this->empDW->where('title', '=', $request->employee_id)->count();

        // if($request->employment_status_id == 0){
        //     return redirect(route('hrd.intern'))->withErrors(['error' => 'Status Harus di Isi']);
        // }
        
        if($request->eeo_cat_code == 0){
            return redirect(route('hrd.intern'))->withErrors(['error' => 'Divisi Harus di Isi']);
        }
        
        if($request->location_id == 0){
            return redirect(route('hrd.intern'))->withErrors(['error' => 'Unit/Project Harus di Isi']);
        }

        if ($cekDataTitle > 0) {
            return redirect(route('hrd.intern'))->withErrors(['error' => 'NIK ' . $request->employee_id . ' sudah terdaftar di System Absensi, Transaksi Gagal!']);
        }

        $this->empDW->create([
            'name' => $request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname,
            'title' => $request->employee_id,
            'badgenumber' => $dataCounter->counter_badgenumber,
            'defaultdeptid' => $project->adms_dept_id,
            'minzu' => '1',
            'SN' => 'OID6110056102700821'
        ]);
        
        if($request->days_type == 'on') {
            $days_type = 1;
        }
        else{
            $days_type = 0;
        }

        $emp_number =  \DB::table('employee')->insertGetId([
            'employee_id' => $request->employee_id,
            'emp_firstname' => $request->emp_firstname,
            'emp_middle_name' => $request->emp_middle_name,
            'emp_lastname' => $request->emp_lastname,
            'emp_fullname' => $request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname,
            'eeo_cat_code' => $request->eeo_cat_code, // Division
            'emp_status' => $request->estatus, // Employment Status
            'location_id' => $request->location_id,
            'termination_id' => 0,
            'days_type' => $days_type,
            'pnum' => Session::get('pnum'),
            'ptype' => Session::get('ptype'),
            'emp_ktp' => $request->emp_ktp, // KTP
            'emp_gender' => $request->emp_gender, // Gender
            'nation_code' => $request->nation_code, // Nationality
            'emp_dri_lice_num' => $request->emp_dri_lice_num, // Driver's License Number
            'emp_dri_lice_exp_date' => $request->emp_dri_lice_exp_date, // License Expiry Date
            'emp_marital_status' => $request->emp_marital_status, // Marital Status
            'emp_birthday' => $request->emp_birthday, // Date of Birth,
            'bpjs_ks' => $request->bpjs_ks, // BPJS Kes
            'bpjs_tk' => $request->bpjs_tk, // BPJS TK
            'npwp' => $request->npwp, // No. NPWP
            'job_level' => $request->job_level, // Job Title
            'joined_date' => $request->joined_date, // Joined Date
            'work_station' => $request->work_station, // SubUnit
            'job_title_code' => $request->job_title_code, // Job Level,
            'job_dept_id' => $request->department // Department
        ]);

        for($i = 0; $i < count($report_to_table); $i++) {
            DB::table("emp_reportto")->insert([
                'erep_sup_emp_number' => $report_to_table[$i][0],
                'erep_sub_emp_number' => $emp_number,
                'erep_reporting_mode' => $report_to_table[$i][2]
            ]);
        }

        DB::table('counter_doc')->where('id', '=', 1)->update([
            'counter_badgenumber' => $dataCounter->counter_badgenumber + 1
        ]);

        $this->sendEmailAddEmployee($request->employee_id);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Add Employee Internship',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Add Employee Internship, employee id ' . $request->employee_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        \DB::commit();

        return redirect(route('hrd.intern'))->with("status", "Success Add Employee");
    }
}
