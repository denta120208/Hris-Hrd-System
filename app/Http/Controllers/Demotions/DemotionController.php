<?php

namespace App\Http\Controllers\Demotions;

use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use App\Models\Master\JobMaster, App\Models\Demotions\Demotion;
use App\Models\Demotions\DemotionRequest;
use App\Models\Master\TemplateContract;
use App\Models\Punishments\PunishmentStatus;
use App\User;
use Illuminate\Http\Request;
use Session,DB;

class DemotionController extends Controller{
    protected $emp;
    protected $demotion;
    protected $dReq;
    protected $dStat;
    protected $job_title;
    public function __construct(Employee $emp, Demotion $demotion, DemotionRequest $dReq, PunishmentStatus $dStat, JobMaster $job_title){
        $this->emp = $emp;
        $this->demotion = $demotion;
        $this->dReq = $dReq;
        $this->dStat = $dStat;
        $this->job_title = $job_title;
        parent::__construct();
    }
    public function index(){
        $now = date("Y-m-d H:i:s");
        $requests = $this->dReq->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Demotion Index',
            'module' => 'Demotion',
            'sub_module' => 'View Demotion Index',
            'modified_by' => Session::get('name'),
            'description' => 'View Demotion Index',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_demotion_request'
        ]);
        return view('pages.demotion.index', compact('requests'));
    }
    public function addDemote(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $emps = DB::table('emp_reportto')
            ->join('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
            ->where('employee.termination_id','=',0)
            ->select('emp_reportto.id','emp_reportto.erep_sub_emp_number',
                'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Add Demotion',
            'module' => 'Demotion',
            'sub_module' => 'View Add Demotion',
            'modified_by' => Session::get('name'),
            'description' => 'View Add Demotion, '. $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto'
        ]);
        return view('pages.demotion.form', compact('emps', 'emp'));
    }
    public function saveDemotion(Request $request){
        $now = date("Y-m-d H:i:s");
        $bulan = date('m');
        $tahun = date('Y');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $ctr = DB::table('counter_doc')->first();
        $doc_no = $ctr->counter.'/SK/METLAND/DMS/'.$bulan.'/'.$tahun;
        $demotion = $this->dReq->create([
            'sub_emp_number' => $request->sub_emp_number,
            'sup_emp_number' => $emp->emp_number,
            'demo_status' => 2,
            'demo_reason' => $request->demo_reason,
            'demo_from_level' => $request->demo_from,
            'demo_to_level' => $request->demo_to,
            'created_at' => $now,
            'created_by' => Session::get('username'),
            'template_id' => '4',
        ]);
        $this->demotion->create([
            'demo_request_id' => $demotion->id,
            'demo_doc_no' => $doc_no,
            'created_at' => $now,
            'created_by' => Session::get('username')
        ]);
//        $this->emp->where('emp_number', $request->sub_emp_number)->update([
//            '' => ''
//        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Save Demotion',
            'module' => 'Demotion',
            'sub_module' => 'Save Demotion',
            'modified_by' => Session::get('name'),
            'description' => 'Save Demotion, '. $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_demotion_request, counter_doc, emp_demotion_request, emp_demotion'
        ]);
        return redirect(route('demotion'))->with(['status' => 'Reqeust Demotion Success']);
    }
    public function delDemotion(Request $request){
        $now = date("Y-m-d H:i:s");
        $this->dReq->where('id', $request->id)->update([
            'demo_status' => 4,
            'updated_at' => $now
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Delete Demotion',
            'module' => 'Demotion',
            'sub_module' => 'Delete Demotion',
            'modified_by' => Session::get('name'),
            'description' => 'Delete Demotion, id'. $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_demotion_request, counter_doc, emp_demotion_request, emp_demotion'
        ]);
        return redirect(route('demotion'))->with(['status' => 'Cancel Demotion Success']);
    }
    public function printDemotion($id){
        $now = date("Y-m-d H:i:s");
        $reqDemo = $this->dReq->where('id', $id)->first();
        $demo = $this->demotion->where('demo_request_id', $id)->first();
        $empSub = $this->emp->where('emp_number', $reqDemo->sub_emp_number)->first();
        $empSup = $this->emp->where('emp_number', $reqDemo->sup_emp_number)->first();
        $hrd = User::where('is_manage', '1')->where('perms_name', 'HRD')->where('pnum', $empSub->location->pnum)->where('ptype', $empSub->location->ptype)->first();
//        print_r('<pre>');
//        print_r($hrd);
//        print_r('</pre>');die;
        $temp = TemplateContract::where('id', $reqDemo->template_id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Print Demotion',
            'module' => 'Demotion',
            'sub_module' => 'Print Demotion',
            'modified_by' => Session::get('name'),
            'description' => 'Print Demotion, req id '. $id .', employee sub number '.$empSub->emp_number.', employee sup number '.$empSup->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_demotion_request, emp_demotion'
        ]);

        return view('prints.pdfSuratSKDemosi', compact('reqDemo', 'demo', 'empSub', 'empSup','hrd'));
    }
    public function job_from(Request $request){
        $now = date("Y-m-d H:i:s");
        $result = array();
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        if(!$emp){
            $result = ['job_title_code' => '0', 'job_title' => ''];
        }else{
            $result = ['job_title_code' => $emp->job_title_code, 'job_title' => $emp->job_title->job_title];
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'Job From',
            'module' => 'Demotion',
            'sub_module' => 'Job From',
            'modified_by' => Session::get('name'),
            'description' => 'Job From, job_title_code '.$emp->job_title_code.', job_title $emp->job_title->job_title',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_demotion_request, emp_demotion'
        ]);
        
        return response()->json($result);
    }
}
