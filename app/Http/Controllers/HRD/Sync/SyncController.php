<?php

namespace App\Http\Controllers\HRD\Sync;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session,
    App\Models\Master\Employee,
    App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeaveType,
    App\Models\Leave\LeaveRequest,
    App\Models\Leave\LeaveStatus;

class SyncController extends Controller {

    protected $emp;
    protected $entitle;
    protected $lvReq;
    protected $lvType;
    protected $lvStat;

    public function __construct(Employee $emp, LeaveEntitlement $entitle, LeaveRequest $lvReq, LeaveType $lvType, LeaveStatus $lvStat) {
        $this->emp = $emp;
        $this->entitle = $entitle;
        $this->lvReq = $lvReq;
        $this->lvType = $lvType;
        $this->lvStat = $lvStat;
        parent::__construct();
    }

    public function sync() {
        $now = date("Y-m-d H:i:s");
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }
        $dataSync = 0;

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Synchronize',
            'module' => 'Synchronize',
            'sub_module' => 'Synchronize',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Synchronize ',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);

        return view('pages.manage.sync.index', compact('dataSync'));
    }

    public function syncProcess(Request $request) {
        $now = date("Y-m-d H:i:s");
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }
        
        $dataSync = 0;
        $dataSyncTable = [];
        
        $start_date = $request->startDate;
        $end_date = $request->endDate;
        $emp_id = $request->emp_id;
        
        if($request->syncType == 1){
            
            $dataNIP = DB::select("select distinct ui.userid as userid,FORMAT(CAST(c.checktime as DATE),'yyyy-MM-dd') as comDate, c.checktime, ui.userid as emp_id
                                    from adms_db..checkinout c INNER JOIN adms_db..userinfo ui
                                    ON c.userid = ui.userid
                                    WHERE CAST(c.checktime as DATE) between '".$start_date."' AND '".$end_date."'
                                    and ui.title IN ('".$emp_id."')
                                    AND ui.title NOT IN ('','NULL')
                                    AND (ui.minzu = 0 OR ui.minzu IS NULL)
                                    ORDER BY ui.userid");
            
            $dataSyncTable = $dataNIP;
            $dataSync = 1;

//            dd($dataNIP);
            if(count($dataNIP)> 0)
            {
                foreach($dataNIP as $data)
                {
                    DB::statement("exec adms_db.dbo.sp_send_att_to_hris ".$data->userid.",'".$data->comDate."'");
                }

                \DB::table('log_activity')->insert([
                    'action' => 'Retrieve Attendance',
                    'module' => 'Attendance',
                    'sub_module' => 'in/out',
                    'modified_by' => 'adms',
                    'description' => 'Retrieve Attendance By Date from '.$request->startDate.' to '.$request->endDate.' execute at '.$now,
                    'created_at' => $now,
                    'updated_at' => $now,
                    'table_activity' => 'adms.checkinout,ml_hris.com_absensi_inout'
                ]);
            }
        }else if($request->syncType == 2){
            $dataCuti = DB::select("Select a.emp_number,b.employee_id,c.comIjin,a.length_days,FORMAT(a.from_date,'yyyy-MM-dd') as from_date,
                                                FORMAT(a.end_date,'yyyy-MM-dd') as end_date,a.comments
                                     from emp_leave_request as a INNER JOIN employee as b ON a.emp_number = b.emp_number
                                     INNER JOIN leave_type as c ON a.leave_type_id = c.id
                                     where from_date >= '".$start_date."' AND end_date <= '".$end_date."'
                                     and leave_status = 4
                                     and b.employee_id IN ('".$emp_id."')
                                     ORDER BY a.from_date");

            $dataSyncTable = $dataCuti;
            $dataSync = 2;
            
            foreach($dataCuti as $row)
            {
                $begin = date_create($row->from_date);
                $end = date_create($row->end_date);

                if ((float)$row->length_days == 0.5)
                {
                    //dd('test1');
                    if($row->comIjin <> 'CB')
                    {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$begin->format("Y-m-d"))
                            ->where('comNIP','=',$row->employee_id)
                            ->count();

                        if($cekDataAbsen > 0)
                        {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '".$row->employee_id."' "
                                            . " AND comDate = '".$begin->format("Y-m-d")."'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate','=',$begin->format("Y-m-d"))
                                    ->where('comNIP','=',$row->employee_id)
                                    ->update([
                                        'comIjin'=>$row->comIjin.' CS',
                                        'comIjin_reason'=>$row->comments,
                                        'source'=>'syncLeaveByDate',
                                        'updatet_at'=>$now
                                    ]);
                        }
                        else
                        {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP'=>$row->employee_id,
                                    'comIn'=>'08:00:00',
                                    'comOut'=>'17:00:00',
                                    'comDate'=>$begin->format("Y-m-d"),
                                    'comDTIn'=>$begin->format("Y-m-d").' 08:00:00',
                                    'comDTOut'=>$begin->format("Y-m-d").' 17:00:00',
                                    'comTotalHours'=>'08:00:00',
                                    'comIjin'=>$row->comIjin.' CS',
                                    'comIjin_reason'=>$row->comments,
                                    'source'=>'syncLeaveByDate',
                                    'created_at'=>$now,
                                    'updatet_at'=>$now,
                                ]);
                        }
                    }
                    else
                    {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$begin->format("Y-m-d"))
                            ->where('comNIP','=',$row->employee_id)
                            ->count();

                        if($cekDataAbsen > 0)
                        {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '".$row->employee_id."' "
                                            . " AND comDate = '".$begin->format("Y-m-d")."'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate','=',$begin->format("Y-m-d"))
                                    ->where('comNIP','=',$row->employee_id)
                                    ->update([
                                        'comIjin'=>'CB',
                                        'comIjin_reason'=>$row->comments,
                                        'source'=>'syncLeaveByDate',
                                        'updatet_at'=>$now
                                    ]);
                        }
                        else
                        {
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP'=>$row->employee_id,
                                    'comIn'=>'08:00:00',
                                    'comOut'=>'17:00:00',
                                    'comDate'=>$begin->format("Y-m-d"),
                                    'comDTIn'=>$begin->format("Y-m-d").' 08:00:00',
                                    'comDTOut'=>$begin->format("Y-m-d").' 17:00:00',
                                    'comTotalHours'=>'08:00:00',
                                    'comIjin'=>'CB',
                                    'comIjin_reason'=>$row->comments,
                                    'source'=>'syncLeaveByDate',
                                    'created_at'=>$now,
                                    'updatet_at'=>$now,
                                ]);
                        }
                    }
                }
                else
                {
                    //dd('test2');
                    for($i = $begin; $i <= $end; $i->modify('+1 day'))
                    {
                        $cekDataAbsen = DB::table('com_absensi_inout')
                            ->where('comDate','=',$i->format("Y-m-d"))
                            ->where('comNIP','=',$row->employee_id)
                            ->count();

                        if($cekDataAbsen > 0)
                        {
                            DB::statement("INSERT INTO com_absensi_inout_hist    
                                            select * 
                                            from com_absensi_inout 
                                            where comNIP = '".$row->employee_id."' "
                                            . " AND comDate = '".$i->format("Y-m-d")."'");

                            DB::table('com_absensi_inout')
                                    ->where('comDate','=',$i->format("Y-m-d"))
                                    ->where('comNIP','=',$row->employee_id)
                                    ->update([
                                        'comIjin'=>$row->comIjin,
                                        'comIjin_reason'=>$row->comments,
                                        'source'=>'syncLeaveByDate',
                                        'updatet_at'=>$now
                                    ]);
                        }
                        else
                        {
                            //dd($i->format("Y-m-d"));
                            DB::table('com_absensi_inout')
                                ->insert([
                                    'comNIP'=>$row->employee_id,
                                    'comIn'=>'08:00:00',
                                    'comOut'=>'17:00:00',
                                    'comDate'=>$i->format("Y-m-d"),
                                    'comDTIn'=>$i->format("Y-m-d").' 08:00:00',
                                    'comDTOut'=>$i->format("Y-m-d").' 17:00:00',
                                    'comTotalHours'=>'08:00:00',
                                    'comIjin'=>$row->comIjin,
                                    'comIjin_reason'=>$row->comments,
                                    'source'=>'syncLeaveByDate',
                                    'created_at'=>$now,
                                    'updatet_at'=>$now,
                                ]);
                        }
                    }
                }
            }
        }else if($request->syncType == 3){
            $dataIMP = DB::select("Select a.id,a.emp_number,a.attendance_id,b.employee_id,(b.emp_firstname+' '+b.emp_middle_name+' '+b.emp_lastname) as emp_name,
                                        a.comIjin,a.reason,FORMAT(cast(a.start_date as date),'yyyy-MM-dd') as start_date
                                     from emp_attendance_request as a INNER JOIN employee as b ON a.emp_number = b.emp_number
                                     where request_status = 2 and b.employee_id = '$emp_id'
                                     and cast(a.start_date as date) between '".$start_date."' AND '".$end_date."'");
            
            $dataSyncTable = $dataIMP;
            $dataSync = 3;

            foreach ($dataIMP as $row)
            {
                $st_date = date_create($row->start_date);

                if ($row->attendance_id > 0)
                {
                    DB::statement("INSERT INTO com_absensi_inout_hist    
                                                select * 
                                                from com_absensi_inout 
                                                where id = ".$row->attendance_id);

                    DB::table('com_absensi_inout')
                        ->where('id','=',$row->attendance_id)
                        ->update([
                            'comIjin'=>$row->comIjin,
                            'comIjin_reason'=>$row->reason,
                            'source'=>'attendance',
                            'updatet_at'=>$now
                        ]);
                }
                else
                {
                    $cekDataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate','=',$st_date->format("Y-m-d"))
                                ->where('comNIP','=',$row->employee_id)
                                ->count();

                    if($cekDataAbsen > 0)
                    {
                        $dataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate','=',$st_date->format("Y-m-d"))
                                ->where('comNIP','=',$row->employee_id)
                                ->first();

                        DB::statement("INSERT INTO com_absensi_inout_hist    
                                        select * 
                                        from com_absensi_inout 
                                        where comNIP = '".$row->employee_id."' "
                                        . " AND comDate = '".$st_date->format("Y-m-d")."'");

                        DB::table('com_absensi_inout')
                                ->where('id','=',$dataAbsen->id)
                                ->update([
                                    'comIjin'=>$row->comIjin,
                                    'comIjin_reason'=>$row->reason,
                                    'source'=>'attendance',
                                    'updatet_at'=>$now
                                ]);

                        DB::table('emp_attendance_request')
                                ->where('id','=',$row->id)
                                ->update([
                                    'attendance_id'=>$dataAbsen->id,
                                ]);
                    }
                    else
                    {
                        DB::table('com_absensi_inout')
                            ->insert([
                                'comNIP'=>$row->employee_id,
                                'comIn'=>'08:00:00',
                                'comOut'=>'17:00:00',
                                'comDate'=>$st_date->format("Y-m-d"),
                                'comDTIn'=>$st_date->format("Y-m-d").' 08:00:00',
                                'comDTOut'=>$st_date->format("Y-m-d").' 17:00:00',
                                'comTotalHours'=>'08:00:00',
                                'comIjin'=>$row->comIjin,
                                'comIjin_reason'=>$row->reason,
                                'source'=>'attendance',
                                'created_at'=>$now,
                                'updatet_at'=>$now,
                            ]);

                        $dataAbsen = DB::table('com_absensi_inout')
                                ->where('comDate','=',$st_date->format("Y-m-d"))
                                ->where('comNIP','=',$row->employee_id)
                                ->first();

                        DB::table('emp_attendance_request')
                            ->where('id','=',$row->id)
                            ->update([
                                'attendance_id'=>$dataAbsen->id,
                            ]);
                    }
                }
            }
        }

        return view('pages.manage.sync.index', compact('dataSyncTable', 'dataSync'));
    }
}
