<?php

namespace App\Http\Controllers\Salaries;

use App\Models\Configs\Email;
use Illuminate\Http\Request;

use App\Http\Requests, DB, Session, Log;
use App\Http\Controllers\Controller, App\Models\Master\Employee, App\Models\Recruitment\JobVacancy;
use Mail;

class SalaryController extends Controller{
    protected $emp;
    public function __construct(Employee $emp){
        $this->emp = $emp;
        parent::__construct();
    }
    public function index(){
        return view('pages.salary.index');
    }
    public function download(Request $request){
        $url = 'http://payroll.metropolitanland.com/upload/pdf/';
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $bln = date('n');
        $thn = date('y');
//        $naming = str_replace('/', 'x', crypt($emp->employee_id, $bln."".$thn));
        $naming = str_replace('/', 'x', crypt('1411010','321'));
        $filename = $naming.'.pdf';

        $result=get_headers($url.$filename);
        if(stripos($result[0],"200 OK")){ //check if $result[0] has 200 OK
            header('Content-Description: File Transfer');
            header('Cache-Control: public'); # needed for IE
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename='. $filename );
            readfile($url.$filename)or die('error!');

//            return $url.$filename;
        }else{
            echo "Not Cool";
        }

//        print_r('<pre>');
//        print_r('payroll.metropolitanland.com/upload/pdf/'.$naming.'.pdf');
//        print_r('</pre>');
        die;
//        foreach ($datas as $data){
//            Mail::send('emails.salEmail', compact('data'), function($message) use ($emp) {
//                $message->to($emp->emp_email, $emp->emp_name);
//                $message->subject('Gaji Bulan '.date('F', mktime(0, 0, 0, $bln, 10)).' 20'.$thn);
//                $message->from(Config::get('mail.username'),'HRD Metland');
//                $message->attach(public_path().'/upload/pdf/'.$naming.'.pdf');
//            });
//        }
        echo "HTML Email Sent. Check your inbox.";
    }
    public function downloads(Request $request)
    {
        //
    }
}
