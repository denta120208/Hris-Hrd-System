<?php

namespace App\Http\Controllers\HRD\Mutations;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\Mutations\MutationRequest, App\Models\Mutations\MutationStatus;
use App\Models\Mutations\Mutation;

class MutationController extends Controller{
    protected $emp;
    protected $mutation;
    protected $mReq;
    protected $mStat;
    public function __construct(Employee $emp, Mutation $mutation, MutationRequest $mReq, MutationStatus $mStat){
        $this->emp = $emp;
        $this->mReq = $mReq;
        $this->mutation = $mutation;
        $this->mStat = $mStat;
        parent::__construct();
    }

    public function index(){
        $now = date('Y-m-d H:i:s');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $requests = $this->mReq->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Mutation index',
            'module' => 'Administration',
            'sub_module' => 'Mutation',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Mutation Index,' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_mutation_request'
        ]);
        
        return view('pages.manage.mutation.index', compact('emp', 'requests'));
    }
    public function saveMutation(Request $request){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $this->mReq->create([
            'sub_emp_number' => $request->sub_emp_number,
            'sup_emp_number' => $emp->emp_number,
            'mt_type' => $request->mt_type,
            'mt_status' => 1,
            'mt_reason' => $request->mt_reason,
            'mt_from_loc' => $request->mt_from_loc,
            'mt_to_loc' => $request->mt_to_loc,
            'mt_from_dept' => $request->dept_id,
            'mt_to_dept' => $request->mt_to_dept,
            'created_at' => $now,
            'created_by' => $emp->emp_number
        ]);
        return redirect(route('hrd.mutation'));
    }
    public function setMutation(Request $request){ // HRD Approval
        $now = date("Y-m-d H:i:s");
        $counter = DB::table('counter_doc')->where('id', '1')->first();
        $mutation = $this->mReq->where('mt_status', '>=', '1')->where('id', $request->id)->first();
        $doc_no = str_pad($counter->counter, 3, '0', STR_PAD_LEFT).'/SK/METLAND/MTS/'.$this->getRomawi(date('n')).'/'.date('Y');

        $this->mutation->create([
            'mt_request_id' => $mutation->id,
            'mt_doc_no' => $doc_no,
            'created_at' => $now,
            'created_by' => Session::get('username')
        ]);
        $mutation->mt_status = 3;
        $mutation->hrd_approved_at = $now;
        $mutation->hrd_approved_by = Session::get('username');
        $mutation->save();

        $this->emp->where('emp_number', $mutation->sub_emp_number)->update([
            'dept_id' => $mutation->mt_to_dept,
            'location_id' => $mutation->mt_to_loc
        ]);

        $counter->counter += 1;
        $counter->save();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Mutation',
            'module' => 'Administration',
            'sub_module' => 'Mutation',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Mutation , mutation request id '.$request->id ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_mutation_request'
        ]);
        
        return redirect(route('hrd.mutation'));
    }
    public function printMutation($id){
        $now = date("Y-m-d H:i:s");
        $reqMut = $this->mReq->where('id', $id)->first();
        $mutasi = $this->mutation->where('mt_request_id', $id)->first();
        $empSub = $this->emp->where('emp_number', $reqMut->sub_emp_number)->first();
        $empSup = $this->emp->where('emp_number', $reqMut->sup_emp_number)->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Mutation',
            'module' => 'Administration',
            'sub_module' => 'Mutation',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Mutation , mutation request id '.$id ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_mutation_request, emp_mutation'
        ]);
        
        return view('prints.pdfSuratSKMutasi', compact('reqMut', 'mutasi', 'empSub', 'empSup'));
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
