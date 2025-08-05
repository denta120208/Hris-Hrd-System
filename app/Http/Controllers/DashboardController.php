<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests, Session, Log, DB, App\Models\Master\Employee;
use App\Models\Leave\LeaveRequest, App\Models\Trainning\TrainningRequest;
use App\Models\Leave\LeaveEntitlement, App\Models\Attendance\AttRecord;

class DashboardController extends Controller{
    protected $leaveReq;
    protected $trainReq;
    protected $emp;
    protected $entitle;
    protected $ar;
    public function __construct(Employee $emp,LeaveEntitlement $entitle,LeaveRequest $leaveReq, TrainningRequest $trainReq, AttRecord $ar){
        $this->leaveReq = $leaveReq;
        $this->trainReq = $trainReq;
        $this->emp = $emp;
        $this->ar = $ar;
        $this->entitle = $entitle;
        parent::__construct();
    }
    public function index(){
        $now = date('Y-m-d H:i:s');
        
        \DB::table('log_activity')->insert([
            'action' => 'View Dashboard',
            'module' => 'Dashboard',
            'sub_module' => 'Dashboard',
            'modified_by' => session("name"),
            'description' => "Open Page Dashboard",
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'com_absensi_inout'
        ]);

        $last = date('Y-m-d H:i:s', strtotime('-7 days'));
        //dd(Session::get('is_manage'));
        if(Session::get('is_manage') == '1'){
            //dd('test1');
            $emp = $this->employee();
            $birth = $this->emp_birth();
            $contracts = $this->emp_contract();
            return view('pages.dashboard', compact('emp','birth', 'contracts'));
        }else{
            //dd('test2');
            //$attends = array();
            $yearEnd = date('Y-m-d H:i:s');//, strtotime('Dec 31 23:59:59'));
            
            $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//            print_r('<pre>');
//            print_r(Session::all());
//            print_r('</pre>'); die;
            if ($emp->job_title_code > 16)
            {
                
                $balLeave = DB::select("SELECT a.*
                                from (
                                select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                                from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                                where emp_number = $emp->emp_number
                                and leave_type_id = 4
                                UNION ALL
                                select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                                from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                                where a.emp_number = $emp->emp_number
                                and leave_type_id NOT IN (4)
                                and to_date > '".$yearEnd."'
                                ) as a
                                order by a.from_date");
                //$balLeave = $this->entitle->where('emp_number', $emp->emp_number)->where('deleted', '0')->get();
            }
            else
            {
                // dd("SELECT a.*
                //                 from (
                //                 select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                //                 from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                //                 where emp_number = $emp->emp_number
                //                 and leave_type_id = 4
                //                 and to_date > '".$yearEnd."'
                //                 UNION ALL
                //                 select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                //                 from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                //                 where a.emp_number = $emp->emp_number
                //                 and leave_type_id NOT IN (4)
                //                 and to_date > '".$yearEnd."'
                //                 ) as a
                //                 order by a.from_date");
                $balLeave = DB::select("SELECT a.*
                                from (
                                select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                                from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                                where emp_number = $emp->emp_number
                                and leave_type_id = 4
                                and to_date > '".$yearEnd."'
                                UNION ALL
                                select b.name,a.from_date,a.to_date,a.no_of_days,a.days_used
                                from leave_entitlement as a INNER JOIN leave_type as b ON a.leave_type_id = b.id
                                where a.emp_number = $emp->emp_number
                                and leave_type_id NOT IN (4)
                                and to_date > '".$yearEnd."'
                                ) as a
                                order by a.from_date");
                //$balLeave = $this->entitle->where('emp_number', $emp->emp_number)->where('deleted', '0')->where('to_date', '>=', $yearEnd)->get();
            }
            

            $attends = DB::select("
                            Select a.id,FORMAT (a.comDate, 'yyyy-MM-dd') as comDate,
                                    convert(char(8),convert(time(0),a.comIn)) as comIn,
                                    convert(char(8),convert(time(0),a.comOut)) as comOut,
                                    cast(convert(char(2),convert(time(0),a.comTotalHours)) as int) as comTotalHours
                             from com_absensi_inout as a
                             where comNIP = '".$emp->employee_id."'
                             and comDate between DATEADD(day, -10, getdate()) and GETDATE()
                             ORDER BY a.comDate DESC
                        ");
            
//            
//            $now = strtotime(date('Y-m-d'));
//            $last = strtotime(date('Y-m-d', strtotime('-10 days')));
//            for ( $i = $now; $i >= $last; $i = $i - 86400 ) {
//                $thisDate = date( 'Y-m-d', $i );
//                $attend = DB::connection('adms')->select("
//                select c.userid, CAST(c.checktime as DATE)as tanggal, MIN(CAST(c.checktime as TIME)) as waktuIn, MAX(CAST(c.checktime as TIME)) as waktuOut
//                from checkinout c INNER JOIN userinfo ui
//                ON c.userid = ui.userid 
//                WHERE ui.title= '".$emp->employee_id."'
//                AND CAST(c.checktime as DATE) = '".$thisDate."'
//                GROUP BY c.userid, CAST(c.checktime as DATE)
//            ");
//                if($attend){
//                    array_push($attends, $attend[0]);
//                }
//            }
//            $attends = $this->ar->where('employee_id',Session::get('username'))
//                ->where('punch_in_utc_time', '>=', $last)->where('punch_in_utc_time', '<=', $now)->orderBy('punch_in_utc_time', 'DESC')->take(10)->get();

            return view('pages.dashboard_emp', compact('emp','balLeave', 'attends'));
        }
    }
    public function changePassword(){
        return view('pages.users.changePass');
    }
    public function ckLeave(Request $request){
        $leave = $this->leaveReq->where('leave_status', '1')->get();
        return $leave;
    }
    public function ckTrain(Request $request){
        $this->trainReq;
        return response()->json([]);
    }
    public function employee(){
        $emp = DB::select("
            SELECT l.name, COUNT(e.emp_number) as total
            FROM employee e INNER JOIN location l
            ON e.pnum = l.pnum AND e.ptype = l.ptype
            WHERE e.termination_id IN (0)
            group by l.name
        ");
        return $emp;
    }
    public function emp_birth(){
        $add = '';
        $day = date('d');
        if($day <= 10){
            $add = "AND datepart(DD,e.emp_birthday) <= '10'";
//            print_r('<pre>');
//            print_r('< 10');
//            print_r('</pre>');
        }elseif ($day >= 10 && $day <= 20){
            $add = "AND datepart(DD,e.emp_birthday) >= '11' AND datepart(DD,e.emp_birthday) <= '20'";
//            print_r('<pre>');
//            print_r('10 - 20');
//            print_r('</pre>');
        }elseif ($day > 20){
            $add = "AND datepart(DD,e.emp_birthday) >= '21'";
//            print_r('<pre>');
//            print_r('> 20');
//            print_r('</pre>');
        }else{
            $add = '';
        }
//        die;
        $emp = DB::select("
            SELECT e.emp_firstname, e.emp_middle_name, e.emp_lastname, e.emp_birthday, p.epic_picture, l.name as unit
            FROM employee e INNER JOIN emp_picture p
            ON e.emp_number = p.emp_number INNER JOIN location l
            ON e.pnum = l.pnum AND e.ptype = l.ptype
            WHERE e.termination_id = 0
            AND datepart(mm,e.emp_birthday) = datepart(mm,GETDATE()) ".$add."
        ");
        return $emp;
    }
    public function emp_contract(){
        $emp = DB::select("
            SELECT c.econ_extend_end_date, e.emp_number,e.emp_firstname, e.emp_middle_name, e.emp_lastname
            FROM employee e INNER JOIN emp_contract c
            ON e.emp_number = c.emp_number
            WHERE e.termination_id = 0
            AND datepart(yyyy, c.econ_extend_end_date) <= datepart(yyyy,GETDATE())
            AND datepart(mm, c.econ_extend_end_date) <= datepart(mm,GETDATE())
            ORDER BY e.emp_number ASC
        ");
        return $emp;
    }
    public function dash_chart(){
        $range_umur = DB::select("
        select x.range_umur,count(x.umur) as counter
        from (
           select employee_id, datediff(YEAR, emp_birthday , getdate()) umur, 
              case 
               when datediff(year,emp_birthday,GETDATE()) < 25 then '[0 < 25]'
               when datediff(year,emp_birthday,GETDATE()) between 25 and 35 then '[25-35]'
               when datediff(year,emp_birthday,GETDATE()) between 36 and 45 then '[36-45]'
               when datediff(year,emp_birthday,GETDATE()) between 46 and 55 then '[46-55]'
               when datediff(year,emp_birthday,GETDATE()) > 56 then '[ > 56]'
              end range_umur
          FROM employee WHERE termination_id = 0) X
          where not range_umur is null
          group by x.range_umur 
          order by x.range_umur
        ");
        return $range_umur;
    }
    public function dash_chart2(){
        $range_umur = DB::select("
        select case emp_gender when '1' then 'Male' when '2' then 'Female' end as gender,count(*) as counters
        from employee
        WHERE termination_id = 0 AND emp_gender IS NOT NULL
        group by emp_gender
        ");
        return $range_umur;
    }
}
