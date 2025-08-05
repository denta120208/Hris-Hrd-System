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


class MetHrisMobileController extends Controller{
    
 
    protected $lvReq;
  
    
    function __construct(User $user,  LeaveRequest $lvReq) {
        //parent::__construct();
        $this->lvReq = $lvReq;
 
        $this->user = $user;
        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }

    // public function test(Request $request){
    //     $id = "1812001";
    //     $content ="TEST NOTIF CONTENT";
    //     $headings = "TEST NOTIF HEADINGSD";
    //     $this->sendNotifalluser( $content, $headings);
    //     $this->sendNotifalluser( $content, $headings);
    //     // dd($request->all());
    //     $client = new Client();
    //     $fields = [
    //         "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
    //         "contents" => ["en" => "Test asdasd"],
    //         "headings" => ["en" => "Test Title"],
    //         "include_player_ids" => ["66808c85-63b4-4143-a933-6d5e2f78108a"],
    //         "small_icon" => "ic_notification_icon",
    //         "android_accent_color" => "009291",
    //         "large_icon" => "ic_notification_icon",
    //         "android_background_layout" => "009291"
    //     ];
        
    //     $fieldsall = [
    //         "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
    //         "contents" => ["en" => "Test asdasd"],
    //         "headings" => ["en" => "Test Title"],
    //         "included_segments" => ["Active Users", "Inactive Users"],
    //         "small_icon" => "ic_notification_icon",
    //         "android_accent_color" => "009291",
    //         "large_icon" => "ic_notification_icon",
    //         "android_background_layout" => "009291"
    //     ];
        
    //     $header = [
    //           "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
    //           "Content-Type" => "text/html; charset=UTF-8"
    //     ];
    //     // $fields = json_encode($fields);
    //     // $header = json_encode($header);
                
    //     // print_r($header); die;
    //     $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
    //         'headers' => [   
    //             'Authorization' => 'Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1',
    //             'Content-Type' => 'application/json'],
    //         'json' => $fieldsall]
    //     );                    
               
    //     // $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [ 'headers' => [
    //     //    "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
    //     //    "Content-Type" => " application/json; charset=utf-8"
    //     // ]], ["content" => [$fields]
    //     // ]);
    // }
    
    public function testData() {
        $data_employee = DB::table('employee')
            ->where('employee_id', '2505004')
            ->first();
        
//        DB::table('employee')
//            ->insert([
////                 'emp_number' => 43898,
//                 'badgenumber' => 0,
//                 'emp_firstname' => 'testfirstname',
//                 'emp_middle_name' => 'testmiddlename',
//                 'emp_lastname' => 'testlastname',
//                 'emp_ktp' => '1234567890',
//                 'emp_street1' => 'test address 1',
//                 'city_code' => '07',
//                 'coun_code' => '08',
//                 'provin_code' => '09',
//                 'emp_zipcode' => '09876',
//                 'emp_street2' => 'test address 2',
//                 'city_code_res' => '13',
//                 'provin_code_res' => '12',
//                 'emp_zipcode_res' => '12345',
//                 'emp_hm_telephone' => '0897645321',
//                 'emp_mobile' => '1324576890',
//                 'emp_work_telephone' => '0987654321',
//                 'emp_work_email' => 'test@metropolitanland.com',
//                 'npwp' => '132435465768798090',
//                 'emp_fullname' => 'testfirstname testmiddlename testlastname',
//                 'eeo_cat_code' => 0,
//                 'job_dept_id' => 0,
//                 'work_station' => 0,
//            ]);
        
//        DB::table('employee')
//            ->where('emp_number', 43898)
//            ->update([
//                 'badgenumber' => 0,
//                 'emp_firstname' => 'testfirstnameEDIT',
//                 'emp_middle_name' => 'testmiddlenameEDIT',
//                 'emp_lastname' => 'testlastnameEDIT',
//                 'emp_ktp' => '1234567890',
//                 'emp_street1' => 'test address 1 EDIT',
//                 'city_code' => '07',
//                 'coun_code' => '08',
//                 'provin_code' => '09',
//                 'emp_zipcode' => '09876',
//                 'emp_street2' => 'test address 2 EDIT',
//                 'city_code_res' => '13',
//                 'provin_code_res' => '12',
//                 'emp_zipcode_res' => '12345',
//                 'emp_hm_telephone' => '0897645321',
//                 'emp_mobile' => '1324576890',
//                 'emp_work_telephone' => '0987654321',
//                 'emp_work_email' => 'testEDIT@metropolitanland.com',
//                 'npwp' => '132435465768798090',
//                 'emp_fullname' => 'testfirstnameEDIT testmiddlenameEDIT testlastnameEDIT',
//                 'eeo_cat_code' => 0,
//                 'job_dept_id' => 0,
//                 'work_station' => 0,
//            ]);

        $result = [
            'data' => $data_employee,
            'status' => 1,
        ];
        
        return response()->json($result, 200);
    }
    
        public function Mlogin(Request $request)
    {
      
      $member =  $this->user->where('username' , $request->username)->first();
      $member_profile = DB::table('employee')->where('employee_id', $request->username)->first();
     
      if(empty($member)){
          $result = ([
              "status" => 0,
              "result" => "User Tidak Ada!"
          ]);
      } else {
           $member_array = explode(',', $member->permission);
      if(in_array("13", $member_array )){
         $is_parent = 1;
      } else {
         $is_parent = 0;
      }
          if($request->password == $member->decrypt ){
            if(empty($member_profile)){
                 $result = ([
             "status" => 1 ,
              "username" => $member->username,
              "result" => "Berhasil Login",
              "emp_firstname" =>$member->name,
              "is_managed" => $member->is_manage,
              "user_id" => $member->id,
              "is_parent" => $is_parent
              ]);   
                
            } else {
                 $result = ([
             "status" => 1 ,
              "username" => $member->username,
              "result" => "Berhasil Login",
              "emp_firstname" => $member_profile->emp_firstname,
              "emp_middle_name" => $member_profile->emp_middle_name,
              "emp_lastname" => $member_profile->emp_lastname,
              "emp_number" => $member_profile->emp_number,
              "is_managed" => $member->is_manage,
              "user_id" => $member->id,
              "is_parent" => $is_parent
              ]); 
            }

              
            
              
              
          } else {
              $result = ([
                 "status" => 0,
                  "result" => "Password Salah"
              ]);
          }
         
      }
        return response()->json($result, 200);
      
    }
    
    public function getEmprewards($id){
        $rewards = DB::table('emp_rewards')
                ->join('rewards', 'emp_rewards.rewards_id', '=','rewards.id')
                ->where('emp_rewards.emp_number', $id)
                ->get();
        
        if(empty($rewards)){
            $result =["result" => "Tidak Ada Rewards"];
        } else {
            $result =$rewards;
        }
                return response()->json($result, 200);

    }
    
    public function getEmppromotion($id){
        $rewards = DB::table('emp_promotions')
                ->where('emp_number', $id)
                ->get();
        if(empty($rewards)){
            $result =["result" => "Tidak Ada Rewards"];
        } else {
            $result =$rewards;
        }
                return response()->json($result, 200);

    }
    
    
    public function getProfile($id){

        $member = DB::table('employee')
                ->leftjoin('emp_picture', 'employee.emp_number','=','emp_picture.emp_number')
                ->rightjoin ('users', 'users.username', '=', 'employee.employee_id')
                ->where('users.username', $id)
                ->select('employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname', 'employee.emp_number', 'users.is_manage', 'users.username', 'users.name')
                ->first();
        
         $member_picture = DB::table('employee')
                ->leftjoin('emp_picture', 'employee.emp_number','=','emp_picture.emp_number')
                ->where('employee_id', $id)
                ->select('emp_picture.epic_picture')
                ->first();
        //dd($member);
        if(empty($member)){
                $result = (["result" => "Member Tidak Ada"]);
            
        } else {
//              $picture =  base64_encode( $member_picture->epic_picture );  
            $result = ([
                "emp_firstname" => $member->emp_firstname,
                "emp_middle_name" => $member->emp_middle_name,
                "emp_lastname" => $member->emp_lastname,
                "emp_number" => $member->emp_number,
                "is_managed" => $member->is_manage,
                "employee_id" => $member->username,
                "name" => $member->name
                    
//                "picture" =>$picture 
            ]);
                    
        }
        
        return response()->json($result,200);
    }
    
    public function getProfilepicture($id){
        $member_picture = DB::table('emp_picture')
                ->where('emp_number', $id)
                ->first();
        if(empty($member_picture)){
            $picture = "";
        } else {
        $picture =  base64_encode( $member_picture->epic_picture );  
        }
        
  
        return response()->json($picture,200);
 
        
    }
    
