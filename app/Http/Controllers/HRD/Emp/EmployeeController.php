<?php

namespace App\Http\Controllers\HRD\Emp;

use App\Models\Employee\EmpContract;
use App\Models\Employee\EmpReportTo;
use App\Models\Employee\EmpTerminate;
use App\Models\Master\Location;
use App\Models\Master\TemplateContract;
//use App\Models\Payroll\PayrollEmp;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests,
    Session,
    DB,
    Log;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee,
    App\Models\Master\EmergencyContact,
    App\Models\Master\Dependents;
use App\Models\Master\JobMaster,
    App\Models\Master\Qualification,
    App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation,
    App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion,
    App\Models\Employee\EmpAttachment;
use App\Models\Employee\EmployeeDW;
use App\Models\Punishments\PunishmentRequest, App\Models\Punishments\Punishment;
use App\Models\Punishments\PunishmentStatus, App\Models\Punishments\PunishmentType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class EmployeeController extends Controller {

    protected $emp;
    protected $empDW;
    protected $eec;
    protected $ed;
    protected $job;
    protected $qlt;
    protected $train;
    protected $edu;
    protected $eReward;
    protected $ePromot;
    protected $eAttach;
    protected $emp_contract;

    public function __construct(Employee $emp, EmployeeDW $empDW, EmergencyContact $eec, 
                    Dependents $ed, JobMaster $job, Qualification $qlt, EmployeeTranning $train, 
                    EmpEducation $edu, EmpReward $eReward, EmpPromotion $ePromot, EmpAttachment $eAttach,
                    Punishment $punishment, PunishmentRequest $pReq, PunishmentStatus $pStat, PunishmentType $pType) 
    {
        $this->emp = $emp;
        $this->empDW = $empDW;
        $this->eec = $eec;
        $this->ed = $ed;
        $this->job = $job;
        $this->qlt = $qlt;
        $this->train = $train;
        $this->edu = $edu;
        $this->eReward = $eReward;
        $this->ePromot = $ePromot;
        $this->eAttach = $eAttach;
        $this->punishment = $punishment;
        $this->pReq = $pReq;
        $this->pStat = $pStat;
        $this->pType = $pType;
        parent::__construct();
    }

    public function index() {
        $now = date("Y-m-d H:i:s");
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }

        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $username = Session::get('username');

        if (Session::get('project') == 'HO') {
            $emps = $this->emp->where('termination_id','=',0)->whereNotNull('emp_status')->whereIn('emp_status', array(1,2,5))->orderBy('joined_date', 'DESC')->get();
        } else {
            $emps = $this->emp->where('termination_id','=',0)->whereNotNull('emp_status')->where('location_id', $project->id)->whereIn('emp_status', array(1,2,5))->orderBy('joined_date', 'DESC')->get();
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Employee Index',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Employee Index, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        \Session::forget('param_search_emp');

        return view('pages.manage.emp.index', compact('emps','project','username'));
    }

    public function createEmp(Request $request) {
        return redirect(route('hrd.employee'));
    }

    public function viewEmp($id) {
        return redirect(route('hrd.employee'));
    }

    public function personalEmp($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Personal Employee Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View personal Employee detail, emp number ' . $id . ', name ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('partials.employee.manage.personal', compact('emp', 'pic'));
    }

    public function setPersonalEmp(Request $request) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        $updateData = [
            'emp_lastname' => $request->emp_lastname,
            'emp_firstname' => $request->emp_firstname,
            'emp_fullname' => $request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname,
            'emp_middle_name' => $request->emp_middle_name,
            'emp_ktp' => $request->emp_ktp,
            'emp_gender' => $request->emp_gender,
            'nation_code' => $request->nation_code,
            'emp_dri_lice_num' => $request->emp_dri_lice_num,
            'emp_dri_lice_exp_date' => $this->date_convert($request->emp_dri_lice_exp_date),
            'emp_birthday' => $this->date_convert($request->emp_birthday),
            'bpjs_ks' => $request->bpjs_ks,
            'bpjs_tk' => $request->bpjs_tk,
            'npwp' => $request->npwp,
            'bank_account_number' => $request->bank_account_number,
            'bank_account_name' => $request->bank_account_name,
            'back_account_loc' => $request->back_account_loc,
        ];
        // Handle upload dokumen
        $docFields = [
            'doc_ktp' => 'ktp',
            'doc_npwp' => 'npwp',
            'doc_ijasah' => 'ijazah',
            'doc_kartu_keluarga' => 'kk',
        ];
        foreach ($docFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $originalName = $file->getClientOriginalName(); //Namafile asli
                $path = $folder . '/' . $originalName;
                // Pastikan folder ada
                if (!Storage::disk('ftp')->exists($folder)) {
                    Storage::disk('ftp')->makeDirectory($folder);
                }
                Storage::disk('ftp')->put($path, file_get_contents($file));
                $updateData[$field] = '/home/HRIS/' . $path;
            }
        }
        // Update ke DB (pilih update sesuai logic lama, tambahkan $updateData)
        if ($emp->employee_id == $request->employee_id) {
            if (empty($request->emp_marital_status)) {
                \DB::table('employee')->where('emp_number', $request->emp_number)->where('employee_id', $request->employee_id)->update($updateData);
            } else {
                $updateData['emp_marital_status'] = $request->emp_marital_status;
                \DB::table('employee')->where('emp_number', $request->emp_number)->where('employee_id', $request->employee_id)->update($updateData);
            }
        } else {
            $updateData['employee_id'] = $request->employee_id;
            if (empty($request->emp_marital_status)) {
                \DB::table('employee')->where('emp_number', $request->emp_number)->update($updateData);
            } else {
                $updateData['emp_marital_status'] = $request->emp_marital_status;
                \DB::table('employee')->where('emp_number', $request->emp_number)->update($updateData);
            }
            
            DB::statement("INSERT INTO com_absensi_inout_hist    
                select * from com_absensi_inout where comNIP = '".$emp->employee_id."'");
            
            DB::table('com_absensi_inout')
                    ->where('comNIP','=',$emp->employee_id)
                    ->update([
                        'comNIP'=>$request->employee_id
                    ]);
            
            if ($emp->badgenumber > 0)
            {
                $this->empDW->where('badgenumber','=',$emp->badgenumber)
                        ->update([
                            'title'=>$request->employee_id,
                            'name'=>$request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname
                        ]);
            }
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Personal Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Personal Employee, emp number ' . $request->emp_number . ', name ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function jobEmp($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
        $location = DB::table('location')->where('id', $emp->location_id)->first();
        $location_pnum = $location->pnum;
        $contract = DB::table('emp_contract')
                        ->where('emp_number', $emp->emp_number)->orderBy('id', 'DESC')->first();
        //dd($contract);
        $reports = DB::table('emp_reportto')
                        ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=', 'emp_reporting_method.reporting_method_id')
                        ->join('employee', 'emp_reportto.erep_sup_emp_number', '=', 'employee.emp_number')
                        ->where('emp_reportto.erep_sub_emp_number', $id)
                        ->where('emp_reportto.is_delete', '=', 0) // Filter out deleted records
                        ->select('emp_reportto.id', 'emp_reporting_method.reporting_method_name', 'emp_reportto.erep_sup_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'emp_reportto.is_delete')->get();
        $subs = DB::table('emp_reportto')
                        ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=', 'emp_reporting_method.reporting_method_id')
                        ->join('employee', 'emp_reportto.erep_sub_emp_number', '=', 'employee.emp_number')
                        ->where('emp_reportto.erep_sup_emp_number', $id)
                        ->where('emp_reportto.is_delete', '=', 0) // Filter out deleted records
                        ->select('emp_reportto.id', 'emp_reporting_method.reporting_method_name', 'emp_reportto.erep_sup_emp_number', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'emp_reportto.is_delete')->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Job Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Job Employee, emp number ' . $id . ', name ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_picture, location, emp_contract, emp_reportto, emp_reporting_method'
        ]);

        return view('partials.employee.manage.job', 
                compact('emp', 'pic', 'location', 'contract', 'reports', 'subs','location_pnum'));
    }

    public function setJobEmp(Request $request) {
        $now = date("Y-m-d H:i:s");

        $contract = $this->eAttach->where('emp_number', $request->job_empId)->where('screen', 'contract')->first();
        $loc = Location::where('old_id', $request->location_id)->first();
        if ($request->hasFile('eattach_filename')) {
            dd('test1');
            $image = $request->file('eattach_filename');
            $fp = fopen($image->getRealPath(), 'rb');
            $file_content = fread($fp, filesize($image->getRealPath()));
            $file_content = bin2hex($file_content);
            fclose($fp);
            $out = "0x" . $file_content;
            if ($contract) {
                DB::statement("
                    UPDATE emp_attachment SET eattach_attachment = CONVERT(varbinary(max), " . $out . ", 1), eattach_filename = '" . $image->getClientOriginalName() . "'
                    , eattach_size = '" . $image->getClientSize() . "', eattach_type = '" . $image->getClientMimeType() . "', attached_by = '" . Session::get('userid') . "', 
                    attached_by_name = '" . Session::get('username') . "',attached_time = '" . $now . "'
                    WHERE eattach_id = '" . $contract->eattach_id . "'
                ");
                $id = $contract->eattach_id;
            } else {
                $id = DB::statement("
                    INSERT INTO emp_attachment(emp_number,eattach_filename,eattach_size,eattach_attachment,eattach_type,attached_by,attached_by_name,attached_time, screen) VALUES
                    ('" . $request->job_empId . "', '" . $image->getClientOriginalName() . "', '" . $image->getClientSize() . "', CONVERT(varbinary(max), " . $out . ", 1),
                    '" . $image->getClientMimeType() . "','" . Session::get('userid') . "','" . Session::get('username') . "', '" . $now . "', 'contract')
                ");
                $id = DB::getPdo()->lastInsertId();
            }
            EmpContract::updateOrCreate(
                    ['emp_number' => $request->job_empId],
                    ['econ_extend_id' => $id,
                        'econ_extend_start_date' => $request->econ_extend_start_date,
                        'econ_extend_end_date' => $request->econ_extend_end_date
                    ]
            );
        }
//        $array = array([
//                'job_level' => $request->job_level,
//                //'job_spec' => $request->job_spec,
//                'emp_status' => $request->estatus,
////            'provin_code' => $request->provin_code,
//                'joined_date' => $this->date_convert($request->joined_date),
//                'work_station' => $request->work_station,
//                'location_id' => $request->location_id,
//                'job_title_code' => $request->job_title_code,
//                'pnum' => $loc->pnum,
//                'ptype' => $loc->ptype,
//                'job_spec'
//        ]);

        //dd($array);
        if($request->days_type == 'on'){
            $days_type = 1;
        }else{
            $days_type = 0;
        }
        
        $this->emp->where('emp_number', $request->job_empId)->update([
            'job_level' => $request->job_level,
            //'job_spec' => $request->job_spec,
            'emp_status' => $request->estatus,
//            'provin_code' => $request->provin_code,
            'joined_date' => $this->date_convert($request->joined_date),
            'work_station' => $request->work_station,
            'location_id' => $request->location_id,
            'job_title_code' => $request->job_title_code,
            'days_type'=> $days_type,
            'pnum' => $loc->pnum,
            'ptype' => $loc->ptype,
            'eeo_cat_code'=>$request->eeo_cat_code,
            'job_dept_id'=>$request->job_dept_id
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Job Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Job Employee, ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_attachment'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }
    
    public function deleteReportTo($id){
        $now = date("Y-m-d H:i:s");
        
        // Soft delete - change is_delete from 0 to 1
        DB::table('emp_reportto')->where('id',$id)->update(['is_delete' => 1]);
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete Report To id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        return redirect(route('hrd.employee'))->with('status', 'Report to has been deleted');
    }

    public function contactEmp($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $eds = $this->ed->where('emp_number', $id)->orderBy('ed_seqno')->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Contact Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Contact Employee, emp number ' . $id . ', name ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_dependents'
        ]);

        return view('partials.employee.manage.contact', compact('emp', 'eds'));
    }

    public function setContactEmp(Request $request) {
        $now = date("Y-m-d H:i:s");
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
            'action' => 'HRD Set Contact Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Contact Employee, emp number ' . $request->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_dependents'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function qualificationsEmp($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first(); //fix bug img
        $quali = $this->qlt->where('emp_number', $id)->get();
        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Qualifications Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Qualifications Employee, emp number ' . $id . ', name ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_work_experience, emp_trainning, emp_education'
        ]);

        return view('partials.employee.manage.qualification', compact('emp', 'quali', 'trains', 'edus'));
    }

    public function setEducation(Requests\Employee\AddEducation $request) {
        $now = date("Y-m-d H:i:s");
        
        if($request->education_id == 0){
            return back()->withErrors(['error' => 'Education level cannot be empty!']);
        }
        
        if($request->year == null){
            $request->year = 0;
        }
        
        $this->edu->create([
            'emp_number' => $request->idEduEmp,
            'education_id' => $request->education_id,
            'institute' => $request->institute,
            'major' => $request->major,
            'year' => $request->year,
            'score' => $request->score,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Education',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Education, emp number ' . $request->idEduEmp . ', education id ' . $request->education_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_education'
        ]);

        return redirect()->route('personalEmp.qualifications', $request->idEduEmp)->with('status', 'Education has been added');
    }

    public function setWork(Requests\Employee\AddWork $request) {
        $now = date("Y-m-d H:i:s");
        $this->qlt->create([
            'emp_number' => $request->idWorkEmp,
            'eexp_employer' => $request->eexp_employer,
            'eexp_jobtit' => $request->eexp_jobtit,
            'eexp_from_date' => $request->eexp_from_date,
            'eexp_to_date' => $request->eexp_to_date,
            'eexp_comments' => $request->eexp_comments
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Work',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Work, emp number ' . $request->idWorkEmp,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_work_experience'
        ]);

        return redirect()->route('personalEmp.qualifications', $request->idWorkEmp)->with('status', 'Work experience has been added');
    }

    public function setTrain(Request $request) {
        $now = date("Y-m-d H:i:s");
        $this->train->create([
            'emp_number' => $request->idTrainEmp,
            'train_name' => $request->train_name,
            'license_no' => $request->license_no,
            'license_issued_date' => $request->license_issued_date,
            'license_expiry_date' => $request->license_expiry_date
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Training',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Training, emp number ' . $request->idTrainEmp,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning'
        ]);

        return redirect()->route('personalEmp.qualifications', $request->idTrainEmp)->with('status', 'Training has been added');
    }
    
    public function deleteEducation($id){
        $now = date("Y-m-d H:i:s");
        
        $education = $this->edu->find($id);
        $emp_number = $education->emp_number;
        
        // Hard delete
        $this->edu->where('id',$id)->delete();
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',  
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete Education id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect()->route('personalEmp.qualifications', $emp_number)->with('status', 'Education has been deleted');
    }

    public function deleteWork($id){
        $now = date("Y-m-d H:i:s");
        
        $work = $this->qlt->find($id);
        $emp_number = $work->emp_number;
        
        $this->qlt->where('id',$id)->delete();
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete Work Experience id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect()->route('personalEmp.qualifications', $emp_number)->with('status', 'Work Experience has been deleted');
    }

    public function deleteTrain($id){
        $now = date("Y-m-d H:i:s");
        
        $training = $this->train->find($id);
        $emp_number = $training->emp_number;
        
        $this->train->where('id',$id)->delete();
        
        \DB::table('log_activity')->insert([
            'action' => 'update data employee',
            'module' => 'Master',
            'sub_module' => 'Personal',
            'modified_by' => Session::get('name'),
            'description' => 'delete Training id '.$id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        return redirect()->route('personalEmp.qualifications', $emp_number)->with('status', 'Training has been deleted');
    }

    public function emergencyEmp($id) {
        $now = date("Y-m-d H:i:s");
        $eec = $this->eec->where('emp_number', $id)->orderBy('eec_seqno')->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Emergency Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Emergency Employee, emp number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_emergency_contacts'
        ]);

        return view('partials.employee.manage.eec', compact('eec'));
    }

    public function getEmergencyDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $eec = $this->eec->where('id', $request->id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Emergency Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Emergency Detail, emergency id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_emergency_contacts'
        ]);

        return response()->json($eec);
    }

    public function setEmergencyDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $eec = $this->eec->updateOrCreate(['id' => $request->id, 'emp_number' => $request->idEmp],
                [
                    'eec_name' => $request->eec_name,
                    'eec_relationship' => $request->eec_relationship,
                    'eec_home_no' => $request->eec_home_no,
                    'eec_mobile_no' => $request->eec_mobile_no,
                    'eec_office_no' => $request->eec_office_no
        ]);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Emergency Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Emergency Detail, emergency id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_emergency_contacts'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }
    
    public function deleteEmergency($id){
        $now = date("Y-m-d H:i:s");
        
        // Hard delete
        $this->eec->where('id',$id)->delete();
        
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
        
        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function dependentsEmp($id) {
        $now = date("Y-m-d H:i:s");
        $eds = $this->ed->where('emp_number', $id)->orderBy('id')->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Dependent Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Dependent Employee, emp number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_dependents'
        ]);
