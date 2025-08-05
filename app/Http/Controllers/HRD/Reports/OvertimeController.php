<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session, DB, Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class OvertimeController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $now = date('Y-m-d H:i:s');
        $project = DB::table('location')->where('code', Session::get('project'))->first();

        if (Session::get('project') == 'HO') {
            $dataLocation = DB::table('location')->get();
        }
        else {
            $dataLocation = DB::table('location')->where('code', Session::get('project'))->get();
        }

        $param = [
            "location_id" => NULL,
            "start_date" => NULL,
            "end_date" => NULL
        ];

        $IS_POST = false;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Overtime',
            'module' => 'Report',
            'sub_module' => 'Overtime Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Overtime' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => null
        ]);
        
        return view('pages.manage.reports.overtime.overtime', compact('project','dataLocation','param','IS_POST'));
    }

    public function viewOvertimeReport() {
        $now = date('Y-m-d H:i:s');
        $project = DB::table('location')->where('code', Session::get('project'))->first();

        if (Session::get('project') == 'HO') {
            $dataLocation = DB::table('location')->get();
        }
        else {
            $dataLocation = DB::table('location')->where('code', Session::get('project'))->get();
        }

        $location_id = request()->query('location_id');
        $start_date_param = request()->query('start_date_param');
        $end_date_param = request()->query('end_date_param');

        $location_id = empty($location_id) ? null : $location_id;
        $start_date_param = empty($start_date_param) ? null : $start_date_param;
        $end_date_param = empty($end_date_param) ? null : $end_date_param;

        $dataOvertimeReport = \DB::select("exec sp_report_overtime '$start_date_param', '$end_date_param', '$location_id', '0'");

        foreach($dataOvertimeReport as $key => $data) {
            $dataDetails = \DB::select("exec sp_report_overtime '$start_date_param', '$end_date_param', '$location_id', '".$data->emp_number."'");
            $dataOvertimeReport[$key]->details = $dataDetails;
        }

        $param = [
            "location_id" => $location_id,
            "start_date" => $start_date_param,
            "end_date" => $end_date_param
        ];

        $IS_POST = true;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Overtime POST',
            'module' => 'Report',
            'sub_module' => 'Overtime Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Overtime POST' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_ot_reqeuest'
        ]);
        
        return view('pages.manage.reports.overtime.overtime', compact('project','dataLocation','param','IS_POST','dataOvertimeReport'));
    }

    public function printOvertimeReport($location_id, $start_date, $end_date) {
        $now = date('Y-m-d H:i:s');

        $location = DB::table('location')->where('id', $location_id)->first();

        $location_name = $location->name;

        $dataOvertimeReport = \DB::select("exec sp_report_overtime '$start_date', '$end_date', '$location_id', '0'");

        foreach($dataOvertimeReport as $key => $data) {
            $dataDetails = \DB::select("exec sp_report_overtime '$start_date', '$end_date', '$location_id', '".$data->emp_number."'");
            $dataOvertimeReport[$key]->details = $dataDetails;
        }
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Report Overtime',
            'module' => 'Report',
            'sub_module' => 'Overtime Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Report Overtime POST' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_ot_reqeuest'
        ]);
        
        return view('pages.manage.reports.overtime.pdfCetakReportOvertime', compact('dataOvertimeReport','location_name','start_date','end_date'));
    }
}