    public function getMyleavedetails($id){
        $leave = DB::table('leave_entitlement')->where('id', $id)->first();
        $emp = DB::table('employee')->where('emp_number', $leave->emp_number)->first();
         if(empty($leave)){
          $result = (["result" => "Member Tidak Ada"]);  
        } else {
            $result = ([
                       'nik' => $emp->employee_id,
                       'member_name' => $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
                       'leave_type' => $leave->leave_type_id,
                       'valid_from' => $leave->from_date,
                       'valid_to' => $leave->to_date,
                       'no_of_days' => $leave->no_of_days,
                       'days_used' => $leave->days_used
            ]);
        }
        
        return response()->json($result,200);
    }
    
     
    public function updateLeave(Request $request){
       $leave = DB::table('leave_entitlement')->where('id', $request->id)->first();
       
       if(empty($leave)){
         $result = (["result" => "Tidak Ada Data"]);  
    } else {
         DB::table('leave_entitlement')->where('id', $request->id)
                ->update([
                    'leave_type_id' => $request->leave_type,
                    'from_date' => $request->valid_from,
                    'to_date' => $request->valid_to,
                    'no_of_days' => $request-> no_of_days,
                    'created_by_id' => $request->user_id,
                    'created_by_name' => $request->member_name
                    ]);
          $result = (["result" => "Berhasil Update",
                    "status" => 1]);
    }
            return response()->json($result,200);
      
    }
    
    
    public function addLeaves(Request $request){
                $now = date("Y-m-d H:i:s");
        $member = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        //$user = DB::table('users')->where('id', $request->user_id);
        $member_name = DB::table('users')->where('id', $request->emp_num);
        if(empty($member)){
            
          $result = (["result" => "Tidak Ada Employee",
                    "status" => 0]);
        } else {
       
                
              DB::table('leave_entitlement')->insert([
           'emp_number' => $request->emp_num,
           'no_of_days' => $request->no_of_days,
           'days_used' => 0,
           'leave_type_id' => $request->leave_type,
           'from_date' => $request->valid_from,
           'to_date' => $request->valid_to,
           'credited_date' => $now,
           'entitlement_type' =>  1,
           'deleted' => 0,
           'created_by_id' => $request->user_id,
           'created_by_name' => $member_name->name
        ]);
        
          $result = (["result" => "Berhasil Menambahkan",
                    "status" => 1]);
          
        }
      
                      return response()->json($result,200);

    }
    
    public function deleteLeaves(Request $request){
        $leave = DB::table('leave_entitlement')->where('id', $request->id)
                ->where('emp_number', $request->emp_num)
                ->first();
        if(empty($leave)){
                 
          $result = (["result" => "Tidak Ada Data",
                    "status" => 0]);
        } else {
            DB::table('leave_entitlement')->where('id', $request->id)
                    ->where('emp_number', $request->emp_num)
                    ->update([
                        "deleted" => 1
                    ]);
             $result = (["result" => "Berhasil Menghapus",
                    "status" => 1]);
        }
        
        return response()->json($result,200);

        
    }
    
 
    
    public function getPersonelDetails($id){
        $member = DB::table('employee')
                ->where('employee_id', $id)
                ->first();
         if(empty($member)){
                $result = (["result" => "Member Tidak Ada"]);
            
        } else {
            $result = $member;
        }
        
        return response()->json($result,200);
    }
    
    public function updatePersonelDetails(Request $request){
        //dd($request->all());
        $member = DB::table('employee')
                ->where('emp_number', $request->emp_num)
                ->first();
          if(empty($member)){
                $result = (["result" => "Member Tidak Ada"]);
            
             } else {
            if($request->emp_dri_lice_exp_date == 'NA' || null){
                   DB::table('employee')->where('emp_number', $request->emp_num )
                    ->update([
                           'emp_firstname' => $request->emp_firstname,
                           'emp_middle_name' => $request->emp_middle_name,
                           'emp_lastname' => $request->emp_lastname,
                           'emp_ktp' => $request->ktp,
                           'emp_dri_lice_num' => $request->emp_dri_lice_num,
//                           'emp_dri_lice_exp_date' => $request->emp_dri_lice_exp_date,
                           'emp_marital_status' => $request->emp_marital_status,
                           'bpjs_ks' => $request -> bpjs_ks,
                           'bpjs_tk' => $request -> bpjs_tk,
                           'npwp' => $request->npwp,
                           'nation_code' => $request->nation_code
                        
                    ]);
                       $result = (["result" => "Berhasil Update",
                    "status" => 1]);
            } else{
                 DB::table('employee')->where('emp_number', $request->emp_num )
                    ->update([
                           'emp_firstname' => $request->emp_firstname,
                           'emp_middle_name' => $request->emp_middle_name,
                           'emp_lastname' => $request->emp_lastname,
                           'emp_ktp' => $request->ktp,
                           'emp_dri_lice_num' => $request->emp_dri_lice_num,
                           'emp_dri_lice_exp_date' => $request->emp_dri_lice_exp_date,
                           'emp_marital_status' => $request->emp_marital_status,
                           'bpjs_ks' => $request -> bpjs_ks,
                           'bpjs_tk' => $request -> bpjs_tk,
                           'npwp' => $request->npwp,
                           'nation_code' => $request->nation_code
                        
                    ]);
                       $result = (["result" => "Berhasil Update",
                    "status" => 1]);
            }
           
            }
                           return response()->json($result,200);

    }
    
    public function updateContactDetails(Request $request){
           $member = DB::table('employee')
                ->where('emp_number', $request->emp_num)
                ->first();
          if(empty($member)){
                $result = (["result" => "Member Tidak Ada"]);
            
             } else {
            DB::table('employee')->where('emp_number', $request->emp_num )
                    ->update([
                         'emp_street1' => $request->emp_street1,
                         'emp_street2' => $request->emp_street2,
                         'city_code' => $request->city_code,
                         'provin_code' => $request->provin_code,
                         'nation_code' => $request->nation_code,
                         'emp_zipcode' => $request->emp_zipcode,
                         'emp_hm_telephone' => $request->emp_hm_telephone,
                         'emp_work_telephone' => $request->emp_work_telephone,
                         'emp_work_email' => $request->emp_work_email,
                         'emp_mobile2' => $request -> emp_mobile2,
                         'emp_mobile' => $request -> emp_mobile,
                         'emp_oth_email' => $request->emp_oth_email,
                         'agama' => $request->agama,
                         'emp_facebook' => $request->emp_facebook,
                         'emp_twitter' => $request->emp_twitter,
                         'emp_instagram' => $request->emp_instagram,
                    ]);
                       $result = (["result" => "Berhasil Update",
                    "status" => 1]);
            }
                           return response()->json($result,200);
        
        
    }
    
    public function getNationality($id){
        $member = DB::table('employee')->where('employee_id', $id)->first();
        
       $nationaility = DB::table('nationality')->get();
               return response()->json($nationaility,200);

       
        
        
    }
    
    public function getDependents($id){
        $dependents = DB::table('emp_dependents')
                ->where('emp_number', $id)->get();
        if(empty($dependents)){
            $result = ["result" =>"Tidak ada data"];
        } else {
            $result = $dependents;
        }
        return response()->json($result,200);
    }
    
    public function getDependentsdetails($id){
        $dependents = DB::table('emp_dependents')
                ->where('id', $id)->first();
        if(empty($dependents)){
            $result = ["result" =>"Tidak ada data"];
        } else {
            $result = $dependents;
        }
        return response()->json($result,200);
    }
    
    public function addDependents(Request $request){
        DB::table('emp_dependents')
                ->insert([
                   "emp_number" => $request->emp_num,
                    "ed_name" => $request->name,
                    "ed_relationship" => $request->relationship,
                    "ed_date_of_birth" => $request->dob
                ]);
         $result = ["result" =>"Successfully Added...",
                    "status" => 1];
                 return response()->json($result,200);

    }
    
