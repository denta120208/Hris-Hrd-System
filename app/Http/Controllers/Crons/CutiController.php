<?php

namespace App\Http\Controllers\Crons;

use App\Models\Leave\Holiday;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, Log, App\Models\Master\Employee;
use App\Models\Leave\LeaveType, App\Models\Leave\LeaveEntitlement, App\Models\Leave\LeaveRequest, App\Models\Leave\LeaveStatus;

class CutiController extends Controller{
    protected $emp;
    protected $entitle;
    protected $lvReq;
    protected $lvType;
    protected $lvStat;
    public function __construct(Employee $emp,LeaveEntitlement $entitle, LeaveRequest $lvReq, LeaveType $lvType, LeaveStatus $lvStat){
        $this->emp = $emp;
        $this->entitle = $entitle;
        $this->lvReq = $lvReq;
        $this->lvType = $lvType;
        $this->lvStat = $lvStat;
        parent::__construct();
    }
    public function cronDeleteCuti(){
        $month = date('m');
        $day = date('d')+1;
        $year = date('Y');
        try{
            $leaves = DB::select("
                SELECT *, (no_of_days - days_used) as sisa_hari FROM leave_entitlement WHERE YEAR(to_date) = '".$year."'
                AND MONTH(to_date) = '".$month."' AND DAY(to_date) = '".$day."'
                AND deleted = '1'
            ");
            if($leaves){
                foreach ($leaves as $leave){
//                    print_r($leave->from_date); die;
//                    if(floatval($leave->sisa_hari) > 0){
                    $this->entitle->where('id', $leave->id)->where('emp_number', $leave->emp_number)
                        ->update([
                            'deleted' => '1'
                        ]);
//                    }else{
//                        echo $leave->sisa_hari.' '.floatval($leave->sisa_hari);
//                    }
                }
            }
            Log::info('================cronDeleteCuti===================');
            Log::info('Sucess');
            Log::info('=================================================');
        }catch (\PDOException $e){
            Log::error('================cronDeleteCuti===================');
            Log::error($e);
            Log::error('=================================================');
        }
    }
    public function cronCT(){
        $employee = array();
        $month = date('m');
        $day = date('d');
        $year = date('Y');
        $emps = DB::select("select emp_number, employee_id, emp_fullname, joined_date, CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) as pengabdian
            from employee
            where CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) >= 1 AND CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) <= 35
            AND termination_id IN (0) AND MONTH(joined_date) = '".$month."' AND DAY(joined_date) = '".$day."'
            AND emp_number NOT IN
            (
            select emp_number from leave_entitlement where leave_type_id = '1' and deleted = '0' AND YEAR(from_date) = '".$year."'
            )
        ");
        try{
            if($emps){
                foreach ($emps as $emp) {
                    $this->entitle->create([
                        'emp_number' => $emp->emp_number,
                        'no_of_days' => (13 - $month),
                        'days_used' => '0',
                        'leave_type_id' => '1',
                        'from_date' => date('Y-m-d', strtotime('first day of january this year')).' 00:00:00',
                        'to_date' => ($year+1).'-12-31 23:59:59',
                        'credited_date' => date('Y-m-d H:i:s'),
                        'entitlement_type' => '1',
                        'created_by_id' => '1',
                        'created_by_name' => "System"
                    ]);
                    $employee[$emp->emp_fullname] = $emp->emp_number;
                    Log::info('================CT===================');
                    Log::info('Sucess '.$emp->emp_fullname.' - '.$emp->emp_number);
                    Log::info('=====================================');
                }
            }
        } catch (Throwable $e) {
            Log::error('================CT===================');
            Log::error($e);
            Log::error('=====================================');
        }
    }
    
