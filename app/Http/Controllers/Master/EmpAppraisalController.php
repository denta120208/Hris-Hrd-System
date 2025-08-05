<?php

namespace App\Http\Controllers\Master;

use App\Models\Master\Appraisal9Box;
use Illuminate\Http\Request;

use Session, DB, Log;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Master\Appraisal, App\Models\Master\AppraisalCategory, App\Models\Master\AppraisalType, App\Models\Master\AppraisalValue;
use App\Models\Master\Employee, App\Models\Employee\EmpAppraisal, App\Models\Employee\EmpAppraisalType, App\Models\Employee\EmpAppraisalValue;
use App\Models\Employee\EmpEvaluator, App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion, App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation;

class EmpAppraisalController extends Controller{
    protected $emp;
    protected $empAppraisal;
    protected $appraisal;
    protected $appraisalCat;
    protected $appraisalType;
    protected $appraisalValue;
    protected $appraisalEmpValue;
    protected $empAppraisalType;
    protected $train;
    protected $edu;
    protected $eReward;
    protected $ePromot;
    public function __construct(Employee $emp,EmpAppraisal $empAppraisal,Appraisal $appraisal, AppraisalCategory $appraisalCat,AppraisalType $appraisalType
    , AppraisalValue $appraisalValue, EmpAppraisalType $empAppraisalType, EmpAppraisalValue $appraisalEmpValue, EmpEvaluator $empEvaluator,
    EmployeeTranning $train, EmpEducation $edu, EmpReward $eReward, EmpPromotion $ePromot){
        $this->emp = $emp;
        $this->empAppraisal = $empAppraisal;
        $this->appraisal = $appraisal;
        $this->appraisalCat = $appraisalCat;
        $this->appraisalType = $appraisalType;
        $this->appraisalValue = $appraisalValue;
        $this->empAppraisalType = $empAppraisalType;
        $this->appraisalEmpValue = $appraisalEmpValue;
        $this->empEvaluator = $empEvaluator;
        $this->train = $train;
        $this->edu = $edu;
        $this->eReward = $eReward;
        $this->ePromot = $ePromot;
        parent::__construct();
    }
    public function index(){
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $year = $project->appraisal_year_period;
        
        $subs = DB::select("
        SELECT distinct employee.emp_number as emp_number_karyawan, emp_evaluator.emp_number, emp_evaluator.emp_evaluation, emp_evaluator.evaluator_status,
        ISNULL((SELECT distinct appraisal_status 
	from emp_appraisal
	where emp_number = emp_evaluator.emp_evaluation
        and emp_evaluator = emp_evaluator.emp_number
	and period = location.appraisal_year_period),1) as appraisal_status,
        employee.employee_id,location.appraisal_year_period, employee.emp_firstname, employee.emp_middle_name, employee.emp_lastname,
        ISNULL((SELECT emp_value 
                        from emp_appraisal_value 
                        where emp_number = emp_evaluator.emp_evaluation
                        and period = location.appraisal_year_period
                        ),0) as emp_value, 
        ISNULL((SELECT sup_value
                        from emp_appraisal_value 
                        where emp_number = emp_evaluator.emp_evaluation
                        and period = location.appraisal_year_period
                        ),0) as sup_value,
        ISNULL((SELECT dir_value 
                        from emp_appraisal_value 
                        where emp_number = emp_evaluator.emp_evaluation
                        and period = location.appraisal_year_period
                        ),0) as dir_value,
        ISNULL((SELECT hrd_value 
                        from emp_appraisal_value 
                        where emp_number = emp_evaluator.emp_evaluation
                        and period = location.appraisal_year_period
                        ),0) as hrd_value,
        ISNULL((SELECT appraisal_value FROM emp_appraisal_evaluator
                        where emp_number = emp_evaluator.emp_evaluation
                        and emp_evaluator = emp_evaluator.emp_number
                        and period = location.appraisal_year_period
                        ),0) as appraisal_value
        FROM emp_evaluator INNER JOIN employee ON emp_evaluator.emp_evaluation = employee.emp_number 
        LEFT JOIN emp_appraisal ON emp_evaluator.emp_number = emp_appraisal.emp_evaluator AND emp_evaluator.emp_evaluation = emp_appraisal.emp_number 
        LEFT JOIN emp_appraisal_value ON emp_evaluator.emp_evaluation = emp_appraisal_value.emp_number
        LEFT JOIN location ON employee.location_id = location.id
        WHERE emp_evaluator.emp_number = '".$emp->emp_number."'
        and location.appraisal_year_period = '".$year."'
        and emp_evaluator.is_delete = 0
        GROUP BY employee.emp_number, emp_evaluator.emp_number, emp_evaluator.emp_evaluation, emp_evaluator.evaluator_status,emp_appraisal.appraisal_status, employee.employee_id,
        location.appraisal_year_period,employee.emp_firstname, employee.emp_middle_name, employee.emp_lastname,
        emp_appraisal_value.emp_value, emp_appraisal_value.sup_value, emp_appraisal_value.dir_value, emp_appraisal_value.hrd_value
        ");        
        
        \DB::table('log_activity')->insert([
            'action' => 'View Employee Appraisal',
            'module' => 'Master',
            'sub_module' => 'View Employee Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'View Employee Appraisal ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname.', accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator'
        ]);
        
        return view('pages.appraisals.index', compact('emp', 'subs'));
    }
    public function getAppraisal(Request $request){
        $now = date("Y-m-d H:i:s");
        $appraisals = DB::select("
            SELECT appraisal.*, emp_appraisal.appraisal_value FROM appraisal LEFT JOIN emp_appraisal
            ON appraisal.id = emp_appraisal.appraisal_id
            WHERE appraisal.type_code = '".$request->type_code."'
        ");
        
        \DB::table('log_activity')->insert([
            'action' => 'Get Appraisal',
            'module' => 'Master',
            'sub_module' => 'Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'Get Appraisal , accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'appraisal, emp_apraisal'
        ]);
        return view('partials.appraisal.emp.add', compact('appraisals'));
    }
    public function appraisal($id) {
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $empEvaluator = $this->emp->where('employee_id', Session::get('username'))->first();
        $evaluator = $empEvaluator->emp_number;
        $now = date("Y-m-d H:i:s");
        $tgl_now = date("Y-m-d");
        $tgl_mundur = date("Y-m-d", strtotime("-5 years", strtotime($tgl_now)));
        $year = $project->appraisal_year_period;
        $emp_number = $id;
        $emp = $this->emp->where('emp_number', $id)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $id)->first();
        $type = $this->empAppraisalType->where('emp_number', $id)->first();
        $eRewards = $this->eReward->where('emp_number', $id)->orderBy('id')->get();

        $ePromots = $this->ePromot->where('emp_number', $id)->where('promo_pnum', Session::get('pnum'))
            ->where('promo_ptype', Session::get('ptype'))->orderBy('id')->get();

        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->get();

        $ijin = DB::select("
            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
            on ci.comIDIjin = cmi.id
            where ci.comEmpNumber = '".$id."' AND cmi.id <> '4'
            AND ci.comStartDate >= '".$year."-01-01'
            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
        ");

        $code_appraisal = $this->empAppraisalType->join('appraisal_type', 'emp_appraisal_type.appraisal_type_id', '=', 'appraisal_type.id')
            ->select('appraisal_type.code_appraisal')
            ->where('emp_appraisal_type.emp_number', $id)->first();

        $appraisal = $this->appraisal->where('type_code', $code_appraisal->code_appraisal)->get();

        $listAppraisal = DB::select("
            SELECT appraisal_id, appraisal_value,emp_evaluator FROM emp_appraisal
            WHERE period = '".$year."' AND emp_number = ".$id."
            AND emp_evaluator = ".$evaluator);
        
        // $total = DB::select("
        //     SELECT SUM(emp_appraisal.appraisal_value) as total_value,emp_appraisal.emp_evaluator, evaluator_as,
        //     CONCAT(employee.emp_firstname,' ', employee.emp_middle_name,' ', employee.emp_lastname) AS fullname
        //     FROM emp_appraisal INNER JOIN employee ON emp_appraisal.emp_evaluator = employee.emp_number
        //     WHERE emp_appraisal.period = '".$year."' AND emp_appraisal.appraisal_status = '2'
        //     AND emp_appraisal.emp_number = '".$id."'
        //     GROUP BY emp_appraisal.emp_evaluator, emp_appraisal.evaluator_as,
        //     employee.emp_firstname, employee.emp_middle_name, employee.emp_lastname
        // ");

        $total = DB::select("
            SELECT --SUM(emp_appraisal.appraisal_value)as total_value,
            emp_appraisal_evaluator.appraisal_value as total_value,
            emp_appraisal_evaluator.emp_evaluator, evaluator_as,
            CONCAT(employee.emp_firstname,' ', employee.emp_middle_name,' ', employee.emp_lastname) AS fullname
            FROM emp_appraisal_evaluator INNER JOIN employee ON emp_appraisal_evaluator.emp_evaluator = employee.emp_number
            WHERE emp_appraisal_evaluator.period = '".$year."'
            --AND emp_appraisal.appraisal_status = '2'
            AND emp_appraisal_evaluator.emp_number = '".$id."'
            --GROUP BY emp_appraisal_evaluator.emp_evaluator, emp_appraisal_evaluator.evaluator_as,
            --employee.emp_firstname, employee.emp_middle_name, employee.emp_lastname
        ");

        $date_now_absensi = new \DateTime($tgl_now);
        $date_mundur_absensi = new \DateTime($tgl_mundur);

        $arrDataAbsensiEmployee = [];
        while ($date_now_absensi >= $date_mundur_absensi) {
            $dataAbsensiEmployee = \DB::select("
                ;with t1 as (
                    select b.comNIP,a.emp_firstname,a.emp_middle_name,a.emp_lastname,
                    FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
                    convert(char(8),convert(time(0),b.comIn)) as comIn,
                    convert(char(8),convert(time(0),b.comOut)) as comOut,
                    b.comIjin,termination_id,(DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) AS workingHours, a.job_title_code,
                    FORMAT (cast(b.comDate as date), 'dddd') AS HARI,
                    CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code <= 4 AND b.is_claim_ot = 1
                        THEN 1
                    WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code > 4 AND DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) >= 4
                        THEN 1
                    WHEN ((a.job_title_code = '11' OR a.job_title_code = '12' OR a.job_title_code = '13' OR a.job_title_code = '14' OR a.job_title_code = '15' OR a.job_title_code = '16' OR a.job_title_code = '17' OR a.job_title_code = '18') AND (b.comIjin IS NULL OR b.comIjin = '')) -- VICE GENERAL MANAGER Ke Atas
                        THEN 1
                    WHEN (b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND ((DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 8 AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 0)
                        THEN 1
                    WHEN b.comIjin = 'CT CS'
                        THEN 0.5
                    WHEN b.comIjin = 'CB' OR b.comIjin = 'CB CS' OR b.comIjin = 'TL' OR b.comIjin = 'PV' OR b.comIjin = 'L'
                        THEN 1
                    WHEN ((b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 8)
                        THEN 1
                    ELSE
                        0
                    END
                    AS hadir,
                    CASE WHEN b.comIjin = 'CT CS' OR b.comIjin = 'CB CS'
                        THEN 0.5
                    ELSE
                        1
                    END
                    AS hitung
                    from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
                    where a.termination_id = 0
                    and b.comNIP IS NOT NULL
                    and a.emp_status IN (1,2,5)
                    and b.comNIP = '".$emp->employee_id."'
                    and YEAR(b.comDate) = '".$date_now_absensi->format("Y")."'
                )
    
                select b.comNIP,a.emp_firstname,a.emp_middle_name,a.emp_lastname,COUNT(b.comNIP) AS JUMLAH_HARI,
                (SELECT ISNULL(SUM(hadir), 0) FROM t1 WHERE comNIP = b.comNIP) AS TOTAL_KEHADIRAN,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin IS NULL OR comIjin = '') AND comNIP = b.comNIP AND workingHours < 8 AND HARI NOT IN ('Saturday','Sunday')) AS LESS_8_HOUR,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'S' AND comNIP = b.comNIP) AS S,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'I' AND comNIP = b.comNIP) AS I,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'TL' AND comNIP = b.comNIP) AS TL,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CT' OR comIjin = 'CT CS') AND comNIP = b.comNIP) AS CT,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'L' AND comNIP = b.comNIP) AS L,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CL' AND comNIP = b.comNIP) AS CL,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CB' OR comIjin = 'CB CS') AND comNIP = b.comNIP) AS CB,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'OFF' AND comNIP = b.comNIP) AS [OFF],
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CS' AND comNIP = b.comNIP) AS CS,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CH' AND comNIP = b.comNIP) AS CH,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CK' AND comNIP = b.comNIP) AS CK,
                (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'PV' AND comNIP = b.comNIP) AS PV
                from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
                where a.termination_id = 0
                and b.comNIP IS NOT NULL
                and a.emp_status IN (1,2,5)
                and b.comNIP = '".$emp->employee_id."'
                and YEAR(b.comDate) = '".$date_now_absensi->format("Y")."'
                GROUP BY b.comNIP, a.emp_firstname, a.emp_middle_name, a.emp_lastname, a.job_title_code
                ORDER BY b.comNIP
            ");

            if(count($dataAbsensiEmployee) > 0) {
                array_push($arrDataAbsensiEmployee, ["tahun" => $date_now_absensi->format("Y"), "data" => $dataAbsensiEmployee[0]]);
            }

            $date_now_absensi->modify("-1 year");
        }

        \DB::table('log_activity')->insert([
            'action' => 'View Appraisal',
            'module' => 'Master',
            'sub_module' => 'Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'View Appraisal , accessed by '. Session::get('name'),
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'appraisal, emp_apraisal'
        ]);
        
        return view('pages.appraisals.form', compact('emp', 'pic', 'emp_number','listAppraisal',
            'type', 'appraisal', 'total', 'eRewards', 'ePromots','trains', 'edus', 'ijin','year','arrDataAbsensiEmployee'));
    }