//        print_r($eds); die;
        return view('partials.employee.manage.dependent', compact('eds'));
    }

    public function setDependentsEmp(Request $request) {
        $now = date("Y-m-d H:i:s");
        if (empty($request->idDep)) {
            $this->ed->create([
                'emp_number' => $request->idEmp,
                'ed_name' => $request->ed_name,
                'ed_relationship' => $request->ed_relationship,
                'ed_date_of_birth' => $request->ed_date_of_birth
            ]);

            \DB::table('log_activity')->insert([
                'action' => 'HRD Create Dependent Employee',
                'module' => 'Master',
                'sub_module' => 'Employee',
                'modified_by' => Session::get('name'),
                'description' => 'HRD Create Dependent Employee, Dep id ' . $request->idDep,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_dependents'
            ]);
        } else {
            $this->ed->where('id', $request->idDep)->update([
                'emp_number' => $request->idEmp,
                'ed_name' => $request->ed_name,
                'ed_relationship' => $request->ed_relationship,
                'ed_date_of_birth' => $request->ed_date_of_birth
            ]);

            \DB::table('log_activity')->insert([
                'action' => 'HRD Update Dependent Employee',
                'module' => 'Master',
                'sub_module' => 'Employee',
                'modified_by' => Session::get('name'),
                'description' => 'HRD Update Dependent Employee, Dep id ' . $request->idDep,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_dependents'
            ]);
        }
        
        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function delDependentsEmp($id) {
        $now = date("Y-m-d H:i:s");
        // Hard delete
        $this->ed->where('id', $id)->delete();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Delete Dependent Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Delete Dependent Employee, Dep id ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_dependents'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function setEducationEmp(Request $request) {
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
        
        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function setWorkEmp(Request $request) {
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $this->qlt->create([
            'emp_number' => $emp->emp_number,
            'eexp_employer' => $request->eexp_employer,
            'eexp_jobtit' => $request->eexp_jobtit,
            'eexp_from_date' => $this->date_convert($request->eexp_from_date),
            'eexp_from_date' => $this->date_convert($request->eexp_from_date),
            'eexp_to_date' => $this->date_convert($request->eexp_to_date),
            'eexp_comments' => $request->eexp_comments
        ]);
        
        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function search_emp(Request $request) {
        $where = '';
        $username = Session::get('username');

        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'emp_name') {
                } else if ($key == 'employee_id') {
                    $where .= $key . " LIKE '%" . $val . "%' AND ";
                } else if ($key == 'termination_id') {
                    if ($val == 1) {
                        $where .= "(". $key . " = 0)";
                    } else {
                        $where .=  $key . " NOT IN (0)";
                    }
                } else {
                    $where .= $key . " = '" . $val . "' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        $project = DB::table('location')->where('code', Session::get('project'))->first();

        if (Session::get('project') == 'HO') {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5) 
                ");
            } else {

                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and " . $where . "
                ");
            }
        } else {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and location_id = " . $project->id
                );
            } else {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and location_id = " . $project->id . " and " . $where . "
                ");
            }
        }
        
        $emps = collect($emps);
        
        if($request->emp_name != ''){
           $emps = $emps->filter(function($emp) use($request) {
               $emp_name = '';
               if($emp->emp_firstname != ''){
                   $emp_name .= $emp->emp_firstname;
               }
               if($emp->emp_middle_name != ''){
                   $emp_name .= ' '.$emp->emp_middle_name;
               }
               if($emp->emp_lastname != ''){
                   $emp_name .= ' '.$emp->emp_lastname;
               }
                if(str_contains(strtolower($emp_name),strtolower($request->emp_name))) {
                    return $emp;
                }
            })->values()->toArray();
        }

        \Session::forget('param_search_emp');
        session()->put('param_search_emp', [
            "emp_name" => empty($request->emp_name) ? null : $request->emp_name,
            "employee_id" => empty($request->employee_id) ? null : $request->employee_id,
            "emp_status" => empty($request->emp_status) ? null : $request->emp_status,
            "eeo_cat_code" => empty($request->eeo_cat_code) ? null : $request->eeo_cat_code,
            "termination_id" => empty($request->termination_id) ? null : $request->termination_id
        ]);
            
        return view('pages.manage.emp.index', compact('emps','username'));
    }

    public function search_emp_get() {
        $where = '';
        $username = Session::get('username');

        $emp_name = request()->query('emp_name');
        $employee_id = request()->query('employee_id');
        $termination_id = request()->query('termination_id');
        $emp_status = request()->query('emp_status');
        $eeo_cat_code = request()->query('eeo_cat_code');

        $emp_name = empty($emp_name) ? null : base64_decode($emp_name);
        $employee_id = empty($employee_id) ? null : base64_decode($employee_id);
        $termination_id = empty($termination_id) ? null : base64_decode($termination_id);
        $emp_status = empty($emp_status) ? null : base64_decode($emp_status);
        $eeo_cat_code = empty($eeo_cat_code) ? null : base64_decode($eeo_cat_code);

        if($employee_id <> null) {
            $where .= "employee_id LIKE '%" . $employee_id . "%' AND ";
        }
        if($termination_id <> null) {
            if ($termination_id == 1) {
                $where .= "(termination_id = 0)";
            }
            else {
                $where .= "termination_id NOT IN (0)";
            }
        }
        if($emp_status <> null) {
            $where .= "emp_status = '" . $emp_status . "' AND ";
        }
        if($eeo_cat_code <> null) {
            $where .= "eeo_cat_code = '" . $eeo_cat_code . "' AND ";
        }

        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        $project = DB::table('location')->where('code', Session::get('project'))->first();

        if (Session::get('project') == 'HO') {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5) 
                ");
            } else {

                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and " . $where . "
                ");
            }
        } else {
            if ($where == '') {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and location_id = " . $project->id
                );
            } else {
                $emps = DB::select("
                    SELECT * FROM employee WHERE emp_status IN (1,2,5)  and location_id = " . $project->id . " and " . $where . "
                ");
            }
        }
        
        $emps = collect($emps);
        
        if($emp_name <> null) {
           $emps = $emps->filter(function($emp) use($emp_name) {
               $emp_name_filter = '';
               if($emp->emp_firstname != ''){
                   $emp_name_filter .= $emp->emp_firstname;
               }
               if($emp->emp_middle_name != ''){
                   $emp_name_filter .= ' '.$emp->emp_middle_name;
               }
               if($emp->emp_lastname != ''){
                   $emp_name_filter .= ' '.$emp->emp_lastname;
               }
                if(str_contains(strtolower($emp_name_filter),strtolower($emp_name))) {
                    return $emp;
                }
            })->values()->toArray();
        }

        \Session::forget('param_search_emp');
        session()->put('param_search_emp', [
            "emp_name" => empty($emp_name) ? null : $emp_name,
            "employee_id" => empty($employee_id) ? null : $employee_id,
            "emp_status" => empty($emp_status) ? null : $emp_status,
            "eeo_cat_code" => empty($eeo_cat_code) ? null : $eeo_cat_code,
            "termination_id" => empty($termination_id) ? null : $termination_id
        ]);
            
        return view('pages.manage.emp.index', compact('emps','username'));
    }

    public function getEmpName(Request $request) {
        $now = date("Y-m-d H:i:s");
        $arr = array();
        $i = 0;
//        $emp = $this->emp->where('termination_id','=',0)
//                        ->where('emp_firstname', 'like', '%' . $request->emp_name . '%')
//                        ->whereOr('emp_middle_name', 'like', '%' . $request->emp_name . '%')
//                        ->whereOr('emp_lastname', 'like', '%' . $request->emp_name . '%')->get();
        
        if (Session::get('pnum') == '1804' && Session::get('ptype') == '01') 
        {
            $emp = $this->emp->where('termination_id','=',0)->get();
        }
        else
        {
            $emp = $this->emp->where('termination_id','=',0)
                    ->where('pnum','=',Session::get('pnum'))
                    ->where('ptype','=',Session::get('ptype'))
                    ->get();
        }
        
        
        if($request->emp_name != ''){
           $emp = $emp->filter(function($emp) use($request) {
               $emp_name = '';
               if($emp->emp_firstname != ''){
                   $emp_name .= $emp->emp_firstname;
               }
               if($emp->emp_middle_name != ''){
                   $emp_name .= ' '.$emp->emp_middle_name;
               }
               if($emp->emp_lastname != ''){
                   $emp_name .= ' '.$emp->emp_lastname;
               }
                if(str_contains(strtolower($emp_name),strtolower($request->emp_name))) {
                    return $emp;
                }
            })->values()->toArray();
        }
        
        foreach ($emp as $row) {
            $arr[$i] = $row['emp_firstname']. ' ' . $row['emp_middle_name'] . ' ' . $row['emp_lastname'] . '/' . $row['employee_id'] . '/' . $row['emp_number'];
            $i++;
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Employee Name',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get EMployee Name,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return response()->json($arr);
    }

    public function empPic($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $emp->emp_number)->first();
//        print_r($pic); die;

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Employee Pic',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Employee Pic, emp number ' . $emp->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_picture'
        ]);

        return view('pages.manage.emp.emp_pic', compact('emp', 'pic'));
    }

    public function setEmpPic(Request $request) {
        //dd($request->all());
        $now = date("Y-m-d H:i:s");
        $pic = DB::table('emp_picture')->where('emp_number', $request->emp_number)->first();
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        if ($request->emp_pic <> 'None') {
            if ($request->hasFile('emp_pic')) {
                $image = $request->file('emp_pic');
                if ($image->getSize() < '2048000') {
                    $fp = fopen($image->getRealPath(), 'rb');
                    $file_content = fread($fp, filesize($image->getRealPath()));
                    $file_content = addslashes(base64_encode($file_content)); // Image store in image data type sql Server
                    fclose($fp);
                    $image_out = $file_content;
                    $size = $image->getSize();
                    $mime = $image->getMimeType();
                    $name = $request->emp_name . ' ' . $request->employee_id . '.' . $image->getClientOriginalExtension();
                } else {
                    return back()->withErrors(['error' => 'Size File terlalu besar']);
                }
            }
            if ($pic) {
                DB::table('emp_picture')->where('id', $pic->id)->where('emp_number', $request->emp_number)->update([
                    'epic_picture' => $image_out,
                    'epic_type' => $mime,
                    'epic_file_size' => $size,
                    'epic_picture_type' => '1'
                ]);
            } else {
                DB::table('emp_picture')->insert([
                    'emp_number' => $request->emp_number,
                    'epic_picture' => $image_out,
                    'epic_filename' => $name,
                    'epic_type' => $mime,
                    'epic_file_size' => $size,
                    'epic_file_width' => '112',
                    'epic_file_height' => '200',
                    'epic_picture_type' => '1'
                ]);
            }
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Employee Pic',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Employee Pic, emp number ' . $emp->emp_number,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_picture'
        ]);

        return redirect(route('personalEmp.empPic', $request->emp_number));
    }

    public function getRewardPunishEmp($id) {
        $now = date("Y-m-d H:i:s");
        $eRewards = $this->eReward->where('emp_number', $id)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('emp_number', $id)->where('promo_pnum', Session::get('pnum'))
                        ->where('promo_ptype', Session::get('ptype'))->orderBy('id')->get();
        $ePunish = DB::select("Select a.id,b.name as punish_type,a.punish_reason, YEAR(hrd_approved_at) as year_punish
                            from emp_punishment_request as a INNER JOIN punishment_type as b ON a.punish_type = b.id
                            where a.punish_status = 3
                            and a.sub_emp_number = ".$id."
                            ORDER BY YEAR(hrd_approved_at) DESC");

        $punishment_type = \DB::table("punishment_type")->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Reward Punish Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Reward Punish Employee, emp number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_rewards, emp_promotions'
        ]);

        return view('partials.employee.manage.reward', compact('eRewards', 'ePromots', 'ePunish', 'punishment_type'));
    }

    public function getRewardDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $eReward = $this->eReward->where('id', $request->id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Reward Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Reward Detail, reward id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_rewards'
        ]);

        return response()->json($eReward);
    }

    public function setRewardDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->emp_idRw)->first();
        if ($request->employee_id) {
            $emp_id = $request->employee_id;
        } else {
            $emp_id = $emp->employee_id;
        }
        $this->eReward->updateOrCreate(
                ['id' => $request->idPr],
                ['emp_number' => $request->emp_idRw,
                    'employee_id' => $emp_id,
                    'rewards_id' => $request->rewards_id,
                    'year_reward' => $request->year_reward]
        );

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Reward Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Reward Detail, reward id ' . $request->idPr,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_rewards'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function getPromotDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $eReward = $this->ePromot->where('id', $request->id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Promotion Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Promotion Detail, promotion id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotions'
        ]);

        return response()->json($eReward);
    }

    public function getPunishDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $ePunish = \DB::table("emp_punishment_request")->where('id', $request->id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Punishment Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Punishment Detail, punishment id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_punishment_request'
        ]);

        $ePunish->TRX_DATE = date("Y-m-d", strtotime($ePunish->created_at));

        return response()->json($ePunish);
    }

    public function setPromotDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $this->ePromot->updateOrCreate(
                ['id' => $request->idPr],
                ['emp_number' => $request->emp_idPr,
                    'promotion_date' => $request->promotion_date,
                    'promotion_from' => $request->promotion_from,
                    'promotion_to' => $request->promotion_to,
                    'promo_pnum' => Session::get('pnum'),
                    'promo_ptype' => Session::get('ptype')]
        );

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Promotion Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Promotion Detail, promotion id ' . $request->idPr,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotions'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function setPunishDtl(Request $request) {
        $now = date("Y-m-d H:i:s");

        $dataEmp = \DB::table("employee")->where("emp_number", $request->emp_idPh)->first();

        if($request->idPh == 0) {
            \DB::table("emp_punishment_request")->insert([
                "sub_emp_number" => $request->emp_idPh,
                "emp_id" => $dataEmp->employee_id,
                "punish_type" => $request->punish_type,
                "punish_status" => $request->punish_status,
                "punish_reason" => $request->punish_reason,
                "created_at" => $request->punishment_date,
                "created_by" => 1,
                "hrd_approved_at" => $request->punishment_date,
                "hrd_approved_by" => 1
            ]);
        }
        else {
            \DB::table("emp_punishment_request")->where("id", $request->idPh)->update([
                "punish_type" => $request->punish_type,
                "punish_status" => $request->punish_status,
                "punish_reason" => $request->punish_reason,
                "created_at" => $request->punishment_date,
                "hrd_approved_at" => $request->punishment_date
            ]);
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Punishment Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Punishment Detail, punishment id ' . $request->idPh,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_punishment_request'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function addEmp(Requests\HRD\Employee\AddEmployee $request) {
        \DB::beginTransaction();

        $now = date("Y-m-d H:i:s");
        $project = Location::where('id', '=', $request->location_id)->first();

        if(!empty($request->TXT_REPORT_TO_DATATABLE)) {
            $report_to_table = json_decode($request->TXT_REPORT_TO_DATATABLE);
        }
        else {
            $report_to_table = [];
        }

        $dataCounter = DB::table('counter_doc')->where('id', '=', 1)->first();

        $cekDataTitle = $this->empDW->where('title', '=', $request->employee_id)->count();

        if($request->eeo_cat_code == 0) {
            return redirect(route('hrd.employee'))->withErrors(['error' => 'Divisi Harus di Isi']);
        }
        
        if($request->location_id == 0) {
            return redirect(route('hrd.employee'))->withErrors(['error' => 'Unit/Project Harus di Isi']);
        }

        if ($cekDataTitle > 0) {
            return redirect(route('hrd.employee'))->withErrors(['error' => 'NIK ' . $request->employee_id . ' sudah terdaftar di System Absensi, Transaksi Gagal!']);
        }

        $this->empDW->create([
            'name' => $request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname,
            'title' => $request->employee_id,
            'badgenumber' => $dataCounter->counter_badgenumber,
            'defaultdeptid' => $project->adms_dept_id,
            'minzu' => '0',
            'SN' => 'OID6110056102700821'
        ]);
        
        if($request->days_type == 'on') {
            $days_type = 1;
        }
        else {
            $days_type = 0;
        }

        $emp_number =  \DB::table('employee')->insertGetId([
            'employee_id' => $request->employee_id,
            'badgenumber' => $dataCounter->counter_badgenumber,
            'emp_firstname' => $request->emp_firstname,
            'emp_middle_name' => $request->emp_middle_name,
            'emp_lastname' => $request->emp_lastname,
            'emp_fullname' => $request->emp_firstname . ' ' . $request->emp_middle_name . ' ' . $request->emp_lastname,
            'eeo_cat_code' => $request->eeo_cat_code, // Division
            'emp_status' => $request->estatus, // Employment Status
            'location_id' => $request->location_id,
            'termination_id' => 0,
            'days_type' => $days_type,
            'pnum' => Session::get('pnum'),
            'ptype' => Session::get('ptype'),
            'emp_ktp' => $request->emp_ktp, // KTP
            'emp_gender' => $request->emp_gender, // Gender
            'nation_code' => $request->nation_code, // Nationality
            'emp_dri_lice_num' => $request->emp_dri_lice_num, // Driver's License Number
            'emp_dri_lice_exp_date' => $request->emp_dri_lice_exp_date, // License Expiry Date
            'emp_marital_status' => $request->emp_marital_status, // Marital Status
            'emp_birthday' => $request->emp_birthday, // Date of Birth,
            'bpjs_ks' => $request->bpjs_ks, // BPJS Kes
            'bpjs_tk' => $request->bpjs_tk, // BPJS TK
            'npwp' => $request->npwp, // No. NPWP
            'job_level' => $request->job_level, // Job Title
            'joined_date' => $request->joined_date, // Joined Date
            'work_station' => $request->work_station, // SubUnit
            'job_title_code' => $request->job_title_code, // Job Level,
            'job_dept_id' => $request->department // Department
        ]);

        for($i = 0; $i < count($report_to_table); $i++) {
            DB::table("emp_reportto")->insert([
                'erep_sup_emp_number' => $report_to_table[$i][0],
                'erep_sub_emp_number' => $emp_number,
                'erep_reporting_mode' => $report_to_table[$i][2]
            ]);
        }

        DB::table('counter_doc')->where('id', '=', 1)->update([
            'counter_badgenumber' => $dataCounter->counter_badgenumber + 1
        ]);

        $this->sendEmailAddEmployee($request->employee_id);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Add Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Add Employee, employee id ' . $request->employee_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        \DB::commit();

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'))->with("status", "Success Add Employee");
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route)->with("status", "Success Add Employee");
        }
    }

    public function addEmpDW(Request $request) {
        $now = date("Y-m-d H:i:s");
        $badgeNumber = DB::table('counter_doc')->where('id', 1)->first();

        $cekDataTitle = $this->empDW->where('title', '=', $request->title)->count();

        if ($cekDataTitle > 0) {
            return redirect(route('hrd.employee'))->withErrors(['error' => 'NIK ' . $request->title . ' sudah terdaftar di System Absensi, Transaksi Gagal!']);
        }

//        $this->sendEmailAddEmployeeDW('1305013');
//        dd('test');

        $this->empDW->create([
            'name' => $request->name,
            'title' => $request->title,
            'badgenumber' => $badgeNumber->counter_badgenumber,
            'defaultdeptid' => $request->defaultdeptid,
            'minzu' => '1',
            'SN' => 'OID6110056102700821'
        ]);

        $newBadgeNumber = $badgeNumber->counter_badgenumber + 1;
        DB::table('counter_doc')->where('id', 1)->update(['counter_badgenumber' => $newBadgeNumber]);

        $this->sendEmailAddEmployeeDW($request->title);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Add Employee DW',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Add Employee DW, employee id ' . $request->userid,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function terminateEmp(Requests\Employee\TerminationReqeust $request) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->terminate_emp_id)->first();
