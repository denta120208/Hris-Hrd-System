<?php

namespace App\Http\Controllers\HRD\Reports;

use App\Models\Employee\EmpEducation;
use App\Models\Employee\EmpReward;
use App\Models\Master\Employee;
use App\Models\Master\EmploymentStatus;
use App\Models\Master\EmployeeTranning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class KomposisiController extends Controller{
    protected $emp;
    protected $train;
    protected $edu;
    protected $eStatus;
    protected $ePromot;
    public function __construct(Employee $emp, EmploymentStatus $eStatus, EmployeeTranning $train, EmpEducation $edu, EmpReward $ePromot){
        $this->emp = $emp;
        $this->train = $train;
        $this->edu = $edu;
        $this->eStatus = $eStatus;
        $this->ePromot = $ePromot;

        // Tambahkan menu Join & Terminate jika belum ada
        try {
            $reportsMenu = \DB::table('menus')
                ->where('title', 'Reports')
                ->where('is_parent', 1)
                ->first();

            if ($reportsMenu) {
                $menuExists = \DB::table('menus')
                    ->where('uri', 'hrd/rJoinTerminate')
                    ->exists();

                if (!$menuExists) {
                    $menuId = \DB::table('menus')->insertGetId([
                        'title' => 'Join & Terminate',
                        'uri' => 'hrd/rJoinTerminate',
                        'parent_id' => $reportsMenu->id,
                        'is_parent' => 0,
                        'show_menu' => 1,
                        'icon' => 'fa fa-users',
                        'manage_status' => 1,
                        'order_no' => 99,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

                    // Tambahkan ke role yang memiliki akses ke Reports
                    $roles = \DB::table('role_menu')
                        ->where('menu_id', $reportsMenu->id)
                        ->get();

                    foreach ($roles as $role) {
                        \DB::table('role_menu')->insert([
                            'role_id' => $role->role_id,
                            'menu_id' => $menuId,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    }

                    // Update session permissions
                    if (Session::has('perms')) {
                        $currentPerms = Session::get('perms');
                        if (!empty($currentPerms)) {
                            Session::put('perms', $currentPerms . ',' . $menuId);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error adding Join & Terminate menu: ' . $e->getMessage());
        }

        parent::__construct();
    }

    public function statusEmp(){
        $now = date('Y-m-d H:i:s');
        $datas = \DB::select("
            SELECT * FROM   
            (
                select es.slug, e.emp_number, e.pnum from employee e
                LEFT JOIN employment_status es ON e.emp_status = es.id
                WHERE e.termination_id = 0 -- AND es.id IN ('1','2')
            -- GROUP BY es.name, e.pnum
            ) t
            PIVOT(
                COUNT(emp_number) 
                FOR slug IN (
                    [karyawan_tetap], 
                    [kontrak]
                    -- [honorer], , 
                    -- [mt],
                    -- [magang]
                    )
            ) AS pivot_table
            ORDER BY pnum Desc
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Status Employee',
            'module' => 'Report',
            'sub_module' => 'Komposisi Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Status Employee, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, employment_status'
        ]);
        
        return view('pages.manage.reports.komposisi_emp.index', compact('datas'));
    }

    public function statusEmpReport(){
        //
    }

    public function turnOverEmp(){
        //
    }

    public function turnOverEmpReport(){
        //
    }
    public function dtlTurnOverEmp(){
        //
    }

    public function dtlTurnOverEmpReport(){
        //
    }

    public function reportUsia(){
        $now = date('Y-m-d H:i:s');
        $datas = \DB::select("
        SELECT * FROM   
        (
            select x.range_umur, x.umur, x.name, x.project_id
            from (
            select e.employee_id, l.name, l.id as project_id, datediff(YEAR, e.emp_birthday , getdate()) umur, 
                case
                when datediff(year,e.emp_birthday,GETDATE()) < 25 then 'r1'
                when datediff(year,e.emp_birthday,GETDATE()) between 25 and 35 then 'r2'
                when datediff(year,e.emp_birthday,GETDATE()) between 36 and 45 then 'r3'
                when datediff(year,e.emp_birthday,GETDATE()) between 46 and 55 then 'r4'
                when datediff(year,e.emp_birthday,GETDATE()) > 56 then 'r5'
                end range_umur
            FROM employee e INNER JOIN location l ON e.pnum = l.pnum AND e.ptype = l.ptype WHERE e.termination_id = 0) X
            where not range_umur is null
        ) t
        PIVOT(
            COUNT(umur) 
            FOR range_umur IN (
                [r1], 
                [r2],
                [r3], 
                [r4],
                [r5]
            )
        ) AS pivot_table
        ORDER BY name Desc
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Usia',
            'module' => 'Report',
            'sub_module' => 'Komposisi Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Usia, ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, location'
        ]);
        
        return view('pages.manage.reports.komposisi_emp.usia', compact('datas'));
    }
    public function reportUsiaShow($id){
//        print_r($id); die;
        $datas = \DB::select("
        select x.employee_id,x.range_umur, x.umur, x.emp_firstname, x.emp_middle_name, x.emp_lastname, x.project_id
        from (
            select e.employee_id, e.emp_firstname, e.emp_middle_name, e.emp_lastname, l.id as project_id, datediff(YEAR, e.emp_birthday , getdate()) umur, 
            case
            when datediff(year,e.emp_birthday,GETDATE()) < 25 then 'r1'
            when datediff(year,e.emp_birthday,GETDATE()) between 25 and 35 then 'r2'
            when datediff(year,e.emp_birthday,GETDATE()) between 36 and 45 then 'r3'
            when datediff(year,e.emp_birthday,GETDATE()) between 46 and 55 then 'r4'
            when datediff(year,e.emp_birthday,GETDATE()) > 56 then 'r5'
            end range_umur
            FROM employee e INNER JOIN location l ON e.pnum = l.pnum AND e.ptype = l.ptype
            WHERE e.termination_id = 0 AND l.id = '".$id."' 
        ) X
        where not range_umur is null
        ORDER BY x.range_umur
        ");
        return view('pages.manage.reports.komposisi_emp.usiaDetail', compact('datas'));
    }

    public function reportGender(){
        $now = date('Y-m-d H:i:s');
        $datas = \DB::select("
        SELECT * FROM   
        (
            select x.name, x.gender, x.employee_id
            from (
                select l.name,
                case e.emp_gender
                    when '1' then 'Male'
                    when '2' then 'Female'
                end as gender, e.employee_id
                from employee e INNER JOIN location l
                ON e.pnum = l.pnum AND e.ptype = l.ptype
                WHERE e.termination_id = 0 AND e.emp_gender IS NOT NULL
            ) X
        ) t
        PIVOT(
            COUNT(employee_id) 
            FOR gender IN (
                [Male], 
                [Female]
            )
        ) AS pivot_table
        ORDER BY name Desc
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Gender',
            'module' => 'Report',
            'sub_module' => 'Komposisi Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Gender ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, location'
        ]);
        
        return view('pages.manage.reports.komposisi_emp.gender', compact('datas'));
    }

    public function addJoinTerminateMenu() {
        try {
            // 1. Dapatkan ID menu Reports
            $reportsMenu = \DB::table('menus')
                ->where('title', 'Reports')
                ->first();

            if (!$reportsMenu) {
                return "Menu Reports tidak ditemukan!";
            }

            // 2. Hapus menu lama jika ada
            \DB::table('menus')
                ->where('uri', 'hrd/rJoinTerminate')
                ->delete();

            // 3. Tambahkan menu baru
            $menuId = \DB::table('menus')->insertGetId([
                'title' => 'Join & Terminate',
                'uri' => 'hrd/rJoinTerminate',
                'parent_id' => $reportsMenu->id,
                'is_parent' => 0,
                'show_menu' => 1,
                'icon' => 'fa fa-users',
                'manage_status' => 1,
                'order_no' => 99, // Letakkan di akhir
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // 4. Tambahkan ke semua role yang memiliki akses Reports
            $roles = \DB::table('roles')->get();
            foreach ($roles as $role) {
                \DB::table('role_menu')->insert([
                    'role_id' => $role->id,
                    'menu_id' => $menuId
                ]);
            }

            // 5. Update session permissions jika user sedang login
            if (Session::has('perms')) {
                $currentPerms = Session::get('perms');
                if (!empty($currentPerms)) {
                    $newPerms = $currentPerms . ',' . $menuId;
                    Session::put('perms', $newPerms);
                }
            }

            return "Menu berhasil ditambahkan! ID: " . $menuId;
        } catch (\Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    public function joinTerminate() {
        // Pastikan menu sudah ada sebelum menampilkan view
        $this->addJoinTerminateMenu();
        
        $now = date('Y-m-d H:i:s');
        
        // Get data karyawan join dalam 1 bulan terakhir
        $joinedEmployees = \DB::table('employee')
            ->select('employee.*', 'job_title.job_title', 'location.name as project_name')
            ->leftJoin('job_title', 'employee.job_title_code', '=', 'job_title.job_title_code')
            ->leftJoin('location', function($join) {
                $join->on('employee.pnum', '=', 'location.pnum')
                     ->on('employee.ptype', '=', 'location.ptype');
            })
            ->whereRaw('DATEDIFF(month, emp_join_date, GETDATE()) = 0')
            ->where('termination_id', 0)
            ->orderBy('emp_join_date', 'desc')
            ->get();

        // Get data karyawan terminate dalam 1 bulan terakhir
        $terminatedEmployees = \DB::table('employee')
            ->select('employee.*', 'job_title.job_title', 'location.name as project_name', 'termination_type.name as termination_type')
            ->leftJoin('job_title', 'employee.job_title_code', '=', 'job_title.job_title_code')
            ->leftJoin('location', function($join) {
                $join->on('employee.pnum', '=', 'location.pnum')
                     ->on('employee.ptype', '=', 'location.ptype');
            })
            ->leftJoin('termination', 'employee.termination_id', '=', 'termination.id')
            ->leftJoin('termination_type', 'termination.termination_type_id', '=', 'termination_type.id')
            ->whereRaw('DATEDIFF(month, termination.termination_date, GETDATE()) = 0')
            ->where('termination_id', '>', 0)
            ->orderBy('termination.termination_date', 'desc')
            ->get();
        
        // Log activity
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Join & Terminate Report',
            'module' => 'Report',
            'sub_module' => 'Komposisi Employee',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Join & Terminate Report',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, job_title, location, termination'
        ]);
        
        return view('pages.manage.reports.komposisi_emp.join_terminate', compact('joinedEmployees', 'terminatedEmployees'));
    }
}
