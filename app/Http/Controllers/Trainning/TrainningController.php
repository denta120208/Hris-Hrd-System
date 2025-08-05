<?php

namespace App\Http\Controllers\Trainning;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session;
use App\Models\Trainning\TrainningRequest, App\Models\Trainning\Trainning, App\Models\Trainning\TrainningEmp;
use App\Models\Trainning\TrainningCategory, App\Models\Master\Employee;

class TrainningController extends Controller{
    protected $emp;
    protected $trainReq;
    protected $train;
    protected $trainEmp;
    protected $trainCat;
    protected $edu;
    public function __construct(Employee $emp, Trainning $train, TrainningRequest $trainReq, TrainningEmp $trainEmp, TrainningCategory $trainCat){
        $this->emp = $emp;
        $this->train = $train;
        $this->trainReq = $trainReq;
        $this->trainEmp = $trainEmp;
        $this->trainCat = $trainCat;
//        $this->qlt = $qlt;
//        $this->edu = $edu;
        parent::__construct();
    }
    public function requestForm(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        \DB::table('log_activity')->insert([
            'action' => 'View Request Form',
            'module' => 'Training',
            'sub_module' => 'View Request Form',
            'modified_by' => Session::get('name'),
            'description' => 'View Request Form ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return view('pages.trainning.formRequest', compact('emp'));
    }
    public function listTrainning(){
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $trainList = $this->trainReq->where('emp_number', $emp->emp_number)->where('training_status', '1')->get();
        $trains = $this->trainEmp->where('emp_number', $emp->emp_number)->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View List Training',
            'module' => 'Training',
            'sub_module' => 'View List Training',
            'modified_by' => Session::get('name'),
            'description' => 'View List Training ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_trainning_request, emp_trainning'
        ]);
        return view('pages.trainning.listRequest', compact('emp', 'trainList', 'trains'));
    }
    public function getVendorTrain(Request $request){
        $now = date("Y-m-d H:i:s");
        $vendors = DB::table('trainning_vendor')->where('training_id', $request->id)->get();
        $ven_data = view('partials.trainning.vendor', compact('vendors'))->render();
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Vendor Training',
            'module' => 'Training',
            'sub_module' => 'Get Vendor Training',
            'modified_by' => Session::get('name'),
            'description' => 'Get Vendor Training ' . $vendors->vendor_name,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'trainning_vendor'
        ]);
        return response()->json([
            'html' => $ven_data
        ]);
    }
    public function setVendorTrain(Requests\Institutions\InstitutionCreate $request){
        $now = date("Y-m-d H:i:s");
        
        DB::table('trainning_vendor')->insert([
            'training_id' => $request->training_id,
            'vendor_name' => $request->vendor_name,
            'vendor_addr' => $request->vendor_addr,
            'vendor_tlp' => $request->vendor_tlp,
            'vendor_fax' => $request->vendor_fax,
            'vendor_email' => $request->vendor_email
//            'pnum' => Session::get('pnum'),
//            'ptype' => Session::get('ptype')
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Set Vendor Training',
            'module' => 'Training',
            'sub_module' => 'Set Vendor Training',
            'modified_by' => Session::get('name'),
            'description' => 'Set Vendor Training ' . $request->vendor_name,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'trainning_vendor'
        ]);
        return redirect()->route('requestTrainning');
    }
    public function saveTraining(Request $request){
        $now = date('Y-m-d H:i:s');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        
        if($request->trainning_costs == null){
            $request->trainning_costs = 0;
        }
        if($request->train_id == 0){
            return redirect(route('requestTrainning'))->withErrors(['error' => 'Training topic can not be empty!' ]);
        }
        if($request->vendor_id == 0){
            return redirect(route('requestTrainning'))->withErrors(['error' => 'Institution can not be empty!' ]);
        }
        
        $train = $this->trainReq->create([
            'emp_number' => $emp->emp_number,
            'requested_at' => $now,
            'trainning_id' => $request->train_id,
            'trainning_intitusion' => $request->vendor_id,
            'trainning_silabus' => $request->trainning_silabus,
            'trainning_purpose' => $request->trainning_purpose,
            'trainning_costs' => $request->trainning_costs,
            'trainning_start_date' => $request->sTrain_date,
            'trainning_end_date' => $request->eTrain_date,
            'training_status' => '1', // Status -> Requested
            'pnum' => Session::get('pnum'),
            'ptype' => Session::get('ptype')
        ]);
        $this->sendEmailTrainingRequest('3', $emp->emp_number, $train->id);
        
        \DB::table('log_activity')->insert([
            'action' => 'Save Training',
            'module' => 'Training',
            'sub_module' => 'Save Training',
            'modified_by' => Session::get('name'),
            'description' => 'Save Training, train_id =' . $request->train_id . ", vendor_id = ". $request->vendor_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning_request'
        ]);
        return redirect()->route('listTrainning')->with('status', 'Request has been placed');
    }
    public function listApprove(){
        $now = date('Y-m-d H:i:s');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $trainList = DB::table('employee')
            ->join('emp_reportto', 'employee.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('emp_trainning_request', 'emp_reportto.erep_sub_emp_number', '=', 'emp_trainning_request.emp_number')
            ->join('trainning', 'emp_trainning_request.trainning_id', '=' ,'trainning.id')
            ->join('trainning_vendor', 'emp_trainning_request.trainning_intitusion', '=' ,'trainning_vendor.id')
            ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_trainning_request.training_status', '1')
            ->select('emp_trainning_request.*','trainning.name','trainning_vendor.vendor_name','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->get();
//        $trainList = $this->trainReq->where('emp_number', $emp->emp_number)->where('training_status', '1')->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'View List Approve',
            'module' => 'Training',
            'sub_module' => 'View List Approve',
            'modified_by' => Session::get('name'),
            'description' => 'View List Approve ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'empoyee, emp_reportto, emp_trainning_request, trainning, trainning_vendor'
        ]);
        return view('pages.trainning.listApprove', compact('emp', 'trainList'));
    }
    public function appvSup(Request $request, $id){
        $now = date('Y-m-d H:i:s');
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $this->trainReq->where('id', $id)->update([
            'training_status' => '2',
            'approved_sup_by' => $emp->employee_id,
            'approved_sup_at' => date('Y-m-d H:i:s')
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Approve Supervisor',
            'module' => 'Training',
            'sub_module' => 'Approve Supervisor',
            'modified_by' => Session::get('name'),
            'description' => 'Approve Supervisor by ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'empoyee, emp_trainning_request'
        ]);
        return redirect()->route('listApprove');
    }
    public function destroy($id)
    {
        //
    }
}