    public function setAppraisal(Request $request) {
        $project = DB::table('location')->where('code', Session::get('project'))->first();
        $year = $project->appraisal_year_period; $nilai = 0;

        $now = date("Y-m-d H:i:s");
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $evaluator = DB::table('emp_evaluator')->where('emp_number', $emp->emp_number)->first();

        for ($i = 0; $i < count($request->appraisal_id); $i++) {
            // Mencari data yang sesuai
            $existingRecord = DB::table('emp_appraisal')
                                ->where('emp_number', $request->emp_number)
                                ->where('period', $year)
                                ->where('emp_evaluator', $emp->emp_number)
                                ->where('appraisal_id', $request->appraisal_id[$i])
                                ->first();
        
            $dataToInsertOrUpdate = [
                'emp_number' => $request->emp_number,
                'period' => $year,
                'emp_evaluator' => $emp->emp_number,
                'appraisal_id' => $request->appraisal_id[$i],
                'evaluator_as' => $evaluator->evaluator_status,
                'appraisal_value' => $request->factor[$i],
                'created_at' => $now
            ];
        
            if ($existingRecord) {
                // Jika data sudah ada, lakukan update
                DB::table('emp_appraisal')
                    ->where('emp_number', $request->emp_number)
                    ->where('period', $year)
                    ->where('emp_evaluator', $emp->emp_number)
                    ->where('appraisal_id', $request->appraisal_id[$i])
                    ->update([
                        'evaluator_as' => $evaluator->evaluator_status,
                        'appraisal_value' => $request->factor[$i],
                        'created_at' => $now
                    ]);
            } else {
                // Jika data belum ada, lakukan insert
                DB::table('emp_appraisal')->insert($dataToInsertOrUpdate);
            }
        
            $nilai += $request->factor[$i];
        }

        $this->saveAppraisal($evaluator, $request->emp_number, $year);
        
        \DB::table('log_activity')->insert([
            'action' => 'Set Appraisal',
            'module' => 'Master',
            'sub_module' => 'Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'Set Appraisal ' . $emp->emp_firstname.' '.$emp->emp_middle_name.' '.$emp->emp_lastname,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee, emp_evaluator, emp_appraisal, appraisal_value'
        ]);

        return redirect(route('appraisal'))->with(['succes' => 'Apprail has been submited']);
    }
    
