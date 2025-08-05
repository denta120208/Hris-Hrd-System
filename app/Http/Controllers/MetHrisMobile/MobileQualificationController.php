<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileQualificationController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();
        $this->lvReq = $lvReq;

        $this->user = $user;
        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }


    public function getEmployeeEducation(Request $request){
//        if( $request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $edus = DB::table('emp_education')->where('emp_number', $request->emp_number)
                    ->leftJoin('education', 'emp_education.education_id','=','education.id')
                    ->select('emp_education.id', 'emp_education.emp_number', 'emp_education.education_id', 'emp_education.institute', 'emp_education.major',
                        'emp_education.year', 'emp_education.score', 'emp_education.start_date', 'emp_education.end_date', 'education.name')
                    ->orderBy('emp_education.start_date', 'desc')
                    ->get();
            } else {
                $edus = DB::table('emp_education')->where('emp_number', $request->emp_number_search)
                    ->leftJoin('education', 'emp_education.education_id','=','education.id')
                    ->select('emp_education.id', 'emp_education.emp_number', 'emp_education.education_id', 'emp_education.institute', 'emp_education.major',
                        'emp_education.year', 'emp_education.score', 'emp_education.start_date', 'emp_education.end_date', 'education.name')
                    ->orderBy('emp_education.start_date', 'desc')
                    ->get();
            }

            if ($edus) {
                $result = $edus;
            } else {
                $result = [];
            }
            return response()->json($result, 200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->emp_number_search == 0) {
                $edus = DB::table('emp_education')->where('emp_number', $request->emp_number)
                    ->leftJoin('education', 'emp_education.education_id','=','education.id')
                    ->select('emp_education.id', 'emp_education.emp_number', 'emp_education.education_id', 'emp_education.institute', 'emp_education.major',
                        'emp_education.year', 'emp_education.score', 'emp_education.start_date', 'emp_education.end_date', 'education.name')
                    ->orderBy('emp_education.start_date', 'desc')
                    ->get();
            } else {
                $edus = DB::table('emp_education')->where('emp_number', $request->emp_number_search)
                    ->leftJoin('education', 'emp_education.education_id','=','education.id')
                    ->select('emp_education.id', 'emp_education.emp_number', 'emp_education.education_id', 'emp_education.institute', 'emp_education.major',
                        'emp_education.year', 'emp_education.score', 'emp_education.start_date', 'emp_education.end_date', 'education.name')
                    ->orderBy('emp_education.start_date', 'desc')
                    ->get();
            }

            if ($edus) {
                $result = $edus;
            } else {
                $result = [];
            }
            return response()->json($result, 200);
        }
    }


    public function getEmployeeTraining(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $training = DB::table('emp_trainning')->where('emp_number', $request->emp_number)
                    ->join('trainning','license_id','=','trainning.id')
                    ->select('emp_trainning.id','emp_trainning.license_id','emp_trainning.license_no','emp_trainning.license_issued_date'
                        ,'emp_trainning.license_expiry_date','trainning.name','emp_trainning.train_name')
                    ->orderBy('license_id', 'desc')
                    ->get();
            } else {
                $training = DB::table('emp_trainning')->where('emp_number', $request->emp_number_search)
                    ->join('trainning','license_id','=','trainning.id')
                    ->select('emp_trainning.id','emp_trainning.license_id','emp_trainning.license_no','emp_trainning.license_issued_date'
                        ,'emp_trainning.license_expiry_date','trainning.name','emp_trainning.train_name')
                    ->orderBy('license_id', 'desc')
                    ->get();
            }

            if ($training) {
                $result = $training;
            } else {
                $result = [];
            }
            return response()->json($result,200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->emp_number_search == 0) {
                $training = DB::table('emp_trainning')->where('emp_number', $request->emp_number)
                    ->join('trainning','license_id','=','trainning.id')
                    ->select('emp_trainning.id','emp_trainning.license_id','emp_trainning.license_no','emp_trainning.license_issued_date'
                        ,'emp_trainning.license_expiry_date','trainning.name','emp_trainning.train_name')
                    ->orderBy('license_id', 'desc')
                    ->get();
            } else {
                $training = DB::table('emp_trainning')->where('emp_number', $request->emp_number_search)
                    ->join('trainning','license_id','=','trainning.id')
                    ->select('emp_trainning.id','emp_trainning.license_id','emp_trainning.license_no','emp_trainning.license_issued_date'
                        ,'emp_trainning.license_expiry_date','trainning.name','emp_trainning.train_name')
                    ->orderBy('license_id', 'desc')
                    ->get();
            }

            if ($training) {
                $result = $training;
            } else {
                $result = [];
            }
            return response()->json($result,200);
        }
    }



    public function getEmployeeWorkexperience(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if ($request->atasan_status == 1) {
            if ($request->emp_number_search == 0) {
                $quali = DB::table('emp_work_experience')->where('emp_number', $request->emp_number)->orderBy('eexp_seqno')->get();
            } else {
                $quali = DB::table('emp_work_experience')->where('emp_number', $request->emp_number_search)->orderBy('eexp_seqno')->get();
            }

            if ($quali) {
                $result = $quali;
            } else {
                $result = [];
            }

            return response()->json($result,200);
        } else {
            $employee_mobile = DB::table("MH_USER_MOBILE")
                ->where("EMP_NUMBER", $request->emp_number)
                ->where("DEVICE_UUID", $request->device_uuid)
                ->where("IS_ACTIVE", 1)
                ->first();

            if ($employee_mobile) {
            } else {
                $result = ["result" => "You're not logged in.", "status" => 0];
                return response()->json($result, 200);
            }

            if ($request->emp_number_search == 0) {
                $quali = DB::table('emp_work_experience')->where('emp_number', $request->emp_number)->orderBy('eexp_seqno')->get();
            } else {
                $quali = DB::table('emp_work_experience')->where('emp_number', $request->emp_number_search)->orderBy('eexp_seqno')->get();
            }

            if ($quali) {
                $result = $quali;
            } else {
                $result = [];
            }

            return response()->json($result,200);
        }
    }


   public function getTrainingTopic(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $training_topic = DB::table("trainning")
            ->get();

        return response()->json($training_topic, 200);
    }

    public function getTrainingVendor(Request $request){
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $training_topic = DB::table("trainning_vendor")
            ->whereIn("training_id",[$request->training_id, 0])
            ->get();

        return response()->json($training_topic, 200);
    }


    public function addTrainingVendor(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        DB::table("trainning_vendor")
            ->insert([
                "training_id" => 0,
                "vendor_name" => $request->name,
                "vendor_addr" => $request->address,
                "vendor_tlp" => $request->phone,
                "vendor_fax" => $request->fax,
                "vendor_email" => $request->email,
                "created_by" => $request->emp_number,
                "created_at" => $now

            ]);
        $vendor_id = DB::getPdo()->lastInsertId();

        $this->addMobileLog($request->emp_number, "Training", "Add training vendor : ".$vendor_id);

        $result = ["result" => "Successfully add new institutions.", "status" => 1];
        return response()->json($result, 200);
    }

    public function getEmployeeTrainingRequest(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        $training = DB::table("emp_trainning_request")
                ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
            ->where("emp_number", $request->emp_number)
            ->where("training_status", 1)
            ->select("emp_trainning_request.*","trainning.name as name","trainning_vendor.vendor_name as vendor_name")
            ->get();
        return response()->json($training, 200);


    }


    public function getEmployeeTrainingHistory(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');

//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
        $training = DB::table("emp_trainning_request")
            ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
            ->where("emp_number", $request->emp_number)
            ->where("training_status","!=", 1)
            ->select("emp_trainning_request.*","trainning.name as name","trainning_vendor.vendor_name as vendor_name")
            ->get();
        return response()->json($training, 200);


    }

    public function cancelRequestTraining(Request $request){

//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        DB::table("emp_trainning_request")
                ->where("id", $request->training_id)
                ->update([
                   "training_status" => 0
                ]);

        $this->addMobileLog($request->emp_number, "Training", "Cancel training request : ".$request->training_id);

        $result = ["result" => "Successfully cancel your training request.", "status" => 1];
        return response()->json($result, 200);

    }

    public function addRequestTraining(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if($employee_mobile){

        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }

        DB::table("emp_trainning_request")
            ->insert([
               "emp_number" => $request->emp_number,
                "trainning_id" => $request->training_topic,
                "trainning_intitusion" => $request->institutions,
                "trainning_silabus" => $request->sylabus,
                "trainning_purpose" => $request->purpose,
                "trainning_costs" => $request->cost,
                "trainning_start_date" => $request->start_date,
                "trainning_end_date" => $request->end_date,
                "requested_at" => $now,
                "training_status" => 1
            ]);
        $training_id = DB::getPdo()->lastInsertId();
        $this->addMobileLog($request->emp_number, "Training", "Add training request : ".$training_id);

        $notif = new MobileNotificationController();
        $notif->requestTrainingNotification($training_id);
        $result = ["result" => "Successfully add your request.", "status" => 1];
        return response()->json($result, 200);
    }


    public function getAtasanTrainingRequest(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();
//
//        if($employee_mobile){
//
//        } else {
//            $result = ["result" => "You're not logged in.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $training_request = DB::table('emp_trainning_request')
            ->join('emp_reportto', 'emp_trainning_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_trainning_request.emp_number', '=' ,'employee.emp_number')
            ->join("trainning", "emp_trainning_request.trainning_id","=","trainning.id")
            ->leftJoin("trainning_vendor","emp_trainning_request.trainning_intitusion","=", "trainning_vendor.id")
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_number)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->where('emp_trainning_request.training_status', 1)
            //->take(10)
            ->select("emp_trainning_request.*","trainning.name as name","trainning_vendor.vendor_name as vendor_name", 'emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')
            ->orderBy('emp_trainning_request.requested_at', 'desc')
            ->get();
        return response()->json($training_request, 200);

    }


    public function approveRequestTraining(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $trainig_request = DB::table("emp_trainning_request")
                        ->where("id", $request->training_id)
                        ->first();

        if($trainig_request){
            DB::table("emp_trainning_request")
                ->where("id", $request->training_id)
                ->update([
                   "training_status" => 2,
                   "approved_sup_by" => $request->emp_number,
                    "approved_sup_at" => $now
                ]);
            $notif = new MobileNotificationController();
            $notif->approveTrainingNotification($request->emp_number,$request->training_id);
            $this->addMobileLog($request->emp_number, "Training", "Approve training request : ".$request->training_id);

            $result = ["result" => "Successfully approve training.", "status" => 1];
            return response()->json($result, 200);


        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }


    public function rejectRequestTraining(Request $request){
        date_default_timezone_set('Asia/Jakarta');
        $now = date('Y-m-d H:i:s');
//        if($request->header('APP-ID') == $this->getMobileAppsID()){
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }
        $trainig_request = DB::table("emp_trainning_request")
            ->where("id", $request->training_id)
            ->first();

        if($trainig_request){
            DB::table("emp_trainning_request")
                ->where("id", $request->training_id)
                ->update([
                    "training_status" => 4,
                    "approved_sup_by" => $request->emp_number,
                    "approved_sup_at" => $now
                ]);
            $notif = new MobileNotificationController();
            $notif->rejectTrainingNotification($request->emp_number,$request->training_id);
            $this->addMobileLog($request->emp_number, "Training", "Reject training request : ".$request->training_id);

            $result = ["result" => "Successfully reject training.", "status" => 1];
            return response()->json($result, 200);


        } else {
            $result = ["result" => "Data not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function getLevelEducation(Request $request) {
        $level_education = DB::table('education')
            ->get();
        
        $current_level_education = DB::table('education')
            ->where('id', $request->education_id)
            ->first();

        $result = [
            "level_education" => $level_education,
            "current_level_education" => $current_level_education,
        ];
        
        return response()->json($result, 200);
    }

    public function addNewEducation(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('emp_education')
                ->insert([
                    'education_id' => $request->level,
                    'institute' => $request->institute,
                    'major' => $request->major,
                    'year' => $request->year,
                    'score' => $request->score,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'emp_number' => $request->emp_number,
                ]);

            $this->addMobileLog($request->emp_number, "Add Education Info", "Add education info");

            $result = ["result" => "Successfully add education.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function updateDataEducation(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('emp_education')
                ->where('emp_number', $employee_mobile->EMP_NUMBER)
                ->where('id', $request->id)
                ->update([
                    'education_id' => $request->education_id,
                    'institute' => $request->institute,
                    'major' => $request->major,
                    'year' => $request->year,
                    'score' => $request->score,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);
            
            $this->addMobileLog($request->emp_number, "Education Info", "Update education info");

            $result = ["result" => "Successfully update education.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function addNewWorkExperience(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('emp_work_experience')
                ->insert([
                    'eexp_employer' => $request->company,
                    'eexp_jobtit' => $request->job_title,
                    'eexp_from_date' => $request->from_date,
                    'eexp_to_date' => $request->to_date,
                    'emp_number' => $request->emp_number,
                ]);

            $this->addMobileLog($request->emp_number, "Add Work Experience Info", "Add work experience info");

            $result = ["result" => "Successfully add work experience.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function updateWorkExperienceInfo(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('emp_work_experience')
                ->where('emp_number', $employee_mobile->EMP_NUMBER)
                ->where('id', $request->id)
                ->update([
                    'eexp_employer' => $request->company,
                    'eexp_jobtit' => $request->job_title,
                    'eexp_from_date' => $request->from_date,
                    'eexp_to_date' => $request->to_date,
                ]);
            
            $this->addMobileLog($request->emp_number, "Work Experience Info", "Update work experience info");

            $result = ["result" => "Successfully update work experience.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function deleteDataEducation(Request $request){
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            $education_data =  DB::table("emp_education")
                ->where('id', $request->id)
                ->first();

            if ($education_data) {
                if ($education_data->emp_number == $request->emp_number) {
                    DB::table("emp_education")
                        ->where('id', $request->id)
                        ->delete();

                    $this->addMobileLog($request->emp_number, "Education", "Delete education : ".$education_data->id);

                    $result = ["result" => "Successfully delete education.", "status" => 1];
                    return response()->json($result, 200);
                } else {
                    $result = ["result" => "This is not your data.", "status" => 0];
                    return response()->json($result, 200);
                }
            } else {
                $result = ["result" => "Education data not found.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function deleteDataWorkExperience(Request $request){
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

        if ($employee_mobile) {
            $work_experience =  DB::table("emp_work_experience")
                ->where('id', $request->id)
                ->first();

            if ($work_experience) {
                if ($work_experience->emp_number == $request->emp_number) {
                    DB::table("emp_work_experience")
                        ->where('id', $request->id)
                        ->delete();

                    $this->addMobileLog($request->emp_number, "Work Experience", "Delete work experience : ".$work_experience->id);

                    $result = ["result" => "Successfully delete work experience.", "status" => 1];
                    return response()->json($result, 200);
                } else {
                    $result = ["result" => "This is not your data.", "status" => 0];
                    return response()->json($result, 200);
                }
            } else {
                $result = ["result" => "Work experience data not found.", "status" => 0];
                return response()->json($result, 200);
            }
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }
}
