<?php

namespace App\Http\Controllers\Promotions;

use App\Models\Master\Employee;
use App\Models\Master\JobMaster;
use App\Models\Promotions\Promotion;
use App\Models\Promotions\PromotionRquest;
use App\Models\Promotions\PromotionStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session;

class PromotionController extends Controller{
    protected $emp;
    protected $promotion;
    protected $pReq;
    protected $pStat;
    protected $job_title;
    public function __construct(Employee $emp, Promotion $promotion, PromotionRquest $pReq, PromotionStatus $pStat, JobMaster $job_title){
        $this->emp = $emp;
        $this->promotion = $promotion;
        $this->pReq = $pReq;
        $this->pStat = $pStat;
        $this->job_title = $job_title;
        parent::__construct();
    }
    public function index(){
        $now = date("Y-m-d H:i:s");
        //$emp = $this->emp->where('employee_id', Session::get('nik'))->first();
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        //dd(Session::get('username'));
        $requests = $this->pReq->where('sup_emp_number', $emp->emp_number)->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Promotion Index',
            'module' => 'Promotion',
            'sub_module' => 'View Promotion Index',
            'modified_by' => Session::get('name'),
            'description' => 'View Promotion Index, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_promotion_request'
        ]);
        return view('pages.promotion.index', compact('requests'));
    }
    public function addPromote(){
        $now = date("Y-m-d H:i:s");
        //$emp = $this->emp->where('emp_number', Session::get('nik'))->first();
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $emps = DB::select("Select a.id,a.erep_sub_emp_number,b.emp_firstname,b.emp_middle_name,b.emp_lastname
                            from emp_reportto as a INNER JOIN employee as b ON a.erep_sub_emp_number = b.emp_number
                            where a.erep_sup_emp_number = ".$emp->emp_number."
                            and a.erep_reporting_mode = 1
                            and b.emp_number NOT IN (
                                Select sub_emp_number from emp_promotion_request where pro_status IN (1,2,3,6)
                            )");

        // $emps = DB::table('emp_reportto')
        //     ->join('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
        //     ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
        //     ->where('emp_reportto.erep_reporting_mode', '1')
        //     ->select('emp_reportto.id','emp_reportto.erep_sub_emp_number',
        //         'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Add Promote',
            'module' => 'Promotion',
            'sub_module' => 'View Add Promote',
            'modified_by' => Session::get('name'),
            'description' => 'View Add Promote, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_reportto'
        ]);
        return view('pages.promotion.form', compact('emps'));
    }
    public function savePromotion(Request $request){
        $now = date("Y-m-d H:i:s");
        if(!$request->sub_emp_number){
            return back()->withErrors(['error' => 'Subordinative cannot be empty!']);
        }
        if(!$request->pro_to){
            return back()->withErrors(['error' => 'To Level cannot be empty!']);
        }
//        dd(Session::get('nik'));
        //$emp = $this->emp->where('emp_number', Session::get('nik'))->first();
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $fromJT = DB::table('job_title')->where('id','=',$request->pro_from)->first();
        $toJT = DB::table('job_title')->where('id','=',$request->pro_to)->first();
        $request_promote = $this->pReq->create([
            'sub_emp_number' => $request->sub_emp_number,
            'sup_emp_number' => $emp->emp_number,
            'pro_status' => 1,
            'pro_reason' => $request->pro_reason,
            'pro_from_level' => $request->pro_from,
            'pro_to_level' => $request->pro_to,
            'created_at' => $now,
            'created_by' => Session::get('username'),
        ]);
        

        \DB::table('log_activity')->insert([
            'action' => 'Request Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'Request ' . $request->sub_emp_number . ' from '.$fromJT->job_title.' to '.$toJT->job_title.' reason: '.$request->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);

        return redirect(route('promotion'));
    }
    public function delPromotion(Request $request){
        $now = date("Y-m-d H:i:s");
        $rerPromote = $this->pReq->where('id', $request->id)->first();
        $fromJT = DB::table('job_title')->where('id','=',$rerPromote->pro_from_level)->first();
        $toJT = DB::table('job_title')->where('id','=',$rerPromote->pro_to_level)->first();
        $this->pReq->where('id', $request->id)->update([
            'pro_status' => 4,
            'updated_at' => $now
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'Cancel Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'Cancel Promotion ' . $request->sub_emp_number . ' from '.$fromJT->job_title.' to '.$toJT->job_title.' reason: '.$request->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);

        return redirect(route('promotion'))->with(['status' => 'Cancel Promotion Success']);
    }
    
    public function job_from(Request $request){
        $now = date("Y-m-d H:i:s");
        $result = array();
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        if(!$emp){
            $result = ['job_title_code' => '0', 'job_title' => ''];
        }else{
            $result = ['job_title_code' => $emp->job_title_code, 'job_title' => $emp->job_title->job_title,
                'job_name_code' => $emp->custom4, 'job_name' => $emp->custom4];
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'Job From',
            'module' => 'Promotion',
            'sub_module' => 'Job From',
            'modified_by' => Session::get('name'),
            'description' => 'Job From, ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_promotion_request'
        ]);
        return response()->json($result);
    }
}
