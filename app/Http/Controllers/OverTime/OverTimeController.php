<?php

namespace App\Http\Controllers\OverTime;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session,
    App\Models\Master\Employee;
use App\Models\OverTime\OverTimeReqeust,
    App\Models\OverTime\OverTime;
use Carbon\Carbon;
use App\Models\Leave\Holiday;

class OverTimeController extends Controller {

    protected $emp;
    protected $overTime;
    protected $otReq;

    public function __construct(Employee $emp, OverTime $overTime, OverTimeReqeust $otReq) {
        $this->emp = $emp;
        $this->overTime = $overTime;
        $this->otReq = $otReq;
//        $this->lvType = $lvType;
//        $this->lvStat = $lvStat;
        parent::__construct();
    }

    public function index() {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//        return view('pages.oeverTime.form', compact('emp', 'leaves'));
        $requests = $this->otReq->where('emp_number', $emp->emp_number)->get();

        \DB::table('log_activity')->insert([
            'action' => 'View Over Time Index',
            'module' => 'Over Time',
            'sub_module' => 'View Over Time Index',
            'modified_by' => Session::get('name'),
            'description' => 'View Over Time Index ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname . ', accessed by ' . Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_ot_reqeuest'
        ]);
        return view('pages.overTime.index', compact('emp', 'requests'));
    }

    public function applOverTime(Request $request) {
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

        return view('pages.overTime.form', compact('dataInOut', 'in', 'out', 'overDate', 'attend_id'));
    }

    public function saveOverTime(Request $request) {
        $emp = $this->emp->where('employee_id', Session::get('username'))->where('termination_id','=',0)->first();
        $reportto = DB::table('emp_reportto')
                ->where('erep_reporting_mode',1)
                ->where('erep_sub_emp_number',$emp->emp_number)
                ->first();
        $empSup = DB::table('employee')
                ->where('emp_number',$reportto->erep_sup_emp_number)
                ->first();
        
        if(empty($empSup->emp_work_email) || $empSup->emp_work_email == "" || $empSup->emp_work_email == NULL){
            return redirect(route('attendance'))->withErrors([
                            'error' => 'Data Employee Sup ('.$empSup->emp_firstname.' '.$empSup->emp_middle_name.' '.$empSup->emp_lastname.') Work Email Belum Lengkap. Silahkan hubungi HRD terkait untuk melengkapi data.'
                ]);
        }
        
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

        
        //$day = (float)$this->calculateDays($sDate, $eDate, $emp->days_type);
        //dd($days);
        $otReqId = $this->otReq->create([
            'attendance_id' => $request->attend_id,
            'emp_number' => $emp->emp_number,
            'ot_date' => $otDate,
            'ot_start_time' => $sTime,
            'ot_end_time' => $eTime,
            'ot_hours' => $jamlembur,
            'ot_total_hours' => $ot_hours,
            'ot_meal_num' => $mealnum,
            'ot_status' => 1,
            'ot_reason' => $request->ot_reason,
            'created_at' => $dateNow,
            'created_by' => $emp->emp_number
        ])->id;
        
        $this->sendEmailAddOvertime($emp->employee_id,$otReqId);

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
        return redirect(route('overtimeRequest'));
    }

    public function apvOverTime() {
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $overTimes = DB::select("Select a.*,b.erep_sub_emp_number,c.emp_firstname,c.emp_middle_name,c.emp_lastname,d.name as status_name
                                from emp_ot_reqeuest as a INNER JOIN emp_reportto as b ON a.emp_number = b.erep_sub_emp_number
                                INNER JOIN employee as c ON a.emp_number = c.emp_number
                                INNER JOIN overtime_status as d ON a.ot_status = d.id
                                where b.erep_sup_emp_number = " . $emp->emp_number . "
                                and b.erep_reporting_mode = 1");

//        $overTimes = DB::table('emp_ot_reqeuest')
//            ->join('emp_reportto', 'emp_ot_reqeuest.emp_number', '=' ,'emp_reportto.erep_sub_emp_number')
//            ->join('employee', 'emp_ot_reqeuest.emp_number', '=' ,'employee.emp_number')
//            ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
//            ->where('emp_reportto.erep_reporting_mode', '1')
//            ->select('emp_ot_reqeuest.*','emp_reportto.erep_sub_emp_number','employee.emp_firstname','employee.emp_middle_name','employee.emp_lastname')->get();

        \DB::table('log_activity')->insert([
            'action' => 'View Approve Over Time',
            'module' => 'Over Time',
            'sub_module' => 'View Approve Over Time',
            'modified_by' => Session::get('name'),
            'description' => 'View Apply Over Time ' . $emp->emp_firstname . ' ' . $emp->emp_middle_name . ' ' . $emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_ot_reqeuest, emp_reportto, overtime_status'
        ]);
        return view('pages.overTime.apvOT', compact('emp', 'overTimes'));
    }

    public function setOverTime(Request $request) {
        //dd($request);
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $ot = $this->otReq->where('id', $request->id)->first();

        $otDate = date("Y-m-d", strtotime($ot->ot_date));
        $sTime = date("H:i:s", strtotime($request->ot_start_time));
        $eTime = date('H:i:s', strtotime($request->ot_end_time));

        $this->otReq->where('id', $request->id)
                ->update([
                    'ot_status' => $request->ot_status,
                    'ot_comment' => $request->ot_comment,
                    'approved_at' => date('Y-m-d H:i:s'),
                    'approved_by' => Session::get('username'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'updated_by' => Session::get('username')
        ]);

//
//        $ot = $this->otReq->where('id', $request->id)->where('ot_status', $request->id)->firstOrFail();
//        $ot->ot_status = $request->ot_status;
//        $ot->ot_reason .= ' + '.Session::get('username')." : ".$request->ot_reason;
//        $ot->approved_at = date('Y-m-d H:i:s');
//        $ot->approved_by = Session::get('username');
//        $ot->save();
//        
        if ($request->ot_status == 2) {//approve
            \DB::table('log_activity')->insert([
                'action' => 'Approve Overtime',
                'module' => 'Overtime',
                'sub_module' => 'Overtime Appr',
                'modified_by' => Session::get('name'),
                'description' => 'Approve overtime : ' . $emp->employee_id . ', date :' . $otDate . ' start : ' . $sTime . ' end : ' . $eTime . ', commect : ' . $request->ot_reason,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
                'table_activity' => 'emp_ot_reqeuest'
            ]);

            DB::table('com_absensi_inout')
                    ->where('id', '=', $ot->attendance_id)
                    ->update([
                        'is_claim_ot' => 1,
                        'updatet_at' => $dateNow
            ]);
        } elseif ($request->ot_status == 3) {//approve
            \DB::table('log_activity')->insert([
                'action' => 'Reject Overtime',
                'module' => 'Overtime',
                'sub_module' => 'Overtime Appr',
                'modified_by' => Session::get('name'),
                'description' => 'Reject overtime : ' . $emp->employee_id . ', date :' . $otDate . ' start : ' . $sTime . ' end : ' . $eTime . ', commect : ' . $request->ot_comment,
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
                'table_activity' => 'emp_ot_reqeuest'
            ]);
        }


        return redirect(route('overTimeAppv'));
    }
}
