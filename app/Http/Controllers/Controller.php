<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Mail;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Menu,
    App\Navigations\MenuBuildNav;
use Session,
    DB,
    App\Models\Configs\Email;
use GuzzleHttp\Client;
use App\Models\Leave\Holiday;
use Swift_Mailer;
use Swift_SmtpTransport;

abstract class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    protected $email;

    public function __construct() {
        date_default_timezone_set('Asia/Jakarta');
        $this->middleware('auth');
    }

    public function guid() {
        return DB::select('SELECT CONVERT(varchar(255), NEWID()) as posd');
    }

    // Check Permission HRD Or Not
    public function checkPermission() {
        if (Session::get('is_manage') == TRUE) {
            return true;
        } else {
            Log::warning('============================ Auth ===============================');
            Log::warning('User ID ' . Session::get('userid') . ' trying to access HRD Menus.');
            Log::warning('=================================================================');
            return false;
        }
    }

    public function sendEmailRequest($mailType, $emp_number, $leave_id, $emp_incharge) {
        $now = date("Y-m-d H:i:s");
        $emailConfig = Email::where('id', $mailType)->first();
//        $emp = DB::table('employee')->where('emp_number', $emp_number)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname', 
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        
        $empIncharge = DB::table('employee')->where('emp_number', $emp_incharge)->first();
        $leaves = DB::table('employee')
                ->join('emp_reportto', 'employee.emp_number', '=', 'emp_reportto.erep_sup_emp_number')
                ->where('emp_reportto.erep_sub_emp_number', $emp_number)
                ->where('emp_reportto.erep_reporting_mode', '1')
                ->select('emp_reportto.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email')
                ->first();
        $emp_leave = DB::table('emp_leave_request')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->join('leave_type', 'emp_leave_request.leave_type_id', '=', 'leave_type.id')
                        ->where('emp_leave_request.id', $leave_id)
                        ->select('emp_leave_request.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'leave_type.name')->first();

        try {
            // $hr = DB::table('users')
            //                 ->join('location', 'location.code', '=', 'users.project_code')
            //                 ->join('employee', 'employee.location_id', '=', 'location.id')
            //                 ->where('employee.emp_number', $emp_leave->emp_number)
            //                 ->where('users.username', 'like', '%hrd%')
            //                 ->select('users.email', 'users.name')->first();
            Mail::send($emailConfig->body_conf, ['emp' => $emp, 'emp_leave' => $emp_leave], function ($message) use ($emailConfig, $emp) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp->emp_work_email);
            });
            Mail::send('mails.leaveNotifSup', ['emp_leave' => $emp_leave, 'leaves' => $leaves, 'empIncharge' => $empIncharge, 'emailtohr' => $emailtohr], function ($message) use ($emailConfig, $leaves, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($leaves->emp_work_email);
                $message->cc($emailtohr);
            });
//                $message->cc($address, $name = null);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Request Leave',
                'module' => 'Leave',
                'sub_module' => 'Request Leave',
                'modified_by' => $emp->emp_work_email,
                'description' => 'ID Leave : ' . $leave_id . ', Email From : ' . $emailConfig->from_conf . ', Email To : ' . $emp->emp_work_email . ', ' . $leaves->emp_work_email . ', Email CC : ' . $emailtohr[0],
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            return back()->with('alert-success', 'Berhasil Kirim Email');
        } catch (Exception $e) {
            return response(['status' => false, 'errors' => $e->getMessage()]);
        }
    }

    public function sendNotifuser($employee_id, $contents, $headings) {
        $user_phone = DB::table('user_phone')
                ->where('employee_id', $employee_id)
                ->first();
        $client = new Client();
        $fields = [
            "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
            "contents" => ["en" => $contents],
            "headings" => ["en" => $headings],
            "include_player_ids" => [$user_phone->player_id],
            "small_icon" => "ic_notification_icon",
            "android_accent_color" => "009291",
            "large_icon" => "ic_notification_icon",
            "android_background_layout" => "009291"
        ];

        $header = [
            "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
            "Content-Type" => "text/html; charset=UTF-8"
        ];

        $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Authorization' => 'Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1',
                'Content-Type' => 'application/json'],
            'json' => $fields]
        );
    }

    public function sendNotifalluser($contents, $headings) {
        $client = new Client();
        $fields = [
            "app_id" => "f2d425cc-c68c-4547-975d-2901faf6fdc1",
            "contents" => ["en" => $contents],
            "headings" => ["en" => $headings],
            "included_segments" => ["Active Users", "Inactive Users"],
            "small_icon" => "ic_notification_icon",
            "android_accent_color" => "009291",
            "large_icon" => "ic_notification_icon",
            "android_background_layout" => "009291"
        ];
        $header = [
            "Authorization" => "Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1",
            "Content-Type" => "text/html; charset=UTF-8"
        ];
        $res = $client->request('POST', 'https://onesignal.com/api/v1/notifications', [
            'headers' => [
                'Authorization' => 'Basic ZDllNTU3OGMtOTljZi00NWI4LWExM2YtYzc5MDE0NDUyN2Y1',
                'Content-Type' => 'application/json'],
            'json' => $fields]
        );
    }

    public function sendEmailApprove($mailType, $emp_number, $leave_id) {
        $now = date("Y-m-d H:i:s");
        $emailConfig = Email::where('id', $mailType)->first();
//        $emp = DB::table('employee')->where('emp_number', $emp_number)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname',
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        $emp_leave = DB::table('emp_leave_request')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_leave_request.id', $leave_id)
                        ->where('emp_leave_request.id', $leave_id)->first();
        $hr = DB::table('users')
                ->join('location', 'location.code', '=', 'users.project_code')
                ->join('employee', 'employee.location_id', '=', 'location.id')
                ->where('employee.emp_number', $emp_leave->emp_number)
                ->where('username', 'like', '%hrd%')
                ->select('users.email', 'users.name')
                ->first();
        try {
            Mail::send($emailConfig->body_conf, ['emp' => $emp, 'emp_leave' => $emp_leave], function ($message) use ($emailConfig, $emp, $emp_leave, $hr, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp_leave->emp_work_email);
                $message->cc($emailtohr);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Approve Leave',
                'module' => 'Leave',
                'sub_module' => 'Approve Leave',
                'modified_by' => $emp_leave->emp_work_email,
                'description' => 'ID Leave : ' . $leave_id . ', Email From : ' . $emailConfig->from_conf . ', Email To : ' . $emp_leave->emp_work_email . ', Email CC : ' . $hr->email,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
    
    public function sendEmailReject($mailType, $emp_number, $leave_id) {
        $now = date("Y-m-d H:i:s");
        $emailConfig = Email::where('id', $mailType)->first();
//        $emp = DB::table('employee')->where('emp_number', $emp_number)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname',
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        $emp_leave = DB::table('emp_leave_request')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_leave_request.id', $leave_id)
                        ->where('emp_leave_request.id', $leave_id)->first();
        $hr = DB::table('users')
                ->join('location', 'location.code', '=', 'users.project_code')
                ->join('employee', 'employee.location_id', '=', 'location.id')
                ->where('employee.emp_number', $emp_leave->emp_number)
                ->where('username', 'like', '%hrd%')
                ->select('users.email', 'users.name')
                ->first();
        try {
            Mail::send($emailConfig->body_conf, ['emp' => $emp, 'emp_leave' => $emp_leave], function ($message) use ($emailConfig, $emp, $emp_leave, $hr, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp_leave->emp_work_email);
                $message->cc($emailtohr);
//                $message->cc($hr->email, $hr->name);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Reject Leave',
                'module' => 'Leave',
                'sub_module' => 'Reject Leave',
                'modified_by' => $emp_leave->emp_work_email,
                'description' => 'ID Leave : ' . $leave_id . ', Email From : ' . $emailConfig->from_conf . ', Email To : ' . $emp_leave->emp_work_email . ', Email CC : ' . $hr->email,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }

    public function sendEmailAutoApprove($mailType, $emp_number, $leave_id) {
        $now = date("Y-m-d H:i:s");
        $emailConfig = Email::where('id', $mailType)->first();
        
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname', 'employee.emp_number',
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        $emp_leave = DB::table('emp_leave_request')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_leave_request.id', $leave_id)
                        ->where('emp_leave_request.id', $leave_id)->first();
        $hr = DB::table('users')
                ->join('location', 'location.code', '=', 'users.project_code')
                ->join('employee', 'employee.location_id', '=', 'location.id')
                ->where('employee.emp_number', $emp_leave->emp_number)
                ->where('username', 'like', '%hrd%')
                ->select('users.email', 'users.name')
                ->first();
        $leaves = DB::table('employee')
                ->join('emp_reportto', 'employee.emp_number', '=', 'emp_reportto.erep_sup_emp_number')
                ->where('emp_reportto.erep_sub_emp_number', $emp->emp_number)
                ->where('emp_reportto.erep_reporting_mode', '1')
                ->select('emp_reportto.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email')
                ->first();
        try {
            // Backup original mailer
            $backup = Mail::getSwiftMailer();

            // Setup your gmail mailer
            $transport = new Swift_SmtpTransport(env("MAIL_HOST"), env("MAIL_PORT"), env("MAIL_ENCRYPTION"));
            $transport->setUsername(env("MAIL_USERNAME"));
            $transport->setPassword(env("MAIL_PASSWORD"));

            $gmail = new Swift_Mailer($transport);

            // Set the mailer as gmail
            Mail::setSwiftMailer($gmail);

            Mail::send($emailConfig->body_conf, ['emp' => $emp, 'emp_leave' => $emp_leave], function ($message) use ($emailConfig, $emp, $emp_leave, $hr, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp_leave->emp_work_email);
                $message->cc($emailtohr);
            });

            // Restore your original mailer
            Mail::setSwiftMailer($backup);

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Approve Leave',
                'module' => 'Leave',
                'sub_module' => 'Approve Leave',
                'modified_by' => 'Send Email Auto Approve',
                'description' => 'ID Leave : ' . $leave_id . ', Email From : ' . $emailConfig->from_conf . ', Email To : ' . $emp_leave->emp_work_email . ', Email CC : ' . implode(",", $emailtohr),
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'emp_leave_request'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }

    public function sendEmailTrainingRequest($mailType, $emp_number, $id) {
        $emailConfig = Email::where('id', $mailType)->first();
//        $emp = DB::table('employee')->where('emp_number', $emp_number)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname',
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        $emp_sup = DB::table('employee')
                ->join('emp_reportto', 'employee.emp_number', '=', 'emp_reportto.erep_sup_emp_number')
                ->where('emp_reportto.erep_sub_emp_number', $emp_number)
                ->where('emp_reportto.erep_reporting_mode', '1')
                ->select('emp_reportto.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email')
                ->first();
        $emp_request = DB::table('emp_trainning_request')
                        ->join('employee', 'emp_trainning_request.emp_number', '=', 'employee.emp_number')
                        ->where('id', $id)
                        ->select('emp_trainning_request.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname')->first();

        try {
            $hr = DB::table('users')
                            ->join('location', 'location.code', '=', 'users.project_code')
                            ->join('employee', 'employee.location_id', '=', 'location.id')
                            ->where('employee.emp_number', $emp_request->emp_number)
                            ->where('username', 'like', '%hrd%')
                            ->select('users.email', 'users.name')->first();
            if (!filter_var($emp->emp_work_email, FILTER_VALIDATE_EMAIL) || !filter_var($hr->email, FILTER_VALIDATE_EMAIL)) {
                return back()->withErrors(['error' => 'Email send fail, invalid email format']);
            }
            Mail::send($emailConfig->body_conf, ['emp' => $emp], function ($message) use ($emailConfig, $emp) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp->emp_work_email);
            });
            Mail::send('mails.trainNotifSup', ['emp_request' => $emp_request, 'emp_sup' => $emp_sup], function ($message) use ($emailConfig, $emp_sup, $hr, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp_sup->emp_work_email);
                $message->cc($emailtohr);
//                $message->cc($hr->email, $hr->name);
            });
//                $message->cc($address, $name = null);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);
            return back()->with('alert-success', 'Berhasil Kirim Email');
        } catch (Exception $e) {
            return response(['status' => false, 'errors' => $e->getMessage()]);
        }
    }

    public function sendEmailApproveTraining($mailType, $emp_number, $leave_id) {
        $emailConfig = Email::where('id', $mailType)->first();
//        $emp = DB::table('employee')->where('emp_number', $emp_number)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('emp_number', $emp_number)
                ->select('employee.employee_id', 'employee.emp_firstname',
                        'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $emailtohr = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailtohr,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailtohr,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailtohr,$emp->email_hrd_3);
        }
        $emp_leave = DB::table('emp_leave_request')
                        ->join('employee', 'emp_leave_request.emp_number', '=', 'employee.emp_number')
                        ->where('emp_leave_request.id', $leave_id)->first();
        $hr = DB::table('users')
                ->join('location', 'location.code', '=', 'users.project_code')
                ->join('employee', 'employee.location_id', '=', 'location.id')
                ->where('employee.emp_number', $emp_leave->emp_number)
                ->where('username', 'like', '%hrd%')
                ->select('users.email', 'users.name')
                ->first();
        $leaves = DB::table('employee')
                ->join('emp_reportto', 'employee.emp_number', '=', 'emp_reportto.erep_sup_emp_number')
                ->where('emp_reportto.erep_sub_emp_number', $emp->emp_number)
                ->where('emp_reportto.erep_reporting_mode', '1')
                ->select('emp_reportto.*', 'employee.emp_firstname', 'employee.emp_middle_name', 'employee.emp_lastname', 'employee.emp_work_email')
                ->first();
        try {
            Mail::send($emailConfig->body_conf, ['emp' => $emp, 'emp_leave' => $emp_leave], function ($message) use ($emailConfig, $emp, $emp_leave, $hr, $emailtohr) {
                $message->subject($emailConfig->subject_conf);
                $message->from($emailConfig->from_conf, 'No Reply HRIS');
                $message->to($emp_leave->emp_work_email);
                $message->cc($emailtohr);
//                $message->cc($hr->email, $hr->name);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);
            });
            return back()->with('alert-success', 'Berhasil Kirim Email');
        } catch (Exception $e) {
            return response(['status' => false, 'errors' => $e->getMessage()]);
        }
    }

    public function sendEmailAddEmployee($emp_id) {
        $now = date("Y-m-d H:i:s");
//        $emailConfig = Email::where('id',$mailType)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('employee_id', $emp_id)
                ->select('employee.employee_id', 'employee.emp_firstname', 
                        'employee.emp_middle_name', 'employee.emp_lastname', 
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        
        
        $empAdms = DB::connection('adms')->table('userinfo')->where('title', $emp->employee_id)->first();
        $emailto = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailto,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailto,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailto,$emp->email_hrd_3);
        }
        $emailcc = array();
        if(!empty($emp->email_it_1) && $emp->email_it_1 != "" && $emp->email_it_1 != NULL){
                array_push($emailto,$emp->email_it_1);
        }
        if(!empty($emp->email_it_2) && $emp->email_it_2 != "" && $emp->email_it_2 != NULL){
                array_push($emailto,$emp->email_it_2);
        }
        if(!empty($emp->email_it_3) && $emp->email_it_3 != "" && $emp->email_it_3 != NULL){
                array_push($emailto,$emp->email_it_3);
        }
//        $emailto = [$emp->email_hrd_1,$emp->email_hrd_2,$emp->email_hrd_3];
//        $emailcc = [$emp->email_it_1,$emp->email_it_2,$emp->email_it_3];
        //$emails = ['rudiyanto@metropolitanland.com', 'aditya.sugiharto@metropolitanland.com'];

        try {
            Mail::send('mails.addEmpBody', ['emp' => $emp, 'empAdms' => $empAdms], function ($message) use ($emailto, $emailcc) {
                $message->subject('Add Employee');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailto);
                $message->cc($emailcc);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Add Employee',
                'module' => 'Master',
                'sub_module' => 'Employee',
                'modified_by' => Session::get('name'),
                'description' => 'Employee Id : ' . $emp->employee_id . ', Email From : hris.metland@gmail.com , Email To : rudiyanto@metropolitanland.com, aditya.sugiharto@metropolitanland.com ',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'employee'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
    
    public function sendEmailAddEmployeeIntern($emp_id) {
        $now = date("Y-m-d H:i:s");
//        $emailConfig = Email::where('id',$mailType)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('employee_id', $emp_id)
                ->select('employee.employee_id', 'employee.emp_firstname', 
                        'employee.emp_middle_name', 'employee.emp_lastname', 
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $empAdms = DB::connection('adms')->table('userinfo')->where('title', $emp->employee_id)->first();
        $emailto = [$emp->email_hrd_1,$emp->email_hrd_2,$emp->email_hrd_3];
        $emailcc = [$emp->email_it_1,$emp->email_it_2,$emp->email_it_3];
        //$emails = ['rudiyanto@metropolitanland.com', 'aditya.sugiharto@metropolitanland.com'];

        try {
            Mail::send('mails.addEmpInternBody', ['emp' => $emp, 'empAdms' => $empAdms], function ($message) use ($emailto, $emailcc) {
                $message->subject('Add Employee Intern');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailto);
                $message->cc($emailcc);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Add Employee Intern',
                'module' => 'Master',
                'sub_module' => 'Employee',
                'modified_by' => Session::get('name'),
                'description' => 'Employee Id : ' . $emp->employee_id . ', Email From : hris.metland@gmail.com , Email To : rudiyanto@metropolitanland.com, aditya.sugiharto@metropolitanland.com ',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'employee'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
    
    public function sendEmailAddAttendance($emp_id,$attReqId) {
        $now = date("Y-m-d H:i:s");
//        $emailConfig = Email::where('id',$mailType)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('employee_id', $emp_id)
                ->select('employee.employee_id', 'employee.emp_firstname', 
                        'employee.emp_middle_name', 'employee.emp_lastname', 
                        'employee.emp_number',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $attReq = DB::table('emp_attendance_request')
                ->leftJoin('com_master_perijinan','emp_attendance_request.comIjin','=','com_master_perijinan.comIjin')
                ->where('emp_attendance_request.id', $attReqId)
                ->select('emp_attendance_request.*','com_master_perijinan.keterangan')
                ->first();
        $date = date_create($attReq->start_date);
        $formatDate = date_format($date,"d-m-Y");
        $reportto = DB::table('emp_reportto')
                ->where('erep_reporting_mode',1)
                ->where('erep_sub_emp_number',$emp->emp_number)
                ->first();
        $empSup = DB::table('employee')
                ->where('emp_number',$reportto->erep_sup_emp_number)
                ->first();
//        dd($empSup->emp_work_email);
        $emailsup = $empSup->emp_work_email;
        $emailto = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailto,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailto,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailto,$emp->email_hrd_3);
        }
//        $emailto = [$emp->email_hrd_1,$emp->email_hrd_2,$emp->email_hrd_3];
//        $emailcc = [$emp->email_it_1,$emp->email_it_2,$emp->email_it_3];
        //$emails = ['rudiyanto@metropolitanland.com', 'aditya.sugiharto@metropolitanland.com'];

        try {
            Mail::send('mails.addEmpAttendance', ['attReq' => $attReq, 'emp' => $emp, 'empSup' => $empSup, 'formatDate' => $formatDate], function ($message) use ($emailsup) {
                $message->subject('Attendance Request');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailsup);
            });
            Mail::send('mails.addEmpAttendanceHrd', ['attReq' => $attReq, 'emp' => $emp, 'empSup' => $empSup, 'formatDate' => $formatDate], function ($message) use ($emailto) {
                $message->subject('Attendance Request');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailto);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Add Attendance',
                'module' => 'Attendance',
                'sub_module' => 'Attendance',
                'modified_by' => Session::get('name'),
                'description' => 'Employee Id : ' . $emp->employee_id . ', Email From : hris.metland@gmail.com , Email To : '.$emailsup.', '.$emp->email_hrd_1.', '.$emp->email_hrd_2.', '.$emp->email_hrd_3,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'employee'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }
    
    public function sendEmailAddOvertime($emp_id,$otReqId) {
        $now = date("Y-m-d H:i:s");
//        $emailConfig = Email::where('id',$mailType)->first();
        $emp = DB::table('employee')
                ->join('location', 'location.id', '=', 'employee.location_id')
                ->where('employee_id', $emp_id)
                ->select('employee.employee_id', 'employee.emp_firstname', 
                        'employee.emp_middle_name', 'employee.emp_lastname', 
                        'employee.emp_number',
                        'location.name AS location_name',
                        'location.email_hrd_1','location.email_hrd_2','location.email_hrd_3',
                        'location.email_it_1','location.email_it_2','location.email_it_3')
                ->first();
        $otReqGet = DB::select("select emp_ot_reqeuest.*,
	FORMAT (ot_date, 'dd-MM-yyyy') as ot_date_format,
	convert(char(8),convert(time(0),ot_start_time)) as ot_start_time_format,
	convert(char(8),convert(time(0),ot_end_time)) as ot_end_time_format
from emp_ot_reqeuest 
where id = ".$otReqId);
        $otReq = $otReqGet[0];
        $reportto = DB::table('emp_reportto')
                ->where('erep_reporting_mode',1)
                ->where('erep_sub_emp_number',$emp->emp_number)
                ->first();
        $empSup = DB::table('employee')
                ->where('emp_number',$reportto->erep_sup_emp_number)
                ->first();
//        dd($empSup->emp_work_email);
        $emailsup = $empSup->emp_work_email;
        $emailto = array();
        if(!empty($emp->email_hrd_1) && $emp->email_hrd_1 != "" && $emp->email_hrd_1 != NULL){
                array_push($emailto,$emp->email_hrd_1);
        }
        if(!empty($emp->email_hrd_2) && $emp->email_hrd_2 != "" && $emp->email_hrd_2 != NULL){
                array_push($emailto,$emp->email_hrd_2);
        }
        if(!empty($emp->email_hrd_3) && $emp->email_hrd_3 != "" && $emp->email_hrd_3 != NULL){
                array_push($emailto,$emp->email_hrd_3);
        }
//        $emailto = [$emp->email_hrd_1,$emp->email_hrd_2,$emp->email_hrd_3];
//        $emailcc = [$emp->email_it_1,$emp->email_it_2,$emp->email_it_3];
        //$emails = ['rudiyanto@metropolitanland.com', 'aditya.sugiharto@metropolitanland.com'];

        try {
            Mail::send('mails.addEmpOverTime', ['otReq' => $otReq, 'emp' => $emp, 'empSup' => $empSup], function ($message) use ($emailsup) {
                $message->subject('Overtime Request');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailsup);
            });
            Mail::send('mails.addEmpOverTimeHrd', ['otReq' => $otReq, 'emp' => $emp, 'empSup' => $empSup], function ($message) use ($emailto) {
                $message->subject('Overtime Request');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emailto);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Add Over Time',
                'module' => 'Over Time',
                'sub_module' => 'Over Time',
                'modified_by' => Session::get('name'),
                'description' => 'Employee Id : ' . $emp->employee_id . ', Email From : hris.metland@gmail.com , Email To : '.$emailsup.', '.$emp->email_hrd_1.', '.$emp->email_hrd_2.', '.$emp->email_hrd_3,
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'employee'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }

    public function sendEmailAddEmployeeDW($emp_id) {
        $now = date("Y-m-d H:i:s");
//        $emailConfig = Email::where('id',$mailType)->first();

        $empAdms = DB::connection('adms')->table('userinfo')->where('title', $emp_id)->first();
        $location = DB::table('location')->where('adms_dept_id', $empAdms->defaultdeptid)->first();
        $emails = ['rudiyanto@metropolitanland.com', 'aditya.sugiharto@metropolitanland.com'];
        //dd($empAdms);
        try {
            Mail::send('mails.addEmpDWBody', ['location' => $location, 'empAdms' => $empAdms], function ($message) use ($emails) {
                $message->subject('Add Employee DW');
                $message->from('hris.metland@gmail.com', 'No Reply HRIS');
                $message->to($emails);
//                $message->cc($hr->email);
//                $message->bcc($address, $name = null);
//                $message->replyTo($address, $name = null);
            });

            \DB::table('log_activity')->insert([
                'action' => 'Send Email Add Employee DW',
                'module' => 'Master',
                'sub_module' => 'Employee',
                'modified_by' => Session::get('name'),
                'description' => 'Employee Id : ' . $empAdms->title . ', Email From : hris.metland@gmail.com , Email To : rudiyanto@metropolitanland.com, aditya.sugiharto@metropolitanland.com ',
                'created_at' => $now,
                'updated_at' => $now,
                'table_activity' => 'employee'
            ]);

            // return back()->with('alert-success','Berhasil Kirim Email');
        } catch (Exception $e) {
            // return response (['status' => false,'errors' => $e->getMessage()]);
        }
    }

    public function calculateDays($start_date, $end_date, $days_type) {
        $day = array();
        $i = 0;
        $now = date('Y') . '-01-01';
        $start = new \DateTime($start_date);
        $end = new \DateTime($end_date);
        // otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');
        $interval = $end->diff($start);
        // total days
        $days = $interval->days;
        // create an iterateable period of date (P1D equates to 1 day)
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
        // best stored as array, so you can add more than one
        // $holidays = array('2019-07-01', '2019-07-03');
        // $holidays = Holiday::where('recurring' , '1')->whereOr('date', '>=', $now)->where('date', '<=', $end)->select('date')->get(); //
        $holidays = Holiday::where('recurring', 1)
                ->orWhere(function ($query) use ($now, $end) {
                    $query->where('date', '>=', $now)
                    ->where('date', '<=', $end);
                })
                ->select('date')
                ->get();

        foreach ($holidays as $holiday) {
            $day[$i] = $this->formatDate($holiday->date);
            $i++;
        }
        foreach ($period as $dt) {
            $curr = $dt->format('D');
            if ($days_type == '1') {
                // substract if Saturday or Sunday
                if ($curr == 'Sat' || $curr == 'Sun') {
                    $days--;
                }
            }
            // substract if Holidays
            if (in_array($dt->format('Y-m-d'), $day)) {
                $days--;
            }
        }
        return $days;
    }

    function formatDate($date, $format = 'Y-m-d') {
        $dat = \DateTime::createFromFormat($format, $date);
        $stat = $dat && $dat->format($format) === $date;
        if ($stat == false) {
            $finalDate = \DateTime::createFromFormat('M d Y h:i:s A', $date)->format($format);
        } else {
            $finalDate = $date;
        }
        return $finalDate;
    }

//    public function calculateDays($start_date, $end_date, $days_type){
//        $start = new \DateTime($start_date);
//        $end = new \DateTime($end_date);
//        // otherwise the  end date is excluded (bug?)
//        $end->modify('+1 day');
//        $interval = $end->diff($start);
//        // total days
//        $days = $interval->days;
//        // create an iterateable period of date (P1D equates to 1 day)
//        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);
//        // best stored as array, so you can add more than one
//        $holidays = array('2019-07-01', '2019-07-03');
//        foreach($period as $dt) {
//            $curr = $dt->format('D');
//            if($days_type == '1'){
//                // substract if Saturday or Sunday
//                if ($curr == 'Sat' || $curr == 'Sun') {
//                    $days--;
//                }
//            }
//            // substract if Holidays
//            if (in_array($dt->format('Y-m-d'), $holidays)) {
//                $days--;
//            }
//        }
//        return $days;
//    }

    public function date_convert($date) {
        date_default_timezone_set('Asia/Jakarta');
        $new_date = date('Y-m-d', strtotime(substr($date, 0, 11)));
//        $new_date = date('Y-m-d', strtotime($date));
//        $new_date = Carbon::parse($date);

        return $new_date;
    }

    public function getMobileAppsID() {
        return "64582a3d31feb2e85f953a24a18f19300db67fbd010373d104929736daaed801";
    }

    public function addMobileLog($emp_number, $title, $desc) {
        date_default_timezone_set('Asia/Jakarta');

        $now = date('Y-m-d H:i:s');
        DB::table("MH_USER_LOG")
                ->insert([
                    "EMP_NUMBER" => $emp_number,
                    "LOG_TITLE" => $title,
                    "LOG_DESC" => $desc,
                    "CREATED_AT" => $now
        ]);
    }

//    public function send_notification($registatoin_ids, $notification, $device_type) {
//        $url = 'https://fcm.googleapis.com/fcm/send';
//        if($device_type == "Android"){
//            $fields = array(
//                'to' => $registatoin_ids,
//                'data' => $notification
//            );
//        } else {
//            $fields = array(
//                'to' => $registatoin_ids,
//                'notification' => $notification
//            );
//        }
//        // Firebase API Key
//        $headers = array('Authorization:key=AAAAb9tqcBk:APA91bEyMmg9X4zTRGRx1BD0z454A0ZL879W3DBDtl_q83SDq0eNXAgT_mGcmJmJUfxbO2XCV5Yl6hUgjz3lpVyQr_RuFdGE55nNwLJ0bvRlPw4XMQS7BflTEC-xp7bPI0hynfGxfeJl','Content-Type:application/json');
//        // Open connection
//        $ch = curl_init();
//        // Set the url, number of POST vars, POST data
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_POST, true);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        // Disabling SSL Certificate support temporarly
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
//        $result = curl_exec($ch);
//        if ($result === FALSE) {
//            die('Curl failed: ' . curl_error($ch));
//        }
//        curl_close($ch);
//    }
}
