<?php

namespace App\Http\Controllers\Mutations;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\Mutations\MutationRequest, App\Models\Mutations\MutationStatus;

class MutationController extends Controller{
    protected $emp;
    protected $mReq;
    protected $mStat;
    public function __construct(Employee $emp, MutationRequest $mReq, MutationStatus $mStat){
        $this->emp = $emp;
        $this->mReq = $mReq;
        $this->mStat = $mStat;
        parent::__construct();
    }

    public function index(){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $requests = $this->mReq->where('sup_emp_number', $emp->emp_number)->get();
        return view('pages.mutation.index', compact('emp', 'requests'));
    }
    public function applMutation(){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $mutations = DB::table('emp_reportto')
            ->join('employee', 'emp_reportto.erep_sub_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sup_emp_number', $emp->emp_number)
            ->select('emp_reportto.id','emp_reportto.erep_sub_emp_number',
                'employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
        return view('pages.mutation.form', compact('mutations'));
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
        return redirect(route('mutation'));
    }
    public function apvMutation(){ // Superior Approval

    }
    public function listDept(Request $request){
        $result = array();
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        $dept = DB::table('emp_dept')->where('id',$emp->dept_id)->first();
        $loc = DB::table('location')->where('id',$emp->location_id)->first();
        if(!$dept){
            $dept = DB::table('emp_dept')->get();
            $result = ['dept_id' => '0', 'name' => '', 'loc_id' => $loc->id, 'loc_name' => $loc->name];
        }else{
            $result = ['dept_id' => $dept->id, 'name' => $dept->name, 'loc_id' => $loc->id, 'loc_name' => $loc->name];
        }
        return response()->json($result);
    }
}
