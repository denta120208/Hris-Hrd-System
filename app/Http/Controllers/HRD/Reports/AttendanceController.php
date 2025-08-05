<?php

namespace App\Http\Controllers\HRD\Reports;

use App\Models\Attendance\Absen;
use App\Models\Master\Employee;
use Illuminate\Http\Request;
use Session, DB, Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HRD\Reports\RekapPerorangReport;
use App\Http\Controllers\HRD\Reports\RekapDWPerorangReport;

class AttendanceController extends Controller{

    protected $emp;
    protected $absen;
    public function __construct(Employee $emp,Absen $absen){
        $this->emp = $emp;
        $this->absen = $absen;
        parent::__construct();
    }
    
    public function index(){
        $now = date('Y-m-d H:i:s');
        //dd('test');
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Attendance Report Index',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Attendance Report Index ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        $dataAbsen = 0;
        
        return view('pages.manage.reports.absen.rekap2',compact('dataAbsen'));
    }
    
    public function rekap_old(){
        $now = date('Y-m-d H:i:s');
        $members = $this->emp->where('location_id', '1')->where('termination_id','=',0)->get();
        $arr = array();
        $j = 0;
        $start_date = '2023-10-16';
        $end_date = '2023-11-15';

//        , DATEDIFF(HOUR, ar.punch_in_utc_time, ar.punch_out_utc_time) AS HourDiff,
//        DATEDIFF(MINUTE, ar.punch_in_utc_time, ar.punch_out_utc_time) AS MinuteDiff
        
        foreach($members as $member){
            $arr[$j]['nik'] = $member->employee_id;
            $arr[$j]['name'] = $member->emp_fullname;
            $arr[$j]['dept'] = 1;
//            $sql = DB::connection('websen')->select("SELECT comNIP, comDate, comIn, comOut, TIMEDIFF(comOut, comIn) AS vals, comIjin FROM com_absensi_inout
//                  WHERE comDate >= '".$request->start_date."' AND comDate <= '".$request->end_date."' AND comNIP = '".$member->employee_id."'");
            $sql = DB::select("SELECT comNIP, comDate, comIn, comOut, DATEDIFF(hour, comIn, comOut) AS vals, comIjin FROM com_absensi_inout
                  WHERE comDate >= '".$start_date."' AND comDate <= '".$end_date."' AND comNIP = '".$member->employee_id."'");
            foreach($sql as $row){
                $newDate = date("d-m", strtotime($row->comDate));
                $arr[$j][$newDate][0] = $row->vals;
                $arr[$j][$newDate][1] = $row->comIn;
                $arr[$j][$newDate][2] = $row->comOut;
                $arr[$j][$newDate][3] = $row->comIjin;
//                print_r('<pre>');
//                print_r($arr);
//                print_r('</pre>');
            } 
            $j++;
        } // die;
        $start_date = date("Y-m-d", strtotime($start_date));
        $end_date = date("Y-m-d", strtotime($end_date));
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Rekap Attendance',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Rekap Attendance, location id '. 1,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);
        
        $dataAbsen = 1;
        
        return view('pages.manage.reports.absen.rekap2_old', compact('arr', 'start_date', 'end_date','dataAbsen'));
    }
    
    public function index_dw_perorg(){
        $now = date('Y-m-d H:i:s');
        $emps = NULL;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Index DW Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Index DW Perorang' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);

        $IS_POST = false;
        
        return view('pages.manage.reports.absen.search_dw', compact('emps','IS_POST'));
    }

