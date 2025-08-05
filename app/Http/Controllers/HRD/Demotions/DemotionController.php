<?php

namespace App\Http\Controllers\HRD\Demotions;

use App\Models\Demotions\Demotion;
use App\Models\Demotions\DemotionRequest;
use App\Models\Master\Employee;
use App\Models\Master\JobMaster;
use App\Models\Punishments\PunishmentStatus;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            'action' => 'HRD View Demotion Index',
            'module' => 'Administration',
            'sub_module' => 'Demotion',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Demotion Index, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_demotion_request'
        ]);
        
        return view('pages.manage.demotion.index', compact('requests'));
    }
    public function addPromote(){
        return view('pages.manage.promotion.form');
    }
    public function savePromotion(Request $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $request_promote = $this->pReq->create([
            'sub_emp_number' => $request->emp_number,
            'demo_status' => 3,
            'demo_reason' => $request->pro_reason,
            'demo_from_level' => $request->pro_from,
            'demo_to_level' => $request->pro_to,
            'created_at' => $now,
            'created_by' => Session::get('username'),
            'hrd_approved_at' => $now,
            'hrd_approved_by' => Session::get('username')
        ]);
        return redirect(route('hrd.demotion'))->with(['status' => 'Reqeust Demotion Success']);
    }
    public function setPromotion(Request $request){ //
        $now = date("Y-m-d H:i:s");
        $counter = DB::table('counter_doc')->first();
        $demotion = $this->dReq->where('id', $request->id)->first();
        $doc_no = str_pad($counter->counter, 3, '0', STR_PAD_LEFT).'/SK/METLAND/DMS/'.$this->getRomawi(date('n')).'/'.date('Y');
//        print_r($doc_no); die;
        $this->demotion->create([
            'demo_request_id' => $demotion->id,
            'demo_doc_no' => $doc_no,
            'created_at' => $now,
            'created_by' => Session::get('username')
        ]);
        // Update Demotion Request
        $demotion->demo_status = 3;
        $demotion->hrd_approved_at = $now;
        $demotion->hrd_approved_by = Session::get('username');
        $demotion->save();

        $counter->counter += 1;
        $counter->save();
        return redirect(route('hrd.demotion'))->with(['status' => 'Approve Demotion Success']);
    }

    public function printDemotion($id){
        $reqDemo = $this->dReq->where('id', $id)->first();
        $demo = $this->demotion->where('demo_request_id', $id)->first();
        $empSub = $this->emp->where('emp_number', $reqDemo->sub_emp_number)->first();
        $empSup = $this->emp->where('emp_number', $reqDemo->sup_emp_number)->first();
//        $temp = TemplateContract::where('id', $contract->template_id)->first();

        return view('prints.pdfSuratSKDemosi', compact('reqDemo', 'demo', 'empSub', 'empSup'));
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
