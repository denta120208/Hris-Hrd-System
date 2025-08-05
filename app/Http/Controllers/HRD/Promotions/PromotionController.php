<?php

namespace App\Http\Controllers\HRD\Promotions;

use App\Models\Master\TemplateContract;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee, App\Models\Promotions\Promotion;
use App\Models\Promotions\PromotionStatus, App\Models\Promotions\PromotionRquest;
use App\Models\Master\JobMaster;
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
        $requests = $this->pReq->where('pro_status','=',1)->orderBy('pro_status','ASC')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Promotion Index',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Promotion Index, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);
        
        return view('pages.manage.promotion.index', compact('requests'));
    }

    public function listRequestPromote(){
        $now = date("Y-m-d H:i:s");
        $requests = $this->pReq->where('pro_status','=',1)->orderBy('pro_status','ASC')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View List Request Promote',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View List Request Promote, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);
        
        return view('pages.manage.promotion.listRequestApprlv1', compact('requests'));
    }

    public function listRequestPromoteBOD(){
        $now = date("Y-m-d H:i:s");
        $requests = $this->pReq->where('pro_status','=',3)->orderBy('pro_status','ASC')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View List Request Promote BOD',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View List Request Promote BOD, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);
        
        return view('pages.manage.promotion.listRequestApprBod', compact('requests'));
    }

    public function listRequestPromoteHRProcess(){
        $now = date("Y-m-d H:i:s");
        $requests = $this->pReq->where('pro_status','=',6)->orderBy('pro_status','ASC')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View List Request Promote HR Process',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View List Request Promote HR Process, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);
        
        return view('pages.manage.promotion.listRequestApprHRProcess', compact('requests'));
    }

    public function addPromote(){
        $now = date("Y-m-d H:i:s");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Add Promote',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Add Promote, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        return view('pages.manage.promotion.form');
    }
    public function savePromotion(Request $request){
//        dd($request);
        $now = date("Y-m-d H:i:s");
        // if(Session::get('is_manage') == 1) {
        //     $emp = $this->emp->where('emp_number', Session::get('nik'))->first();
        // }
        // else {
        //     $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        // }

        //$emp = $this->emp->where('emp_number', $request->sub_emp_number)->first();

        // $dataArray = array([
        //     'sub_emp_number' => $request->emp_number,
        //     'pro_status' => 1,
        //     'pro_reason' => $request->pro_reason,
        //     'pro_from_loc' => $request->pro_from_id,
        //     'pro_to_loc' => $request->pro_to,
        //     'created_at' => $now,
        //     'created_by' => Session::get('name')
        //     // 'hrd_approved_at' => $now,
        //     // 'hrd_approved_by' => Session::get('username')
        // ]);
        // dd($dataArray);

        $request_promote = $this->pReq->create([
            'sub_emp_number' => $request->emp_number,
            'pro_status' => 1,
            'pro_reason' => $request->pro_reason,
            'pro_from_loc' => $request->pro_from_id,
            'pro_to_loc' => $request->pro_to,
            'created_at' => $now,
            'created_by' => Session::get('username'),
            // 'hrd_approved_at' => $now,
            // 'hrd_approved_by' => Session::get('username')
        ]);


        \DB::table('log_activity')->insert([
            'action' => 'Request Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'Request ' . $request->sub_emp_number . ' from '.$request->pro_from.' to '.$request->pro_to.' reason: '.$request->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_leave_request'
        ]);

        return redirect(route('hrd.promotion'));
    }
    public function setPromotion(Request $request){ // Dir Ops Approval
        $now = date("Y-m-d H:i:s");
        $counter = DB::table('counter_doc')->where('id', '1')->first();
        $Promotion = $this->pReq->where('id', $request->id)->first();
        $fromJT = DB::table('job_title')->where('id','=',$Promotion->pro_from_level)->first();
        $toJT = DB::table('job_title')->where('id','=',$Promotion->pro_to_level)->first();
//        $doc_no = str_pad($counter->counter, 3, '0', STR_PAD_LEFT).'/SK/METLAND/PRO/'.$this->getRomawi(date('n')).'/'.date('Y');
        //$doc_no = $request->pro_doc_no;
//        print_r($doc_no); die;
        // $this->promotion->create([
        //     'pro_request_id' => $Promotion->id,
        //     'pro_doc_no' => $doc_no,
        //     'created_at' => $now,
        //     'created_by' => Session::get('name')
        // ]);
        // Update Promotion Request
        $Promotion->pro_status = 3;
        // $Promotion->hrd_approved_at = $now;
        // $Promotion->hrd_approved_by = Session::get('name');
        $Promotion->save();

        \DB::table('log_activity')->insert([
            'action' => 'Approve Lv1 Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'Approve Lv1 ' . $request->sub_emp_number . ' from '.$fromJT->job_title.' to '.$toJT->job_title.' reason: '.$request->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);

        //$this->emp->where('emp_number', $Promotion->sub_emp_number)->update(['job_title_code' => $Promotion->pro_to_level]);

        // $counter->counter += 1;
        // $counter->save();
        return redirect(route('hrd.promotionapprlv1'))->with(['status' => 'Approve Lv1 Promotion Success']);
    }

    public function setPromotionBOD($id_request){ // BOD Approval
        $now = date("Y-m-d H:i:s");
        $counter = DB::table('counter_doc')->where('id', '1')->first();
        $Promotion = $this->pReq->where('id', $id_request)->first();
        $fromJT = DB::table('job_title')->where('id','=',$Promotion->pro_from_level)->first();
        $toJT = DB::table('job_title')->where('id','=',$Promotion->pro_to_level)->first();
        $Promotion->pro_status = 6;
        $Promotion->save();

        \DB::table('log_activity')->insert([
            'action' => 'Approve BOD Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'Approve BOD ' . $Promotion->sub_emp_number . ' from '.$fromJT->job_title.' to '.$toJT->job_title.' reason: '.$Promotion->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);

        return redirect(route('hrd.promotionapprbod'))->with(['status' => 'Approve BOD Promotion Success']);
    }

    public function setPromotionHRProcess(Request $request){ // HRD Approval
        $now = date("Y-m-d H:i:s");
        $counter = DB::table('counter_doc')->where('id', '1')->first();
        $Promotion = $this->pReq->where('id', $request->id)->first();
        $fromJT = DB::table('job_title')->where('id','=',$Promotion->pro_from_level)->first();
        $toJT = DB::table('job_title')->where('id','=',$Promotion->pro_to_level)->first();
//        $doc_no = str_pad($counter->counter, 3, '0', STR_PAD_LEFT).'/SK/METLAND/PRO/'.$this->getRomawi(date('n')).'/'.date('Y');
        $doc_no = $request->pro_doc_no;
//        print_r($doc_no); die;
        $this->promotion->create([
            'pro_request_id' => $Promotion->id,
            'pro_doc_no' => $doc_no,
            'created_at' => $now,
            'created_by' => Session::get('name')
        ]);
        // Update Promotion Request
        $Promotion->pro_status = 7;
        $Promotion->hrd_approved_at = $now;
        $Promotion->hrd_approved_by = Session::get('name');
        $Promotion->save();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Process Promotion',
            'module' => 'Administator',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Process Promotion ' . $request->sub_emp_number . ' from '.$fromJT->job_title.' to '.$toJT->job_title.' reason: '.$request->pro_reason,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request'
        ]);

        //$this->emp->where('emp_number', $Promotion->sub_emp_number)->update(['job_title_code' => $Promotion->pro_to_level]);

        // $counter->counter += 1;
        // $counter->save();
        return redirect(route('hrd.promotionhrprocess'))->with(['status' => 'Process Promotion Success']);
    }


    public function printPromotion($id){
        $now = date("Y-m-d H:i:s");
        $reqPro = $this->pReq->where('id', $id)->first();
        $pro = $this->promotion->where('pro_request_id', $id)->first();
        $empSub = $this->emp->where('emp_number', $reqPro->sub_emp_number)->first();
        $empSup = $this->emp->where('emp_number', $reqPro->sup_emp_number)->first();
//        $temp = TemplateContract::where('id', $contract->template_id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD print Promotion',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Promotion, request promotion id '.$id.', emp sub number '.$reqPro->sub_emp_number.', emp sup number '.$reqPro->sup_emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotion_request, emp_promotion, employee'
        ]);
        
        
        return view('prints.pdfSuratSKPromosi', compact('reqPro', 'pro', 'empSub', 'empSup'));
    }
    public function getEmp(Request $request){
        $now = date("Y-m-d H:i:s");
        $arr = array(); $i = 0;

        $emps = DB::select("Select a.emp_fullname,a.employee_id,a.emp_number,b.id,b.job_title
        from employee as a INNER JOIN job_title as b ON a.job_title_code = b.id
        where emp_fullname LIKE '%".$request->q."%'
        OR employee_id LIKE '%".$request->q."%'");
        
        // $emps = $this->emp->join('job_title', 'employee.job_title_code', '=', 'job_title.id')
        //     ->whereNull('termination_id')
        //     ->where('emp_fullname', 'LIKE', '%'.$request->q.'%')
        //     ->orWhere('employee_id', 'LIKE', '%'.$request->q.'%')
        //     ->select(employee.emp_fullname,employee.employee_id,employee.emp_number,job_title.id,job_title.job_title)
        //     ->get();

        foreach($emps as $row){
            $arr[$i] = trim($row->emp_fullname).';'.$row->employee_id.';'.trim($row->emp_number).';'.$row->id.";".$row->job_title;
            $i++;
        } // 211001002
//        print_r($arr); die;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Employee',
            'module' => 'Administration',
            'sub_module' => 'Promotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Employee,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'job_title, employee'
        ]);
        
        return response()->json($arr);
    }

    function getRomawi($bln){
        switch ($bln){
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }
}
