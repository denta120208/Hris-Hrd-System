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
use Illuminate\Support\Facades\Crypt;


class MobilePersonelController extends Controller
{


    protected $lvReq;


    function __construct()
    {

        // Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }

    public function getEmployeePersonelList(Request $request){
        $employee_mobile = DB::table("MH_USER_MOBILE")
            ->where("EMP_NUMBER", $request->emp_number)
            ->where("DEVICE_UUID", $request->device_uuid)
            ->where("IS_ACTIVE", 1)
            ->first();

//        if($employee_mobile){
//
//        } else {
//            $result = ["result" => "You're not logged in.", "status" => 0];
//            return response()->json($result, 200);
//        }

//        $member = DB::select('
//                            select b.erep_sub_emp_number,c.employee_id, c.emp_firstname ,c.emp_middle_name ,c.emp_lastname,
//						case when c.emp_middle_name is not null
//							then c.emp_firstname +\' \'+ c.emp_middle_name + \' \'+c.emp_lastname
//							when c.emp_middle_name is null
//							then c.emp_firstname +\' \'+ c.emp_lastname
//						else
//							c.emp_firstname +\' \'+ c.emp_lastname
//							end as full_name, a.emp_number, a.job_title_code,
//	                        d.job_description, d. job_title, c.joined_date from employee a inner join emp_reportto b
//                            on a.emp_number = b.erep_sup_emp_number
//                            inner join employee c on b.erep_sub_emp_number =  c.emp_number
//                            inner join job_title d
//                            on c.job_title_code =  d.id
//                            where a.emp_number = '.$request->emp_number." order by c.joined_date desc");
        
//        $member = DB::select("
//            SELECT b.erep_sub_emp_number, c.employee_id, c.emp_firstname, c.emp_middle_name, c.emp_lastname, (COALESCE(c.emp_firstname, '') + ' ' + COALESCE(c.emp_middle_name, '') + ' ' + COALESCE(c.emp_lastname, '')) AS full_name, a.emp_number, a.job_title_code, d.job_description, d.job_title, c.joined_date
//            FROM employee AS a
//            INNER JOIN emp_reportto AS b
//            ON a.emp_number = b.erep_sup_emp_number
//            INNER JOIN employee AS c
//            ON b.erep_sub_emp_number = c.emp_number
//            INNER JOIN job_title AS d
//            ON c.job_title_code = d.id
//            WHERE a.emp_number = ".$request->emp_number."
//            AND c.termination_id = 0 
//            AND b.erep_reporting_mode IN ('1', '2')
//            ORDER BY c.joined_date DESC
//        ");
        
        $members = DB::select("
            SELECT b.erep_sub_emp_number, c.employee_id, c.emp_firstname, c.emp_middle_name, c.emp_lastname, c.emp_fullname, a.emp_number, a.job_title_code, d.job_description, d.job_title, c.joined_date
            FROM employee AS a
            INNER JOIN emp_reportto AS b
            ON a.emp_number = b.erep_sup_emp_number
            INNER JOIN employee AS c
            ON b.erep_sub_emp_number = c.emp_number
            INNER JOIN job_title AS d
            ON c.job_title_code = d.id
            WHERE a.emp_number = ".$request->emp_number."
            AND c.termination_id = 0
            AND b.erep_reporting_mode IN ('1', '2')
            ORDER BY c.joined_date DESC
        ");


        if(empty($members)){
            $result = [];

        } else {
            foreach ($members as $key => $member) {
                $members[$key]->full_name = $member->emp_fullname;
                unset($members[$key]->emp_fullname);
            }
            
            for($i=0;$i<count($members); $i++){
                $img = DB::table("emp_picture")
                    ->where("emp_number", $members[$i]->erep_sub_emp_number)
                    ->first();
                if($img){

                    if($img->epic_picture_type == 2){
                        $picture =  base64_encode( $img->epic_picture );
                    } else {
                        $picture = $img->epic_picture;
                    }
                } else {
                    $picture = [];
                }
                $res[$i] = [
                    "data_personel" => $members[$i],
                    "picture" => $picture
                ];

            }
            $result = $res;
        }
        return response()->json($result,200);
    }

    public function getNation(Request $request) {
        $nation = DB::table('nationality')
            ->get();

        $current_nation = DB::table('nationality')
            ->where('id', $request->nation_code)
            ->first();

        $result = [
            "nation" => $nation,
            "current_nation" => $current_nation,
        ];
        
        return response()->json($result, 200);
    }

    public function getAgama(Request $request) {
        $agama = DB::table('emp_agama')
            ->get();

        $current_agama = DB::table('emp_agama')
            ->where('id', $request->agama_code)
            ->first();

        $result = [
            "agama" => $agama,
            "current_agama" => $current_agama,
        ];
        
        return response()->json($result, 200);
    }

    public function updateDataPersonal(Request $request) {
        $member = DB::table('employee')
            ->where('employee_id',  $request->employee_id)
            ->first();

        if ($member) {
            // $employee_mobile = DB::table('MH_USER_MOBILE')
            //     ->where('EMP_NUMBER', $request->emp_number)
            //     ->where('DEVICE_UUID', $request->device_uuid)
            //     ->where('IS_ACTIVE', 1)
            //     ->first();

            // if ($employee_mobile) {
                DB::table('employee')
                    ->where('employee_id', $request->employee_id)
                    ->update([
                        'emp_firstname' => $request->first_name,
                        'emp_middle_name' => $request->middle_name,
                        'emp_lastname' => $request->last_name,
                        'emp_fullname' => trim(implode(' ', [$request->first_name, $request->middle_name, $request->last_name])),
                        'emp_birthday' => $request->dob,
                        'emp_gender' => $request->gender,
                        'emp_ktp' => $request->ktp,
                        'emp_dri_lice_num' => $request->driver_license_number,
                        'emp_dri_lice_exp_date' => $request->license_expiry_date,
                        'emp_marital_status' => $request->marital_status,
                        'bpjs_ks' => $request->bpjs_kes,
                        'bpjs_tk' => $request->bpjs_tk,
                        'npwp' => $request->npwp,
                        'nation_code' => $request->nation_code,
                    ]);
                
                $this->addMobileLog($request->emp_number, "Personal Info", "Update personal info");

                $result = ["result" => "Successfully update personal info.", "status" => 1];
                return response()->json($result, 200);
            // } else {
            //     $result = ["result" => "You're not logged in.", "status" => 0];
            //     return response()->json($result, 200);
            // }
        } else {
            $result = ["result" => "User not found.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function updateContactDetailsInfo(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('employee')
                ->where('employee_id', $employee_mobile->EMPLOYEE_ID)
                ->update([
                    'emp_street1' => $request->address_1,
                    'emp_street2' => $request->address_2,
                    'city_code' => $request->city,
                    'provin_code' => $request->state,
                    'nation_code' => $request->country,
                    'emp_zipcode' => $request->zip,
                    'emp_hm_telephone' => $request->home_phone,
                    'emp_mobile' => $request->mobile_phone,
                    'emp_mobile2' => $request->mobile_phone2,
                    'emp_work_telephone' => $request->work_phone,
                    'emp_work_email' => $request->work_email,
                    'emp_oth_email' => $request->other_email,
                    'agama' => $request->agama,
                ]);
            
            $this->addMobileLog($request->emp_number, "Contact Details Info", "Update contact details info");

            $result = ["result" => "Successfully update contact details info.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }

    public function updateSocialMedia(Request $request) {
        $employee_mobile = DB::table('MH_USER_MOBILE')
            ->where('EMP_NUMBER', $request->emp_number)
            ->where('DEVICE_UUID', $request->device_uuid)
            ->where('IS_ACTIVE', 1)
            ->first();

        if ($employee_mobile) {
            DB::table('employee')
                ->where('employee_id', $employee_mobile->EMPLOYEE_ID)
                ->update([
                    'emp_facebook' => $request->facebook,
                    'emp_twitter' => $request->twitter,
                    'emp_instagram' => $request->instagram,
                ]);
            
            $this->addMobileLog($request->emp_number, "Social Media Info", "Update social media info");

            $result = ["result" => "Successfully update social media info.", "status" => 1];
            return response()->json($result, 200);
        } else {
            $result = ["result" => "You're not logged in.", "status" => 0];
            return response()->json($result, 200);
        }
    }
}