    public function updateDependents(Request $request){
        DB::table('emp_dependents')
                ->where('emp_number', $request->emp_num)
                ->where('id', $request->id)
                ->update([
                  "ed_name" => $request->name,
                  "ed_relationship" => $request->relationship,
                  "ed_date_of_birth" => $request->dob
                ]);
           $result = ["result" =>"Successfully Updated...",
                    "status" => 1];
                 return response()->json($result,200);
                
    }
    
    
    public function deleteDependents(Request $request){
        DB::table('emp_dependents')
                ->where('emp_number', $request->emp_num)
                ->where('id', $request->id)
                ->delete();
        $result = ["result" =>"Successfully Delete.",
                    "status" => 1];
                 return response()->json($result,200);
    }
    
        
    public function getJobInfo($id){
        $emp = DB::table('employee')
                ->join('employment_status', 'employee.emp_status', '=', 'employment_status.id')
//                ->join('job_title', 'employee.job_title_code','=','job_title.old_id')
                ->where('emp_number', $id)->first();
                
        $job_title = DB::table('job_title')->where('old_id', $emp->job_title_code)->first();
        if (empty($job_title)){
        $job_title = DB::table('job_title')->where('id', $emp->job_title_code)->first();
        }
        $location = DB::table('location')->where('id', $emp->location_id)->first();
        $subunit = DB::table('subunit')->where('old_id', $emp->work_station)->first();
        if(empty($subunit)){
        $subunit = DB::table('subunit')->where('id', $emp->work_station)->first();
        }
       // dd($location);
        $contract = DB::table('emp_contract')
            ->where('emp_number', $id)
            ->first();
       // dd($contract);
        
//        return view('partials.employee.personal.job', compact('emp', 'location', 'contract','reports'));
//        if(empty($location)){
//            $result =([
//                'job_title' => $emp->job_title_code,
//                'emp_status' => $emp->name,
//                'joined_date' => $emp->joined_date,
//                'subunit' => $emp->work_station,
//                'job_level' => $emp->job_level,
//                 'econ_extend_start_date' => $contract->econ_extend_start_date,
//                'econ_extend_end_date' => $contract->econ_extend_end_date
//        ]); 
//        } else {
        if($contract){
            if(empty($subunit)){
                $result =([
                    'job_title' => $job_title->id,
                    'emp_status' => $emp->emp_status,
                    'joined_date' => $emp->joined_date,
                    'location' => $emp->location_id,
                    'job_level' => $emp->job_level,
                    'econ_extend_start_date' => $contract->econ_extend_start_date,
                    'econ_extend_end_date' => $contract->econ_extend_end_date
                ]);
            } else {
                $result =([
                    'job_title' => $job_title->id,
                    'emp_status' => $emp->emp_status,
                    'joined_date' => $emp->joined_date,
                    'subunit' => $subunit->id,
                    'location' => $emp->location_id,
                    'job_level' => $emp->job_level,
                    'econ_extend_start_date' => $contract->econ_extend_start_date,
                    'econ_extend_end_date' => $contract->econ_extend_end_date
                ]);
            }
        } else {
            if(empty($subunit)){
                $result =([
                    'job_title' => $job_title->id,
                    'emp_status' => $emp->emp_status,
                    'joined_date' => $emp->joined_date,
                    'location' => $emp->location_id,
                    'job_level' => $emp->job_level,

                ]);
            } else {
                $result =([
                    'job_title' => $job_title->id,
                    'emp_status' => $emp->emp_status,
                    'joined_date' => $emp->joined_date,
                    'subunit' => $subunit->id,
                    'location' => $emp->location_id,
                    'job_level' => $emp->job_level,

                ]);
            }
        }

        return response()->json($result,200);

    }
    
    public function getEmploymentstatus(){
        $status = DB::table('employment_status')
                ->get();
        return response()->json($status,200);
    }
    
    public function getJobtitle($id){
        $job_title = DB::table('job_title')
                ->where('is_deleted', 0)
                ->get();
        return response()->json($job_title,200);
    }
    
    public function getLocation($id){
        $loaction = DB::table('location')->get();
        return response()->json($loaction,200);
    }
    
    public function getSubunit($id){
        $subunit = DB::table('subunit')->get();
        return response()->json($subunit,200);
    }
    
    public function updateJob(Request $request){
        $emp = DB::table('employee')
                ->where('emp_number', $request->emp_num)
                ->first();
        
        if(empty($emp)){
                    $result = (["result" => "Employee Not Found"]);

        } else {
               DB::table('employee')
                ->where('emp_number', $request->emp_num)
                ->update([
                    'job_title_code' => $request->job_title,
                    'emp_status' => $request->emp_status,
                    'work_station' => $request->subunit,
                    'location_id' => $request->location,
                    'job_level' => $request->job_level,
                ]);
        
           DB::table('emp_contract')
                ->where('emp_number', $request->emp_num)
                ->update([
                    'econ_extend_start_date' => $request->contract_start,
                    'econ_extend_end_date' => $request->contract_end
                ]);
           
           $result = ["result" => "Successfully Update",
                      "status" => 1];
        }
        
     
         return response()->json($result,200);

    }
    
    
    public function getReportToJob($id){
        $reports = DB::table('emp_reportto')
            ->join('emp_reporting_method', 'emp_reportto.erep_reporting_mode', '=','emp_reporting_method.reporting_method_id')
            ->join('employee', 'emp_reportto.erep_sup_emp_number', '=' ,'employee.emp_number')
            ->where('emp_reportto.erep_sub_emp_number',$id)
            ->whereIn('emp_reportto.erep_reporting_mode', [1,2])
            ->select('emp_reporting_method.reporting_method_name','emp_reportto.erep_sup_emp_number','employee.emp_firstname',
                    'employee.emp_middle_name','employee.emp_lastname')->get();
         if (empty($reports)){
             $result = [];
         } else {
             $result = $reports;
         }
         return response()->json($result,200);

        
    }
    
    public function getNotification($id){
         $now = date("Y-m-d");
        $users = DB::table('employee')->where('emp_number', $id)->first(); 
        $contract = DB::table('emp_contract')->where('emp_number', $id)->first();
        $leaves = DB::table('emp_leave_request')
            ->join('emp_reportto', 'emp_leave_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_leave_request.emp_number', '=' ,'employee.emp_number')
            ->join('leave_status', 'leave_status.id','=', 'emp_leave_request.leave_status')
            ->where('emp_reportto.erep_sup_emp_number',$id)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->select('emp_leave_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname','leave_status.name')
            ->where('emp_leave_request.leave_status', 3)
            //->take(10)
            ->orderBy('emp_leave_request.created_at', 'desc')
             ->get();

            if($contract){
                $date1 = strtotime($contract->econ_extend_end_date);
            } else {
                $date1 =  strtotime($now);
            }

            $date2 = strtotime($now);  
  

            // Formulate the Difference between two dates 
            $diff = abs($date2 - $date1);  


            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years = floor($diff / (365*60*60*24));  

            //dd($years.' Years');

            // To get the month, subtract it with years and 
            // divide the resultant date into 
            // total seconds in a month (30*60*60*24) 
            $months = floor(($diff - $years * 365*60*60*24) 
                                           / (30*60*60*24));  


        
          $attendancereq = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->join('attendance_status_req', 'attendance_status_req.id','=', 'emp_attendance_request.request_status')
            ->where('emp_reportto.erep_sup_emp_number',$id)
            ->where('emp_reportto.erep_reporting_mode', '1')
           ->select('emp_attendance_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname',
                   'employee.emp_middle_name','employee.emp_lastname','attendance_status_req.name')
            ->where('emp_attendance_request.request_status', 1)
                  
            //->take(10)
             ->get();
          
             $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
                  WHERE  employee_id = '".$users->employee_id."' order by punch_in_utc_time desc");
             
                 $absendatang = DB::table('attendance_record')->where('employee_id', $users->employee_id)
                ->orderBy('punch_in_utc_time', 'desc')
                         
                ->where('punch_in_utc_time', null)
                ->where('punch_out_utc_time','<',$now)
                ->take(100)
                ->get();
                 
                   $absenpulang = DB::table('attendance_record')->where('employee_id', $users->employee_id)
                ->orderBy('punch_out_utc_time', 'desc')
                ->where('punch_out_utc_time', null)
                ->where('punch_in_utc_time','<',$now)  
                ->take(100)
                ->get();
                   //dd($now);
                   //dd($absenpulang);
                 
        
           

          if (empty($leaves))
          {
              $countleaves = 0;
          } else {
               $countleaves= count($leaves);
          }
          
          if (empty($attendancereq))
          {
              $countattendancereq = 0;
          } else {
               $countattendancereq= count($attendancereq);
          }
          
        
          
          if (empty($absendatang))
          {
              $countabsendatang = 0;
          } else {
               $countabsendatang= count($absendatang);
          }
          
           if (empty($absenpulang))
          {
              $countabsenpulang = 0;
          } else {
               $countabsenpulang= count($absenpulang);
          }
          
          if (empty($contract))
          {
              $contractcount = 0;
          } else {
              if($months <= 3 && $years == 0){
                                $contractcount = count($contract);

              } else {
              $contractcount = 0;
              }
          }
          
          $totalnotif = $countleaves + $countattendancereq + $countabsendatang + $countabsenpulang + $contractcount;
          
          if(empty($contract)){
               
          $result= ["leave_request" => $countleaves,
                    "attendance_request" => $countattendancereq,
                    "absendatang" => $countabsendatang,
                    "absenpulang" => $countabsenpulang,
                    "contract_end" => 0,
                    "total_notif" => $totalnotif];
          } else {
               if($months <= 3 && $years == 0){
            $result= ["leave_request" => $countleaves,
                    "attendance_request" => $countattendancereq,
                    "absendatang" => $countabsendatang,
                    "absenpulang" => $countabsenpulang,
                    "contract_end" => $contract->econ_extend_end_date,
                    "total_notif" => $totalnotif];
              } else {
             $result= ["leave_request" => $countleaves,
                    "attendance_request" => $countattendancereq,
                    "absendatang" => $countabsendatang,
                    "absenpulang" => $countabsenpulang,
                    "total_notif" => $totalnotif];           
              }
               
        
          }
          
         
           return response()->json($result,200);

    }
    
    
    public function getContract(){
        
    }
    
  
    
