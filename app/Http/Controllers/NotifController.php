<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MetHrisMobile\MobileNotificationController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use DB, Log, Session;
use App\Models\Notifications\Notification, App\Models\Master\Employee, App\Models\Leave\LeaveRequest;

class NotifController extends Controller{
    protected $emp;
    protected $notif;
    protected $lvReq;
    public function __construct(Employee $emp, Notification $notif,LeaveRequest $lvReq) {
        $this->emp = $emp;
        $this->notif = $notif;
        $this->lvReq = $lvReq;
        parent::__construct();
    }
    public function leave(){
        $msg = array(); $i =0;
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $new_notif = $this->notif->where('NOTIFICATION_TYPE_ID', '1')
            ->where('EMPLOYEE_ID', Session::get('username'))->where('IS_READ', '0')->where('IS_DELETED', '0')
            ->groupBy('NOTIFICATION_STATUS_ID')->count();
        $msg_notif = $this->notif->where('IS_READ', '0')->where('IS_DELETED', '0')->where('EMPLOYEE_ID', Session::get('username'))->get();
        foreach ($msg_notif as $row){
            if($row->MODULE_ID > 0){
                $msg[$i] ='
                <a href="#apvModal" data-toggle="modal" class="open-apvModal" data-id="'.$row->MODULE_ID.'" id="apv">
                    <div class="hd-message-sn">
                        <div class="hd-mg-ctn">
                            <h3>'. $row->NOTIFICATION_TITLE .'</h3>
                            <p>'. $row->NOTIFICATION_DESC .'</p>
                        </div>
                    </div>
                </a>';

            }else{
                $msg[$i] ='
                <a href="#">
                    <div class="hd-message-sn">
                        <div class="hd-mg-ctn">
                            <h3>'. $row->NOTIFICATION_TITLE .'</h3>
                            <p>'. $row->NOTIFICATION_DESC .'</p>
                        </div>
                    </div>
                </a>';
            }
            $i++;
        }
        return json_encode(['counter' => $new_notif, 'msg' => $msg]);
    }
    public function notif_leave($id){
        $leave = $this->lvReq->where('id',$id)->first();
        $emp = $this->emp->where('emp_number', $leave->emp_number)->first();

//        $notif = new MobileNotificationController();
//        $notif->approveLeaveNotification($emp->emp_number, $leave->id);

        return view('pages.leave.index', compact('emp', 'leave'));
    }

    public function contract(){
        $query = DB::connection('mysql')->select("
			select a.employee_id,concat(rtrim(a.emp_firstname),' ',rtrim(a.emp_middle_name),' ',rtrim(a.emp_lastname)) as emp_name,d.name,b.econ_extend_end_date,
			b.econ_extend_start_date, TIMESTAMPDIFF(YEAR, IFNULL(a.emp_birthday,0), NOW()) AS Age
			from hs_hr_employee a
			inner join hs_hr_emp_contract_extend b on a.emp_number=b.emp_number
			inner join hs_hr_emp_locations c on a.emp_number=c.emp_number
			inner join ohrm_location d on c.location_id=d.id
			where a.emp_status=2 and a.termination_id = 0
			AND DATEDIFF(b.econ_extend_end_date,Now()) <= 37
			order by d.name
        ");
        print_r('<pre>');
        print_r($query);
        print_r('</pre>'); die;

        Log::info('================CRON RENEWAL CRONTRACT===================');
        Log::info('RENEWAL CRONTRACT run at '.date('d-m-Y'));
        Log::info('=========================================================');
    }
}
