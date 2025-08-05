<?php

namespace App\Http\Controllers\HRD\Emp;

use App\Models\Appraisal\AprraisalResult;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Session, DB, Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Appraisal, App\Models\Master\AppraisalCategory, App\Models\Master\AppraisalType, App\Models\Master\AppraisalValue;
use App\Models\Master\Employee, App\Models\Employee\EmpAppraisal, App\Models\Employee\EmpAppraisalType, App\Models\Employee\EmpEvaluator;
use Response;

class AppraisalController extends Controller{
    protected $emp;
    protected $empAppraisal;
    protected $appraisal;
    protected $appraisalCat;
    protected $appraisalType;
    protected $appraisalValue;
    protected $empAppraisalType;
    protected $empEvaluator;
    public function __construct(Employee $emp,EmpAppraisal $empAppraisal,Appraisal $appraisal, AppraisalCategory $appraisalCat,AppraisalType $appraisalType
        , AppraisalValue $appraisalValue, EmpAppraisalType $empAppraisalType, EmpEvaluator $empEvaluator){
        $this->emp = $emp;
        $this->empAppraisal = $empAppraisal;
        $this->appraisal = $appraisal;
        $this->appraisalCat = $appraisalCat;
        $this->appraisalType = $appraisalType;
        $this->appraisalValue = $appraisalValue;
        $this->empAppraisalType = $empAppraisalType;
        $this->empEvaluator = $empEvaluator;
        parent::__construct();
    }
    public function index(){
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $now = date('Y-m-d H:i:s');
        $year = $project->appraisal_year_period;
        
        if (Session::get('project') == 'HO') {
            // $emps = DB::select("
            //     SELECT employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
            //         , code_appraisal,evaluator_status, period,SUM(appraisal_value) AS appraisal_value
            //         FROM(
            //             SELECT e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname, ate.name
            //             , ate.code_appraisal,
            //                 (CASE WHEN ee.evaluator_status = 2 THEN 'Supperior Appraisal' WHEN ee.evaluator_status = 3 THEN 'Director Appraisal' ELSE 'NONE' END) as evaluator_status, 
            //                 AVG(ea.appraisal_value) AS appraisal_value,ea.period
            //             FROM employee e INNER JOIN emp_appraisal_type et
            //             ON e.emp_number = et.emp_number INNER JOIN appraisal_type ate
            //             ON et.appraisal_type_id = ate.id LEFT JOIN emp_appraisal ea
            //             ON e.emp_number = ea.emp_number INNER JOIN emp_evaluator as ee 
            //                 ON e.emp_number = ee.emp_evaluation 
            //             WHERE ea.period = '".$year."'
            //             AND ee.is_delete = 0
            //             GROUP BY e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
            //             ate.name, ate.code_appraisal, ea.appraisal_id, ea.evaluator_as,ee.evaluator_status,ea.period
            //         ) as inner_query
            //         GROUP BY employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
            //         , code_appraisal,evaluator_status,period
            // ");

            $emps = DB::select("
                SELECT employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
                    , code_appraisal,evaluator_status, period,appraisal_value
                    FROM(
                        SELECT e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname, ate.name
                        , ate.code_appraisal,
                            (CASE WHEN ee.evaluator_status = 2 THEN 'Supperior Appraisal' WHEN ee.evaluator_status = 3 THEN 'Director Appraisal' ELSE 'NONE' END) as evaluator_status, 
                            a.sup_value AS appraisal_value,ea.period
                        FROM employee e INNER JOIN emp_appraisal_type et
                        ON e.emp_number = et.emp_number INNER JOIN appraisal_type ate
                        ON et.appraisal_type_id = ate.id LEFT JOIN emp_appraisal ea
                        ON e.emp_number = ea.emp_number INNER JOIN emp_evaluator as ee 
                        ON e.emp_number = ee.emp_evaluation left join emp_appraisal_value as a
                        on e.emp_number = a.emp_number
                        WHERE ea.period = '".$year."'
                        AND ee.is_delete = 0
                        GROUP BY e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
                        ate.name, ate.code_appraisal, ea.appraisal_id, ea.evaluator_as,ee.evaluator_status,ea.period,a.sup_value
                    ) as inner_query
                    GROUP BY employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
                    , code_appraisal,evaluator_status,period,appraisal_value
            ");
        }
        else
        {
            // $emps = DB::select("
            //     SELECT employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
            //         , code_appraisal,evaluator_status, period,SUM(appraisal_value) AS appraisal_value
            //         FROM(
            //             SELECT e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname, ate.name
            //             , ate.code_appraisal,
            //                 (CASE WHEN ee.evaluator_status = 2 THEN 'Supperior Appraisal' WHEN ee.evaluator_status = 3 THEN 'Director Appraisal' ELSE 'NONE' END) as evaluator_status, 
            //                 AVG(ea.appraisal_value) AS appraisal_value,ea.period
            //             FROM employee e INNER JOIN emp_appraisal_type et
            //             ON e.emp_number = et.emp_number INNER JOIN appraisal_type ate
            //             ON et.appraisal_type_id = ate.id LEFT JOIN emp_appraisal ea
            //             ON e.emp_number = ea.emp_number INNER JOIN emp_evaluator as ee 
            //                 ON e.emp_number = ee.emp_evaluation 
            //             WHERE ea.period = '".$year."'
            //             AND e.location_id = '".$project->id."'
            //             AND ee.is_delete = 0
            //             GROUP BY e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
            //             ate.name, ate.code_appraisal, ea.appraisal_id, ea.evaluator_as,ee.evaluator_status,ea.period
            //         ) as inner_query
            //         GROUP BY employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
            //         , code_appraisal,evaluator_status,period
            // ");

            $emps = DB::select("
                SELECT employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
                    , code_appraisal,evaluator_status, period,appraisal_value
                    FROM(
                        SELECT e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname, ate.name
                        , ate.code_appraisal,
                            (CASE WHEN ee.evaluator_status = 2 THEN 'Supperior Appraisal' WHEN ee.evaluator_status = 3 THEN 'Director Appraisal' ELSE 'NONE' END) as evaluator_status, 
                            a.sup_value AS appraisal_value,ea.period
                        FROM employee e INNER JOIN emp_appraisal_type et
                        ON e.emp_number = et.emp_number INNER JOIN appraisal_type ate
                        ON et.appraisal_type_id = ate.id LEFT JOIN emp_appraisal ea
                        ON e.emp_number = ea.emp_number INNER JOIN emp_evaluator as ee 
                        ON e.emp_number = ee.emp_evaluation left join emp_appraisal_value as a
                        on e.emp_number = a.emp_number
                        WHERE ea.period = '".$year."'
                        AND e.location_id = '".$project->id."'
                        AND ee.is_delete = 0
                        GROUP BY e.employee_id, e.emp_number, e.emp_firstname, e.emp_middle_name, e.emp_lastname,
                        ate.name, ate.code_appraisal, ea.appraisal_id, ea.evaluator_as,ee.evaluator_status,ea.period,a.sup_value
                    ) as inner_query
                    GROUP BY employee_id, emp_number, emp_firstname, emp_middle_name, emp_lastname, name
                    , code_appraisal,evaluator_status,period,appraisal_value
            ");
        }
        
        
//        dd($emps);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Appraisal Index',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Appraisal Index, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type, emp_appraisal, appraisal_value'
        ]);
        
        return view('pages.manage.appraisals.index', compact('emps','year'));
    }
    