    public function getReportto($id){
        $member = DB::select("
            select c.employee_id,c.emp_firstname, c.emp_middle_name,c.emp_lastname, a.emp_number from employee a inner join emp_reportto b
            on a.emp_number = b.erep_sup_emp_number
            inner join employee c on b.erep_sub_emp_number =  c.emp_number
            where a.emp_number = ".$id."
            AND c.termination_id = 0
            AND b.erep_reporting_mode IN ('1', '2')"); 
       if(empty($member)){
        $result = (["result" => "User Not Found"]);
            
        } else {
            $result = $member;
        }
        
        return response()->json($result,200);
    }
    
//    public function getAttendanceNow($id){
//       $attendance = DB::select('select * from attendance_record where employee_id '.$id.' 
//                        and punch_in_time_offset > ');
//       
//                    
//    }
    
     public function myLeave($id){
        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $emp = DB::table('employee')->where('emp_number', $id)->first();
        $balLeaves = DB::table('leave_entitlement')
                ->join('leave_type','leave_entitlement.leave_type_id', '=','leave_type.id')
                ->where('emp_number', $id)
                ->where('to_date' ,'>=', $yearEnd)
                ->where('deleted', 0)
                ->select('leave_entitlement.id','leave_type.name','leave_entitlement.no_of_days', 'leave_entitlement.days_used', 'leave_entitlement.from_date', 'leave_entitlement.to_date')
                ->get();
        
        $i = 0;
        
        if(empty($balLeaves) ){
            $arr=["result" => "Tidak Ada Data"];
        } else {
                 foreach ($balLeaves as $balLeave){
                $noofdays = $balLeave-> no_of_days; 
                $daysused = $balLeave-> days_used;
                $total = $noofdays - $daysused ;
                
                $arr[$i] = [
                   "id" => $balLeave->id,
                   "leave_type" => $balLeave->name,
                   "valid_from" => $balLeave->from_date,
                   "valid_to" => $balLeave->to_date,
                   "no_of_days" => $balLeave-> no_of_days,
                   "days_used" => $balLeave->days_used,
                   "total_cuti" => $total
                ];
                $status = 200;
            $i++;

        }
        }
   
                return response()->json($arr,200);

        
     }
     
     
     
    
    public function getAttendance($id){
              $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
            WHERE  employee_id = '".$id."' order by punch_in_utc_time desc");
        $attendances = DB::table('attendance_record')->where('employee_id', $id)
                ->orderBy('punch_in_utc_time', 'desc')
                ->take(25)
                ->get();
        $i = 0;
        foreach($attendances as $attendance){

           $hari =   date('l', strtotime($attendance->punch_in_utc_time));
           $date = substr($attendance->punch_in_utc_time,0,10);
           $time_in = substr($attendance->punch_in_utc_time,11,8);
           $time_out = substr($attendance->punch_out_utc_time,11,8);
           
           
                        // Declare and define two dates 
            $date1 = strtotime($attendance->punch_in_utc_time);  
            $date2 = strtotime($attendance->punch_out_utc_time);  

            // Formulate the Difference between two dates 
            $diff = abs($date2 - $date1);  


            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years = floor($diff / (365*60*60*24));  


            // To get the month, subtract it with years and 
            // divide the resultant date into 
            // total seconds in a month (30*60*60*24) 
            $months = floor(($diff - $years * 365*60*60*24) 
                                           / (30*60*60*24));  


            // To get the day, subtract it with years and  
            // months and divide the resultant date into 
            // total seconds in a days (60*60*24) 
            $days = floor(($diff - $years * 365*60*60*24 -  
                         $months*30*60*60*24)/ (60*60*24)); 


            // To get the hour, subtract it with years,  
            // months & seconds and divide the resultant 
            // date into total seconds in a hours (60*60) 
            $hours = floor(($diff - $years * 365*60*60*24  
                   - $months*30*60*60*24 - $days*60*60*24) 
                                               / (60*60));  
            
            $minutes = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24  
                          - $hours*60*60)/ 60);  
             
                $arr[$i] = [
                   "id" => $attendance->id,
                   "day" => $hari,
                   "date" => $date,
                   "time_in" =>  $time_in,
                   "time_out" => $time_out,
                   "hours" => $hours,
                   "minutes" => $minutes
                    
                ];
              $status = 200;
            $i++;

        }
        
        
        $result = [
                "day" => $hari,
        ];
        
