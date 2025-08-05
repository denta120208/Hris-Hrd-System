<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session;
use App\Models\Master\Employee, App\Models\Master\EmergencyContact, App\Models\Master\Dependents;
use App\Models\Master\JobMaster, App\Models\Master\Qualification, App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation, App\Models\Master\Reward, App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion, App\Models\Punishments\PunishmentRequest;

class EmployeeController extends Controller{
    protected $emp;
    protected $eec;
    protected $ed;
    protected $job;
    protected $qlt;
    protected $train;
    protected $edu;
    protected $reward;
    protected $eReward;
    protected $ePromot;
    protected $pReq;
    public function __construct(Employee $emp, EmergencyContact $eec, Dependents $ed, JobMaster $job,
                                Qualification $qlt, EmployeeTranning $train, EmpEducation $edu,
                                Reward $reward, EmpReward $eReward, EmpPromotion $ePromot, PunishmentRequest $pReq){
        $this->emp = $emp;
        $this->eec = $eec;
        $this->ed = $ed;
        $this->job = $job;
        $this->qlt = $qlt;
        $this->train = $train;
        $this->edu = $edu;
        $this->reward = $reward;
        $this->eReward = $eReward;
        $this->ePromot = $ePromot;
        $this->pReq = $pReq;
        parent::__construct();
    }

