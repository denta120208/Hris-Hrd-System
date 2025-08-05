<?php

namespace App\Http\Controllers\MetHrisMobile;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;

class MobileEmpLoyalty extends Controller {
    
    function __construct(){
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }
    public function getDataEmp(Request $request){
        $result = array();
        $emp = DB::table('employee')->where('emp_ktp', $request->id)->where('termination_id', 0)->first();
        if($emp){
            $result = ['name' => $emp->emp_fullname];
        }
        
        return response()->json($result,200);
    }
    public function getAllEmp(Request $request){
        $arr = array();
        $i = $status = 0;
        $emps = DB::table('employee')->where('employee_id', 'LIKE', $request->id.'%')->where('termination_id', '0')
                ->select('emp_fullname','employee_id','emp_status','joined_date', 'npwp', 'status_pajak', 'bpjs_tk', 'bpjs_ks', 'emp_birthday', 'emp_ktp','emp_oth_email')->get();
        
//        print_r('<pre>');
//        print_r($emps);
//        print_r('</pre>'); die;
        if(!empty($emps)){
            foreach($emps as $emp){
                if($emp->emp_status == '1'){
                    $status = $emp->emp_status;
                }else{
                    $status = 2;
                }
                $arr[$i] = $emp->employee_id.';'.$emp->emp_fullname.';'.$emp->joined_date.';'.$emp->npwp.";".$this->date_convert($emp->emp_birthday).";".$status.";".$emp->status_pajak
                    .";".$emp->bpjs_tk.";".$emp->bpjs_ks.";".$emp->emp_ktp.";".$emp->emp_oth_email;
                $i++;
            }
        }else{
            $arr[0] = '0;Tidak Ditemukan';
        }
        return response()->json($arr);
    }
}
