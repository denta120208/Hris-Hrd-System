<?php

namespace App\Http\Controllers\Punhisments;

use App\Http\Controllers\Controller;
use App\Models\Master\Employee, App\Models\Master\JobMaster;
use App\Models\Punishments\PunishmentRequest, App\Models\Punishments\Punishment;
use App\Models\Punishments\PunishmentStatus, App\Models\Master\TemplateContract;
use App\User, App\Models\Punishments\PunishmentType;
use Illuminate\Http\Request;
use Session,DB;

class STSPController extends Controller{
    protected $emp;
    protected $punishment;
    protected $pReq;
    protected $pStat;
    protected $pType;
    public function __construct(Employee $emp, Punishment $punishment, PunishmentRequest $pReq, PunishmentStatus $pStat, PunishmentType $pType){
        $this->emp = $emp;
        $this->punishment = $punishment;
        $this->pReq = $pReq;
        $this->pStat = $pStat;
        $this->pType = $pType;
        parent::__construct();
    }
    public function index(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $requests = $this->pReq->where('sup_emp_number', $emp->emp_number)
                ->orderBy('punish_status','ASC')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View STSP',
            'module' => 'Punishment',
            'sub_module' => 'STSP',
            'modified_by' => Session::get('name'),
            'description' => 'View STSP, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request'
        ]);
        
        return view('pages.punhisment.index', compact('requests'));
    }
    public function punish_appr(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        $reqAppr = DB::select("Select a.id,c.employee_id,c.emp_firstname,c.emp_middle_name,c.emp_lastname,d.name as punish_type,
                                      e.name as punish_status_name,a.punish_reason,a.created_at,a.punish_status
                                 from emp_punishment_request as a INNER JOIN emp_reportto as b ON a.sup_emp_number = b.erep_sub_emp_number
                                 INNER JOIN employee as c ON a.sub_emp_number = c.emp_number
                                 INNER JOIN punishment_type as d ON a.punish_type = d.id
                                 INNER JOIN punishment_status as e ON a.punish_status = e.id
                                 where b.erep_sup_emp_number = ".$emp->emp_number."
                                 and a.punish_status IN (1)");
        
        \DB::table('log_activity')->insert([
            'action' => 'view approve punishment',
            'module' => 'Punishment',
            'sub_module' => 'view approve punishment',
            'modified_by' => Session::get('name'),
            'description' => 'view approve punishment, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request, emp_reportto, punihsment_type, punishment_status'
        ]);
        
        return view('pages.punhisment.index_appr', compact('reqAppr'));
    }
    public function addPunishment(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $emps = DB::table('emp_reportto')
            ->join('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
            ->where('employee.termination_id','=',0)
            ->select('emp_reportto.id','emp_reportto.erep_sub_emp_number',
                'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        $punishType = PunishmentType::lists('name','id')->prepend('-=Punishment Type=-', '0');
        
        \DB::table('log_activity')->insert([
            'action' => 'view add punishment',
            'module' => 'Punishment',
            'sub_module' => 'view add punishment',
            'modified_by' => Session::get('name'),
            'description' => 'view add punishment, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto'
        ]);
        
        return view('pages.punhisment.form', compact('emps','emp','punishType'));
    }
    public function savePunishment(Request $request){
        $now = date("Y-m-d H:i:s"); 
        $template = '';
        $bulan = date('m');
        $tahun = date('Y');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $type = $this->pType->where('id', $request->punish_type)->first();
        $ctr = DB::table('counter_doc')->first();
        //$doc_no = $ctr->counter.'/'.$type->name.'/HRD/'.$bulan.'/'.$tahun;
        $sub_emp = $this->emp->where('emp_number', $request->sub_emp_number)->first();
//        if($request->punish_type == '1'){
//            $template = 5;
//        }else{
//            $template = 6;
//        }
        
        $request_punish = $this->pReq->create([
            'sub_emp_number' => $sub_emp->emp_number,
            'sup_emp_number' => $emp->emp_number,
            'emp_id' => $sub_emp->employee_id,
            'punish_status' => '1',
            'punish_type' => $request->punish_type,
            'punish_reason' => $request->punish_reason,
            'created_at' => $now,
            'created_by' => Session::get('name')
            //'template_id' => $template,
//            'punish_pasal' => $request->punish_pasal,
        ]);
//        $this->punishment->create([
//            'punish_request_id' => $request_punish->id,
//            'punish_doc_no' => $doc_no,
//            'created_at' => $now,
//            'created_by' => Session::get('username')
//        ]);
        //DB::table('counter_doc')->where('id', $ctr->id)->update(['counter' => $ctr->counter + 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Save Punishment',
            'module' => 'Punishment',
            'sub_module' => 'Save Punishment',
            'modified_by' => Session::get('name'),
            'description' => 'Save Punishment, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request, emp_punishment, punihsment_type'
        ]);
        
        return redirect(route('stsp'))->with(['status' => 'Request Punhisment Success']);
    }
    public function delPunishment($id){
        $now = date("Y-m-d H:i:s");
        //dd($id);
        $this->pReq->where('id', $id)->update([
            'punish_status' => 4,
            'updated_at' => $now
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Delete Punishment',
            'module' => 'Punishment',
            'sub_module' => 'Delete Punishment',
            'modified_by' => Session::get('name'),
            'description' => 'Delete Punishment, request id '. $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request'
        ]);
        
        return redirect(route('stsp'))->with(['status' => 'Cancel Punhisment Success']);
    }
    public function apprPunishment($id){
        $now = date("Y-m-d H:i:s");
        //dd($id);
        
        if (Session::get('is_manage') == 1)
        {
            $status = 3;
            $this->pReq->where('id', $id)->update([
                'punish_status' => $status,
                'hrd_approved_at' => $now,
                'hrd_approved_by' => Session::get('name'),
                'updated_at' => $now
            ]);
        }
        else
        {
            $status = 2;
            $this->pReq->where('id', $id)->update([
                'punish_status' => $status,
                'approved_at' => $now,
                'approved_by' => Session::get('name'),
                'updated_at' => $now
            ]);
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'Delete Punishment',
            'module' => 'Punishment',
            'sub_module' => 'Delete Punishment',
            'modified_by' => Session::get('name'),
            'description' => 'Delete Punishment, request id '. $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request'
        ]);
        
        return redirect(route('stsp'))->with(['status' => 'Approve Punhisment Success']);
    }
    public function editPunishment($id){
        $now = date("Y-m-d H:i:s");
        $punish_req = $this->pReq->where('id', $id)->first();
        $punish = $this->punishment->where('punish_request_id', $id)->first();
        $emp_sub = $this->emp->where('emp_number', $punish_req->sub_emp_number)->first();
        $emp_sup = $this->emp->where('emp_number', $punish_req->sup_emp_number)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Edit Punishment',
            'module' => 'Punishment',
            'sub_module' => 'View Edit Punishment',
            'modified_by' => Session::get('name'),
            'description' => 'View Edit Punishment, id '. $id.', emp sub number '.$emp_sub->emp_number.', emp sup number '.$emp_sup->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto'
        ]);
        
        return view('pages.punhisment.form_edit', compact('id','emp_sub', 'emp_sup', 'punish_req', 'punish'));
    }
    public function saveEPunishment(Request $request){
        $template = '';
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $type = $this->pType->where('id', $request->punish_type)->first();
        $sub_emp = $this->emp->where('emp_number', $request->sub_emp_number)->first();
        if($request->punish_type == '1'){
            $template = 5;
        }else{
            $template = 6;
        }
        $request_punish = $this->pReq->where('id', $request->id)->update([
            'sub_emp_number' => $sub_emp->emp_number,
            'sup_emp_number' => $emp->emp_number,
            'emp_id' => $sub_emp->employee_id,
            'punish_status' => '2',
            'punish_type' => $request->punish_type,
            'punish_reason' => $request->punish_reason,
            'updated_at' => $now,
            'template_id' => $template,
            'punish_pasal' => $request->punish_pasal,
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Save Punishment',
            'module' => 'Punishment',
            'sub_module' => 'Save Punishment',
            'modified_by' => Session::get('name'),
            'description' => 'Save Punishment, id '. $request->id.', emp sub number '.$sub_emp->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request'
        ]);
        
        return redirect(route('stsp'))->with(['status' => 'Request Punhisment Success']);
    }
    public function printSTSP($id){
        $now = date("Y-m-d H:i:s");
        $reqPunish = $this->pReq->where('id', $id)->first();
        $punish = $this->punishment->where('punish_request_id', $id)->first();
        $empSub = $this->emp->where('emp_number', $reqPunish->sub_emp_number)->first();
        $empSup = $this->emp->where('emp_number', $reqPunish->sup_emp_number)->first();
        $hrd = User::where('is_manage', '1')->where('perms_name', 'HRD')->where('pnum', $empSub->location->pnum)->where('ptype', $empSub->location->ptype)->first();
        $temp = TemplateContract::where('id', $reqPunish->template_id)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'Print STSP',
            'module' => 'Punishment',
            'sub_module' => 'Print STSP',
            'modified_by' => Session::get('name'),
            'description' => 'Print STSP, id '. $id.', emp sub number '.$empSub->emp_number.', emp sup number '.$empSup->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_punishment_request, emp_punishment'
        ]);
        
        return view($temp->file_temp, compact('reqPunish', 'punish', 'empSub', 'empSup','hrd'));
    }
}
