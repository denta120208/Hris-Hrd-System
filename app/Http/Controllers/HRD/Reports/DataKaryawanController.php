<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session, DB, Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class DataKaryawanController extends Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $now = date('Y-m-d H:i:s');
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $dataLocation = \DB::table("location")->get();
        $dataEmploymentStatus = \DB::table("employment_status")->get();
        $dataDivisi = \DB::table("job_category")->where('pnum','=',$project->pnum)->orderby('name','asc')->get();
        // $dataEmployee = \DB::select("SELECT a.*, b.name AS location_name, c.name AS employment_status, d.name AS job_category
        //     FROM employee AS a
        //     LEFT JOIN location AS b ON b.id = a.location_id
        //     LEFT JOIN employment_status AS c ON c.id = a.emp_status
        //     LEFT JOIN job_category AS d ON d.id = a.eeo_cat_code");
        $dataEmployee = [];
        $param = [
            "location_id" => NULL,
            "emp_name" => NULL,
            "employee_id" => NULL,
            "emp_status" => NULL,
            "eeo_cat_code" => NULL,
            "termination_id" => NULL
        ];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Data Karyawan Index',
            'module' => 'Report',
            'sub_module' => 'Data Karyawan',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Data Karyawan Index ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employment_status, location, job_category'
        ]);
        
        return view('pages.manage.reports.data_emp.data_emp', compact('dataLocation','dataEmploymentStatus','dataDivisi','dataEmployee','param'));
    }

    public function viewDataKaryawan(Request $request) {
        $now = date('Y-m-d H:i:s');
        $dataLocation = \DB::table("location")->get();
        $dataEmploymentStatus = \DB::table("employment_status")->get();
        $dataDivisi = \DB::table("job_category")->get();

        if(empty($request->location_id) && empty($request->employee_id) &&
            empty($request->emp_status) && empty($request->eeo_cat_code) && empty($request->termination_id)) {
            $where = "";
        }
        else {
            $where = "WHERE";
        }

        if(!empty($request->location_id)) {
            $where .= " a.location_id = '".$request->location_id."' AND";
        }

        if(!empty($request->emp_name)) {
            // $where .= " a.emp_fullname LIKE '%".$request->emp_name."%' AND";
        }

        if(!empty($request->employee_id)) {
            $where .= " a.employee_id LIKE '%".$request->employee_id."%' AND";
        }

        if(!empty($request->emp_status)) {
            $where .= " a.emp_status = '".$request->emp_status."' AND";
        }

        if(!empty($request->eeo_cat_code)) {
            $where .= " a.eeo_cat_code = '".$request->eeo_cat_code."' AND";
        }

        if(!empty($request->termination_id)) {
            if($request->termination_id == "1") {
                $where .= " a.termination_id IN (0) AND";
            }
            elseif($request->termination_id == "2") {
                $where .= " a.termination_id NOT IN (0) AND";
            }
        }

        $where = $where == "" ? $where : substr($where, 0, -4);

//        $dataEmployee = \DB::select("SELECT a.*, b.name AS location_name, c.name AS employment_status,e.job_description as job_title, d.name AS job_category,f.job_dept_desc
//            FROM employee AS a
//            LEFT JOIN location AS b ON b.id = a.location_id
//            LEFT JOIN employment_status AS c ON c.id = a.emp_status
//            LEFT JOIN job_category AS d ON d.id = a.eeo_cat_code
//            LEFT JOIN job_title as e ON a.job_title_code = e.id
//            LEFT JOIN job_department as f ON a.job_dept_id = f.id
//            $where");
        
        // dd("SELECT a.*, 
        //         b.name AS location_name, 
        //         c.name AS employment_status,
        //         e.job_description AS job_title, 
        //         d.name AS job_category,
        //         f.job_dept_desc,
        //         g.name AS work_station,
        //         h.name AS agama,
        //         (SELECT TOP 1 econ_extend_start_date 
        //          FROM emp_contract 
        //          WHERE emp_number = a.emp_number
        //          ORDER BY id DESC) AS econ_extend_start_date,
        //          (SELECT TOP 1 econ_extend_end_date
        //          FROM emp_contract 
        //          WHERE emp_number = a.emp_number
        //          ORDER BY id DESC) AS econ_extend_end_date,
        //          (SELECT TOP 1 UPPER(edu.slug)+' - '+ed.institute
        //          FROM emp_education as ed INNER JOIN education as edu ON ed.education_id = edu.id
        //          WHERE emp_number = a.emp_number
        //          ORDER BY edu.edu_order DESC) AS institute
        //  FROM employee AS a
        //  LEFT JOIN location AS b ON b.id = a.location_id
        //  LEFT JOIN employment_status AS c ON c.id = a.emp_status
        //  LEFT JOIN job_category AS d ON d.id = a.eeo_cat_code
        //  LEFT JOIN job_title AS e ON a.job_title_code = e.id
        //  LEFT JOIN job_department AS f ON a.job_dept_id = f.id
        //  LEFT JOIN subunit AS g ON a.work_station = g.id 
        //  LEFT JOIN emp_agama AS h ON a.agama = h.id
        //  $where");
        
        $dataEmployee = \DB::select("SELECT a.*, 
                                            b.name AS location_name, 
                                            c.name AS employment_status,
                                            e.job_description AS job_title, 
                                            d.name AS job_category,
                                            f.job_dept_desc,
                                            g.name AS work_station,
                                            h.name AS agama,
                                            (SELECT TOP 1 econ_extend_start_date 
                                             FROM emp_contract 
                                             WHERE emp_number = a.emp_number
                                             ORDER BY id DESC) AS econ_extend_start_date,
                                             (SELECT TOP 1 econ_extend_end_date
                                             FROM emp_contract 
                                             WHERE emp_number = a.emp_number
                                             ORDER BY id DESC) AS econ_extend_end_date,
                                             (SELECT TOP 1 UPPER(edu.slug)+' - '+ed.institute
                                             FROM emp_education as ed INNER JOIN education as edu ON ed.education_id = edu.id
                                             WHERE emp_number = a.emp_number
                                             ORDER BY edu.edu_order DESC) AS institute
                                     FROM employee AS a
                                     LEFT JOIN location AS b ON b.id = a.location_id
                                     LEFT JOIN employment_status AS c ON c.id = a.emp_status
                                     LEFT JOIN job_category AS d ON d.id = a.eeo_cat_code
                                     LEFT JOIN job_title AS e ON a.job_title_code = e.id
                                     LEFT JOIN job_department AS f ON a.job_dept_id = f.id
                                     LEFT JOIN subunit AS g ON a.work_station = g.id 
                                     LEFT JOIN emp_agama AS h ON a.agama = h.id
                                     $where");
        
        $dataEmployee = collect($dataEmployee);
        if($request->emp_name != ''){
           $dataEmployee = $dataEmployee->filter(function($dataEmployee) use($request) {
               $emp_name = '';
               if(!empty($dataEmployee->emp_firstname)){
                   $emp_name .= $dataEmployee->emp_firstname;
               }
               if(!empty($dataEmployee->emp_middle_name)){
                   $emp_name .= ' '.$dataEmployee->emp_middle_name;
               }
               if(!empty($dataEmployee->emp_lastname)){
                   $emp_name .= ' '.$dataEmployee->emp_lastname;
               }
                if(str_contains(strtolower($emp_name),strtolower($request->emp_name))) {
                    return $dataEmployee;
                }
            })->values()->toArray();
            // dd($dataEmployee);
        }

        $param = [
            "location_id" => $request->location_id,
            "emp_name" => $request->emp_name,
            "employee_id" => $request->employee_id,
            "emp_status" => $request->emp_status,
            "eeo_cat_code" => $request->eeo_cat_code,
            "termination_id" => $request->termination_id
        ];

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Data Karyawan',
            'module' => 'Report',
            'sub_module' => 'Data Karyawan',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Data Karyawan ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employment_status, location, job_category'
        ]);
        
        return view('pages.manage.reports.data_emp.data_emp', compact('dataLocation','dataEmploymentStatus','dataDivisi','dataEmployee','param'));
    }
}
