<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;

use App\Http\Requests, Session, DB;
use App\Http\Controllers\Controller;

class RCustomeController extends Controller{

    public function komposisi_emp(){
        return view('pages.manage.reports.komposisi_emp.index');
    }
    public function search_emp(Request $request){
        $where = '';
        foreach($request->except('_token') as $key => $val){
            if($request->$key){
                if($key == 'emp_name'){
                    $where .= "emp_firstname LIKE '%".$val."%' OR emp_middle_name LIKE '%".$val."%' OR emp_lastname LIKE '%".$val."%' OR ";
                }else if($key == 'employee_id'){
                    $where .= $key." LIKE '%".$val."%' AND ";
                }else if($key == 'termination_id'){
                    if($val == 1){
                        $where .= $key." IS NULL AND ";
                    }else{
                        $where .= $key." IS NOT NULL AND ";
                    }
                }else{
                    $where .= $key." = '".$val."' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        $emps = DB::select("
            SELECT * FROM employee WHERE ".$where."
        ");
        return view('pages.manage.reports.custome.search', compact('emps'));
    }
}