    public function rekap_dw_perorg(Request $request){
        $now = date('Y-m-d H:i:s');
        $where = '';

        $IS_POST = true;

        $report = new RekapDWPerorangReport(array(
            "project"=>$request->project,
            "start_date_param"=>$request->start_date,
            "end_date_param"=>$request->end_date
        ));

        $report->run();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Rekap DW Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Rekap DW Perorang' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'adms_db..userinfo, adms_db..departments, adms_db..checkinout'
        ]);
        
        return view('pages.manage.reports.absen.search_dw', compact('emps','report','IS_POST'));
    }
    
    public function index_perorg(){
        $now = date('Y-m-d H:i:s');
        $emps = NULL;
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Index Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Index Perorang' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);

        $IS_POST = false;
        
        return view('pages.manage.reports.absen.search', compact('emps','IS_POST'));
    }
    public function rekap_perorg(Request $request){
        $now = date('Y-m-d H:i:s');
        $where = '';

        $IS_POST = true;
        
        //dd($request);
        
        // if ($request->start_date <> '' && $request->end_date <> '')
        // {
        //     $where .= "and b.comDate between '".$request->start_date."' and '".$request->end_date."' ";
        // }
        // else
        // {
        //     $where .= ' ';
        // }
        
        // if ($request->comDisplayName <> '')
        // {
        //     $where .= "and (a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) like '%".$request->comDisplayName."%' ";
        // }
        // else
        // {
        //     $where .= ' ';
        // }
        
        // if ($request->comNIP <> '')
        // {
        //     $where .= "and b.comNIP = '".$request->comNIP."' ";
        // }
        // else
        // {
        //     $where .= ' ';
        // }
        
        // if ($request->project > 0)
        // {
        //     $where .= "and a.location_id =  ".$request->project." ";
        // }
        // else
        // {
        //     $where .= ' ';
        // }
        
        // dd("select b.comNIP,(a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) as comDisplayName,
        //                                 b.comDate,b.comIn,b.comOut,b.comIjin,termination_id
        //                     from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
        //                     where a.termination_id = 0
        //                     and b.comNIP IS NOT NULL 
        //                     ".$where." 
        //                     ORDER BY b.comNIP,b.comDate");
        
        
        // $emps = DB::select("select b.comNIP,(a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) as comDisplayName,
        //                             FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
        //                             convert(char(8),convert(time(0),b.comIn)) as comIn,
        //                             convert(char(8),convert(time(0),b.comOut)) as comOut,
        //                             b.comIjin,termination_id
        //                      from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
        //                      where a.termination_id = 0
        //                      and b.comNIP IS NOT NULL 
        //                      ".$where." 
        //                      ORDER BY b.comNIP,b.comDate");
        
        //dd($emps);

        $report = new RekapPerorangReport(array(
            "project"=>$request->project,
            "start_date_param"=>$request->start_date,
            "end_date_param"=>$request->end_date,
            "employee"=>$request->comDisplayName,
            "nik"=>$request->comNIP
        ));

        $report->run();

        // dd($report->dataStore('rekap_perorang_table1')->all());
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Rekap Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Rekap Perorang' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'com_absensi_inout, com_member'
        ]);
        
        return view('pages.manage.reports.absen.search', compact('emps','report','IS_POST'));
    }
    
    public function absenDW(){
        $now = date('Y-m-d H:i:s');
        //dd('test');
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Attendance DW Report Index',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Attendance DW Report Index ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        $dataAbsenDW = 0;
        
        return view('pages.manage.reports.absen.rekap2_dw',compact('dataAbsen','dataAbsenDW'));
    }
    
    public function rekapDW(Request $request){
        $now = date('Y-m-d H:i:s');
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));

        // Data utama absensi DW
        $arr = DB::select("exec sp_absen_employee_DW '".$start_date."','".$end_date."','".$request->project."'");

        // Data Join Employee (masuk pada rentang tanggal)
        $joinEmployees = \App\Models\Master\Employee::whereDate('joined_date', '>=', $start_date)
            ->whereDate('joined_date', '<=', $end_date)
            ->where('location_id', $request->project)
            ->get();

        // Data Terminate Employee (keluar pada rentang tanggal)
        $terminateEmployees = \App\Models\Master\Employee::where('termination_id', '!=', 0)
            ->whereNotNull('termination_id')
            ->whereDate('termination_date', '>=', $start_date)
            ->whereDate('termination_date', '<=', $end_date)
            ->where('location_id', $request->project)
            ->get();

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Attendance DW Report Index',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Rekap Attendance DW, location id '. $request->project,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        $dataAbsenDW = 1;

        return view('pages.manage.reports.absen.rekap2_dw', compact('arr', 'start_date', 'end_date','dataAbsenDW', 'joinEmployees', 'terminateEmployees'));
    }

    public function perorang()
    {
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Attendance Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Attendance Perorang',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.reports.absen.perorang');
    }

    public function dw()
    {
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View DW Attendance',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View DW Attendance',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.reports.absen.dw_index');
    }

    public function dwPerorang()
    {
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View DW Attendance Perorang',
            'module' => 'Report',
            'sub_module' => 'Attendance',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View DW Attendance Perorang',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.reports.absen.dw_perorang');
    }
}