    public function setAppraisalYear(Request $request){
        $now = date('Y-m-d H:i:s');
        
        DB::table('location')
                ->update(['appraisal_year_period'=>$request->active_year]);
        
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Appraisal Year',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Appraisal Year '.$request->active_year,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return redirect()->route('hrd.appraisal');
    }
    
    public function view($id){
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        $emp = $this->emp->where('emp_number', $id)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $id)->first();
        $code_appraisal = $this->empAppraisalType->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->select('appraisal_type.code_appraisal')
            ->where('emp_appraisal_type.emp_number', $id)->first();
        $appraisals = DB::select("
            SELECT a.factor, a.id
            FROM emp_appraisal_type et INNER JOIN appraisal_type ate
            ON et.appraisal_type_id = ate.id INNER JOIN appraisal a 
            ON ate.code_appraisal = a.type_code
            where et.emp_number = '".$id."'
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Appraisal',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Appraisal, employee number '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type, emp_appraisal, appraisal_value'
        ]);
        
        return view('pages.manage.appraisals.view', compact('pic', 'emp', 'total','appraisals'));
    }
    public function empAppraisal(){
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $now = date('Y-m-d H:i:s');
        if (Session::get('project') == 'HO') {
            $empApprTypes = $this->empAppraisalType->join('employee', 'emp_appraisal_type.emp_number', '=', 'employee.emp_number')
            ->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->where('employee.termination_id','=',0)
            ->where('emp_appraisal_type.is_delete', '=', 0)  
            ->select('emp_appraisal_type.id','appraisal_type.name','appraisal_type.code_appraisal', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.employee_id')->get();
        }
        else
        {
            $empApprTypes = $this->empAppraisalType->join('employee', 'emp_appraisal_type.emp_number', '=', 'employee.emp_number')
            ->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->where('employee.termination_id','=',0)
            ->where('emp_appraisal_type.is_delete', '=', 0)
            ->where('employee.location_id','=',$project->id)   
            ->select('emp_appraisal_type.id','appraisal_type.name','appraisal_type.code_appraisal', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.employee_id')->get();
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Employee Appraisal',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Employee Appraisal, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type'
        ]);
        
        return view('pages.manage.appraisals.emp', compact('empApprTypes'));
    }
    public function empAssignAdd(Request $request){
        $now = date('Y-m-d H:i:s');
        
        $cekEmployee = $this->empAppraisalType
                ->where('emp_number','=', $request->emp_number)
                ->where('appraisal_type_id','=',$request->appraisal_type_id)
                ->where('is_delete','=',0)
                ->count();
        
        if ($cekEmployee > 0)
        {
            return redirect()->route('hrd.addEmpAppraisal')->withErrors(['error' => 'Assign Fail, employee has been added in list before. please check data in list']);
        }
        else
        {
            $this->empAppraisalType->updateOrCreate(
                [ 'emp_number' => $request->emp_number ],
                [
                    'appraisal_type_id' => $request->appraisal_type_id
                ]
            );
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Employee Assign Add',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Employee Assign Add, employee number '.$request->emp_number.', appraisal type id '.$request->appraisal_type_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type'
        ]);
        
        return redirect()->route('hrd.addEmpAppraisal');
    }
    public function getAssign(Request $request){
        $now = date('Y-m-d H:i:s');
        $empApprTypes = $this->empAppraisalType->join('employee', 'emp_appraisal_type.emp_number', '=', 'employee.emp_number')
            ->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->where('emp_appraisal_type.id', $request->id)
            ->select('appraisal_type.id','appraisal_type.name','appraisal_type.code_appraisal','employee.emp_number',
                    'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname'
//                DB::raw("CONCAT([employee].[emp_firstname],' ', [employee].[emp_middle_name],' ', [employee].[emp_lastname]) AS display_name")
                , 'employee.employee_id')->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Assign',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Assign, appraisal type id '.$request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type'
        ]);
        
        return response()->json($empApprTypes);
    }
    public function evaluator(){
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $now = date('Y-m-d H:i:s');
        if (Session::get('project') == 'HO') {
            $evaluators = DB::table('emp_evaluator')->join('employee', 'emp_evaluator.emp_number', '=', 'employee.emp_number')
            ->join('employee as e1', 'emp_evaluator.emp_evaluation', '=', 'e1.emp_number')
            ->where('emp_evaluator.is_delete','=',0)
            ->select('emp_evaluator.*','employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.employee_id','e1.emp_firstname as firstname', 'e1.emp_middle_name as middle_name', 'e1.emp_lastname as lastname', 'e1.employee_id as evaluation_id')
            ->get();
        }
        else
        {
            $evaluators = DB::table('emp_evaluator')->join('employee', 'emp_evaluator.emp_number', '=', 'employee.emp_number')
            ->join('employee as e1', 'emp_evaluator.emp_evaluation', '=', 'e1.emp_number')
            ->where('emp_evaluator.is_delete','=',0)
            ->where('employee.location_id','=',$project->id)
            ->select('emp_evaluator.*','employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.employee_id','e1.emp_firstname as firstname', 'e1.emp_middle_name as middle_name', 'e1.emp_lastname as lastname', 'e1.employee_id as evaluation_id')
            ->get();
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Evaluator',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Evaluator, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return view('pages.manage.appraisals.evaluator', compact('evaluators'));
    }

    public function deleteEmpAppraisal($id) {
        $now = date("Y-m-d H:i:s");

        \DB::beginTransaction();

        // Ambil Data Employee Appraisal Type
        $dataEmpAppraisalType = \DB::table("emp_appraisal_type")->where("id", $id)->first();

        // Hapus Data Evaluator
        \DB::table("emp_evaluator")->where("emp_evaluation", $dataEmpAppraisalType->emp_number)->where("is_delete", 0)->update([
            "is_delete" => 1,
            "updated_by" => Session::get('userid'),
            "update_at" => $now
        ]);

        // Ambil Data Appraisal
        $dataAppraisalDetails = \DB::table("emp_appraisal")
            ->where("emp_number", $dataEmpAppraisalType->emp_number)
            ->get();

        // Simpan Semua Data Appraisal Ke Table Appraisal Delete
        foreach($dataAppraisalDetails as $data) {
            \DB::table("emp_appraisal_deleted")->insert([
                "id" => $data->id,
                "emp_number" => $data->emp_number,
                "appraisal_id" => $data->appraisal_id,
                "appraisal_value_id" => $data->appraisal_value_id,
                "period" => $data->period,
                "box_9_appraisal" => $data->box_9_appraisal,
                "appraisal_value" => $data->appraisal_value,
                "emp_evaluator" => $data->emp_evaluator,
                "evaluator_as" => $data->evaluator_as,
                "hrd_value" => $data->hrd_value,
                "hrd_date" => $data->hrd_date,
                "appraisal_status" => $data->appraisal_status,
                "created_at" => $data->created_at,
                "updated_at" => $data->updated_at
            ]);
        }

        // Hapus Semua Data Appraisal
        \DB::table("emp_appraisal")->where("emp_number", $dataEmpAppraisalType->emp_number)->delete();

        // Ambil Data Summary Appraisal
        $dataAppraisalValue = \DB::table("emp_appraisal_value")
            ->where('emp_number', $dataEmpAppraisalType->emp_number)
            ->get();

        // Simpan Semua Data Summary Appraisal Ke Table Summary Appraisal Delete
        foreach($dataAppraisalValue as $data) {
            \DB::table("emp_appraisal_value_deleted")->insert([
                "id" => $data->id,
                "emp_number" => $data->emp_number,
                "period" => $data->period,
                "emp_value" => $data->emp_value,
                "emp_later" => $data->emp_later,
                "emp_box_9" => $data->emp_box_9,
                "emp_val_status" => $data->emp_val_status,
                "sup_value" => $data->sup_value,
                "sup_later" => $data->sup_later,
                "sup_box_9" => $data->sup_box_9,
                "sup_val_status" => $data->sup_val_status,
                "dir_value" => $data->dir_value,
                "dir_later" => $data->dir_later,
                "dir_box_9" => $data->dir_box_9,
                "dir_val_status" => $data->dir_val_status,
                "hrd_value" => $data->hrd_value,
                "hrd_later" => $data->hrd_later,
                "hrd_box_9" => $data->hrd_box_9,
                "hrd_val_status" => $data->hrd_val_status,
                "final_value" => $data->final_value,
                "is_final" => $data->is_final,
                "created_at" => $data->created_at,
                "updated_at" => $data->updated_at
            ]);
        }

        // Hapus Semua Data Summary Appraisal
        \DB::table("emp_appraisal_value")->where("emp_number", $dataEmpAppraisalType->emp_number)->delete();

        // Ambil Data Appraisal Evaluator
        $dataAppraisalEvaluators = \DB::table("emp_appraisal_evaluator")
            ->where("emp_number", $dataEmpAppraisalType->emp_number)
            ->get();

        // Simpan Semua Data Appraisal Evaluator Ke Table Appraisal Evaluator Delete
        foreach($dataAppraisalEvaluators as $data) {
            \DB::table("emp_appraisal_evaluator_deleted")->insert([
                "id" => $data->id,
                "emp_number" => $data->emp_number,
                "emp_evaluator" => $data->emp_evaluator,
                "evaluator_as" => $data->evaluator_as,
                "appraisal_type_id" => $data->appraisal_type_id,
                "appraisal_value" => $data->appraisal_value,
                "period" => $data->period,
                "created_at" => $data->created_at,
                "updated_at" => $data->updated_at
            ]);
        }

        // Hapus Semua Data Appraisal
        \DB::table("emp_appraisal_evaluator")->where("emp_number", $dataEmpAppraisalType->emp_number)->delete();

        // Ganti Status Data Employee Appraisal Type
        \DB::table("emp_appraisal_type")->where("id", $id)->update([
            "is_delete" => 1
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Emp Appraisal Type',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Type',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Emp Appraisal Type, id '.$dataEmpAppraisalType->id.', employee number '.$dataEmpAppraisalType->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type'
        ]);

        \DB::commit();

        return redirect()->route('hrd.addEmpAppraisal')->with("success", "Delete Employee Appraisal Type Success");
    }

    public function deleteEvaluator($id) {
        $now = date("Y-m-d H:i:s");

        \DB::beginTransaction();

        // Ambil Data Evaluator
        $dataEvaluator = \DB::table("emp_evaluator")->where("id", $id)->first();

        // Ambil Data Appraisal Atas Evaluator Tersebut
        $dataAppraisalDetails = \DB::table("emp_appraisal")
            ->where("emp_number", $dataEvaluator->emp_evaluation)
            ->where("emp_evaluator", $dataEvaluator->emp_number)
            ->where('evaluator_as', $dataEvaluator->evaluator_status)
            ->get();

        // Simpan Semua Data Appraisal Atas Evaluator Tersebut Ke Table Appraisal Delete
        foreach($dataAppraisalDetails as $data) {
            \DB::table("emp_appraisal_deleted")->insert([
                "id" => $data->id,
                "emp_number" => $data->emp_number,
                "appraisal_id" => $data->appraisal_id,
                "appraisal_value_id" => $data->appraisal_value_id,
                "period" => $data->period,
                "box_9_appraisal" => $data->box_9_appraisal,
                "appraisal_value" => $data->appraisal_value,
                "emp_evaluator" => $data->emp_evaluator,
                "evaluator_as" => $data->evaluator_as,
                "hrd_value" => $data->hrd_value,
                "hrd_date" => $data->hrd_date,
                "appraisal_status" => $data->appraisal_status,
                "created_at" => $data->created_at,
                "updated_at" => $data->updated_at
            ]);
        }

        // Hapus Semua Data Appraisal Atas Evaluator Tersebut
        \DB::table("emp_appraisal")->where("emp_number", $dataEvaluator->emp_evaluation)->where("emp_evaluator", $dataEvaluator->emp_number)->where('evaluator_as', $dataEvaluator->evaluator_status)->delete();

        // Ambil Data Period Dari Data Appraisal Untuk Keperluan Hitung Ulang Summary Appraisal Value
        $appraisal_periods = \DB::table("emp_appraisal")
            ->select("period")
            ->where('emp_number', $dataEvaluator->emp_evaluation)
            ->where('evaluator_as', $dataEvaluator->evaluator_status)
            ->groupBy("period")
            ->get();

        // Hitung Ulang Summary Appraisal Value
        foreach($appraisal_periods as $appraisal_period) {
            $dataNilaiSumEmps = \DB::table("emp_appraisal")
                ->where('emp_number', $dataEvaluator->emp_evaluation)
                ->where('evaluator_as', $dataEvaluator->evaluator_status)
                ->where('period', '=', $appraisal_period->period)
                ->get();

            $nilaiSumEmp = 0;
            foreach($dataNilaiSumEmps as $dataNilaiSumEmp) {
                $nilaiSumEmp += $dataNilaiSumEmp->appraisal_value;
            }

            $nilaiEvaluator = \DB::table("emp_appraisal")
                ->selectRaw('COUNT(DISTINCT emp_evaluator) as distinct_count')
                ->where('emp_number', $dataEvaluator->emp_evaluation)
                ->where('evaluator_as', $dataEvaluator->evaluator_status)
                ->where('period', '=', $appraisal_period->period)
                ->value('distinct_count');

            $value = \DB::table("emp_appraisal_value")
                ->where('emp_number', $dataEvaluator->emp_evaluation)
                ->where('period', '=', $appraisal_period->period)
                ->first();

            if($dataEvaluator->evaluator_status == '1') { // Self Appraiss
                if($value->emp_value > 0) {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "emp_value" => $nilaiSumEmp / $nilaiEvaluator
                        ]);
                }
                else {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "emp_value" => $nilaiSumEmp
                        ]);
                }
            }
            else if($dataEvaluator->evaluator_status == '2') { // Sup Appraiss
                if($value->sup_value > 0) {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "sup_value" => $nilaiSumEmp / $nilaiEvaluator
                        ]);
                }
                else {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "sup_value" => $nilaiSumEmp
                        ]);
                }
            }
            else if($dataEvaluator->evaluator_status == '3') { // Dir Appraiss
                if($value->dir_value > 0) {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "dir_value" => $nilaiSumEmp / $nilaiEvaluator
                        ]);
                }
                else {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "dir_value" => $nilaiSumEmp
                        ]);
                }
            }
            else {
                if($value->hrd_value > 0) {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "hrd_value" => $nilaiSumEmp / $nilaiEvaluator
                        ]);
                }
                else {
                    \DB::table("emp_appraisal_value")
                        ->where('emp_number', $dataEvaluator->emp_evaluation)
                        ->where('period', '=', $appraisal_period->period)
                        ->update([
                            "hrd_value" => $nilaiSumEmp
                        ]);
                }
            }
        }

        // Ambil Data Appraisal Evaluator Atas Evaluator Tersebut
        $dataAppraisalEvaluators = \DB::table("emp_appraisal_evaluator")
            ->where("emp_number", $dataEvaluator->emp_evaluation)
            ->where("emp_evaluator", $dataEvaluator->emp_number)
            ->where('evaluator_as', $dataEvaluator->evaluator_status)
            ->get();

        // Simpan Semua Data Appraisal Evaluator Atas Evaluator Tersebut Ke Table Appraisal Evaluator Delete
        foreach($dataAppraisalEvaluators as $data) {
            \DB::table("emp_appraisal_evaluator_deleted")->insert([
                "id" => $data->id,
                "emp_number" => $data->emp_number,
                "emp_evaluator" => $data->emp_evaluator,
                "evaluator_as" => $data->evaluator_as,
                "appraisal_type_id" => $data->appraisal_type_id,
                "appraisal_value" => $data->appraisal_value,
                "period" => $data->period,
                "created_at" => $data->created_at,
                "updated_at" => $data->updated_at
            ]);
        }

        // Hapus Semua Data Appraisal Evaluator Atas Evaluator Tersebut
        \DB::table("emp_appraisal_evaluator")->where("emp_number", $dataEvaluator->emp_evaluation)->where("emp_evaluator", $dataEvaluator->emp_number)->where('evaluator_as', $dataEvaluator->evaluator_status)->delete();

        // Ganti Status Data Evaluator
        \DB::table("emp_evaluator")->where("id", $id)->update([
            "is_delete" => 1,
            "updated_by" => Session::get('userid'),
            "update_at" => $now
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Evaluator',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Evaluator, evaluator id '.$dataEvaluator->id.', employee number '.$dataEvaluator->emp_evaluation,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);

        \DB::commit();

        return redirect()->route('hrd.evaluator')->with("success", "Delete Evaluator Success");
    }

    public function setEvaluator(Request $request){
        $now = date("Y-m-d H:i:s");
        
        $cekDataEvaluation = $this->empEvaluator
                ->where('emp_number','=',$request->emp_number)
                ->where('emp_evaluation','=',$request->emp_evaluation)
                ->where('evaluator_status','=',$request->evaluator_status)
                ->where('is_delete','=',0)
                ->count();
     
        if ($cekDataEvaluation> 0)
        {
            return redirect()->route('hrd.evaluator')
                    ->withErrors(['error' => 'Process Fail, employee has been set, please check data in list']);
        }
        else
        {
            $this->empEvaluator->updateOrCreate(['id' => $request->id], [
                'emp_number' => $request->emp_number,
                'emp_evaluation' => $request->emp_evaluation,
                'evaluator_status' => $request->evaluator_status,
                'created_at' => $now,
                'created_by' => Session::get('userid')
            ]);
        }
        
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Evaluator',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Evaluator, evaluator id '.$request->id.', employee number '.$request->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return redirect()->route('hrd.evaluator');
    }

    public function organisasi(){
        $org = DB::table('hierarchical')
            ->leftJoin('hierarchical_detail', 'hierarchical.id', '=', 'hierarchical_detail.hierarchi_id')
            ->leftJoin('employee', 'hierarchical_detail.emp_number', '=', 'employee.emp_number')
            ->leftJoin('emp_picture', 'employee.emp_number', '=', 'emp_picture.emp_number')
            ->where('hierarchical.hierarchi_status', '1')
//            ->where('hierarchical_detail.is_active', '1')
            ->select('hierarchical.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname'
            , 'emp_picture.epic_picture')->get();
        return view('pages.organisasi.index', compact('org'));
    }
    
    public function organisasi1(){
//        $org = DB::table('hierarchical')
//            ->leftJoin('hierarchical_detail', 'hierarchical.id', '=', 'hierarchical_detail.hierarchi_id')
//            ->leftJoin('employee', 'hierarchical_detail.emp_number', '=', 'employee.emp_number')
//            ->leftJoin('emp_picture', 'employee.emp_number', '=', 'emp_picture.emp_number')
//            ->where('hierarchical.hierarchi_status', '1')
////            ->where('hierarchical_detail.is_active', '1')
//            ->select('hierarchical.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname'
//            , 'emp_picture.epic_picture')->get();
        return view('pages.organisasi.index1', compact('org'));
    }
    public function getEvaluator(Request $request){
        $now = date("Y-m-d H:i:s");
        $empApprTypes = $this->empEvaluator->join('employee', 'emp_evaluator.emp_number', '=', 'employee.emp_number')
            ->join('employee AS e', 'emp_evaluator.emp_evaluation', '=', 'e.emp_number')
            ->where('emp_evaluator.id', $request->id)
            ->select('emp_evaluator.*',
                    'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname',
                    'e.emp_firstname as firstname','e.emp_middle_name as middle_name','e.emp_lastname as lastname',
//                DB::raw("CONCAT([employee].[emp_firstname],' ', [employee].[emp_middle_name],' ', [employee].[emp_lastname]) AS sup_name"),
//                DB::raw("CONCAT(e.emp_firstname,' ', e.emp_middle_name,' ', e.emp_lastname) AS emp_name")
                 'employee.employee_id', 'e.employee_id as employee_id2')->first();
//        print_r($empApprTypes); die;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Evaluator',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Evaluator, evaluator id '.$request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return response()->json($empApprTypes);
    }
    public function getEvaluated(Request $request){
        $now = date("Y-m-d H:i:s");
        $arr = array(); $i = 0;
        $emp = $this->emp->join('emp_evaluator', 'employee.emp_number', '=', 'emp_evaluator.emp_evaluation')
            ->where('employee.termination_id','=',0)
            ->where('employee.emp_firstname', 'like', '%'.$request->emp_name.'%')
            ->whereOr('employee.emp_middle_name', 'like', '%'.$request->emp_name.'%')
            ->whereOr('employee.emp_lastname', 'like', '%'.$request->emp_name.'%')->get();
        foreach ($emp as $row){
            $arr[$i] = $row->emp_firstname.' '.$row->emp_middle_name.' '.$row->emp_lastname.'/'.$row->employee_id.'/'.$row->emp_number;
            $i++;
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Evaluated',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Evaluated, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return response()->json($arr);
    }
    public function getResult(Request $request){
        $now = date("Y-m-d H:i:s");
        $hasil = AprraisalResult::where('min_val', '<=', $request->result_val)->where('max_val', '>=', $request->result_val)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Result',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Result, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'appraisal_result'
        ]);
        
        return response()->json(['hasil' => $hasil->alpha_val]);
    }
    public function rekap(){
        $now = date("Y-m-d H:i:s");
        $emps = $this->emp->join('emp_appraisal_value', 'employee.emp_number', '=', 'emp_appraisal_value.emp_number')
            ->where('employee.termination_id','=',0)
            ->where('employee.pnum', Session::get('pnum'))->where('employee.ptype', Session::get('ptype'))
            ->select('employee.employee_id',
                DB::raw("CONCAT([employee].[emp_firstname],' ', [employee].[emp_middle_name],' ', [employee].[emp_lastname]) AS emp_name"),
                'emp_appraisal_value.*', 'employee.job_title_code'
            )->get();
//        foreach ($emps as $emp){
//            print_r("<pre>");
//            print_r($emp);
//            print_r("</pre>");
//        } die;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Rekap Appraisal',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Evaluator',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Rekap Appraisal, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_value'
        ]);
        
        return view('pages.manage.appraisals.rekap', compact('emps'));
    }

    public function printAppraisal($id, $id2) {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        $emp = $this->emp->where('emp_number', $id)->first();

        $id_evaluator = $id2;

        $emp_evaluator = $this->emp->where('emp_number', $id_evaluator)->first();

        $pic = DB::table('emp_picture')->where('emp_number', $id)->first();

        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $year = $project->appraisal_year_period;

        $code_appraisal = $this->empAppraisalType->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->select('appraisal_type.code_appraisal')
            ->where('emp_appraisal_type.emp_number', $id)->first();

        $appraisal_code = $code_appraisal["code_appraisal"];

        $appraisals = DB::select("
            SELECT a.factor, a.id
            FROM emp_appraisal_type et INNER JOIN appraisal_type ate
            ON et.appraisal_type_id = ate.id INNER JOIN appraisal a 
            ON ate.code_appraisal = a.type_code
            where et.emp_number = '".$id."'
        ");

        foreach($appraisals as $key => $data) {
            $val_appr = DB::select("
                SELECT ea.appraisal_value, ea.emp_evaluator,ea.appraisal_id,ea.appraisal_status
                FROM emp_appraisal ea
                WHERE ea.period = '".$year."' AND ea.emp_number = '".$id."' AND ea.emp_evaluator = '".$id_evaluator."' AND appraisal_id = '".$data->id."'
            ");

            $appraisals[$key]->val_appr = $val_appr;
        }

        $dataPunishment = DB::select("
            Select ISNULL(SUM(pns_score.score),0) as total_score
            from (
                Select a.sub_emp_number,a.emp_id,a.punish_type,b.job_title_code,isnull(c.score,0) as score
                from emp_punishment_request as a LEFT JOIN employee as b ON a.sub_emp_number = b.emp_number
                LEFT JOIN appraisal_stsp_score as c ON a.punish_type = c.punish_type_id AND  b.job_title_code = c.job_title_id
                where a.punish_status = 3
                and YEAR(hrd_approved_at) =  '$year'
            ) as pns_score
            where pns_score.sub_emp_number = '$id'
        ");

        $data_punishment = empty($dataPunishment[0]->total_score) ? 0 : ((float) $dataPunishment[0]->total_score);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Appraisal',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Appraisal, employee number '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_appraisal_type, appraisal_type, emp_appraisal, appraisal_value'
        ]);

        return view('pages.manage.appraisals.print_pa', compact('year', 'pic', 'emp', 'total','appraisals', 'id_evaluator', 'appraisal_code', 'emp_evaluator', 'data_punishment'));
    }

    public function AdjAppraisal() {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $dataLocation = \DB::table("location")->get();
        $dataDirOpsId = \DB::table("job_department")->whereIn('id', array(508,509,510,511,512))->get();
        
        $location_id = NULL;
        $dirops_dept_id = NULL;
        $periodYear = NULL;
        $appraisal_attach = NULL;

        $viewData = 0;

        $dataAppraisal = [];
        $param = [
            "location_id" => NULL,
            "dirops_dept_id" => NULL,
            "periodYear" => NULL
        ];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Adjust Appraisal',
            'module' => 'Appraisal',
            'sub_module' => 'Appraisal Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Adjust Appraisal' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_appraisal_value, employee'
        ]);
        
        return view('pages.manage.appraisals.adjustAppraisal', 
        compact('viewData','appraisal_attach','location_id','dirops_dept_id','periodYear','year','dataLocation','dataDirOpsId','dataAppraisal','param'));
    }

    public function viewAdjAppraisal(Request $request) {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        $dataLocation = \DB::table("location")->get();
        $dataDirOpsId = \DB::table("job_department")->whereIn('id', array(508,509,510,511,512))->get();

        $periodYear = $request->periodYear;

        $viewData = 1;

        //dd($request->all());

        $appraisal_attach = \DB::table("emp_appraisal_attachment")
            ->where('location_id','=',$request->location_id)
            ->where('period','=',$request->periodYear)
            ->get();

        $dataWhereDirOps = \DB::table("dirops_project")
                ->where('dirops_dept_id','=',$request->dirops_dept_id)
                ->whereNotIn('location_id', array(1))
                ->get();

        if(!empty($request->location_id)) {
            $dataWhereDirOps = \DB::table("dirops_project")
                ->where('dirops_dept_id','=',$request->dirops_dept_id)
                ->where('location_id','=',$request->location_id)
                ->get();

            $location_id = $request->location_id;

            $dataLocationByParam = \DB::table("location")->where("id", $request->location_id)->first();
            $location_name = $dataLocationByParam->name;
        }
        else {
            $dataWhereDirOps = \DB::table("dirops_project")
                ->where('dirops_dept_id','=',$request->dirops_dept_id)
                ->whereNotIn('location_id', array(1))
                ->get();
            
            $location_id = 0;

            $location_name = null;
        }

        if (!empty($request->dirops_dept_id)) {
            $dirops_dept_id = $request->dirops_dept_id;
        }
        else {
            $dirops_dept_id = 0;
        }

        if(empty($request->location_id) && empty($request->dirops_dept_id) &&
            empty($request->periodYear)) {
            $whereAnd = "";
        }
        else {
            $whereAnd = "AND";
        }

        if(!empty($request->location_id)) {
            if(empty($request->dirops_dept_id)) {
                $whereAnd .= " a.location_id = '".$request->location_id."' AND";
            }
        }

        // if(!empty($request->dirops_dept_id)) {
        //     if(!empty($request->location_id)) {
        //         foreach($dataWhereDirOps as $dirOps) {
        //             if($dirOps->location_id == 1) {
        //                 $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND ".$dirOps->division." AND";
        //             }
        //             else {
        //                 $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND";
        //             }
        //         }
        //     }
        //     else {
        //         $loc_id = '';
        //         $division = '';
        //         foreach($dataWhereDirOps as $dirOps) {
        //             if($dirOps->location_id <> 0) {
        //                 $loc_id .= $dirOps->location_id.",";
        //             }
        //             $division .= $dirOps->division;
        //         }
        //         $whereAnd .= " ((".$division.") OR a.location_id in (".substr($loc_id, 0, -1).")) AND";
        //     }
        // }

        if(!empty($request->periodYear)) {
            $whereAnd .= " h.period = '".$request->periodYear."' AND";
            $year = $request->periodYear;
        }

        $whereAnd = $whereAnd == "" ? $whereAnd : substr($whereAnd, 0, -4);
        // dd($whereAnd);
        $dataAppraisal = \DB::select("SELECT final_result.location_name,final_result.nik,final_result.emp_fullname,final_result.division,
                        final_result.department,final_result.employment_status,final_result.code_appraisal,final_result.nilai_awal,
                        final_result.item_pengurangan,
                        --(final_result.nilai_awal - final_result.item_pengurangan) as nilai_akhir,
                        final_result.period_year,final_result.count_evaluator,final_result.count_evaluator_submit,
                        final_result.count_eval_submit_draft,final_result.emp_number,final_result.final_value,
                        final_result.is_final,
                        (
                            CASE WHEN (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0) THEN 'Final' ELSE 'Not Final Yet' END
                        ) as status_appraisals,
                        final_result.job_title_code,final_result.job_title,final_result.joined_date
                        FROM (
                            SELECT b.name as location_name, a.employee_id as nik, a.emp_fullname, d.name as division, 
                            e.job_dept_desc as department, c.name as employment_status, ISNULL(g.code_appraisal,'-') as code_appraisal, 
                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                            ELSE 
                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                            END as nilai_awal, 
                            --0 as item_pengurangan, 
                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                            ELSE 
                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                            END as nilai_akhir, 
                            ISNULL(h.period,'-') as period_year,
                            (
                                SELECT COUNT(*)
                                FROM emp_evaluator AS ev
                                WHERE ev.emp_evaluation = a.emp_number
                                and ev.is_delete = 0
                            ) as count_evaluator,
                            (
                                SELECT COUNT(*)
                                FROM (
                                    SELECT COUNT(eapp1.emp_evaluator) as temp_count
                                    FROM emp_appraisal AS eapp1
                                    WHERE eapp1.emp_number = a.emp_number
                                    AND eapp1.period = h.period
                                    GROUP BY eapp1.emp_evaluator
                                ) as temp_count_submit
                            ) as count_evaluator_submit,
                            (
                                SELECT COUNT(*)
                                FROM emp_appraisal AS eapp
                                WHERE eapp.emp_number = a.emp_number
                                AND eapp.period = h.period
                                AND appraisal_status <> 2
                            ) as count_eval_submit_draft,
                            (
                                Select ISNULL(SUM(pns_score.score),0) as total_score
                                from (
                                    Select a.sub_emp_number,a.emp_id,a.punish_type,b.job_title_code,isnull(c.score,0) as score
                                    from emp_punishment_request as a LEFT JOIN employee as b ON a.sub_emp_number = b.emp_number
                                    LEFT JOIN appraisal_stsp_score as c ON a.punish_type = c.punish_type_id AND  b.job_title_code = c.job_title_id 
                                    where a.punish_status = 3
                                    and YEAR(hrd_approved_at) = $request->periodYear
                                ) as pns_score
                                where pns_score.sub_emp_number = a.emp_number
                            ) as item_pengurangan,a.emp_number,h.final_value,h.is_final,
                            i.job_title,a.job_title_code,a.joined_date
                            FROM employee AS a
                            LEFT JOIN location AS b ON a.location_id = b.id
                            LEFT JOIN employment_status AS c ON a.emp_status = c.id
                            LEFT JOIN job_category AS d ON a.eeo_cat_code = d.id
                            LEFT JOIN job_department AS e ON a.job_dept_id = e.id
                            LEFT JOIN emp_appraisal_type AS f ON a.emp_number = f.emp_number
                            LEFT JOIN appraisal_type AS g ON f.appraisal_type_id = g.id
                            LEFT JOIN emp_appraisal_value AS h ON a.emp_number = h.emp_number
                            LEFT JOIN job_title as i ON a.job_title_code = i.id
                            WHERE a.emp_status IN (1,2,5)
                            $whereAnd
                        ) as final_result
                        where (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0)
                        order by final_result.job_title_code DESC, final_result.joined_date ASC");

        foreach($dataAppraisal as $key => $data) {
            $dataAppraisal[$key]->nilai_akhir = $data->nilai_awal - $data->item_pengurangan;
        }
        
        $param = [
            "location_id" => $request->location_id,
            "location_name" => $location_name,
            "dirops_dept_id" => $request->dirops_dept_id,
            "periodYear" => $request->periodYear
        ];

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Appraisal',
            'module' => 'Report',
            'sub_module' => 'Appraisal Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Appraisal ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'location, job_department'
        ]);
        
        return view('pages.manage.appraisals.adjustAppraisal', 
        compact('viewData','appraisal_attach','location_id','dirops_dept_id','periodYear','year','dataLocation','dataDirOpsId','dataAppraisal','param'));
    }

    public function setAdjAppraisal(Request $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        
        $empAppraisal = DB::table('emp_appraisal_value')
            ->where('emp_number','=',$emp->emp_number)
            ->where('period','=',$request->period_year)
            ->first();

        try {
            \DB::beginTransaction();

            DB::table('emp_appraisal_value')
                ->where('id','=',$empAppraisal->id)
                ->update([
                    'final_value'=>$request->nilai_akhir
            ]);

            \DB::table('log_activity')->insert([
                'action' => 'Adjustment Appraisal',
                'module' => 'Appraisal',
                'sub_module' => 'Adjustment Appraisal',
                'modified_by' => Session::get('name'),
                'description' => 'NIK : '.$emp->employee_id.', Adjustment: '.$request->nilai_akhir.'. Submit By : ' . trim(Session::get('name')),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_appraisal_value'
            ]);

            \DB::commit();
        } catch (QueryException $ex) {
            \DB::rollback();
            return redirect('/hrd.AdjAppraisal')->withErrors(['error' => 'Failed save data, errmsg : ' . $ex]);
        }

        return redirect(route('hrd.AdjAppraisal'));
    }

    public function finalisasiAdj(Request $request) {
        $now = date("Y-m-d H:i:s");
        $dataFinalAdj = $request->all();
        $location = \DB::table("location")->where('id','=',$dataFinalAdj['location_id'])->first();
        
        $appraisal_attach = \DB::table("emp_appraisal_attachment")
            ->where('location_id','=',$request->location_id)
            ->where('period','=',$request->periodYear)
            ->get();

        try {
            \DB::beginTransaction();

            if($dataFinalAdj['selectall'] == 'all')
            {  
                if (count($dataFinalAdj['empid']) > 0)
                {
                    for($i=0;  $i < count($dataFinalAdj['empid']); $i++){
                        if ($dataFinalAdj['empid'][$i] > 0) {
                            $emp = $this->emp->where('emp_number', $dataFinalAdj['empid'][$i])->first();
        
                            $empAppraisal = DB::table('emp_appraisal_value')
                                ->where('emp_number','=',$dataFinalAdj['empid'][$i])
                                ->where('period','=',$dataFinalAdj['periodYear'])
                                ->first();
                                
                            DB::table('emp_appraisal_value')
                                ->where('id','=',$empAppraisal->id)
                                ->update([
                                    'is_final'=>1
                            ]);
        
                            \DB::table('log_activity')->insert([
                                'action' => 'Finalisasi Adjustment Appraisal',
                                'module' => 'Appraisal',
                                'sub_module' => 'Finalisasi Adjustment Appraisal',
                                'modified_by' => Session::get('name'),
                                'description' => 'NIK : '.$emp->employee_id.', Submit Finalisasi By : ' . trim(Session::get('name')),
                                'created_at' => $now,
                                'updated_at' => $now,
                                'table_activity' => 'emp_appraisal_value'
                            ]);
                        }
                    }
                }
            }
            else
            {
                if ($dataFinalAdj['employee'] == 0)
                {
                    return redirect()->route('hrd.AdjAppraisal')->with('error','Please Choose Document First....');
                }

                if (count($dataFinalAdj['empid']) > 0)
                {
                    for($i=0;  $i < count($dataFinalAdj['empid']); $i++){

                        $emp = $this->emp->where('emp_number', $dataFinalAdj['empid'][$i])->first();

                        $empAppraisal = DB::table('emp_appraisal_value')
                            ->where('emp_number','=',$dataFinalAdj['empid'][$i])
                            ->where('period','=',$dataFinalAdj['periodYear'])
                            ->first();
                            
                        DB::table('emp_appraisal_value')
                            ->where('id','=',$empAppraisal->id)
                            ->update([
                                'is_final'=>1
                        ]);

                        \DB::table('log_activity')->insert([
                            'action' => 'Finalisasi Adjustment Appraisal',
                            'module' => 'Appraisal',
                            'sub_module' => 'Finalisasi Adjustment Appraisal',
                            'modified_by' => Session::get('name'),
                            'description' => 'NIK : '.$emp->employee_id.', Submit Finalisasi By : ' . trim(Session::get('name')),
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_appraisal_value'
                        ]);
                    }
                }
            }

            if(empty($appraisal_attach)) {
                if($request->file('pdf_file')) {
                    $pdf_file = $request->file('pdf_file');
                    $ext = $pdf_file->getClientOriginalExtension();
    
                    if ($ext == 'pdf') {
                        if($pdf_file->getClientSize() == 0) {
                            return redirect()->route('hrd.AdjAppraisal')->with("error", "File size must be 2MB or less.");
                        }
                        else if ($pdf_file->getClientSize() <= 2 * 1024 * 1024) {
                            $fileName = pathinfo($pdf_file->getClientOriginalName(), PATHINFO_FILENAME) . " " . $now . "." . $ext;
                            $originalName = '/ATTC_APPRAISAL/'.$fileName;
        
                            Storage::disk('ftp_appraisal')->put($originalName, fopen($pdf_file, 'r'));
                        }
                        else {
                            return redirect()->route('hrd.AdjAppraisal')->with("error", "File size must be 2MB or less.");
                        }
                    }
                    else {
                        return redirect()->route('hrd.AdjAppraisal')->with("error", "Format File Must Be PDF!");
                    }
                }
                else {
                    return redirect()->route('hrd.AdjAppraisal')->with('error', "The Appraisal File Cannot Be Empty!");
                }

                if(empty($fileName)) {
                    return redirect()->route('hrd.AdjAppraisal')->with('error', "The Appraisal File Cannot Be Empty!");
                }

                \DB::table('emp_appraisal_attachment')->insert([
                    'location_id' => $dataFinalAdj['location_id'],
                    'period' => $dataFinalAdj['periodYear'],
                    'filename' => $fileName,
                    'created_at' => $now,
                    'created_by' => Session::get('name')
                ]);
    
                \DB::table('log_activity')->insert([
                    'action' => 'Upload Attachment Appraisal',
                    'module' => 'Appraisal',
                    'sub_module' => 'Adjustment Appraisal',
                    'modified_by' => Session::get('name'),
                    'description' => 'Project : '.$location->name.', Period: '.$dataFinalAdj['periodYear'].', Filename: '.$fileName.'. Submit By : ' . trim(Session::get('name')),
                    'created_at' => $now,
                    'updated_at' => $now,
                    'table_activity' => 'emp_appraisal_attachment'
                ]);
            }

            \DB::commit();
        } catch (\Exception $ex) {
            \DB::rollback();
            return redirect()->route('hrd.AdjAppraisal')->with('error', 'Failed save data, errmsg : ' . $ex->getMessage());
        }
        
        return redirect()->route('hrd.AdjAppraisal')->with("success", "Finalisasi Success");
    }

    // public function uploadAttachmentAdj(Request $request){
    //     $now = date("Y-m-d H:i:s");
    //     $location = \DB::table("location")->where('id','=',$request->location_id_upload)->first();
        
    //     $appraisal_attach = \DB::table("emp_appraisal_attachment")
    //         ->where('location_id','=',$request->location_id_upload)
    //         ->where('period','=',$request->periodYearUpload)
    //         ->get();

    //     if(empty($request->location_id_upload) || empty($request->periodYearUpload) || empty($request->file('pdf_file'))) {
    //         return redirect()->route('hrd.AdjAppraisal')->with("error", "Lengkapi Form Upload dengan Benar");
    //     }

    //     if(!empty($appraisal_attach)) {
    //         return redirect()->route('hrd.AdjAppraisal')->with("error", "File Already Exist for Project ".$location->name." Period ".$request->periodYearUpload);
    //     }

    //     try {
    //         \DB::beginTransaction();

    //         if($request->file('pdf_file')) {
    //             $pdf_file = $request->file('pdf_file');
    //             $ext = $pdf_file->getClientOriginalExtension();

    //             if ($ext == 'pdf') {
    //                 $fileName = pathinfo($pdf_file->getClientOriginalName(), PATHINFO_FILENAME) . " " . $now . "." . $ext;
    //                 $originalName = '/ATTC_APPRAISAL/'.$fileName;
    
    //                 Storage::disk('ftp_appraisal')->put($originalName, fopen($pdf_file, 'r'));
    //             }
    //             else {
    //                 return redirect()->route('hrd.AdjAppraisal')->with("error", "Format File Must Be PDF!");
    //             }
    //         }
            
    //         \DB::table('emp_appraisal_attachment')->insert([
    //             'location_id' => $request->location_id_upload,
    //             'period' => $request->periodYearUpload,
    //             'filename' => $fileName,
    //             'created_at' => $now,
    //             'created_by' => Session::get('name')
    //         ]);

    //         \DB::table('log_activity')->insert([
    //             'action' => 'Upload Attachment Appraisal',
    //             'module' => 'Appraisal',
    //             'sub_module' => 'Adjustment Appraisal',
    //             'modified_by' => Session::get('name'),
    //             'description' => 'Project : '.$location->name.', Period: '.$request->periodYearUpload.', Filename: '.$fileName.'. Submit By : ' . trim(Session::get('name')),
    //             'created_at' => $now,
    //             'updated_at' => $now,
    //             'table_activity' => 'emp_appraisal_attachment'
    //         ]);

    //         \DB::commit();
    //     } catch (QueryException $ex) {
    //         \DB::rollback();
	// 		return redirect()->route('hrd.AdjAppraisal')->with('errorFailed', 'Failed save data, errmsg : ' . $ex);
    //     }

    //     return redirect()->route('hrd.AdjAppraisal')->with("success", "Upload File Appraisal Success");
    // }

    public function downloadFileAttachmentAdj($emp_appraisal_attch_id) {
        $dataAttach = \DB::table("emp_appraisal_attachment")->where("emp_appraisal_attch_id", $emp_appraisal_attch_id)->first();

        $fileName = basename($dataAttach->filename);

        $filecontent = Storage::disk('ftp_appraisal')->get('/ATTC_APPRAISAL/'.$fileName);
        return Response::make($filecontent, '200', array(
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename="'.$fileName.'"'
        ));
    }
}