        return response()->json($arr,200);

    }
    
    public function getAttendancedetails($id){
        $attendance = DB::table('attendance_record')->where('id', $id)->first();
        $hari =   date('l', strtotime($attendance->punch_in_utc_time));
        $date = substr($attendance->punch_in_utc_time,0,10);
           $time_in = substr($attendance->punch_in_utc_time,11,8);
           $time_out = substr($attendance->punch_out_utc_time,11,8);
       $result=  ["id" => $attendance->id,
                   "day" => $hari,
                   "date" => $date,
                   "time_in" =>  $time_in,
                   "time_out" => $time_out];    
        return response()->json($result,200);
    }
    
    
    public function addAttendancerequest(Request $request){
        $emp = DB::table('employee')->where('emp_number', $request->emp_num)
               ->first();
        $attendance = DB::table('attendance_record')->where('id', $request->id)->first();
         $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        $empreport = DB::table('emp_reportto')->where('erep_sub_emp_number', $request->emp_num)
                    ->where('erep_reporting_mode','1')
                    ->first();
        $empreport_username = DB::table('employee')
                ->where('emp_number', $empreport->erep_sup_emp_number)
                ->first();
        $player_id = DB::table('user_phone')
                ->where('employee_id', $empreport_username->employee_id)
                ->first();
        $attendance_req = DB::table('emp_attendance_request')->where('attendance_id', $request->id)
                ->where('request_status', 1)->first();
        if(empty($emp)){
            $result = ["result" =>"Data Not Found"];
        } else {
            if(empty($attendance_req)){
                  DB::table('emp_attendance_request')
                    ->insert([
                       "attendance_id" => $request->id,
                        "emp_number" => $request->emp_num,
                        "start_date" => $attendance->punch_in_utc_time,
                        "end_date" => $attendance->punch_in_utc_time,
                        "request_status" => 1,
                        "reason" => $request->reason
                    ]);
               if(empty($emp->emp_middle_name)){
               $member_name = $emp->emp_firstname .' '.$emp->emp_lastname;
               } else {
               $member_name = $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname;
               }
      
            $result = ["result" =>"Berhasil request",
                       "status" => 1,
                        "player_id" => $player_id->player_id,
                         "member_name" => $member_name];
            } else {
               $result = ["result" =>"Request Already Exist"];
            }
          
        }
                return response()->json($result,200);

    }
    
    
    public function getAttendancewithdate(Request $request){
//              $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
//            WHERE  employee_id = '".$id."' order by punch_in_utc_time desc");
        $attendances = DB::table('attendance_record')->where('employee_id', $request->username)
                ->where('punch_in_utc_time', '>=',$request->startdate.' 00:00:00')
                ->where('punch_in_utc_time', '<=',$request->enddate.' 23:59:59')
                ->get();
        $i = 0;
        //dd($attendance);
        foreach($attendances as $attendance){
           $hari =   date('l', strtotime($attendance->punch_in_utc_time));
           $date = substr($attendance->punch_in_utc_time,0,10);
           $time_in = substr($attendance->punch_in_utc_time,11,8);
           $time_out = substr($attendance->punch_out_utc_time,11,8);
           
           
                        // Declare and define two dates 
            $date1 = strtotime($attendance->punch_in_utc_time);  
            $date2 = strtotime($attendance->punch_out_utc_time);  

            // Formulate the Difference between two dates 
            $diff = abs($date2 - $date1);  


            // To get the year divide the resultant date into 
            // total seconds in a year (365*60*60*24) 
            $years = floor($diff / (365*60*60*24));  


            // To get the month, subtract it with years and 
            // divide the resultant date into 
            // total seconds in a month (30*60*60*24) 
            $months = floor(($diff - $years * 365*60*60*24) 
                                           / (30*60*60*24));  


            // To get the day, subtract it with years and  
            // months and divide the resultant date into 
            // total seconds in a days (60*60*24) 
            $days = floor(($diff - $years * 365*60*60*24 -  
                         $months*30*60*60*24)/ (60*60*24)); 


            // To get the hour, subtract it with years,  
            // months & seconds and divide the resultant 
            // date into total seconds in a hours (60*60) 
            $hours = floor(($diff - $years * 365*60*60*24  
                   - $months*30*60*60*24 - $days*60*60*24) 
                                               / (60*60));  
            
            $minutes = floor(($diff - $years * 365*60*60*24  
         - $months*30*60*60*24 - $days*60*60*24  
                          - $hours*60*60)/ 60);  
             
                $arr[$i] = [
                   "id" => $attendance->id,
                   "day" => $hari,
                   "date" => $date,
                   "time_in" =>  $time_in,
                   "time_out" => $time_out,
                   "hours" => $hours,
                   "minutes" => $minutes
                    
                ];
              $status = 200;
            $i++;
        
    }
          if(empty($arr)){
              $result = [];
          } else {
              $result = $arr;
          }
     
        return response()->json($result,200);

    }
    
    public function getAttendancenow($id){
                        $now = date("Y-m-d H:i:s");

            $date = DB::select("SELECT convert(VARCHAR(50),punch_in_utc_time,110)as date from attendance_record
            WHERE cast(punch_in_utc_time AS date) = '".$now."' AND employee_id = '".$id."' order by  punch_in_utc_time desc");
            
            $datedays = DB::select("SELECT punch_in_utc_time as date from attendance_record
            WHERE cast(punch_in_utc_time AS date) = '".$now."' AND employee_id = '".$id."' order by  punch_in_utc_time desc");
            
            $time = DB::select("SELECT convert(VARCHAR(8),punch_in_utc_time,108)as time  from attendance_record
            WHERE cast(punch_in_utc_time AS date)  = '".$now."' AND employee_id = '".$id."'");
            
//            dd($hari);
            
        if (empty($date)){
            $result = ["date" =>"Tidak Ada Absent Hari ini"];
        } else {
            $hari =   date('l', strtotime( $datedays[0]->date));
            //dd($hari);
            $result = [
                        "days" => $hari,
                        "date" => $date[0]->date,
                        "time" => $time[0]->time    
                ];

        }
        
        return response()->json($result,200);

                
    }
        
    
     
     public function myLeavewithtype(Request $request){
        // dd($request->all());
        $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        //dd($emp);
        $balLeaves = DB::table('leave_entitlement')
                ->join('leave_type','leave_entitlement.leave_type_id', '=','leave_type.id')
                ->where('emp_number', $request->emp_num)
                ->where('leave_entitlement.to_date', '>=', $yearEnd)
                ->where('leave_entitlement.leave_type_id', $request->leave_type )
                ->where('leave_entitlement.deleted',0)
                ->select('leave_entitlement.id','leave_type.name','leave_entitlement.no_of_days', 'leave_entitlement.days_used', 'leave_entitlement.from_date', 'leave_entitlement.to_date')
                ->get();
        $i = 0;
        dd($balLeaves);
        
        foreach ($balLeaves as $balLeave){
                $noofdays = $balLeave-> no_of_days; 
                $daysused = $balLeave-> days_used;
                $total = $noofdays - $daysused ;
                
                $arr[$i] = [
                   "id" => $balLeave->id,
                   "leave_type" => $balLeave->name,
                   "valid_from" => $balLeave->from_date,
                   "valid_to" => $balLeave ->to_date,
                   "total_cuti" => $total
                ];
                $status = 200;
            $i++;

        }
        
        if($balLeaves == null )
        {
            $result = [];
                    return response()->json($result,200);

        } else {
                            return response()->json($arr,200);

        }

        
     }
     
     
     public function addUserhp(Request $request){
        $now = date("Y-m-d H:i:s");
        $player_id = DB::table('user_phone')
                ->where('employee_id', $request->username)
                //->where('player_id', $request->player_id)
                ->first();
        $phone = DB::table('user_phone')
                ->where('uuid', $request->uuid)
                ->first();
        if(empty($phone)){
              DB::table('user_phone')
                ->insert([
                    "employee_id" => $request->username,
                    "player_id" => $request->player_id,
                    "uuid" => $request->uuid,
                    "created_at" => $now,
                     "platform" => $request->platform,
                    "serial" => $request->serial,
                    "manufacturer" => $request->manufacturer,
                    "created_at" => $now
                ]);
        } else {
                 DB::table('user_phone')
                ->where('uuid', $request->uuid)
                      ->update([
                    "employee_id" => $request->username,
                    "player_id" => $request->player_id,
                    "uuid" => $request->uuid,
                    "platform" => $request->platform,
                    "serial" => $request->serial,
                    "manufacturer" => $request->manufacturer,
                    "created_at" => $now
                ]);
        }
        
//        if(empty($player_id)){
//              DB::table('user_phone')
//                ->insert([
//                    "employee_id" => $request->username,
//                    "player_id" => $request->player_id,
//                    "uuid" => $request->uuid,
//                    "created_at" => $now,
//                     "platform" => $request->platform,
//                    "serial" => $request->serial,
//                    "manufacturer" => $request->manufacturer,
//                    "created_at" => $now
//                ]);
//        
//        } else {
//              DB::table('user_phone')
//                ->where('employee_id', $request->username)
//                      ->update([
//                    "employee_id" => $request->username,
//                    "player_id" => $request->player_id,
//                    "uuid" => $request->uuid,
//                    "platform" => $request->platform,
//                    "serial" => $request->serial,
//                    "manufacturer" => $request->manufacturer,
//                    "created_at" => $now
//                ]);
//        
//        }
//       
       $result =["Berhasil register player ID"];
    
       return response()->json($result,200);
     }
     
     public function attendanceList(Request $request){
         $attends = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->join('attendance_status_req', 'emp_attendance_request.request_status', '=' ,'attendance_status_req.id')
            ->where('emp_attendance_request.request_status', '1')
            ->where('emp_reportto.erep_sup_emp_number',$request->emp_num)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->select('attendance_status_req.name','emp_attendance_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();
         
             return response()->json($attends,200);

     }
     
     
     public function leaveType(){
         $type = DB::table('leave_type')->where('is_active',1)->get();
         return response()->json($type,200);

     }
     
     public function balLeave($id){
          $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $no_of_days = DB::table('leave_entitlement')->where('emp_number', $id)
            ->where('to_date','>=', $yearEnd)
            ->where('deleted',0)
            ->sum('no_of_days');
        $days_used =  DB::table('leave_entitlement')->where('emp_number', $id)
            ->where('to_date','>=', $yearEnd)
            ->where('deleted',0)
            ->sum('days_used');
        $result = ([
            'no_of_days' => $no_of_days,
            'days_used' => $days_used,
            'balance' => $no_of_days - $days_used
        ]);
        
                 return response()->json($result,200);

     }
     
      public function balLeavewithtype(Request $request){
          $yearEnd = date('Y-m-d H:i:s', strtotime('Dec 31'));
        $no_of_days = DB::table('leave_entitlement')->where('emp_number', $request->emp_num)
            ->where('to_date','>=', $yearEnd)
            ->where('deleted',0)
            ->where('leave_type_id', $request->leave_type)->sum('no_of_days');
        $days_used =  DB::table('leave_entitlement')->where('emp_number', $request->emp_num)
            ->where('to_date','>=', $yearEnd)
             ->where('deleted',0)
            ->where('leave_type_id', $request->leave_type)->sum('days_used');
                    //dd($days_used);

            $result = ([
            'no_of_days' => $no_of_days,
            'days_used' => $days_used,
            'balance' => $no_of_days - $days_used
        ]);
        
                 return response()->json($result,200);

     }
     
     public function hitungHari(Request $request ){
        $sDate = date("Y-m-d", strtotime($request->start_date));
        $eDate = date('Y-m-d', strtotime($request->end_date));

        $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        $days = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);
        
        $result = ["days" => $days];
        return response()->json($result,200);

     }
     
     
     public function applyLeave(Request $request){
        $now = date("Y-m-d H:i:s");
        $sDate = date("Y-m-d", strtotime($request->start_date));
        $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
        $empreport = DB::table('emp_reportto')->where('erep_sub_emp_number', $request->emp_num)
                    ->where('erep_reporting_mode','1')
                    ->first();
        $empreport_username = DB::table('employee')
                ->where('emp_number', $empreport->erep_sup_emp_number)
                ->first();
        $player_id = DB::table('user_phone')
                ->where('employee_id', $empreport_username->employee_id)
                ->first();
       // dd ($player_id);
        $eDate = date('Y-m-d', strtotime($request->end_date));
        $days = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);
        if($request->half_day == 1){
            $days -= (float) 0.5;
        }
//        print_r($emp->emp_number); die;
//        $id = DB::table('emp_leave_request')->insert([
//            'leave_type_id' => $request->type,
//            'date_applied' => $request->start_date,
//            'emp_number' => $request->emp_num,
//            'leave_status' => '3',
//            'comments' => $request->comments,
//            'length_days' => $days,
//            'from_date' => $request->start_date,
//            'end_date' => $request->end_date,hi
//            'created_at' => $now,
//            'created_by' => $request->emp_num
//        ]);
            
          $id = $this->lvReq->create([
            'leave_type_id' => $request->type,
            'date_applied' => $request->start_date,
            'emp_number' => $emp->emp_number,
            'leave_status' => '3',
            'comments' => $request->comments,
            'length_days' => $days,
            'from_date' => $request->start_date,
            'end_date' => $request->end_date,
            'created_at' => $now,
            'created_by' => $emp->emp_number
        ]);
        if(empty($emp->emp_middle_name)){
               $member_name = $emp->emp_firstname .' '.$emp->emp_lastname;
        } else {
               $member_name = $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname;
        }
        $result =([
            "result" => "Berhasil Mengajukan",
            "status" => 1,
            "player_id" => $player_id->player_id,
            "member_name" => $member_name
        ]);
     //  $this->sendEmailRequest('1',$request->emp_num, $id->id);
       
      return response()->json($result,200);

     }
     
     public function getLeaveApprove($id){
             $emp = DB::table('employee')->where('employee_id', $id)->first();
        $leaves = DB::table('emp_leave_request')
            ->join('emp_reportto', 'emp_leave_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_leave_request.emp_number', '=' ,'employee.emp_number')
            ->join('leave_status', 'leave_status.id','=', 'emp_leave_request.leave_status')
            ->where('emp_reportto.erep_sup_emp_number',$id)
            ->where('emp_reportto.erep_reporting_mode', '1')
            ->select('emp_leave_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname','leave_status.name')
            ->where('emp_leave_request.leave_status', 3)
            //->take(10)
            ->orderBy('emp_leave_request.created_at', 'desc')
             ->get();
        
        
        
        
        if(empty($leaves)){
            $result = [];
        }else {
            $result = $leaves;
        }
              return response()->json($result,200);
     }
     
     public function getAttendancereqapprove($id){
         $attendances = DB::table('emp_attendance_request')
            ->join('emp_reportto', 'emp_attendance_request.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
            ->join('employee', 'emp_attendance_request.emp_number', '=' ,'employee.emp_number')
            ->join('attendance_status_req', 'attendance_status_req.id','=', 'emp_attendance_request.request_status')
            ->where('emp_reportto.erep_sup_emp_number',$id)
            ->where('emp_reportto.erep_reporting_mode', '1')
           ->select('emp_attendance_request.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname',
                   'employee.emp_middle_name','employee.emp_lastname','attendance_status_req.name')
            ->where('emp_attendance_request.request_status', 1)
            //->take(10)
             ->get();
         
         $i = 0;
         
           //dd($hari);
//           $date = substr($attendance->$attendance,0,10);
//          $time_in = substr($attendance->start_date,11,8);
//           $time_out = substr($attendance->end_date,11,8);
         if(empty($attendances)){
             $result = ["result" => "Data not found.."];
         } else {
               foreach($attendances as $attendance){
             $hari =   date('l', strtotime($attendance->start_date));
              $date = substr($attendance->start_date,0,10);
              $time_in = substr($attendance->start_date,11,8);
              $time_out = substr($attendance->end_date,11,8);
              
              $arr[$i]=[
                  "id" =>$attendance->id,
                  "hari" => $hari,
                  "emp_firstname" => $attendance->emp_firstname,
                  "emp_middle_name" => $attendance->emp_middle_name,
                  "emp_lastname" => $attendance->emp_lastname,
                  "date" => $date,
                  "reason" => $attendance->reason
              ];
              $i++;
         }
             $result = $arr;
         }
         
              return response()->json($result,200);
     }
     
     
     public function getAttendancehrd($id){
         $attendances = DB::table('emp_attendance_request')
                 ->join('employee', 'employee.emp_number','=', 'emp_attendance_request.emp_number' )
                 ->where('request_status', 2)
                 ->get();
                 $i =0;
               foreach($attendances as $attendance){
                   if(empty($attendance->start_date)){
                       $date = substr($attendance->start_date,0,10);
                       $hari =   date('l', strtotime($attendance->start_date));

                   } else {
                       $date = substr($attendance->end_date,0,10);
                       $hari =   date('l', strtotime($attendance->end_date));
                   }
               $approved = DB::table('employee')
                       ->where('emp_number', $attendance->approve_sup)
                       ->first();
                   
               $arr[$i]=[
                  "id" =>$attendance->id,
                  "hari" => $hari,
                  "emp_firstname" => $attendance->emp_firstname,
                  "emp_middle_name" => $attendance->emp_middle_name,
                  "emp_lastname" => $attendance->emp_lastname,
                  "date" => $date,
                  "approve_by1" => $approved->emp_firstname,
                  "approve_by2" => $approved->emp_middle_name,
                  "approve_by3" => $approved->emp_lastname,
                  "reason" => $attendance->reason,
                  "attendance_id" => $attendance->attendance_id
              ];
              $i++;
                   
                   

               }
               if(empty($arr)){
            $result = ["result" => "Tidak Ada Data"];

               } else {
                   $result = $arr;
               }
              


              return response()->json($result,200);

     }
     
     public function updateAttendancehrd(Request $request){
         $now = date("Y-m-d H:i:s");
         $attendance_req = DB::table('emp_attendance_request')
                            ->where('id' , $request->id)
                            ->first();
         $attendance_record =DB::table('attendance_record')
                            ->where('id', $attendance_req->attendance_id)
                            ->first();
                           
         $punch_in = $attendance_record ->punch_in_utc_time;
         $punch_out = $attendance_record ->punch_out_utc_time;
         
         if(empty($punch_in)){
             $date = date('Y-m-d', strtotime($punch_out));
         } else {
             $date = date('Y-m-d', strtotime($punch_in));
         }          
         
         $updateRequset = DB::table('emp_attendance_request')
                            ->where('id' , $request->id)
                         ->update([
                             "request_status" => 3,
                             "approve_hr" => $request->username,
                             "approve_hr_date" => $now
                         ]);
         
         $updateRecord = DB::table('attendance_record')
                  ->where('id', $attendance_req->attendance_id)
                  ->update([
                    "punch_in_utc_time" =>  $date.' 08:00:00',
                    "punch_out_utc_time" => $date.' 17:00:00',
                    "punch_in_note" => $punch_in,
                    "punch_out_note" => $punch_out
         ]);
           $result =([
            "result" => "Successfully  Approved.",
            "status" => 1]);
         
             return response()->json($result,200);     
         
     }
     
      public function rejectAttendancehrd(Request $request){
          $now = date("Y-m-d H:i:s");
           $attendance_req = DB::table('emp_attendance_request')
                       ->where('id', $request->id)->first(); 
          
         if(empty($attendance_req)){
                        $result = ["result" => "Tidak Ada Data"];

         } else {
              $attendance = DB::table('emp_attendance_request')
                       ->where('id', $request->id)
                       ->update([
                         "request_status" => 0,
                         "approve_hr" => $request->username,
                         "approve_hr_date" =>$now  
                       ]);
                 $result =([
            "result" => "Successfully  Rejected.",
            "status" => 1]);
         }
                       return response()->json($result,200); 

     }
     
     
     public function rejectAttendance(Request $request){
          $now = date("Y-m-d H:i:s");
           $attendance_req = DB::table('emp_attendance_request')
                       ->where('id', $request->id)->first();
           
             $emp = DB::table('employee')
                           ->where('emp_number', $attendance_req->emp_number)
                           ->first();
                   $player_id = DB::table('user_phone')
                           ->where('employee_id', $emp->employee_id)
                           ->first();
                   $empparent =  DB::table('employee')
                           ->where('emp_number', $request->emp_num)
                           ->first();
                   
                            
           if(empty($empparent->emp_middle_name)){
               $member_name = $empparent->emp_firstname .' '.$empparent->emp_lastname;
        } else {
               $member_name = $empparent->emp_firstname.' '.$empparent->emp_middle_name.' '.$empparent->emp_lastname;
        }         
          
         if(empty($attendance_req)){
                        $result = ["result" => "Tidak Ada Data"];

         } else {
              $attendance = DB::table('emp_attendance_request')
                       ->where('id', $request->id)
                       ->update([
                         "request_status" => 0,
                         "approve_sup" => $request->emp_num,
                         "approve_sup_date" =>$now  
                       ]);
                 $result =([
            "result" => "Successfully  Rejected.",
            "status" => 1,
            "player_id" => $player_id->player_id,
            "member_name" => $member_name]);
         }
                       return response()->json($result,200); 

     }
     
     public function approveAttendance(Request $request){
                   $now = date("Y-m-d H:i:s");
                   $attendance_req = DB::table('emp_attendance_request')
                       ->where('id', $request->id)->first(); 
                   $emp = DB::table('employee')
                           ->where('emp_number', $attendance_req->emp_number)
                           ->first();
                   $player_id = DB::table('user_phone')
                           ->where('employee_id', $emp->employee_id)
                           ->first();
                   $empparent =  DB::table('employee')
                           ->where('emp_number', $request->emp_num)
                           ->first();
                   
           if(empty($empparent->emp_middle_name)){
               $member_name = $empparent->emp_firstname .' '.$empparent->emp_lastname;
        } else {
               $member_name = $empparent->emp_firstname.' '.$empparent->emp_middle_name.' '.$empparent->emp_lastname;
        }         
         if(empty($attendance_req)){
                        $result = ["result" => "Tidak Ada Data"];

         } else {
              $attendance = DB::table('emp_attendance_request')
                       ->where('id', $request->id)
                       ->update([
                         "request_status" => 2,
                         "approve_sup" => $request->emp_num,
                         "approve_sup_date" =>$now  
                       ]);
                 $result =([
            "result" => "Successfully Approved.",
            "status" => 1,
            "player_id" => $player_id->player_id,
            "member_name" => $member_name
                         ]);
         }  
                       return response()->json($result,200); 

     }
     
     public function addEmergency(Request $request){
         $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_emergency_contacts')->insert([
                               'emp_number' => $request->emp_num,
                               'eec_name' => $request->name,
                               'eec_relationship' => $request->relationship,
                               'eec_home_no' => $request->homephone,
                               'eec_mobile_no' => $request->mobilephone,
                               'eec_office_no'=> $request->officephone
                           ]);
             
             $result =([
            "result" => "Your new emergency contact has been added.",
            "status" => 1
        ]);
         }
              return response()->json($result,200); 
     }
     
     public function getEmergencyDetails($id){
         $contact = DB::table('emp_emergency_contacts')->where('id', $id)->first();
         return response()->json($contact,200); 

     }
     
     public function updateEmergencyContact(Request $request){
            $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_emergency_contacts')->where('id', $request->id)
                      ->where('emp_number', $request->emp_num )
                      ->update([
                               'emp_number' => $request->emp_num,
                               'eec_name' => $request->name,
                               'eec_relationship' => $request->relationship,
                               'eec_home_no' => $request->homephone,
                               'eec_mobile_no' => $request->mobilephone,
                               'eec_office_no'=> $request->officephone
                           ]);
             
             $result =([
            "result" => "Your emergency contact has been updated.",
            "status" => 1
        ]);
         }
              return response()->json($result,200);
     }
     
     public function deleteEmergencyContacts(Request $request){
         DB::table('emp_emergency_contacts')->where('id', $request->id)
                   ->where('emp_number', $request->emp_num )->delete();
           $result =([
            "result" => "Your new emergency contact has been deleted.",
            "status" => 1
        ]);
                         return response()->json($result,200);
     }
     
     public function getEducationinfo($id){
        $education = DB::table('education')->get();
           return response()->json($education,200);

     }
     
    public function addWorkexperience(Request $request){
    $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_work_experience')->insert([
                               'emp_number' => $request->emp_num,
                               'eexp_employer' => $request->company,
                               'eexp_jobtit' => $request->job_title,
                               'eexp_from_date' => $request->from_date,
                               'eexp_to_date' => $request->to_date,
                              
                           ]);
             
             $result =([
            "result" => "Your new work experience has been added.",
            "status" => 1   
                 
        ]);
         }
         return response()->json($result,200);
    }
    
    public function updateWorkexperience(Request $request){
        $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_work_experience')->where('id', $request->id)
                      ->where('emp_number', $request->emp_num )
                      ->update([
                              'emp_number' => $request->emp_num,
                                'emp_number' => $request->emp_num,
                               'eexp_employer' => $request->company,
                               'eexp_jobtit' => $request->job_title,
                               'eexp_from_date' => $request->from_date,
                               'eexp_to_date' => $request->to_date,              
                           ]);
             
             $result =([
            "result" => "Your work experience has been updated.",
            "status" => 1
        ]);
    }
             return response()->json($result,200);

    }
    
    public function deleteWorkexperience(Request $request){
         DB::table('emp_work_experience')->where('id', $request->id)
                   ->where('emp_number', $request->emp_num )->delete();
           $result =([
            "result" => "Your work experience has been deleted.",
            "status" => 1
        ]);
                         return response()->json($result,200);
     }     
     
     
     
    
     
    public function addEducation(Request $request ){
         $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_education')->insert([
                               'emp_number' => $request->emp_num,
                               'education_id' => $request->id,
                               'institute' => $request->institute,
                               'major' => $request->major,
                               'year' => $request->year,
                               'score'=> $request->gpa,
                               'start_date' => $request->start_date,
                               'end_date' => $request->end_date
                           ]);
             
             $result =([
            "result" => "Your new education has been added.",
            "status" => 1
        ]);
         }
              return response()->json($result,200); 
     }
     
      public function updateEducation(Request $request){
            $emp = DB::table('employee')->where('emp_number', $request->emp_num)->first();
         
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data"];
         } else {
              DB::table('emp_education')->where('id', $request->id)
                      ->where('emp_number', $request->emp_num )
                      ->update([
                              'emp_number' => $request->emp_num,
                               'education_id' => $request->education_id,
                               'institute' => $request->institute,
                               'major' => $request->major,
                               'year' => $request->year,
                               'score'=> $request->gpa,
                               'start_date' => $request->start_date,
                               'end_date' => $request->end_date
                           ]);
             
             $result =([
            "result" => "Your education has been updated.",
            "status" => 1
        ]);
         }
              return response()->json($result,200);
     }
     
    public function changePassword(Request $request){
       $emp = DB::table('users')->where('username', $request->username)->first();
      
         if(empty($emp)){
           $result = ["result" => "Tidak Ada Data Users"];
         } else {
             if ($request->currentpassword == $emp->decrypt){
                 
            DB::table('users')->where('username', $request->username)
            ->where('decrypt', $request->currentpassword )
            ->update([
                       'decrypt' => $request->newpassword
                     ]);
             
            $result =([
            "result" => "Your password has been changed.",
            "status" => 1
            ]);
            
            } else {
            $result =([
            "result" => "Your password does not match.",
            "status" => 0
            ]);

         }
         }
              return response()->json($result,200);
    }
     
    public function deleteEducation(Request $request){
         DB::table('emp_education')->where('id', $request->id)
                   ->where('emp_number', $request->emp_num )->delete();
           $result =([
            "result" => "Your education has been deleted.",
            "status" => 1
        ]);
                         return response()->json($result,200);
     }     
     

     
     
     public function getLeavedetails($id)
     {
         $details = DB::table('emp_leave_request')
                 ->where('id', $id)->first();
         ///dd($details);
         $leave_type = DB::table('leave_type')
                    ->where('id', $details->leave_type_id)->first();
         $emp = DB::table('employee')->where('emp_number', $details->emp_number)->first();
         $result= ([
             "emp_firstname" => $emp->emp_firstname,
             "emp_middle_name" => $emp->emp_middle_name,
             "emp_lastname" => $emp->emp_lastname,
             "start_date" => $details->from_date,
             "end_date" => $details->end_date,
             "tanggal_pengajuan" => $details->date_applied,
             "leave_type" => $leave_type->name,
             "comment" => $details->comments
             
         ]);
         return response()->json($result,200);
  
     }
     
      public function approveLeave(Request $request){
        $now = date("Y-m-d H:i:s");
        $year = date("Y");
        $leave = $this->lvReq->where('id',$request->leave_id)->first();
        $entitle = DB::select("
            SELECT * FROM leave_entitlement where leave_type_id = '".$leave->leave_type_id."'
            AND emp_number = '".$leave->emp_number."' AND YEAR(to_date) = '".$year."' and deleted = 0
            ");
        
           $empparent =  DB::table('employee')
                           ->where('emp_number', $request->emp_num)
                           ->first();
                   
           if(empty($empparent->emp_middle_name)){
               $member_name = $empparent->emp_firstname .' '.$empparent->emp_lastname;
        } else {
               $member_name = $empparent->emp_firstname.' '.$empparent->emp_middle_name.' '.$empparent->emp_lastname;
        }         
        
        $employeereq_id = DB::table('employee')
                    ->where('emp_number', $leave->emp_number)
                    ->first();
        $player_id = DB::table('user_phone')
                    ->where('employee_id', $employeereq_id->employee_id)
                     ->first();
      //  dd($entitle);
        $emp = DB::table('employee')->where('emp_number',$request->emp_num)->first();
        $leave->comments .= " - Comments from ".$emp->emp_firstname." ".$request->comments;
        $leave->leave_status = $request->leave_status;
        $taken = (float)$leave->length_days;
      //  dd($taken);
        if($request->leave_status == '4'){
            $leave->approved_at = $now;
            $leave->approved_by = $emp->emp_number;
            $left = $tmp = 0;
            foreach ($entitle as $row){ // length_days
                $left = (float)$row->no_of_days - $row->days_used;
               if($taken >= 0){
                    $taken -= $left;
                    if($taken >= 0 && $left >= 0){
                        DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $left)]);
                        $tmp = $taken;
                    }else if($taken < 0 && $left >= 0){
                        DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $taken + $left)]);
                    }else{
                        DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $tmp)]);
                    }
                }
            }
       //     $this->sendEmailApprove('2', $emp->emp_number, $request->leave_id);
        }
        $leave->save();
        $result = ["result" => "Approve Success",
                   "status" => 1,
                   "player_id" => $player_id->player_id,
                   "member_name" => $member_name
                  ];

         return response()->json($result,200);
    }
    
    public function gethistoryLeave($id) {
        $history = DB:: table('emp_leave_request')
                ->join('employee', 'employee.emp_number', '=', 'emp_leave_request.emp_number')
                ->join('leave_status', 'leave_status.id', '=' ,'emp_leave_request.leave_status')
                ->where('emp_leave_request.emp_number', $id)
                ->select('emp_leave_request.*','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname','leave_status.name')
                ->orderBy('created_at', 'desc')
                ->get();
        if(empty($history))
        {
            $result = ["result" => "Tidak Ada Data"];
        } else {
            $result = $history;
        }
                 return response()->json($result,200);

        
    }
    
       public function getQualifications($id){
        $emp = $this->emp->where('emp_number', $id)->first();
        $trains = DB::table('trainning')->where('emp_number', $id)->get();
        
        $result = ([
                ""
        ]);
        
                 return response()->json($reports,200);

    }
    
    public function getWorkexperience($id){
                $quali = DB::table('emp_work_experience')->where('emp_number', $id)->orderBy('eexp_seqno')->get();
                 return response()->json($quali,200);

    }
    
    public function getEducation($id){
                $edus = DB::table('emp_education')->where('emp_number', $id)
                        ->leftJoin('education', 'emp_education.education_id','=','education.id')
                        ->select('emp_education.id', 'emp_education.emp_number', 'emp_education.institute', 'emp_education.major',
                                'emp_education.year', 'emp_education.score', 'emp_education.start_date', 'emp_education.end_date', 'education.name')
                        ->orderBy('emp_education.start_date', 'desc')
                        ->get();
                
               // dd($edus);
                 return response()->json($edus,200);

    }
    
    public function getWorkexperiencedetails($id){
          $work = DB::table('emp_work_experience')->where('id', $id)->first();
                           return response()->json($work,200);

    }
    
    public function getEducationdetails($id){
        $edu = DB::table('emp_education')->where('id', $id)->first();
         return response()->json($edu,200);

    }
    
     public function getEmergency($id){

    }
    
    
    public function getTraining($id){
        $training = DB::table('emp_trainning')->where('emp_number', $id)
                ->join('trainning','license_id','=','trainning.id')
                ->select('emp_trainning.id','emp_trainning.license_id','emp_trainning.license_no','emp_trainning.license_issued_date'
                        ,'emp_trainning.license_expiry_date','trainning.name','emp_trainning.train_name')
                ->orderBy('license_i', 'desc')
                ->get();
        return response()->json($training,200);

    }
    
    public function getAllpersonel($id){
        $users = DB::table('users')
                ->where('id', $id)
                ->first();
        
        $allpersonel = DB::table('employee')
                ->where('project_code', $users->project_code)
                ->select('employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_number', 'employee.employee_id')
                ->orderBy('employee.emp_firstname')
                ->get();
                return response()->json($allpersonel,200);

    }
    
    public function searchPersonel($id, $emp_num){
        $users = DB::table('users')
                ->where('id', $emp_num)
                ->first();
        
        if($users->project_code == 'HO'){
        if(empty($id)){
             $allpersonel = DB::table('employee')
                ->select('employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_number', 'employee.employee_id')
                ->orderBy('employee.emp_firstname')
                ->get();
        } else {
           $allpersonel =  DB::table('employee')
                ->select('employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_number', 'employee.employee_id')
                ->where('employee_id', 'like',$id.'%')
                ->orderBy('employee.emp_firstname')
                ->get(); 
        }
        } else {
            if(empty($id)){
             $allpersonel = DB::table('employee')
                ->where('project_code', $users->project_code)
                ->select('employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_number', 'employee.employee_id')
                ->orderBy('employee.emp_firstname')
                ->get();
        } else {
           $allpersonel =  DB::table('employee')
                ->select('employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_number', 'employee.employee_id')
                ->where('employee_id', 'like',$id.'%')
                ->where('project_code', $users->project_code)
                ->orderBy('employee.emp_firstname')
                ->get(); 
        }
        }
        
     
        
        if(empty($allpersonel)){
            $result = ["result" => "Tidak Ada Data"];
        } else {
            $result = $allpersonel;
        }
         return response()->json($result,200);

    }
    
    public function postNotification(){
        $client = new Client();

    $res = $client->request('POST', 'http://trialhris.metropolitanland.com/m/addUserhp', [
        'form_params' => [
            'username' => '1812001',
        ]
    ]);

    if ($res->getStatusCode() == 200) { // 200 OK
        $response_data = $res->getBody()->getContents();
    }
    }
    
    public function addTraining(Request $request){
       //dd($request->all());
//        DB::table('trainning')
//               ->insert([
//                   "name" => $request->nama_trainning,
//                   "vendor_id" => '8'
//               ]);
//        
//        $id = DB::getPdo()->lastInsertId();
//        
        
        DB::table('emp_trainning')
               ->insert([
                   "emp_number" => $request->emp_num,
                   "license_id" => 1,
                   "license_no" => $request->nomor_sertifikat,
                   "license_issued_date" => $request->tanggal_sertifikat,
                   "license_expiry_date" => $request->tanggal_expired,
                   "train_name" => $request->nama_training
               ]);
        
            $result = ["result" => "Berhasil Menambahkan Training",
                       "status" => 1];

                 return response()->json($result,200);

        }
    
        
    public function getTrainingdetails($id){
       $training =  DB::table('emp_trainning')
            ->where('id', $id)
            ->first();
        return response()->json($training,200);

    }
    
    public function updateTraining(Request $request){
        $training =  DB::table('emp_trainning')
            ->where('id', $request->id)
            ->where('emp_number', $request->emp_num)
            ->where('license_id', 1)
            ->first();
        
        if (empty($training)){
            $result = ["ID not valid"];
        } else {
            DB::table('emp_trainning')
                    ->where('id', $request->id)
                    ->where('emp_number', $request->emp_num)
                    ->where('license_id', 1)
                    ->update([
                   "license_no" => $request->nomor_sertifikat,
                   "license_issued_date" => $request->tanggal_sertifikat,
                   "license_expiry_date" => $request->tanggal_expired,
                   "train_name" => $request->nama_training     
                            ]);
            
        $result = ["result" => "Berhasil Update Training",
                       "status" => 1];
        }
                return response()->json($result,200);

    }
    
    public function deleteTraining(Request $request){
        
         $training =  DB::table('emp_trainning')
            ->where('id', $request->id)
            ->where('emp_number', $request->emp_num)
            ->where('license_id', 1)
            ->first();
         
            
        if (empty($training)){
            $result = ["ID not valid"];
        } else {
            DB::table('emp_trainning')
                    ->where('id', $request->id)
                    ->where('emp_number', $request->emp_num)
                    ->where('license_id', 1)
                    ->delete();
               
            
        $result = ["result" => "Berhasil Delete Training",
                       "status" => 1];
        }
                return response()->json($result,200);
        
    }
    
    public function checkVersionApp($id) {
        $version = DB::table('MH_APPS_VER')
            ->where('APPS_VER_CHAR', $id)
            ->where('IS_ACTIVE', 1)
            ->first();

        $valid_ver = DB::table('MH_APPS_VER')
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($version) {
            $result = [
                "result" => "Apps Versiaon Match.",
                "status" => 1,
            ];
        } else {
            $result = [
                "result" => "Apps Version Does Not Match.",
                "status" => 0,
                "APP_VER_CHAR" => $valid_ver->APPS_VER_CHAR,
            ];
        }
        return response()->json($result, 200);
    }

    public function getAttendanceType() {
        $attendance_type = DB::table('com_master_perijinan')
            ->where('module', 'IMP')
            ->get();

        $result = [
            "attendance_type" => $attendance_type,
        ];
        
        return response()->json($result, 200);
    }

    public function getHolidayDate() {
        $year = date("Y");
        
        $holiday = DB::SELECT ("
            SELECT *, CONVERT(varchar, date, 23) as date_convert
            FROM holiday
            WHERE YEAR(date) = ".$year."
            ORDER BY date ASC
        ");

        $result = [
            "holiday" => $holiday,
        ];

        return response()->json($result, 200);
    }
}
