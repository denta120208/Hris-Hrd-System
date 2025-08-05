<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;
use Session, DB, Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee, App\Models\Recruitment\JobVacancy;

class EmpRecruitmentController extends Controller{
    protected $emp;
    protected $vacan;
    public function __construct(Employee $emp, JobVacancy $vacan){
        $this->emp = $emp;
        $this->vacan = $vacan;
        parent::__construct();
    }
    public function index(){
        $now = date("Y-m-d H:i:s");
        $vacans = $this->vacan->where('created_by', Session::get('name'))->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Employee Recruitment',
            'module' => 'Recruitment',
            'sub_module' => 'View Employee Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'View Employee Recruitment',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return view('pages.recruitment.index', compact('vacans'));
    }
    public function getReqVacan(Request $request){
        $now = date("Y-m-d H:i:s");
        $vacancy = $this->vacan->where('id', $request->id)->where('vacancy_status', '1')->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Request Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Request Vacancy',
            'modified_by' => Session::get('name'),
            'description' => 'Get Request Vacancy, id '. $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return response()->json($vacancy);
    }
    public function setReqVacan(Request $request){
        $now = date("Y-m-d H:i:s");
        $this->vacan->updateOrCreate(
            ['id' => $request->id, 'vacancy_status' => '1'],
            [
                'job_title_code' => $request->job_title_code,
                'name' => $request->name,
                'description' => $request->description,
                'no_of_positions' => $request->no_of_positions,
                'dept_id' => $request->dept_id,
                'location_id' => $request->location_id,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => Session::get('name')
            ]
        );
        
        \DB::table('log_activity')->insert([
            'action' => 'Set Request Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Request Vacancy',
            'modified_by' => Session::get('name'),
            'description' => 'Set Request Vacancy, id '. $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return redirect(route('recruitment'));
    }
    public function show($id){
        $now = date("Y-m-d H:i:s");
        $vacancy = $this->vacan->where('id', $id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Show Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Request Vacancy',
            'modified_by' => Session::get('name'),
            'description' => 'Show Request Vacancy, id '. $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return view('pages.recruitment.view', compact('vacancy'));
    }
}