//        $pr_emp = PayrollEmp::where('emp_number', $request->terminate_emp_id)->first();
        $terminate = EmpTerminate::create([
                    'emp_number' => $emp->emp_number,
                    'reason_id' => $request->reason_id,
                    'termination_date' => $this->date_convert($request->termination_date),
                    'note' => $request->note,
                    'status' => 4,
                ])->id;
//        print_r($terminate); die;
        $this->emp->where('emp_number', $emp->emp_number)
                ->where('employee_id', $emp->employee_id)
                ->update(['termination_id' => $terminate]);
        
        DB::table('emp_evaluator')
                ->where('emp_evaluation','=',$emp->emp_number)
                ->where('is_delete','=',0)
                ->update(['is_delete'=>1]);
        
        DB::table('emp_appraisal_type')
                ->where('emp_number','=', $emp->emp_number)
                ->where('is_delete','=',0)
                ->update(['is_delete'=>1]);
        
        
        $ch = curl_init();
        if($_SERVER['SERVER_NAME'] == 'trialhris.metropolitanland.com'){
            curl_setopt($ch, CURLOPT_URL,"https://trialsso.metropolitanland.com/Api/TerminateUser/Hris");
        }else{
            curl_setopt($ch, CURLOPT_URL,"https://sso.metropolitanland.com/Api/TerminateUser/Hris");
        }
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);

        // In real life you should use something like:
         curl_setopt($ch, CURLOPT_POSTFIELDS, 
                  http_build_query(array('NIK' => $emp->employee_id,'terminate_by'=>Session::get('name'), 'is_unterminate' => 0)));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $server_output = curl_exec($ch);

        curl_close($ch);
        
        $server_respond = json_decode($server_output);

        \DB::table('log_activity')->insert([
            'action' => 'TERMINATE_EMP',
            'module' => 'Employee',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'Terminate NIK ' . $emp->employee_id . 'Reason ID: ' . $request->reason_id . ' Notes: ' . $request->note . ' (HRD)',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        if($server_respond->status == 'SUCCESS'){
        return redirect(route('hrd.employee'))->with('status', 'Employee has been successfully terminated');
        }else{
            return redirect(route('hrd.employee'))->with('alert-error', "Fail to terminate in SSO, Employee has been terminated in HRIS");
        }
    }

    public function unterminateEmp(Requests\Employee\UnterminationReqeust $request) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $request->terminate_emp_id)->first();

        $this->emp->where('emp_number', $emp->emp_number)
                ->where('employee_id', $emp->employee_id)
                ->update(['termination_id' => 0]);
        
        $ch = curl_init();
        if($_SERVER['SERVER_NAME'] == 'trialhris.metropolitanland.com'){
            curl_setopt($ch, CURLOPT_URL,"https://trialsso.metropolitanland.com/Api/TerminateUser/Hris");
        }else{
            curl_setopt($ch, CURLOPT_URL,"https://sso.metropolitanland.com/Api/TerminateUser/Hris");
        }
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);

        // In real life you should use something like:
         curl_setopt($ch, CURLOPT_POSTFIELDS, 
                  http_build_query(array('NIK' => $emp->employee_id,'terminate_by'=>Session::get('name'), 'is_unterminate' => 1)));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $server_output = curl_exec($ch);

        curl_close($ch);
        
        $server_respond = json_decode($server_output);

        \DB::table('log_activity')->insert([
            'action' => 'UNTERMINATE_EMP',
            'module' => 'Employee',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'Unterminate NIK ' . $emp->employee_id . ' Notes: ' . $request->note . ' (HRD)',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        if($server_respond->status == 'SUCCESS'){
        return redirect(route('hrd.employee'))->with('status', 'Employee has been successfully unterminated');
        }else{
            return redirect(route('hrd.employee'))->with('alert-error', "Fail to unterminate in SSO, Employee has been terminated in HRIS");
        }
    }

    public function getReportToDtl(Request $request) {
        $now = date("Y-m-d H:i:s");
        $rppt = EmpReportTo::join('employee', 'emp_reportto.erep_sup_emp_number', '=', 'employee.emp_number')
                        ->select('emp_reportto.*', DB::raw("CONCAT([employee].[emp_firstname],' ', [employee].[emp_middle_name],' ', [employee].[emp_lastname]) AS fullname"))
                        ->where('emp_reportto.id', $request->id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Report To Detail',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Report To Detail, report to id ' . $request->id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_promotions'
        ]);
        return response()->json($rppt);
    }

    public function getSupReportTo(Request $request) {
        $now = date("Y-m-d H:i:s");
        $arr = array();
        $i = 0;
//        $rppt = DB::select("
//            SELECT emp_number, CONCAT(emp_firstname, ' ', emp_middle_name, ' ', emp_lastname) AS name FROM employee
//            WHERE (emp_firstname LIKE '%" . $request->emp_sup . "%' OR emp_middle_name LIKE '%" . $request->emp_sup . "%'
//            OR emp_lastname LIKE '%" . $request->emp_sup . "%' ) and termination_id = 0
//        ");
        $rppt = DB::select("
            SELECT emp_number, emp_fullname FROM employee
            WHERE termination_id = 0
        ");
        
        
        
//        dd($rppt);
        
        if($request->emp_sup != ''){
           $rppt = collect($rppt);
           $rppt = $rppt->filter(function($rppt) use($request) {
                if(str_contains(strtolower($rppt->emp_fullname),strtolower($request->emp_sup))) {
                    return $rppt;
                }
            })->values()->toArray();
        }
        foreach ($rppt as $row) {
            $arr[$i] = $row->emp_number . '|' . $row->emp_fullname;
            $i++;
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Get Sup Report To',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Get Sup Report To,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_reportto'
        ]);

        return response()->json($arr);
    }

    public function setReportTo(Request $request) {
        $now = date("Y-m-d H:i:s");

        EmpReportTo::updateOrCreate(
                ['id' => $request->rpt_id],
                ['erep_sup_emp_number' => $request->emp_supId,
                    'erep_sub_emp_number' => $request->emp_subId,
                    'erep_reporting_mode' => $request->rt_type]
        );

        \DB::table('log_activity')->insert([
            'action' => 'HRD Set Report To',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Set Report To, report to id ' . $request->rpt_id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_reportto'
        ]);

        if(session("param_search_emp") == null) {
            return redirect(route('hrd.employee'));
        }
        else {
            $param_search_emp = session("param_search_emp");
            $param_route = "";
            if($param_search_emp["emp_name"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
                else {
                    $param_route .= "&emp_name=" . base64_encode($param_search_emp["emp_name"]);
                }
            }
            if($param_search_emp["employee_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
                else {
                    $param_route .= "&employee_id=" . base64_encode($param_search_emp["employee_id"]);
                }
            }
            if($param_search_emp["emp_status"] <> null) {
                if($param_route == "") {
                    $param_route .= "?emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
                else {
                    $param_route .= "&emp_status=" . base64_encode($param_search_emp["emp_status"]);
                }
            }
            if($param_search_emp["eeo_cat_code"] <> null) {
                if($param_route == "") {
                    $param_route .= "?eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
                else {
                    $param_route .= "&eeo_cat_code=" . base64_encode($param_search_emp["eeo_cat_code"]);
                }
            }
            if($param_search_emp["termination_id"] <> null) {
                if($param_route == "") {
                    $param_route .= "?termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
                else {
                    $param_route .= "&termination_id=" . base64_encode($param_search_emp["termination_id"]);
                }
            }
            return redirect("/hrd/search_emp_get" . $param_route);
        }
    }

    public function emp_list(Request $request) {
        $arr = array();
        $i = 0;
//        DB::enableQueryLog();
        if (Session::get('project') == 'HO') {
            $emps = $this->emp->where('termination_id','=',0)
                            ->where('emp_firstname', 'like', '%' . $request->q . '%')
                            ->orWhere('emp_middle_name', 'like', '%' . $request->q . '%')
                            ->orWhere('emp_lastname', 'like', '%' . $request->q . '%')
                            ->orWhere('employee_id', 'like', '%' . $request->q . '%')->get();
        } else {
            $emps = $this->emp->where('termination_id','=',0)
                            ->where('pnum', Session::get('pnum'))
                            ->where('ptype', Session::get('ptype'))
                            ->where('emp_firstname', 'like', '%' . $request->q . '%')
                            ->orWhere('emp_middle_name', 'like', '%' . $request->q . '%')
                            ->orWhere('emp_lastname', 'like', '%' . $request->q . '%')
                            ->orWhere('employee_id', 'like', '%' . $request->q . '%')->get();
        }
        foreach ($emps as $row) {
            $arr[$i] = $row->emp_number . '|' . $row->employee_id . '|' . $row->emp_firstname . ' ' . $row->emp_middle_name . ' ' . $row->emp_lastname . '|' . $row->job_title->job_title;
            $i++;
        }
        return response()->json($arr);
    }

    public function renewContract($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->where('termination_id','=',0)->first();
        $contracts = EmpContract::where('emp_number', $emp->emp_number)
        ->where('is_delete','=',0)->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD Renew Contract',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Renew Contract, employee number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.contract.index', compact('emp', 'contracts'));
    }

    public function setRenewContract(Request $request) {
        EmpContract::where('emp_number', $request->emp_number)->update(['econ_status' => '4']);
        EmpContract::create([
            'emp_number' => $request->emp_number,
            'econ_extend_id' => $request->emp_number,
            'econ_extend_start_date' => $this->date_convert($request->econ_extend_start_date),
            'econ_extend_end_date' => $this->date_convert($request->econ_extend_end_date),
            'template_id' => $request->template_id,
            'econ_status' => '1'
        ]);
        return redirect(route('hrd.renewContract', $request->emp_number));
    }

    public function printContract($id) {
        $contract = EmpContract::find($id);
        if (!$contract) {
            return redirect()->back()->with('error', 'Contract tidak ditemukan');
        }
        
        $emp = $this->emp->where('emp_number', $contract->emp_number)->first();
        if (!$emp) {
            return redirect()->back()->with('error', 'Employee tidak ditemukan');
        }
        
        $temp = TemplateContract::where('id', $contract->template_id)->first();
        
        // Siapkan data yang diperlukan template
        $data = [
            'contract' => $contract,
            'emp' => $emp,
            'start_date' => date('d F Y', strtotime($contract->econ_extend_start_date)),
            'awal_kontrak' => date('d F Y', strtotime($contract->econ_extend_start_date)),
            'akhir_kontrak' => date('d F Y', strtotime($contract->econ_extend_end_date)),
            'staf_posisi' => $emp->job_title,
            'staf_level' => $emp->job_level,
            'staf_dept' => $emp->department,
            'staf_PT' => 'METROPOLITAN LAND TBK',
            'Nama_Staf' => $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'Jabatan_Staf' => $emp->job_title,
            'Alamat_Staf' => $emp->con_add1 . ' ' . $emp->con_add2,
            'Nama_Metland' => 'NAMA HRD',
            'Jabatan_Metland' => 'HRD Manager',
            'Alamat_Metland' => 'Jl. M.H. Thamrin No.1'
        ];

        // Jika template tidak ditemukan atau file_temp kosong, gunakan default template
        if (!$temp || !$temp->file_temp) {
            return view('prints.pdfPKWT', $data);
        }
        
        // Cek apakah view template ada
        if (!view()->exists($temp->file_temp)) {
            // Jika view tidak ditemukan, coba cari di folder prints
            $viewPath = 'prints.' . str_replace('/', '.', $temp->file_temp);
            if (view()->exists($viewPath)) {
                return view($viewPath, $data);
            }
            // Jika masih tidak ditemukan, gunakan default template
            return view('prints.pdfPKWT', $data);
        }
        
        return view($temp->file_temp, $data);
    }

    private function hitungLamaKontrak($start_date, $end_date) {
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        $interval = $start->diff($end);
        return $interval->y; // Mengembalikan jumlah tahun
    }

    private function terbilang($angka) {
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh'];
        return isset($bilangan[$angka]) ? $bilangan[$angka] : $angka;
    }

    public function editContract($id)
    {
        $contract = EmpContract::find($id);
        if (!$contract) {
            return redirect()->back()->with('error', 'Contract tidak ditemukan');
        }
        
        $emp = $this->emp->where('emp_number', $contract->emp_number)->first();
        if (!$emp) {
            return redirect()->back()->with('error', 'Employee tidak ditemukan');
        }
        
        $temp_contract = TemplateContract::where('type', 'PKWT')->lists('name','id')->prepend('Template PKWT', '0');
        
        return view('pages.manage.contract.edit', compact('contract', 'emp', 'temp_contract'));
    }
// update contract
    public function updateContract(Request $request, $id)
    {
        $contract = \DB::table('emp_contract')->where('id', $id)->first();
        
        \DB::table('emp_contract')->where('id', $id)->update([
            'econ_extend_start_date' => $request->econ_extend_start_date,
            'econ_extend_end_date' => $request->econ_extend_end_date,
            'template_id' => $request->template_id
        ]);

        return redirect()->route('hrd.renewContract', $contract->emp_number)->with('success', 'Data kontrak berhasil diperbarui');
    }

    public function deleteContract($id)
    {
        // $contract = EmpContract::find($id);
        // if (!$contract) {
        //     return redirect()->back()->with('error', 'Contract tidak ditemukan');
        // }

        $contract = EmpContract::where('id','=', $id)
            ->update(['is_delete'=>1]);

        if ($contract) {
            return redirect()->back()->with('success', 'Contract berhasil dihapus');
        }
        else
        {
            return redirect()->back()->with('error', 'Contract tidak dihapus');
        }
    }

    public function find_emp(Request $request) {
        $now = date("Y-m-d H:i:s");
        $arr = array();
        $i = 0;
//        $emps = $this->emp->where('emp_fullname', 'LIKE', '%' . $request->q . '%')
//                        ->orWhere('employee_id', 'LIKE', '%' . $request->q . '%')->get();
        $emps = $this->emp->where('termination_id','=',0)->get();
        
        if($request->q != ''){
           $emps = $emps->filter(function($emp) use($request) {
                if(str_contains(strtolower($emp->emp_fullname),strtolower($request->q))) {
                    return $emp;
                }
                if(str_contains(strtolower($emp->employee_id),strtolower($request->q))) {
                    return $emp;
                }
            })->values()->toArray();
        }
        foreach ($emps as $row) {
            $arr[$i] = trim($row['emp_fullname']) . ';' . $row['employee_id'] . ';' . trim($row['emp_number']);
            $i++;
        } // 211001002
//        print_r($arr); die;

        \DB::table('log_activity')->insert([
            'action' => 'HRD Find Employee',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Find Employee,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return response()->json($arr);
    }

    public function find_emp2(Request $request) {
        $now = date("Y-m-d H:i:s");
        $arr = array();
        $i = 0;
//        $emps = $this->emp->where('emp_number', '<>', $request->empNum)->where('emp_fullname', 'LIKE', '%' . $request->q . '%')
//                        ->orWhere('employee_id', 'LIKE', '%' . $request->q . '%')->get();
        
//        dd($request->empNum);
        $emps = $this->emp->where('emp_number', '<>', $request->empNum)->where('termination_id','=',0)->get();
        
        if($request->q != ''){
           $emps = $emps->filter(function($emp) use($request) {
                if(str_contains(strtolower($emp->emp_fullname),strtolower($request->q))) {
                    return $emp;
                }
                if(str_contains(strtolower($emp->employee_id),strtolower($request->q))) {
                    return $emp;
                }
            })->values()->toArray();
        }
        foreach ($emps as $row) {
            $arr[$i] = trim($row['emp_fullname']) . ';' . $row['employee_id'] . ';' . trim($row['emp_number']);
//            $arr[$i] = trim($row->emp_fullname) . ';' . $row->employee_id . ';' . trim($row->emp_number);
            $i++;
        } // 211001002
//        print_r($arr); die;

        \DB::table('log_activity')->insert([
            'action' => 'HRD Find Employee 2',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Find Employee 2,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return response()->json($arr);
    }

    public function prepareImageDBString($filepath) {
        $out = 'null';
        $handle = @fopen($filepath, 'rb');
        if ($handle) {
            $content = @fread($handle, filesize($filepath));
            $content = bin2hex($content);
            @fclose($handle);
            $out = "0x" . $content;
        }
        return $out;
    }

    public function printSK($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date("Y-m-d H:i:s");

        $emp = DB::select("select top 1 
                                employee.emp_firstname, 
                                employee.emp_middle_name, 
                                employee.emp_lastname,
                                employee.job_level,
                                FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date,
                                FORMAT (emp_termination.termination_date, 'yyyy-MM-dd') as termination_date
                from employee
                inner join emp_termination on employee.emp_number = emp_termination.emp_number
                where emp_termination.status = 4 and employee.emp_number = " . $id);
        $employee = $emp[0];

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print SK',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print SK, employee number ' . $id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);

        return view('prints.pdfSuratKeteranganKerjaNew', compact('employee', 'now'));
    }

    public function administrationDocument($id) {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('emp_number', $id)->first();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Employee Administration Document',
            'module' => 'Master',
            'sub_module' => 'Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Employee Administration Document, employee number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.administration_document.index', compact('emp'));
    }

    public function addTemplate(Request $request) {
        TemplateContract::create([
            'name' => $request->name,
            'file_temp' => $request->file_temp,
            'status' => '0'
        ]);
        return redirect()->back()->with('success', 'Template berhasil ditambahkan');
    }

    public function updateTemplate(Request $request) {
        $template = TemplateContract::find($request->id);
        $template->update([
            'name' => $request->name,
            'file_temp' => $request->file_temp
        ]);
        return redirect()->back()->with('success', 'Template berhasil diupdate');
    }

    public function deleteTemplate($id) {
        $template = TemplateContract::find($id);
        $template->delete();
        return redirect()->back()->with('success', 'Template berhasil dihapus');
    }

//    public function date_convert($date){
//        $new_date = date('Y-m-d', strtotime(substr($date, 0, 11)));
//
//        return $new_date;
//    }

    public function getEmployeeFile($type, $emp_number)
    {
        $fieldMap = [
            'ktp' => 'doc_ktp',
            'npwp' => 'doc_npwp',
            'ijasah' => 'doc_ijasah',
            'kk' => 'doc_kartu_keluarga',
        ];
        if (!isset($fieldMap[$type])) abort(404);

        $emp = $this->emp->where('emp_number', $emp_number)->first();
        if (!$emp) abort(404);
        $filePath = $emp->{$fieldMap[$type]};
        if (!$filePath) abort(404);

        $relativePath = str_replace('/home/HRIS/', '', $filePath);
        if (!Storage::disk('ftp')->exists($relativePath)) abort(404);

        $fileContent = Storage::disk('ftp')->get($relativePath);
        $mime = Storage::disk('ftp')->mimeType($relativePath);

        return response($fileContent, 200)->header('Content-Type', $mime);
    }
}