    public function saveAppraisal($evaluator = array(), $emp_number, $year) {
        $now = date("Y-m-d H:i:s");

        $dataNilaiSumEmps = $this->empAppraisal
            ->where('emp_number', $emp_number)
            ->where('evaluator_as', $evaluator->evaluator_status)
            ->where('period','=',$year)
            ->get();

        $nilaiSumEmp = 0;
        foreach($dataNilaiSumEmps as $dataNilaiSumEmp) {
            $nilaiSumEmp += $dataNilaiSumEmp->appraisal_value;
        }
        
        $nilaiEvaluator = $this->empAppraisal
            ->selectRaw('COUNT(DISTINCT emp_evaluator) as distinct_count')
            ->where('emp_number', $emp_number)
            ->where('evaluator_as', $evaluator->evaluator_status)
            ->where('period','=',$year)
            ->value('distinct_count');

        $value = $this->appraisalEmpValue
            ->where('emp_number', $emp_number)
            ->where('period','=',$year)
            ->first();
        
        if ($value) {
            $dataToUpdate = [];
            if ($evaluator->evaluator_status == '1') { // Self Appraisal
                if ($value->emp_value > 0) {
                    $dataToUpdate['emp_value'] = $nilaiSumEmp / $nilaiEvaluator;
                } else {
                    $dataToUpdate['emp_value'] = $nilaiSumEmp;
                }
            } else if ($evaluator->evaluator_status == '2') { // Supervisor Appraisal
                if ($value->sup_value > 0) {
                    $dataToUpdate['sup_value'] = $nilaiSumEmp / $nilaiEvaluator;
                } else {
                    $dataToUpdate['sup_value'] = $nilaiSumEmp;
                }
            } else if ($evaluator->evaluator_status == '3') { // Director Appraisal
                if ($value->dir_value > 0) {
                    $dataToUpdate['dir_value'] = $nilaiSumEmp / $nilaiEvaluator;
                } else {
                    $dataToUpdate['dir_value'] = $nilaiSumEmp;
                }
            } else { // HR Appraisal
                if ($value->hrd_value > 0) {
                    $dataToUpdate['hrd_value'] = $nilaiSumEmp / $nilaiEvaluator;
                } else {
                    $dataToUpdate['hrd_value'] = $nilaiSumEmp;
                }
            }
        
            DB::table('emp_appraisal_value')  // Pastikan tabel yang benar
                ->where('emp_number', $emp_number)
                ->where('period', '=', $year)
                ->update($dataToUpdate);
        }
        else {
            $data = [];
            if ($evaluator->evaluator_status == '1') { // Self Appraisal
                $data = [
                    'emp_number' => $emp_number,
                    'emp_value' => $nilaiSumEmp,
                    'period' => $year
                ];
            } else if ($evaluator->evaluator_status == '2') { // Supervisor Appraisal
                $data = [
                    'emp_number' => $emp_number,
                    'sup_value' => $nilaiSumEmp,
                    'period' => $year
                ];
            } else if ($evaluator->evaluator_status == '3') { // Director Appraisal
                $data = [
                    'emp_number' => $emp_number,
                    'dir_value' => $nilaiSumEmp,
                    'period' => $year
                ];
            } else { // HR Appraisal
                $data = [
                    'emp_number' => $emp_number,
                    'hrd_value' => $nilaiSumEmp,
                    'period' => $year
                ];
            }
            
            DB::table('emp_appraisal_value')
                ->insert($data);
        }

        // Ambil nilai detail appraisal per evaluator
        $dataNilaiSumEmpApprEvals = $this->empAppraisal
            ->where('emp_number', $emp_number)
            ->where('emp_evaluator', $evaluator->emp_number)
            ->where('evaluator_as', $evaluator->evaluator_status)
            ->where('period', '=', $year)
            ->get();

        $nilaiSumEmpApprEval = 0;
        foreach($dataNilaiSumEmpApprEvals as $dataNilaiSumEmpApprEval) {
            $nilaiSumEmpApprEval += $dataNilaiSumEmpApprEval->appraisal_value;
        }

        // Ambil data employee appraisal evaluator
        $dataEmpAppraisalEvaluator = \DB::table("emp_appraisal_evaluator")
            ->where('emp_number', $emp_number)
            ->where('emp_evaluator', $evaluator->emp_number)
            ->where('evaluator_as', $evaluator->evaluator_status)
            ->where('period', '=', $year)
            ->first();

        // Jika belum ada data employee appraisal evaluator maka insert data baru
        if(empty($dataEmpAppraisalEvaluator->id)) {
            $dataEmpAppraisalType = \DB::table("emp_appraisal_type")->where("emp_number", $emp_number)->where("is_delete", 0)->first();

            \DB::table("emp_appraisal_evaluator")->insert([
                "emp_number" => $emp_number,
                "emp_evaluator" => $evaluator->emp_number,
                "evaluator_as" => $evaluator->evaluator_status,
                "appraisal_type_id" => $dataEmpAppraisalType->appraisal_type_id,
                "appraisal_value" => $nilaiSumEmpApprEval,
                "period" => $year,
                "created_at" => $now
            ]);
        }
        else { // Jika sudah ada data employee appraisal evaluator maka update datanya
            \DB::table("emp_appraisal_evaluator")
                ->where('emp_number', $emp_number)
                ->where('emp_evaluator', $evaluator->emp_number)
                ->where('evaluator_as', $evaluator->evaluator_status)
                ->where('period', '=', $year)
                ->update([
                    "appraisal_value" => $nilaiSumEmpApprEval,
                    "updated_at" => $now
                ]);
        }

        $this->empAppraisal->where('emp_number', $emp_number)->where('emp_evaluator', $evaluator->emp_number)->update([
            'appraisal_status' => '1'
        ]);
    }
    
    public function finalAppraisal($evaluation, $evaluator) {
        $now = date("Y-m-d H:i:s");
        $evaluator = DB::table('emp_evaluator')->where('emp_number', $evaluator)->first();
        $apprEmpValue = $this->appraisalEmpValue->where('emp_number', $evaluation)->first();

        $empAppraisal = $this->empAppraisal->where('emp_number', $apprEmpValue->emp_number)
            ->where('emp_evaluator', $evaluator->emp_number)
            ->first();

        $this->empAppraisal->where('emp_number', $apprEmpValue->emp_number)
            ->where('emp_evaluator', $evaluator->emp_number)
            ->update([
                'appraisal_status' => '2'
            ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'Final Appraisal',
            'module' => 'Master',
            'sub_module' => 'Appraisal',
            'modified_by' => Session::get('name'),
            'description' => 'Final Appraisal ' . $evaluation . ' appraisal_status = 2',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'emp_appraisal_value, emp_evaluator, emp_appraisal'
        ]);

        return redirect()->route('appraisal');
    }
}
