<?php

namespace App\Http\Controllers\HRD\Attendance;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Attendance\Absen,App\Models\Master\Employee;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller{

    protected $emp;
    protected $absen;
    public function __construct(Employee $emp,Absen $absen){
        $this->emp = $emp;
        $this->absen = $absen;
        parent::__construct();
    }
    public function index(){

        return view('pages.manage.absen.index');
    }
    public function rekap(Request $request){
        $arr = array();
        $j = 0;
        $members = DB::connection('websen')->select("SELECT ci.comNIP, cm.comDisplayName, cm.comDeptID FROM com_absensi_inout ci INNER JOIN com_member cm
          ON ci.comNIP = cm.comNIP
          WHERE ci.comDate >= '".$request->start_date."' AND ci.comDate <= '".$request->end_date."'
          AND cm.comDeptID = '".$request->project."' GROUP BY ci.comNIP");

        foreach($members as $member){
            $arr[$j]['nik'] = $member->comNIP;
            $arr[$j]['name'] = $member->comDisplayName;
            $arr[$j]['dept'] = $member->comDeptID;
            $sql = DB::connection('websen')->select("SELECT comNIP, comDate, comIn, comOut, TIMEDIFF(comOut, comIn) AS vals, comIjin FROM com_absensi_inout
                  WHERE comDate >= '".$request->start_date."' AND comDate <= '".$request->end_date."' AND comNIP = '".$member->comNIP."'");
            foreach($sql as $row){
                $newDate = date("d-m", strtotime($row->comDate));
                $arr[$j][$newDate][0] = $row->vals;
                $arr[$j][$newDate][1] = $row->comIn;
                $arr[$j][$newDate][2] = $row->comOut;
                $arr[$j][$newDate][3] = $row->comIjin;
            }
            $j++;
        }
        $start_date = date("Y-m-d", strtotime($request->start_date));
        $end_date = date("Y-m-d", strtotime($request->end_date));
        return view('pages.manage.absen.rekap', compact('arr', 'start_date', 'end_date'));
    }
}
