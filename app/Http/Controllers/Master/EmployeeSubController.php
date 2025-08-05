<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session;
use App\Models\Master\Employee, App\Models\Master\EmergencyContact, App\Models\Master\Dependents;
use App\Models\Master\JobMaster, App\Models\Master\Qualification, App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation, App\Models\Master\Reward, App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion;

class EmployeeSubController extends Controller{
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
    public function __construct(Employee $emp, EmergencyContact $eec, Dependents $ed, JobMaster $job,
                                Qualification $qlt, EmployeeTranning $train, EmpEducation $edu,
                                Reward $reward, EmpReward $eReward, EmpPromotion $ePromot){
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
        parent::__construct();
    }

    public function listSub(Employee $emp){
//        dd(session()->all());
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//        dd($emp->emp_number);
        $subs = DB::table('emp_reportto')
            ->leftJoin('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
            ->leftJoin('emp_picture', 'emp_reportto.erep_sub_emp_number', '=','emp_picture.emp_number')
            ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('employee.termination_id','=',0)
            ->select('emp_reportto.id', 'emp_picture.epic_picture','employee.employee_id','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname'
                ,'employee.job_title_code','employee.joined_date','employee.emp_number','emp_picture.epic_picture_type'
            )->get();
//        dd($subs);
        
        \DB::table('log_activity')->insert([
            'action' => 'View List Employee Sub',
            'module' => 'Master',
            'sub_module' => 'List Employee Sub',
            'modified_by' => Session::get('name'),
            'description' => 'View List Employee Sub ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.personal.subordinate.index', compact('emp', 'subs'));
    }
    public function detailSub($id){
        $emp = $this->emp->where('employee_id', $id);
        return view('pages.emps.detail', compact('emp'));
    }
    public function empPersonal(){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
        $class = 'active';
        return view('pages.personal.employee.index', compact('emp','pic', 'class'));
    }
    public function getPersonal($id){
        $emp = $this->emp->where('emp_number', $id)->first();
//        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
        return view('partials.employee.personal.personal', compact('emp'));
    }
    public function getContact($id){
        $emp = $this->emp->where('emp_number', $id)->first();
        $eds = $this->ed->where('emp_number', $id)->orderBy('ed_seqno')->get();
        return view('partials.employee.personal.contact', compact('emp','eds'));
    }
    public function setContact(Request $request){
        $this->emp->where('emp_number', $request->emp_number)->update([
            'emp_street1' => $request->emp_street1,
            'emp_street2' => $request->emp_street2,
            'city_code' => $request->city_code,
            'provin_code' => $request->provin_code,
            'emp_zipcode' => $request->emp_zipcode,
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
        return redirect('personal');
    }
    public function getErContact(Request $request){
        $ed = $this->ed->where('emp_number', $request->id)->orderBy('ed_seqno')->first();
        return response()->json($ed);
    }
    public function getEmergencyDtl(Request $request){
        $eec = $this->eec->where('id', $request->id)->first();
        return response()->json($eec);
    }
    public function setEmergencyDtl(Request $request){
        $eec = $this->eec->updateOrCreate(['id' => $request->id],
            ['eec_name' => $request->eec_name,
                'eec_relationship' => $request->eec_relationship,
                'eec_home_no' => $request->eec_home_no,
                'eec_mobile_no' => $request->eec_mobile_no,
                'eec_office_no' => $request->eec_office_no
            ]);
//        return response()->json($eec);
        return redirect('personal');
    }
    public function getJob($id){
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
        return view('partials.employee.personal.job', compact('emp', 'location', 'contract','reports','subs'));
    }
    public function getReportToDtl(Request $request){// HRD
        $rtt = DB::table('emp_reportto')->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.id', $request->id)
            ->select('emp_reportto.erep_reporting_mode','emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->first();
        return response()->json($rtt);
    }
    public function setReportTo(Request $request){

    }
    public function viewContract($id){
        $attach = DB::table('emp_attachment')->where('emp_number', $id)->first();
        header("Content-type: $attach->eattach_type");
        header("Content-length: $attach->eattach_size");
        header("Content-Disposition: attachment; filename=$attach->eattach_filename");
        header("Content-Description: PHP Generated Data");
        ob_clean();
        flush();
        echo $attach->eattach_attachment;
    }
    public function getQualifications($id){
        $emp = $this->emp->where('emp_number', $id)->first();
        $quali = $this->qlt->where('emp_number', $id)->orderBy('eexp_seqno')->get();
        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->get();
        return view('partials.employee.personal.qualification', compact('emp', 'quali', 'trains', 'edus'));
    }
    public function getReportTo($id){
        $emp = $this->emp->where('emp_number', $id)->first();
        $reports = DB::table('emp_reportto')->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sub_emp_number',$id)
            ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        return view('partials.employee.personal.reportto', compact('emp', 'reports'));
    }
    public function getEmergency($id){
        $eec = $this->eec->where('emp_number', $id)->orderBy('eec_seqno')->get();
        return view('partials.employee.personal.eec', compact('eec'));
    }
    public function getDependents($id){
        $eds = $this->ed->where('emp_number', $id)->orderBy('ed_seqno')->get();
        return view('partials.employee.personal.dependent', compact('eds'));
    }
    public function setDependents(Request $request){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $this->ed->create([
            'emp_number' => $emp->emp_number,
            'ed_name' => $request->ed_name,
            'ed_relationship' => $request->ed_relationship,
            'ed_date_of_birth' => $request->ed_date_of_birth
        ]);
        return redirect('personal');
    }
    public function setEducation(Request $request){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $this->edu->create([
            'emp_number' => $emp->emp_number,
            'education_id' => $request->education_id,
            'institute' => $request->institute,
            'major' => $request->major,
            'year' => $request->year,
            'score' => $request->score,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);
        return redirect('personal');
    }
    public function setWork(Request $request){
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
        return redirect('personal');
    }
    public function getReward($id){
        $emp = $this->emp->where('emp_number', $id)->first();
        $eRewards = $this->eReward->where('emp_number', $id)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('emp_number', $id)->where('promo_pnum', Session::get('pnum'))
        ->where('promo_ptype', Session::get('ptype'))->orderBy('id')->get();
        return view('partials.employee.personal.reward', compact('emp','eRewards','ePromots'));
    }
    public function setTrain(Request $request){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
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
        return redirect('personal');
    }
}