<?php

namespace App\Http\Controllers\HRD\Recruitment;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session, Validation, DB, Log;
use App\Http\Controllers\Controller;
use App\Models\Recruitment\JobVacancy, App\Models\Recruitment\JobVacancyAttachment, App\Models\Recruitment\JobCandidateVacancy, App\Models\Recruitment\JobCandidate;


class RecruitmentController extends Controller{
    protected $jv;
    protected $jva;
    protected $jc;
    protected $jcv;
    public function __construct(JobVacancy $jv, JobVacancyAttachment $jva, JobCandidateVacancy $jcv, JobCandidate $jc){
        $this->jv = $jv;
        $this->jva = $jva;
        $this->jcv = $jcv;
        $this->jc = $jc;
        parent::__construct();
    }
    public function index(){
        $now = date('Y-m-d H:i:s');
        $jobVacan = $this->jv->where('id', '<=', '2')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Recruitment Index',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Recruitment Index,' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return view('pages.manage.recruitment.index', compact('jobVacan'));
    }
    public function create(JobVacancy $jvs){
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Create Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Create Vacancy, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return view('pages.manage.recruitment.formVacan', compact('jvs'));
    }
    public function store(Request $request){
        $now = date('Y-m-d H:i:s');
        $this->jv->create([
            'vacancy_status' => '1',
            'job_title_code' => $request->job_title_code,
            'name' => $request->name,
            'description' => $request->description,
            'no_of_positions' => $request->no_of_positions,
            'dept_id' => $request->dept_id,
            'location_id' => $request->location_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Session::get('name')
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Store Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Store Vacancy, vacancy name '.$request->name,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return redirect(route('hrd.recruitment'));
    }
    public function show($id){
        $now = date('Y-m-d H:i:s');
        $jobVacan = $this->jv->where('id', $id)->first();
        $jobCandidate = $this->jcv->where('vacancy_id', $id)->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Show Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Show Vacancy, vacancy id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy, job_candidate_vacancy'
        ]);
        
        return view('pages.manage.recruitment.show', compact('jobVacan', 'jobCandidate'));
    }
    public function edit($id){
        $now = date('Y-m-d H:i:s');
        $jvs = $this->jv->where('vacancy_status', $id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Edit Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Edit Vacancy, vacancy id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return view('pages.manage.recruitment.formVacan', compact('jvs'));
    }
    public function update(Request $request, $id){
        $now = date('Y-m-d H:i:s');
        $jvs = $this->jv->findOrFail($id);
        $jvs->fill([
            'job_title_code' => $request->job_title_code,
            'name' => $request->name,
            'description' => $request->description,
            'no_of_positions' => $request->no_of_positions,
            'dept_id' => $request->dept_id,
            'location_id' => $request->location_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Session::get('name')
        ]);
        $jvs->save();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Update Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Update Vacancy, vacancy id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return redirect(route('hrd.recruitment'));
    }
    public function destroy($id){
        //
    }
    public function getVacan(Request $request){
        $now = date('Y-m-d H:i:s');
        $vacancy = $this->jv->where('id', $request->id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Vacancy',
            'module' => 'Recruitment',
            'sub_module' => 'Recruitment',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Vacancy, vacancy id '. $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_vacancy'
        ]);
        
        return response()->json($vacancy);
    }
}
