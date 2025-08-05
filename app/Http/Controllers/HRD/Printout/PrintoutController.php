<?php

namespace App\Http\Controllers\HRD\printout;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB,
    Session;
use App\Models\Master\Employee;

class PrintoutController extends Controller {

    protected $emp;

    public function __construct(Employee $emp) {
        $this->emp = $emp;

        parent::__construct();
    }

    public function printSuratPerintahKerja($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');

        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date
                                from employee
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Perintah Kerja',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Perintah Kerja, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratPerintahKerja', compact('employee','now'));
    }
    public function printSuratKeputusan($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');

        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date
                                from employee
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Keputusan',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Keputusan, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratKeputusan', compact('employee','now'));
    }
    
    public function printSuratKeputusanTMJ($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');
        
        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date
                                from employee
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Keputusan TMJ',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Keputusan TMJ, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratKeputusanTMJ', compact('employee','now'));
    }
    
    public function printSuratPernyataanKontrakKerja($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');

        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    location.name as location_name,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date,
                                    FORMAT (employee.emp_birthday, 'yyyy-MM-dd') as emp_birthday
                                from employee
                                inner join location on employee.location_id = location.id
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Pernyataan Kontrak Kerja',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Pernyataan Kontrak Kerja, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratPernyataanKontrakKerja', compact('employee','now'));
    }
    
    public function printSuratPernyataanMenjagaRahasiaPerusahaan($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');
        
        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date,
                                    FORMAT (employee.emp_birthday, 'yyyy-MM-dd') as emp_birthday
                                from employee
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Pernyataan Menjaga Rahasia Perusahaan',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Pernyataan Menjaga Rahasia Perusahaan, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratPernyataanMenjagaRahasiaPerusahaan', compact('employee','now'));
    }
    
    public function printSuratPernyataanBerakhirHubunganKerja($id) {
//        $empNumber = $this->emp->where('employee_id', Session::get('username'))->first();
        $now = date("d-M-Y");
        $nowLog = date('Y-m-d H:i:s');

        $emp = DB::select("select TOP 1
                                    employee.emp_firstname, 
                                    employee.emp_middle_name, 
                                    employee.emp_lastname,
                                    employee.job_level,
                                    employee.emp_street1,
                                    employee.employee_id,
                                    employee.emp_ktp,
                                    employee.joined_date as real_join_date,
                                    FORMAT (employee.joined_date, 'yyyy-MM-dd') as emp_join_date,
                                    FORMAT (employee.emp_birthday, 'yyyy-MM-dd') as emp_birthday
                                from employee
                                where employee.emp_number = '".$id."'");
        $employee = $emp[0];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Surat Pernyataan Berakhir Hubungan Kerja',
            'module' => 'Printout',
            'sub_module' => 'Printout',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Surat Pernyataan Berakhir Hubungan Kerja, employee id '.$emp[0]->employee_id,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        
        return view('prints.pdfSuratPernyataanBerakhirHubunganKerja', compact('employee','now'));
    }
}