    public function cronCT_rev1(){
        $employee = array();
        $now = date("Y-m-d H:i:s");
        //$month = date('m');
        //$day = date('d');
        $year = date('Y');
        $emps = DB::select("
            Select a.emp_number,a.employee_id,a.emp_fullname,FORMAT(cast(a.joined_date as date),'yyyy-MM-dd') as joined_date,
                    YEAR(a.joined_date) as join_year,
                    FORMAT(cast(DATEADD(yy, DATEDIFF(yy, 0, cast(a.joined_date as date)) + 1, -1) as date),'yyyy-MM-dd') as last_date_of_year,
                    DATEDIFF(MONTH,cast(a.joined_date as date),cast(getdate() as date)) as jml_bulan,
                    (CASE WHEN a.joined_date < '2023-11-16' THEN 0 ELSE 1 END) as flag_status 
            from employee as a
            where termination_id = 0
            and emp_status IN (1,2,5)
            and cast(a.joined_date as date) IS NOT NULL
            AND cast(a.joined_date as date) NOT IN ('1970-01-01','1900-01-01')
            AND emp_number NOT IN
            (
                select emp_number
                from leave_entitlement
                where leave_type_id = '1'
                and deleted = '0'
                AND YEAR(from_date) IN (".$year.")
            )
            AND DATEDIFF(MONTH,cast(a.joined_date as date),cast(getdate() as date)) > 11
            ORDER BY cast(a.joined_date as date) ASC
        ");
        try{
            if($emps){
                foreach ($emps as $emp) {
                    $from_date = date_create($emp->joined_date);
                    $last_date_of_year = date_create($emp->last_date_of_year);
                    
                    if($emp->jml_bulan == 12 && $emp->flag_status == 1)
                    {
                        $cekDataCuti = $this->entitle
                                ->where('emp_number','=',$emp->emp_number)
                                ->where('deleted','=',0)
                                ->where('leave_type_id','=',1)
                                ->count();
                        
                        if($cekDataCuti <= 0)
                        {
                            //Proses Insert sisa cuti di tahun join employee
                            $dataHolidayLY = DB::table('holiday')
                                    ->whereBetween('date', [$from_date, $last_date_of_year])
                                    ->where('holiday_id','=', 1) //cuti bersama
                                    ->count();
                            
                            $dataHolidayCY = DB::table('holiday')
                                    ->whereBetween('date', [($year).'-01-01', ($year).'-12-31'])
                                    ->where('holiday_id','=', 1) //cuti bersama
                                    ->count();
                            
                            $nilaiCutiTahunJoin = 12 - $dataHolidayLY;
                            $nilaiCutiTahunBerjalan = 12 - $dataHolidayCY;
                            
                            if ($nilaiCutiTahunJoin > 0)
                            {
                                $this->entitle->create([
                                    'emp_number' => $emp->emp_number,
                                    'no_of_days' => $nilaiCutiTahunJoin,
                                    'days_used' => '0',
                                    'leave_type_id' => '1',
                                    'from_date' => $from_date.' 00:00:00',
                                    'to_date' => ($year).'-12-31 23:59:59',
                                    'credited_date' => date('Y-m-d H:i:s'),
                                    'entitlement_type' => '1',
                                    'created_by_id' => '1',
                                    'created_by_name' => "System"
                                ]);
                                
                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'Create CT ' . $emp->employee_id .' '. $emp->emp_fullname.'(cuti tahun pertama)',
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                            else
                            {
                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'No Days CT ' . $emp->employee_id .' '. $emp->emp_fullname,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                            
                            if($nilaiCutiTahunBerjalan > 0)
                            {
                                $this->entitle->create([
                                    'emp_number' => $emp->emp_number,
                                    'no_of_days' => $nilaiCutiTahunBerjalan,
                                    'days_used' => '0',
                                    'leave_type_id' => '1',
                                    'from_date' => date('Y-m-d', strtotime('first day of january this year')).' 00:00:00',
                                    'to_date' => ($year+1).'-12-31 23:59:59',
                                    'credited_date' => date('Y-m-d H:i:s'),
                                    'entitlement_type' => '1',
                                    'created_by_id' => '1',
                                    'created_by_name' => "System"
                                ]);
                                
                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'Create CT ' . $emp->employee_id .' '. $emp->emp_fullname.'(cuti tahun pertama)',
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                            else
                            {
                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'No Days CT ' . $emp->employee_id .' '. $emp->emp_fullname,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                        }
                    }
                    else
                    {
                        if ($emp->jml_bulan >= 12)
                        {
                            $dataHolidayCY = DB::table('holiday')
                                        ->whereBetween('date', [($year).'-01-01', ($year).'-12-31'])
                                        ->where('holiday_id','=', 1) //cuti bersama
                                        ->count();

                            $nilaiCutiTahunBerjalan = 12 - $dataHolidayCY;

                            if ($nilaiCutiTahunBerjalan > 0)
                            {
                                $this->entitle->create([
                                    'emp_number' => $emp->emp_number,
                                    'no_of_days' => $nilaiCutiTahunBerjalan,
                                    'days_used' => '0',
                                    'leave_type_id' => '1',
                                    'from_date' => date('Y-m-d', strtotime('first day of january this year')).' 00:00:00',
                                    'to_date' => ($year+1).'-12-31 23:59:59',
                                    'credited_date' => date('Y-m-d H:i:s'),
                                    'entitlement_type' => '1',
                                    'created_by_id' => '1',
                                    'created_by_name' => "System"
                                ]);

                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'Create CT ' . $emp->employee_id .' '. $emp->emp_fullname,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                            else
                            {
                                \DB::table('log_activity')->insert([
                                    'action' => 'Create CT',
                                    'module' => 'Leave',
                                    'sub_module' => 'Cuti Tahunan',
                                    'modified_by' => 'SystemHRIS',
                                    'description' => 'No Days CT ' . $emp->employee_id .' '. $emp->emp_fullname,
                                    'created_at' => $now,
                                    'updated_at' => $now,
                                    'table_activity' => 'leave_entitlement'
                                ]);
                            }
                        }
                    }
                }
            }
        } catch (Throwable $e) {
            Log::error('================CT===================');
            Log::error($e);
            Log::error('=====================================');
        }
    }
    
    public function cronCB(){
        $employee = array();
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $month = date('m');
        $day = date('d')+1;
        //$day = date('d');
        //dd($day);
        $year = date('Y')+5;
        $emps = DB::select("select emp_number, employee_id, emp_fullname, joined_date, CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) as pengabdian
            from employee
            where CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) >= 5 AND CONVERT(int,ROUND(DATEDIFF(hour,joined_date,GETDATE())/8766.0,0)) <= 35
            AND termination_id = 0 
            AND MONTH(joined_date) = '".$month."' AND DAY(joined_date) = '".$day."'
            AND emp_number NOT IN
            (
                select emp_number from leave_entitlement where leave_type_id = '4' 
                and deleted = '0' and to_date >= GETDATE()
            )
            and emp_status IN (1,2,5)
        ");
        foreach ($emps as $emp){
            $this->entitle->where('emp_number', $emp->emp_number)->where('leave_type_id', '4')->update([
                'deleted' => '0'
            ]);
            $this->entitle->create([
                'emp_number' => $emp->emp_number,
                'no_of_days' => '25',
                'days_used' => '0',
                'leave_type_id' => '4',
                'from_date' => date('Y-m-d').' 00:00:00',
                'to_date' => $year.'-'.$month.'-'.$day.' 23:59:59',
                'credited_date' => date('Y-m-d H:i:s'),
                'entitlement_type' => '1',
                'created_by_id' => '1',
                'created_by_name' => "System"
            ]);
            
            \DB::table('log_activity')->insert([
                'action' => 'Proses Cuti Besar',
                'module' => 'Leave',
                'sub_module' => 'Leave Emp',
                'modified_by' => 'System',
                'description' => $emp->emp_number.' Cuti besar : ' . $emp->employee_id . ', Periode : '.date('Y-m-d').' 00:00:00 s/d '.$year.'-'.$month.'-'.$day.' 23:59:59 Sudah ditambahkan',
                'created_at' => $dateNow,
                'updated_at' => $dateNow,
                'table_activity' => 'leave_entitlement'
            ]);
            
            //$employee[$emp->emp_fullname] = $emp->emp_number;
        }
        
        
        
        Log::info('================CB===================');
        Log::info('Sucess');
        Log::info('=====================================');
    }

    public function cronAppCuti() {
        $employee = array();
        $month = date('m');
        $day = date('Y-m-d', strtotime("-3 days"));
        $year = date('Y');
        $now = date("Y-m-d H:i:s");

        $emps = DB::select("
            SELECT el.id, el.emp_number, el.length_days, el.created_at, el.from_date, el.end_date, el.date_applied, el.leave_type_id,
            e.emp_fullname, e.emp_work_email
            FROM emp_leave_request el INNER JOIN employee e
            ON el.emp_number = e.emp_number
            where el.leave_status = '3' AND e.termination_id = 0 AND el.length_days > 0 AND el.from_date <= '".$day." 00:00:00'
        ");

        try{
            if($emps){
                $counter = 0;
                foreach ($emps as $emp) {
                    if(empty($emp->emp_work_email) || $emp->emp_work_email == "" || $emp->emp_work_email == NULL) {
                    }
                    else {
                        $left = $tmp = 0;
                        $leave = $this->lvReq->where('id',$emp->id)->first();
                        
                        $empLeave = $this->emp->where('emp_number', $leave->emp_number)->first();
                        $begin = date_create($leave->from_date);
                        $end = date_create($leave->end_date);
                        $leaveType = $this->lvType->where('id','=',$leave->leave_type_id)->first();
                        
                        $entitle = DB::select("
                            SELECT * FROM leave_entitlement where leave_type_id = '".$leave->leave_type_id."'
                            AND emp_number = '".$leave->emp_number."' AND YEAR(to_date) >= '".$year."'
                        ");
                        // $emp = $this->emp->where('employee_id', Session::get('username'))->first();
                        $leave->comments .= " - Comments from System Auto Approve After 3 Days";
                        $leave->leave_status = '4';
                        $taken = (float)$leave->length_days;
                        $leave->approved_at = date('Y-m-d H:i:s');
                        $leave->approved_by = '3';
                        $leave->pnum = '1803';
                        $leave->ptype = '01';
                        foreach ($entitle as $row){ // length_days
                            $left = (float)$row->no_of_days - $row->days_used;
                            if($taken >= 0){
                                $taken -= $left;
                                if($taken >= 0 && $left >= 0){
                                    DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $left)]);
                                    $tmp = $taken;
                                }else if($taken < 0 && $left >= 0){
                                    DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + ($taken + $left))]);
                                }else{
                                    DB::table('leave_entitlement')->where('id', $row->id)->update(['days_used' => ($row->days_used + $tmp)]);
                                }
                            }
                        }
                        
                        if ($taken == 0.5)
                        {
                            //dd('test1');
                            if($leaveType->comIjin <> 'CB')
                            {
                                $cekDataAbsen = DB::table('com_absensi_inout')
                                    ->where('comDate','=',$begin->format("Y-m-d"))
                                    ->where('comNIP','=',$empLeave->employee_id)
                                    ->count();

                                if($cekDataAbsen > 0)
                                {
                                    DB::statement("INSERT INTO com_absensi_inout_hist    
                                                    select * 
                                                    from com_absensi_inout 
                                                    where comNIP = '".$empLeave->employee_id."' "
                                                    . " AND comDate = '".$begin->format("Y-m-d")."'");

                                    DB::table('com_absensi_inout')
                                            ->where('comDate','=',$begin->format("Y-m-d"))
                                            ->where('comNIP','=',$empLeave->employee_id)
                                            ->update([
                                                'comIjin'=>$leaveType->comIjin.' CS',
                                                'comIjin_reason'=>$leave->comments,
                                                'updatet_at'=>$now
                                            ]);
                                }
                                else
                                {
                                    DB::table('com_absensi_inout')
                                        ->insert([
                                            'comNIP'=>$empLeave->employee_id,
                                            'comIn'=>'08:00:00',
                                            'comOut'=>'17:00:00',
                                            'comDate'=>$begin->format("Y-m-d"),
                                            'comDTIn'=>$begin->format("Y-m-d").' 08:00:00',
                                            'comDTOut'=>$begin->format("Y-m-d").' 17:00:00',
                                            'comTotalHours'=>'08:00:00',
                                            'comIjin'=>$leaveType->comIjin.' CS',
                                            'comIjin_reason'=>$leave->comments,
                                            'source'=>'leave',
                                            'created_at'=>$now,
                                            'updatet_at'=>$now,
                                        ]);
                                }
                            }
                            else
                            {
                                $cekDataAbsen = DB::table('com_absensi_inout')
                                    ->where('comDate','=',$begin->format("Y-m-d"))
                                    ->where('comNIP','=',$empLeave->employee_id)
                                    ->count();

                                if($cekDataAbsen > 0)
                                {
                                    DB::statement("INSERT INTO com_absensi_inout_hist    
                                                    select * 
                                                    from com_absensi_inout 
                                                    where comNIP = '".$empLeave->employee_id."' "
                                                    . " AND comDate = '".$begin->format("Y-m-d")."'");

                                    DB::table('com_absensi_inout')
                                            ->where('comDate','=',$begin->format("Y-m-d"))
                                            ->where('comNIP','=',$empLeave->employee_id)
                                            ->update([
                                                'comIjin'=>'CB',
                                                'comIjin_reason'=>$leave->comments,
                                                'updatet_at'=>$now
                                            ]);
                                }
                                else
                                {
                                    DB::table('com_absensi_inout')
                                        ->insert([
                                            'comNIP'=>$empLeave->employee_id,
                                            'comIn'=>'08:00:00',
                                            'comOut'=>'17:00:00',
                                            'comDate'=>$begin->format("Y-m-d"),
                                            'comDTIn'=>$begin->format("Y-m-d").' 08:00:00',
                                            'comDTOut'=>$begin->format("Y-m-d").' 17:00:00',
                                            'comTotalHours'=>'08:00:00',
                                            'comIjin'=>'CB',
                                            'comIjin_reason'=>$leave->comments,
                                            'source'=>'leave',
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
                                    ->where('comNIP','=',$empLeave->employee_id)
                                    ->count();

                                if($cekDataAbsen > 0)
                                {
                                    DB::statement("INSERT INTO com_absensi_inout_hist    
                                                    select * 
                                                    from com_absensi_inout 
                                                    where comNIP = '".$empLeave->employee_id."' "
                                                    . " AND comDate = '".$i->format("Y-m-d")."'");

                                    DB::table('com_absensi_inout')
                                            ->where('comDate','=',$i->format("Y-m-d"))
                                            ->where('comNIP','=',$empLeave->employee_id)
                                            ->update([
                                                'comIjin'=>$leaveType->comIjin,
                                                'comIjin_reason'=>$leave->comments,
                                                'updatet_at'=>$now
                                            ]);
                                }
                                else
                                {
                                    //dd($i->format("Y-m-d"));
                                    DB::table('com_absensi_inout')
                                        ->insert([
                                            'comNIP'=>$empLeave->employee_id,
                                            'comIn'=>'08:00:00',
                                            'comOut'=>'17:00:00',
                                            'comDate'=>$i->format("Y-m-d"),
                                            'comDTIn'=>$i->format("Y-m-d").' 08:00:00',
                                            'comDTOut'=>$i->format("Y-m-d").' 17:00:00',
                                            'comTotalHours'=>'08:00:00',
                                            'comIjin'=>$leaveType->comIjin,
                                            'comIjin_reason'=>$leave->comments,
                                            'source'=>'leave',
                                            'created_at'=>$now,
                                            'updatet_at'=>$now,
                                        ]);
                                }
                            }
                        }
                        
                        $this->sendEmailAutoApprove('2', $emp->emp_number, $leave->id);
                        $leave->save();
                        $counter++;
                        \DB::table('log_activity')->insert([
                            'action' => 'Set Approve Leave',
                            'module' => 'Leave',
                            'sub_module' => 'Approve Leave',
                            'modified_by' => 'System Auto Approve',
                            'description' => 'ID Leave : ' . $leave->id . ', Approve Leave By : System Auto Approve',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_leave_request'
                        ]);
                    }
                }
                Log::info('================ACT===================');
                Log::info('Sucess Approve '.$counter);
                Log::info('=====================================');
            }
        } catch (Throwable $e) {
            Log::error('================ACT===================');
            Log::error($e);
            Log::error('=====================================');
        }
    }

    public function deleteDoubleCT(){
        $leaves = DB::select("
            SELECT emp_number, from_date, COUNT(from_date) as ctDouble
            FROM emp_leave_request
            WHERE leave_status = '3' AND leave_type_id = '1'
            GROUP BY emp_number, from_date
            HAVING COUNT(from_date) > 1
        ");
        if($leaves){
            foreach ($leaves as $leave){
                $doubleCT = $this->lvReq->where('emp_number', $leave->emp_number)->where('from_date', $leave->from_date)->first();
                DB::select("
                delete from emp_leave_request where id > '".$doubleCT->id."' AND emp_number = '".$doubleCT->emp_number."' AND from_date = '".$doubleCT->from_date."'
                ");
                Log::info('================DCT===================');
                Log::info('Sucess '.$leave->emp_number.' - '.$leave->from_date.' - '.$leave->ctDouble);
                Log::info('=====================================');
            }
        }
    }
    public function deleteDoubleCB(){
        $leaves = DB::select("
            SELECT emp_number, from_date, COUNT(from_date) as ctDouble
            FROM emp_leave_request
            WHERE leave_status = '3' AND leave_type_id = '4'
            GROUP BY emp_number, from_date
            HAVING COUNT(from_date) > 1
        ");
        if($leaves){
            foreach ($leaves as $leave){
                $doubleCT = $this->lvReq->where('emp_number', $leave->emp_number)->where('from_date', $leave->from_date)->first();
                DB::select("
                delete from emp_leave_request where id > '".$doubleCT->id."' AND emp_number = '".$doubleCT->emp_number."' AND from_date = '".$doubleCT->from_date."'
                ");
                Log::info('================DCB===================');
                Log::info('Sucess '.$leave->emp_number.' - '.$leave->from_date.' - '.$leave->ctDouble);
                Log::info('=====================================');
            }
        }
    }
}
