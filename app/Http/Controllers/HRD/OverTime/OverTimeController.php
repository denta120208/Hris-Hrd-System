<?php

namespace App\Http\Controllers\HRD\OverTime;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\OverTime\OverTime, App\Models\OverTime\OverTimeReqeust;
use Carbon\Carbon;
use App\Models\Leave\Holiday;

class OverTimeController extends Controller{
    protected $emp;
    protected $overTime;
    protected $otReq;
    public function __construct(Employee $emp, OverTime $overTime, OverTimeReqeust $otReq){
        $this->emp = $emp;
        $this->overTime = $overTime;
        $this->otReq = $otReq;
        parent::__construct();
    }
    public function index(){
        $now = date('Y-m-d H:i:s');
        $ots = $this->otReq->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Over Time Index',
            'module' => 'Over Time',
            'sub_module' => 'Over Time',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Over Time Index,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_trainning_request'
        ]);
        return view('pages.manage.overTime.index', compact('ots'));
    }
    
    public function addOverTime(Request $request) {
        $now = date("Y-m-d H:i:s");

        $dataInOut = DB::table('com_absensi_inout')
                ->where('id', '=', $request->attend_id)
                ->first();
        $emp = $this->emp->where('employee_id', $dataInOut->comNIP)->first();
        $date = date_create(substr($dataInOut->comDate,0, 11)) ;
        $day = date('D', strtotime(date_format($date,"Y-m-d")));
        //dd(substr(date('H:i:s', strtotime($dataInOut->comDTIn)),3));
        $overDate = $request->ot_date;
        $attend_id = $request->attend_id;
        //dd(strtotime($dataInOut->comDTIn) <= strtotime($request->ot_date.' 08:00:00'));
        if ($emp->job_title_code <= 4 && ($day == 'Sat' || $day == 'Sun')) {
            
            $in = date('H:i:s', strtotime($dataInOut->comDTIn));
            $out = date('H:i:s', strtotime($dataInOut->comDTOut));
        } else {
            //jika absen masuk sebelum jam 8
            if (strtotime($dataInOut->comDTIn) <= strtotime($request->ot_date . ' 08:00:00')) {
                //dd('test1');
                $in = '18:00:00';
                $out = date('H:i:s', strtotime($dataInOut->comDTOut));
            } elseif ((strtotime($dataInOut->comDTIn) > strtotime($request->ot_date . ' 08:00:00')) && (strtotime($dataInOut->comDTIn) < strtotime($request->ot_date . ' 09:00:00'))) {
                //dd('test2');
                $time = '18:' . substr(date('H:i:s', strtotime($dataInOut->comDTIn)), 3);
                //dd($time);
                $in = $time;
                $out = date('H:i:s', strtotime($dataInOut->comDTOut));
            } else {
                //dd('test3');
                $time = '19:' . substr(date('H:i:s', strtotime($dataInOut->comDTIn)), 3);
                //dd($time);
                $in = $time;
                $out = date('H:i:s', strtotime($dataInOut->comDTOut));
            }
        }


        \DB::table('log_activity')->insert([
            'action' => 'View Apply Over Time',
            'module' => 'Over Time',
            'sub_module' => 'View Apply Over Time',
            'modified_by' => Session::get('name'),
            'description' => 'View Apply Over Time, attend_id ' . $request->attend_id . ', accessed by ' . Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'com_absensi_inout'
        ]);

        //dd($in.' s/d '.$out);

        return view('pages.manage.overTime.form1', compact('dataInOut', 'in', 'out', 'overDate', 'attend_id', 'emp'));
    }
    
    public function saveOverTime(Request $request) {
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $ot_hours = 0;
        $firstHour = 1.5;
        $secondHour = 2.0;

        $mealnum = 0;

        //$now = date("Y-m-d H:i:s");
        $otDate = date("Y-m-d", strtotime($request->ot_date));
        $dateday = new \DateTime($otDate);
        $currDay = $dateday->format('D');

        $sTime = date("H:i:s", strtotime($request->start_time));
        $eTime = date('H:i:s', strtotime($request->end_time));
        //dd($request->ot_date.' '.$request->start_time.':00');
        $sDate = strtotime($request->ot_date . ' ' . $request->start_time);
        $eDate = strtotime($request->ot_date . ' ' . $request->end_time);
        $diff = $eDate - $sDate;
        //dd($diff);

        $years = abs(floor($diff / 31536000));
        $days = abs(floor(($diff - ($years * 31536000)) / 86400));
        $hours = abs(floor(($diff - ($years * 31536000) - ($days * 86400)) / 3600));
        $mins = abs(floor(($diff - ($years * 31536000) - ($days * 86400) - ($hours * 3600)) / 60));

        //dd('hours: '.$hours.', min :'.$mins);

        $jamlembur = (float) $hours . '.' . $mins;

        //dd($jamlembur);

        $holidays = Holiday::where('date', '=', $otDate)->count();

        //jika lembur di hari sabtu atau minggu
        if ($jamlembur < 1) {
            $ot_hours = 0;
        } else {
            if ($currDay == 'Sat' || $currDay == 'Sun') {
//               if($jamlembur >= 0 && $jamlembur < 1)
//               {
//                   $ot_hours = $jamlembur * $secondHour;
//                   $mealnum = 0;
//               }
                if ($jamlembur >= 5 && $jamlembur <= 9) {
                    $ot_hours = ($jamlembur - 1) * $secondHour;
                    $mealnum = 10000;
                } else if ($jamlembur >= 10 && $jamlembur <= 14) {
                    $ot_hours = ($jamlembur - 2) * $secondHour;
                    $mealnum = 10000;
                } else if ($jamlembur >= 15 && $jamlembur <= 19) {
                    $ot_hours = ($jamlembur - 3) * $secondHour;
                    $mealnum = 10000;
                } else {
                    $ot_hours = $jamlembur * $secondHour;
                }
            } else {
                //jika Lembur di libur nasional
                if ($holidays > 0) {
//                    if($jamlembur >= 0 && $jamlembur < 1)
//                    {
//                       $ot_hours = $jamlembur * $secondHour;
//                       $mealnum = 0;
//                    }
                    if ($jamlembur >= 5 && $jamlembur <= 9) {
                        $ot_hours = ($jamlembur - 1) * $secondHour;
                        $mealnum = 10000;
                    } else if ($jamlembur >= 10 && $jamlembur <= 14) {
                        $ot_hours = ($jamlembur - 2) * $secondHour;
                        $mealnum = 10000;
                    } else if ($jamlembur >= 15 && $jamlembur <= 19) {
                        $ot_hours = ($jamlembur - 3) * $secondHour;
                        $mealnum = 10000;
                    } else {
                        $ot_hours = $jamlembur * $secondHour;
                    }
                }
                //jika lembur dihari biasa;
                else {
//                    if($jamlembur >= 0 && $jamlembur < 1)
//                    {
//                       $ot_hours = $jamlembur;
//                       $mealnum = 0;
//                    }
                    if ($jamlembur >= 5 && $jamlembur <= 9) {
                        $hours_ot = ($jamlembur - 1);
                        $mealnum = 10000;
                    } else if ($jamlembur >= 10 && $jamlembur <= 14) {
                        $hours_ot = ($jamlembur - 2);
                        $mealnum = 10000;
                    } else if ($jamlembur >= 15 && $jamlembur <= 19) {
                        $hours_ot = ($jamlembur - 3);
                        $mealnum = 10000;
                    } else {
                        $hours_ot = $jamlembur;
                    }

                    $ot_hours = 1 * $firstHour;
                    $ot_hours += ($hours_ot - 1) * $secondHour;
                }
            }
        }


        //dd($ot_hours);

        $emp = $this->emp->where('emp_number', $request->emp_number)->where('termination_id','=',0)->first();
        //$day = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);
        //dd($days);
        $this->otReq->create([
            'attendance_id' => $request->attend_id,
            'emp_number' => $emp->emp_number,
            'ot_date' => $otDate,
            'ot_start_time' => $sTime,
            'ot_end_time' => $eTime,
            'ot_hours' => $jamlembur,
            'ot_total_hours' => $ot_hours,
            'ot_meal_num' => $mealnum,
            'ot_status' => 2,
            'ot_reason' => $request->ot_reason,
            'created_at' => $dateNow,
            'created_by' => Session::get('name'),
            'approved_at' => $dateNow,
            'approved_by' => Session::get('name'),
        ]);
        
        DB::table('com_absensi_inout')
                    ->where('id', '=', $request->attend_id)
                    ->update([
                        'is_claim_ot' => 1,
                        'updatet_at' => $dateNow
            ]);

        \DB::table('log_activity')->insert([
            'action' => 'Add Request Overtime',
            'module' => 'Overtime',
            'sub_module' => 'Request Overtime',
            'modified_by' => Session::get('name'),
            'description' => 'Request overtime : ' . $emp->employee_id . ', date :' . $otDate . ' start : ' . $sTime . ' end : ' . $eTime . ', reason : ' . $request->ot_reason,
            'created_at' => $dateNow,
            'updated_at' => $dateNow,
            'table_activity' => 'emp_ot_reqeuest'
        ]);
//        $this->sendEmailRequest('1',$emp->emp_number, $id->id);
        return redirect(route('hrd.inout'))->with('status', 'Overtime has been added');;
    }
    
    public function otReqList() {
//        $otR = $this->otReq
//                ->leftJoin('employee', 'emp_ot_reqeuest.emp_number', '=', 'employee.emp_number')
//                ->where('ot_status',1)
//                ->select('emp_ot_reqeuest.*','employee.employee_id', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')
//                ->get();
//        dd($otR);
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        
        if (Session::get('project') == 'HO') {
            $otR = DB::select("select emp_ot_reqeuest.*,
	FORMAT(emp_ot_reqeuest.ot_date, 'dd-MM-yyyy') as ot_date1, 
	employee.employee_id, 
	employee.emp_firstname, 
	employee.emp_middle_name, 
	employee.emp_lastname,
	overtime_status.name as status_name,
        overtime_status.id as status_id
from emp_ot_reqeuest
LEFT JOIN employee ON emp_ot_reqeuest.emp_number = employee.emp_number
LEFT JOIN overtime_status on emp_ot_reqeuest.ot_status =  overtime_status.id
where employee.emp_status in (1,2,5) and overtime_status.id = 1");
        } else {
            $otR = DB::select("select emp_ot_reqeuest.*,
	FORMAT(emp_ot_reqeuest.ot_date, 'dd-MM-yyyy') as ot_date1, 
	employee.employee_id, 
	employee.emp_firstname, 
	employee.emp_middle_name, 
	employee.emp_lastname,
	overtime_status.name as status_name,
        overtime_status.id as status_id
from emp_ot_reqeuest
LEFT JOIN employee ON emp_ot_reqeuest.emp_number = employee.emp_number
LEFT JOIN overtime_status on emp_ot_reqeuest.ot_status =  overtime_status.id
where employee.emp_status in (1,2,5) and overtime_status.id = 1 and employee.location_id = ".$project->id);
        }
        
                
        return view('pages.manage.overTime.overtimeRequestList',compact('otR'));
    }
}
