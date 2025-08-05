<?php

namespace App\Http\Controllers\HRD\HrdProcess;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB,
    Session;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee;
use League\Flysystem\Filesystem;
use Illuminate\Support\Facades\Response;

class HrdProcessController extends Controller {

    protected $emp;

    public function __construct(Employee $emp) {
        $this->emp = $emp;

        parent::__construct();
    }

    public function index(Request $request) {
        $now = date('Y-m-d H:i:s');
//        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
//        $termination = DB::table('emp_termination')
//                ->join('emp_reportto','emp_termination.emp_number','=','emp_reportto.erep_sub_emp_number')
//                ->join('employee','emp_termination.emp_number','=','employee.emp_number')
//                ->join('termination_reason','emp_termination.reason_id','=','termination_reason.id')
//                ->where('emp_reportto.erep_sup_emp_number',$emp->emp_number)
//                ->where('emp_termination.status',1)
//                ->get(['emp_firstname','emp_lastname','emp_middle_name','termination_date','termination_reason.name','emp_termination.id']);
        $termination = DB::select("select
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.emp_number,
                                    FORMAT (termination_date, 'yyyy-MM-dd') as termination_date,
                                    termination_reason.name,
                                    emp_termination.id,
                                    emp_termination.is_upload,
                                    emp_termination.status,
                                    emp_termination.termination_file_name
                                from emp_termination
                                left join employee on emp_termination.emp_number = employee.emp_number
                                left join termination_reason on emp_termination.reason_id = termination_reason.id
                                where emp_termination.status = 3 or emp_termination.status = 2
                                ORDER BY emp_termination.id");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View HRD Process Index',
            'module' => 'HRD Process',
            'sub_module' => 'HRD Process',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View HRD Process Index, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_termination, termination_reason'
        ]);
        
        return view('pages.manage.hrd_process.index', compact('termination'));
    }

    public function upload($id, Request $request) {
        $now = date("Y-m-d H:i:s");

        if ($request->hasFile('form_exit_interview')) {

            //get filename with extension
            $filenamewithextension = $request->file('form_exit_interview')->getClientOriginalName();

            $filenamewithextensionandpath = '/home/HRIS/Form_Exit_Interview/' . $request->file('form_exit_interview')->getClientOriginalName();

            //Upload File to external server
            Storage::disk('ftp')->put($filenamewithextensionandpath, fopen($request->file('form_exit_interview'), 'r+'));

            //Store $filenametostore in the database
        } else {
            return redirect(route('HrdProcess'))->withErrors("file not found");
        }

        DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                        array(
                            'is_upload' => 1,
                            'termination_file_name' => $filenamewithextension
                        )
        );

        \DB::table('log_activity')->insert([
            'action' => 'HRD Upload File Exit Form',
            'module' => 'HRD Process',
            'sub_module' => 'HRD Upload File Exit Form',
            'modified_by' => Session::get('name'),
            'description' => 'Termination ID : ' . $id . ', Uploaded By : ' . trim(Session::get('name')) . ', Termination Status = 3',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_termination'
        ]);

        return redirect(route('HrdProcess'))->with('status', 'file has been uploaded successfully');
    }

    public function Terminate($id, Request $request) {
        $now = date("Y-m-d H:i:s");
        
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();

        DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                        array(
                            'status' => 4,
                            'hrd_by' => $request->session()->get('name'),
                            'hrd_at' => $now,
                        )
        );

        DB::table('employee')
                ->where('emp_number', $request->emp_number)
                ->update(
                        array(
                            'termination_id' => $id,
                        )
        );
        
        $ch = curl_init();
        if($_SERVER['SERVER_NAME'] == 'trialhris.metropolitanland.com'){
            curl_setopt($ch, CURLOPT_URL,"https://trialsso.metropolitanland.com/Api/TerminateUser/Hris");
        }else{
            curl_setopt($ch, CURLOPT_URL,"https://sso.metropolitanland.com/Api/TerminateUser/Hris");
        }
        curl_setopt($ch, CURLOPT_POST, 1);
//        curl_setopt($ch, CURLOPT_POSTFIELDS,$json);

        // In real life you should use something like:
        curl_setopt($ch, CURLOPT_POSTFIELDS, 
                  http_build_query(array('NIK' => $emp->employee_id,'terminate_by'=>Session::get('name'), 'is_unterminate' => 0)));

        // Receive server response ...
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $server_output = curl_exec($ch);

        curl_close($ch);

        \DB::table('log_activity')->insert([
            'action' => 'HRD Terminate',
            'module' => 'HRD Process',
            'sub_module' => 'Termination',
            'modified_by' => Session::get('name'),
            'description' => 'Termination ID : ' . $id . ', Request Resign By : ' . trim(Session::get('name')) . ', Termination Status = 4',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_termination, employee'
        ]);

        return redirect(route('HrdProcess'))->with('status', 'Termination success');
    }
    
    public function approve($id, Request $request) {
        $now = date("Y-m-d H:i:s");

        \DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                array(
                    'status' => 3,
                    'hrd_by' => $request->session()->get('name'),
                    'hrd_at' => $now,
                )
        );
        
        \DB::table('log_activity')->insert([
                            'action' => 'Approve Resign HRD',
                            'module' => 'HRD Process',
                            'sub_module' => 'Approve Termination HRD',
                            'modified_by' => Session::get('name'),
                            'description' => 'Termination ID : ' . $id . ', Approved By : ' . trim(Session::get('name')) . ', Termination Status = 3',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_termination'
                        ]);

        return redirect(route('HrdProcess'))->with('status','Request termination HRD has been successfully approved');
    }

    public function reject($id, Request $request) {
        $now = date("Y-m-d H:i:s");

        \DB::table('emp_termination')
                ->where('id', $id)
                ->update(
                array(
                    'status' => 0,
//                    'approve_by' => $request->session()->get('name'),
//                    'approve_at' => $now,
                )
        );
        
        \DB::table('log_activity')->insert([
                            'action' => 'Reject Resign HRD',
                            'module' => 'HRD Process',
                            'sub_module' => 'Reject Termination HRD',
                            'modified_by' => Session::get('name'),
                            'description' => 'Termination ID : ' . $id . ', Rejected By : ' . trim(Session::get('name')) . ', Termination Status = 0',
                            'created_at' => $now,
                            'updated_at' => $now,
                            'table_activity' => 'emp_termination'
                        ]);

        return redirect(route('HrdProcess'))->with('status','Request termination HRD has been successfully rejected');
    }
    
    public function download($id) {
        $now = date('Y-m-d H:i:s');
        $emp_termination = DB::table('emp_termination')->where('id',$id)->first();
        
        
        $filecontent = Storage::disk('ftp')->get('/home/HRIS/Form_Exit_Interview/'.$emp_termination->termination_file_name);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Download File',
            'module' => 'HRD Process',
            'sub_module' => 'HRD Process',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Download File, id '.$id ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_termination'
        ]);
        
        return Response::make($filecontent, '200', array(
            'Content-Type' => 'application/pdf',
        ));
    }
}