    public function listEmp(Employee $emp){

        return view('pages.emps.list', compact('emp'));
    }
    public function detailEmp($id){
        $emp = $this->emp->where('employee_id', $id);
        return view('pages.emps.detail', compact('emp'));
    }
    public function addEmp(){
        //
    }
    function storeEmp(Request $request){
        //
    }
    public function empPersonal(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
        $termination_reason = DB::table('termination_reason')->get();
        $emp_termination_status_3 = DB::table('emp_termination')->where('emp_number', $emp->emp_number)->where('status',3)->first();
        $emp_termination_status_1_2 = $emp_termination_3 = DB::table('emp_termination')->where(['emp_number' => $emp->emp_number,'status' => 1])->orWhere(['emp_number' => $emp->emp_number,'status' => 2])->first();
        $termination_exist = false;
        if(isset($emp_termination_status_1_2)){
            $termination_exist = true;
        }
        $termination_upload = false;
        if(isset($emp_termination_status_3)){
            $termination_upload = true;
        }
        if($emp->termination_id){
            return redirect(route('dashboard'))->with('status', 'Employee has been terminated');
        }
        $class = 'active';
        
        \DB::table('log_activity')->insert([
            'action' => 'View Master Personal',
            'module' => 'Master',
            'sub_module' => 'View Master Personal',
            'modified_by' => Session::get('name'),
            'description' => 'View Master Personal ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.personal.employee.index', 
                compact('emp','pic','class',
                        'termination_reason',
                        'termination_exist',
                        'termination_upload'
                    ));
    }
    public function setPersonal(Request $request){
        $now = date("Y-m-d H:i:s");
        
        \DB::table('employee')->where('emp_number', $request->emp_number)->update([
//        $this->emp->where('emp_number', $request->emp_number)->update([
            'emp_lastname' => $request->emp_lastname,
            'emp_firstname' => $request->emp_firstname,
            'emp_middle_name' => $request->emp_middle_name,
            'emp_ktp' => $request->emp_ktp,
            'emp_gender' => $request->emp_gender,
            'nation_code' => $request->nation_code,
            'emp_dri_lice_num' => $request->emp_dri_lice_num,
            'emp_dri_lice_exp_date' => $this->date_convert($request->emp_dri_lice_exp_date),
            'emp_marital_status' => $request->emp_marital_status,
            'emp_birthday' => $this->date_convert($request->emp_birthday),
            'bpjs_ks' => $request->bpjs_ks,
            'bpjs_tk' => $request->bpjs_tk,
            'npwp' => $request->npwp,
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update personal detail' . $request->emp_firstname.' '.$request->emp_middle_name.' '.$request->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect('personal');
    }
    public function getPersonal($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
//        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Personal Detail',
            'module' => 'Master',
            'sub_module' => 'Personal Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get personal detail ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return view('partials.employee.personal.personal', compact('emp'));
    }
    public function getContact($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $eds = $this->ed->where('emp_number', $id)->orderBy('ed_seqno')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Contact Detail',
            'module' => 'Master',
            'sub_module' => 'Personal Contact Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get contact detail ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_dependents'
        ]);
        
        return view('partials.employee.personal.contact', compact('emp','eds'));
    }
    public function setContact(Request $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        \DB::table('employee')->where('emp_number', $request->emp_number)->update([
//        $this->emp->where('emp_number', $request->emp_number)->update([
            'emp_street1' => $request->emp_street1,
            'emp_street2' => $request->emp_street2,
            'city_code' => $request->city_code,
            'provin_code' => $request->provin_code,
            'emp_zipcode' => $request->emp_zipcode,
            'city_code_res' => $request->city_code_res,
            'provin_code_res' => $request->provin_code_res,
            'emp_zipcode_res' => $request->emp_zipcode_res,
            'coun_code' => $request->coun_code,
            'emp_hm_telephone' => $request->emp_hm_telephone,
            'emp_mobile' => $request->emp_mobile,
            'emp_work_telephone' => $request->emp_work_telephone,
            'emp_work_email' => $request->emp_work_email,
            'emp_oth_email' => $request->emp_oth_email,
            'agama' => $request->agama,
            'emp_mobile2' => $request->emp_mobile2,
            'emp_facebook' => $request->emp_facebook,
            'emp_twitter' => $request->emp_twitter,
            'emp_instagram' => $request->emp_instagram
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update contact detail' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    public function getErContact(Request $request){
        $now = date("Y-m-d H:i:s");
        $ed = $this->ed->where('emp_number', $request->id)->orderBy('ed_seqno')->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Er Contact Detail',
            'module' => 'Master',
            'sub_module' => 'Er Contact',
            'modified_by' => Session::get('name'),
            'description' => 'Get er contact ' . $ed->ed_name.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_dependents'
        ]);
        
        return response()->json($ed);
    }
    public function getEmergencyDtl(Request $request){
        $now = date("Y-m-d H:i:s");
        $eec = $this->eec->where('id', $request->id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Emergency Contact Detail',
            'module' => 'Master',
            'sub_module' => 'Emergency Contact Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get Emergency Contact Detail ' . $eec->eec_name.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return response()->json($eec);
    }
    public function setEmergencyDtl(Request $request){
        $now = date("Y-m-d H:i:s");
        
        //$dataEmp = $this->emp->where('emp_number', $request->emp_number)->first();
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        $this->eec->updateOrCreate(['id' => $request->id],
            ['emp_number' => $emp->emp_number,
                'eec_name' => $request->eec_name,
                'eec_relationship' => $request->eec_relationship,
                'eec_home_no' => $request->eec_home_no,
                'eec_mobile_no' => $request->eec_mobile_no,
                'eec_office_no' => $request->eec_office_no
            ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update emergency contact' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
//        return response()->json($eec);
        return redirect('personal');
    }
    
    public function deleteEmergency($id){
        $now = date("Y-m-d H:i:s");
        
        // Soft delete - change is_delete from 0 to 1
        $this->eec->where('id',$id)->update(['is_delete' => 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete emergency contact id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function getJob($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $location = DB::table('location')->where('id', $emp->location_id)->first();
        $contract = DB::table('emp_contract')->join('emp_attachment', 'emp_contract.econ_extend_id', '=', 'emp_attachment.eattach_id')
            ->where('emp_contract.emp_number', $emp->emp_number)
            ->where('emp_attachment.emp_number', $emp->emp_number)
            ->select('emp_contract.econ_extend_start_date','emp_contract.econ_extend_end_date','emp_attachment.eattach_attachment'
                ,'emp_attachment.eattach_filename','emp_attachment.eattach_type','emp_attachment.eattach_size')->first();
        $reports = DB::table('emp_reportto')
            ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sub_emp_number',$id)
            ->select('emp_reportto.id','emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        $subs = DB::table('emp_reportto')
            ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sub_emp_number',$id)
            ->select('emp_reportto.id','emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
//        dd($contract);
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Job Detail',
            'module' => 'Master',
            'sub_module' => 'Job Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get Job Detail ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('partials.employee.personal.job', compact('emp', 'location', 'contract','reports','subs'));
    }
    public function getReportToDtl(Request $request){// HRD
        $now = date("Y-m-d H:i:s");
        $rtt = DB::table('emp_reportto')->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.id', $request->id)
            ->select('emp_reportto.erep_reporting_mode','emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Report To Detail',
            'module' => 'Master',
            'sub_module' => 'Report To Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get Report To ' . $rtt->emp_firstname.' '.$rtt->emp_middle_name.' '.$rtt->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return response()->json($rtt);
    }
    public function setReportTo(Request $request){

    }
    public function viewContract($id){
        $now = date("Y-m-d H:i:s");
        $attach = DB::table('emp_attachment')->where('emp_number', $id)->first();
        header("Content-type: $attach->eattach_type");
        header("Content-length: $attach->eattach_size");
        header("Content-Disposition: attachment; filename=$attach->eattach_filename");
        header("Content-Description: PHP Generated Data");
        ob_clean();
        flush();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Contract',
            'module' => 'Master',
            'sub_module' => 'Contract',
            'modified_by' => Session::get('name'),
            'description' => 'File name ' . $attach->eattach_filename.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        echo $attach->eattach_attachment;
    }
    public function getQualifications($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $quali = $this->qlt->where('emp_number', $id)->orderBy('eexp_seqno')->get();
        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->get();
//        $edus = DB::table('emp_education')
//                ->join('education', 'emp_education.education_id', '=','education.id')
//                ->where('emp_number', $id)
//                ->get();

        
        \DB::table('log_activity')->insert([
            'action' => 'Get Qualifications',
            'module' => 'Master',
            'sub_module' => 'Qualifications',
            'modified_by' => Session::get('name'),
            'description' => 'Get Qualifications ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_trainning, emp_trainning, emp_work_experience'
        ]);
        
        return view('partials.employee.personal.qualification', compact('emp', 'quali', 'trains', 'edus'));
    }
    public function getReportTo($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $reports = DB::table('emp_reportto')->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sub_emp_number',$id)
            ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Report To',
            'module' => 'Master',
            'sub_module' => 'Report To',
            'modified_by' => Session::get('name'),
            'description' => 'Get Report To ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto'
        ]);
        return view('partials.employee.personal.reportto', compact('emp', 'reports'));
    }
    public function getEmergency($id){
        $eec = $this->eec->where('emp_number', $id)->orderBy('eec_seqno')->get();
        return view('partials.employee.personal.eec', compact('eec'));
    }
    public function getDependents($id){
        $now = date("Y-m-d H:i:s");
        $eds = $this->ed->where('emp_number', $id)->orderBy('ed_seqno')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Dependents',
            'module' => 'Master',
            'sub_module' => 'Get Dependents',
            'modified_by' => Session::get('name'),
            'description' => 'Get Dependents, accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return view('partials.employee.personal.dependent', compact('eds'));
    }
    public function setDependent(Request $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        $this->ed->create([
            'emp_number' => $emp->emp_number,
            'ed_name' => $request->ed_name,
            'ed_relationship' => $request->ed_relationship,
            'ed_date_of_birth' => $request->ed_date_of_birth
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'create dependent of ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function getDependentsDtl(Request $request){
        $now = date("Y-m-d H:i:s");
        $ed = $this->ed->where('id', $request->id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Emergency Contact Detail',
            'module' => 'Master',
            'sub_module' => 'Emergency Contact Detail',
            'modified_by' => Session::get('name'),
            'description' => 'Get Emergency Contact Detail ' . $ed->ed_name.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return response()->json($ed);
    }
    
    public function setDependentsDtl(Request $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        $this->ed->where('id',$request->id)->update([
            'ed_name' => $request->ed_name_edit,
            'ed_relationship' => $request->ed_relationship_edit,
            'ed_date_of_birth' => $request->ed_date_of_birth_edit
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update dependent of ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function deleteDependent($id){
        $now = date("Y-m-d H:i:s");
        
        // Soft delete - change is_delete from 0 to 1
        $this->ed->where('id',$id)->update(['is_delete' => 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete dependent id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function setEducation(Requests\Employee\AddEducation $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        if($request->education_id == 0){
            return back()->withErrors(['error' => 'Education level cannot be empty!']);
        }
        
        if($request->year == null){
            $request->year = 0;
        }
        
        $this->edu->create([
            'emp_number' => $emp->emp_number,
            'education_id' => $request->education_id,
            'institute' => $request->institute,
            'major' => $request->major,
            'year' => $request->year,
            'score' => $request->score,
            'start_date' => $this->date_convert($request->start_date),
            'end_date' => $this->date_convert($request->end_date)
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update education' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal')->with('status', 'Education has been added');
    }
    
    public function deleteEducation($id){
        $now = date("Y-m-d H:i:s");
        
        // Soft delete - change is_delete from 0 to 1
        $this->edu->where('id',$id)->update(['is_delete' => 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete education id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function setWork(Requests\Employee\AddWork $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        $this->qlt->create([
            'emp_number' => $emp->emp_number,
            'eexp_employer' => $request->eexp_employer,
            'eexp_jobtit' => $request->eexp_jobtit,
            'eexp_from_date' => $request->eexp_from_date,
            'eexp_from_date' => $request->eexp_from_date,
            'eexp_to_date' => $request->eexp_to_date,
            'eexp_comments' => $request->eexp_comments
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update work experience ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect('personal')->with('status', 'Work experience has been added');
    }
    
    public function deleteWork($id){
        $now = date("Y-m-d H:i:s");
        
        // Soft delete - change is_delete from 0 to 1
        $this->qlt->where('id',$id)->update(['is_delete' => 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete work experience id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal');
    }
    
    public function getReward($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $eRewards = $this->eReward->where('emp_number', $id)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('emp_number', $id)->where('promo_pnum', Session::get('pnum'))
        ->where('promo_ptype', Session::get('ptype'))->orderBy('id')->get();
        $pReqs = $this->pReq->where('sub_emp_number', $id)->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Reward',
            'module' => 'Master',
            'sub_module' => 'Reward',
            'modified_by' => Session::get('name'),
            'description' => 'Get Reward ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('partials.employee.personal.reward', compact('emp','eRewards','ePromots','pReqs'));
    }
    public function setTrain(Request $request){
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//        print_r('<pre>');
//        print_r($emp);
//        print_r('</pre>'); die;
        $this->train->updateOrCreate(
            ['id' => $request->idTrain, 'emp_number' => $emp->emp_number],
            [
                'train_name' => $request->train_name,
                'license_no' => $request->license_no,
                'license_issued_date' => $request->license_issued_date,
                'license_expiry_date' => $request->license_expiry_date,
                'pnum' => Session::get('pnum'),
                'ptype' => Session::get('ptype')
            ]
        );
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update training  ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect('personal');
    }

    public function getSalary($id){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Salary',
            'module' => 'Master',
            'sub_module' => 'Salary',
            'modified_by' => Session::get('name'),
            'description' => 'Get Salary ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.salary.index', compact('emp'));
    }
    public function downSalary(Request $request){
        $now = date("Y-m-d H:i:s");
        $month_year = explode('-', $request->month);
        $month = $month_year[0];
        $year = $month_year[1];
        $pdf_file = str_replace('/', 'x', crypt($request->emp, $month.''.$year));

        $filePath = 'http://payroll.metropolitanland.com/upload/pdf/'.$pdf_file.'.pdf';
        $filename = $pdf_file.'.pdf';
        $fileContent = file_get_contents($filePath);
        $response = response($fileContent, 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Download Salary',
            'module' => 'Master',
            'sub_module' => 'Salary',
            'modified_by' => Session::get('name'),
            'description' => 'Download Salary , accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        return $response;
    }

    public function getEducation($id) {
        $edu = $this->edu->where('id', $id)->first();
        return response()->json($edu);
    }

    public function updateEducation(Request $request) {
        $now = date("Y-m-d H:i:s");
        
        if($request->education_id == 0){
            return back()->withErrors(['error' => 'Education level cannot be empty!']);
        }
        
        if($request->year == null){
            $request->year = 0;
        }
        
        $this->edu->where('id', $request->id)->update([
            'education_id' => $request->education_id,
            'institute' => $request->institute,
            'major' => $request->major,
            'year' => $request->year,
            'score' => $request->score,
            'start_date' => $this->date_convert($request->start_date),
            'end_date' => $this->date_convert($request->end_date)
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'update education id '.$request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect('personal')->with('status', 'Education has been updated');
    }
}
