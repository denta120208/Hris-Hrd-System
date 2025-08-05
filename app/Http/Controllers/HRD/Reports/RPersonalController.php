<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session,
    DB,
    Log;
use App\Http\Controllers\Controller;
use App\Models\Master\Employee,
    App\Models\Employee\EmpReward;
use App\Models\Employee\EmpPromotion,
    App\Models\Master\EmployeeTranning;
use App\Models\Employee\EmpEducation,
    App\Models\Punishments\PunishmentRquest;
use App\Models\Promotions\PromotionRquest;
use Carbon\Carbon;
use View;

class RPersonalController extends Controller {

    protected $emp;
    protected $train;
    protected $edu;
    protected $eReward;
    protected $ePromot;
    protected $ePunish;

    public function __construct(Employee $emp, EmployeeTranning $train, EmpEducation $edu, EmpReward $eReward, PromotionRquest $ePromot, PunishmentRquest $ePunish) {
        $this->emp = $emp;
        $this->train = $train;
        $this->edu = $edu;
        $this->eReward = $eReward;
        $this->ePromot = $ePromot;
        $this->ePunish = $ePunish;
        parent::__construct();
    }

    public function index() {
        $now = date('Y-m-d H:i:s');
        if ($this->checkPermission() == false) {
            return redirect(route('auth.logout'))->with('alert-error', "You Unauthorize to Access");
        }
        if (Session::get('pnum') == '1803' && Session::get('ptype') == '01') {
            $emps = $this->emp->where('termination_id','=',0)->get();
        } else {
            $emps = $this->emp->where('termination_id','=',0)->where('pnum', Session::get('pnum'))->where('ptype', Session::get('ptype'))->get();
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Personal Index',
            'module' => 'Report',
            'sub_module' => 'Report Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Personal Index,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.reports.index', compact('emps'));
    }

    public function search_emp(Request $request) {
        $now = date('Y-m-d H:i:s');
        $where = '';
        foreach ($request->except('_token') as $key => $val) {
            if ($request->$key) {
                if ($key == 'emp_name') {
//                    $where .= "emp_firstname LIKE '%" . $val . "%' OR emp_middle_name LIKE '%" . $val . "%' OR emp_lastname LIKE '%" . $val . "%' OR ";
                } else if ($key == 'employee_id') {
                    $where .= $key . " LIKE '%" . $val . "%' AND ";
                } else if ($key == 'termination_id') {
                    if ($val == 1) {
                        $where .= $key . " IN (0) AND ";
                    } else {
                        $where .= $key . " NOT IN (0) AND ";
                    }
                } else {
                    $where .= $key . " = '" . $val . "' AND ";
                }
            }
        }
        $where = rtrim($where, ' AND ');
        $where = rtrim($where, ' OR ');
        if($where != '' ){
            $emps = DB::select("
                SELECT * FROM employee WHERE " . $where . "
            ");
        }else{
            $emps = DB::select("
                SELECT * FROM employee
            ");
        }
        
        
        $emps = collect($emps);
        
        if($request->emp_name != ''){
           $emps = $emps->filter(function($emp) use($request) {
               $emp_name = '';
               if($emp->emp_firstname != ''){
                   $emp_name .= $emp->emp_firstname;
               }
               if($emp->emp_middle_name != ''){
                   $emp_name .= ' '.$emp->emp_middle_name;
               }
               if($emp->emp_lastname != ''){
                   $emp_name .= ' '.$emp->emp_lastname;
               }
                if(str_contains(strtolower($emp_name),strtolower($request->emp_name))) {
                    return $emp;
                }
            })->values()->toArray();
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Search Employee Index',
            'module' => 'Report',
            'sub_module' => 'Report Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Search Employee Index,',
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.reports.search', compact('emps'));
    }

    public function view($id) {
        $now = date('Y-m-d H:i:s');
        $year = date("Y", strtotime('-2 year'));
        $emp = $this->emp->where('emp_number', $id)->first();
        
        $pic = DB::table('emp_picture')->where('emp_number', $id)->first();
        $eRewards = $this->eReward->where('emp_number', $id)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('sub_emp_number', $id)->where('pro_status', '3')->orderBy('id')->get();
        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->orderBy('year', 'ASC')->get();
        $punishs = $this->ePunish->where('sub_emp_number', $id)->where('punish_status', '3')->orderBy('id')->get();
        
        // Get data karyawan join dalam 1 bulan terakhir
        $joinedEmployees = DB::table('employee')
            ->select('employee.*', 'job_title.job_title')
            ->leftJoin('job_title', 'employee.job_title_code', '=', 'job_title.id')
            ->where('joined_date', '>=', date('Y-m-d', strtotime('-1 month')))
            ->where('termination_id', '=', 0)
            ->orderBy('joined_date', 'desc')
            ->get();

        // Get data karyawan terminate dalam 1 bulan terakhir
        $terminatedEmployees = DB::table('employee')
            ->select('employee.*', 'job_title.job_title', 'termination.term_date')
            ->leftJoin('job_title', 'employee.job_title_code', '=', 'job_title.id')
            ->leftJoin('termination', 'employee.termination_id', '=', 'termination.id')
            ->where('termination.term_date', '>=', date('Y-m-d', strtotime('-1 month')))
            ->where('termination_id', '>', 0)
            ->orderBy('termination.term_date', 'desc')
            ->get();

        $ijin = DB::connection('websen')->select("
            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
            on ci.comIDIjin = cmi.id INNER JOIN com_member cm
            on ci.comIDKaryawan = cm.id
            where cm.comNIP = '" . $emp->employee_id . "' AND cmi.id <> '4'
            AND ci.comDate >= '" . $year . "-01-01'
            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
        ");

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Employee Detail',
            'module' => 'Report',
            'sub_module' => 'Report Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Employee Detail, employee number ' . $id,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'employee'
        ]);

        return view('pages.manage.reports.view', compact('emp', 'pic', 'ijin', 'edus', 'trains', 'eRewards', 'ePromots', 'punishs', 'joinedEmployees', 'terminatedEmployees'));
    }

//     public function printPersonal(Request $request){
//         $yos = '';
//         $img = asset('images\personal\FOTO_DEFAULT.gif');
//         $year = date("Y", strtotime('-2 year'));
//         $emp = $this->emp->where('emp_number', $request->emp_number)->first();
//         $emp_birthday = date('d-m-Y', strtotime(substr($emp->emp_birthday, 0, 11)));
//         $pic = DB::table('emp_picture')->where('emp_number', $request->emp_number)->first();
//         $eRewards = $this->eReward->where('emp_number', $request->emp_number)->orderBy('id')->get();
//         $ePromots = $this->ePromot->where('sub_emp_number', $request->emp_number)->orderBy('id')->get();
// //        $ijin = DB::select("
// //            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
// //            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
// //            on ci.comIDIjin = cmi.id
// //            where ci.comEmpNumber = '" . $request->emp_number . "' AND cmi.id <> '4'
// //            AND ci.comStartDate >= '" . $year . "-01-01'
// //            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
// //        ");
//         $ijin = DB::connection('websen')->select("
//             select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
//             FROM com_ijin ci INNER JOIN com_master_perijinan cmi
//             on ci.comIDIjin = cmi.id INNER JOIN com_member cm
//             on ci.comIDKaryawan = cm.id
//             where cm.comNIP = '".$emp->employee_id."' AND cmi.id <> '4'
//             AND ci.comDate >= '".$year."-01-01'
//             GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
//         ");
//         $date = new \DateTime($emp->joined_date);
//         $now = new \DateTime();
//         $interval = $now->diff($date);
//         if($interval->y <= 1){
//             $yos = $interval->y.' Year - '.$interval->m.' Months';
//         }else{
//             $yos = $interval->y.' Years -'.$interval->m.' Months';
//         }
//         // return View::make('masterdata.pdfCetakReqUnit1_20221109',
//         //     ['project_no'=>$project_no,'dataProject'=>$dataProject,'datarReqRelease'=>$datarReqRelease,
//         //         'dataReqType'=>$dataReqType,'dateRequest'=>$dateRequest,'dataDetailLampiran'=>$dataDetailLampiran,
//         //         'dataAssign1'=>$dataAssign1,'dataAssign2'=>$dataAssign2,'dataAssign3'=>$dataAssign3,
//         //         'dataAssign4'=>$dataAssign4,'dataAssign5'=>$dataAssign5,'dataAssign6'=>$dataAssign6,
//         //         'dataAssign7'=>$dataAssign7,'dataAssign8'=>$dataAssign8,'dataAssign9'=>$dataAssign9,
//         //         'dataAssign10'=>$dataAssign10,'dataAssign11'=>$dataAssign11,'dataDetailReyType'=>$dataDetailReyType]);
//         $view = "
//         <table border='1'><tr>
//                 <td>
//         ";
//         if ($pic) {
//             if ($pic) {
//                 if($pic->epic_picture_type == '2')
//                 {
//                     $view .= "<img style='height: 150px;'  class='img-responsive img-thumbnail' 
//                             src='data:image/jpeg;base64,". base64_encode($pic->epic_picture) . "'/></td>";
//                 }
//                 elseif($pic->epic_picture_type == '1')
//                 {
//                     $view .= "<img style='height: 150px;'  class='img-responsive img-thumbnail' 
//                                 src='data:image/jpeg;base64,". $pic->epic_picture . "'/></td>";
//                 }
//             } else {
//                 $view .= "<img src='" . $img . "'>
//                     </td>";
//             }
//             // $view .= "<img style='height: 150px;' src='data:image/jpeg;base64," . base64_encode($pic->epic_picture) . "'/>
//             //     </td>";
//         } else {
//             $view .= "<img src='" . $img . "'>
//                 </td>";
//         }
//         $view .= "<td><table><tr>
// 		<td style='font-weight: bold'>Employee Name</td>
// 		<td></td>
// 		<td>" . $emp->emp_firstname . " " . $emp->emp_middle_name . " " . $emp->emp_lastname . "</td>
// 	</tr><tr>
// 		<td style='font-weight: bold'>DOB</td>
// 		<td></td>
// 		<td>" . $emp_birthday . "</td>
// 	</tr><tr>
// 		<td style='font-weight: bold'>Period of Employment</td>
// 		<td></td>
// 		<td>" . $yos . "</td>
// 	</tr><tr>
// 		<td style='font-weight: bold'>Job Level</td>
// 		<td></td>
// 		<td>" . $emp->job_title->job_title . "</td>
// 	</tr></table></td>
// </tr></table>
// <h4>Attendance</h4>
// <table border='0'>
//     <thead>
//         <tr>
//             <th>No</th>
//             <th>Name</th>
//             <th>Code</th>
//             <th>Count</th>
//         </tr>
//     </thead>
//     <tbody>";
//         if (!empty($ijin)){
//             $no = 1;
//             foreach ($ijin as $row) {
//                 $view .= "
//     <tr>
//         <td>" . $no . "</td>
//         <td>" . $row->keterangan . "</td>
//         <td>" . $row->comIjin . "</td>
//         <td>" . $row->id . "</td>
//     </tr>
//     ";
//                 $no++;
//             }
//         }else{
//             $view .= "<td colspan='4'>No Data</td>";
//         }
//         $view .= "
// </tbody>
// </table>
// <h4>Rewards</h4>
// <table border='0'>
//     <thead>
//     <tr>
//         <th>No</th>
//         <th>Reward Type</th>
//         <th>Year</th>
//     </tr>
//     </thead>
//     <tbody>";
//         if(!$eRewards->isEmpty()) {
//             $no = 1;
//             foreach ($eRewards as $row) {
//                 $view .= "
//                 <tr>
//                     <td>".$no."</td>
//                     <td>".$row->reward_name->name."</td>
//                     <td>".$row->year_reward."</td>
//                 </tr>
//                 ";
//                 $no++;
//             }
//         }else{
//             $view .= "<td colspan='3'>No Data</td>";
//         }
//         $view .= "
// </tbody>
// </table>
// <h4>Demotion</h4>
// <table border='0'>
//     <thead>
//     <tr>
//         <th>No</th>
//         <th>Demotion Date</th>
//         <th>From</th>
//         <th>To</th>
//     </tr>
//     </thead>
//     <tbody>";
//         if(!$ePromots->isEmpty()){
//             $no = 1;
//             foreach($ePromots as $row){
//                 $view .= "
//                 <tr>
//                     <td>".$no."</td>
//                     <td>".$row->promotion_date."</td>
//                     <td>".$row->promotion_from."</td>
//                     <td>".$row->promotion_to."</td>
//                 </tr>
//                 ";
//                 $no++;
//             }
//         }else{
//             $view .= "<tr><td colspan='6'>No Data</td></tr>";
//         }
//         $view .= "
// </tbody>
// </table>
//     <h4>Punishment</h4>
//     <table border='0'>
//         <thead>
//         <tr>
//             <th>No</th>
//             <th>Punishment Type</th>
//             <th>Year</th>
//         </tr>
//         </thead>
//         <tbody>
//         <tr><td colspan='3'>No Data</td></tr>
//         </tbody>
//     </table>
// </tbody>
// </table>
// ";
//         return $view;
//     }

    public function printPersonal($emp_number) {
        //dd($emp_number);
        $nowLog = date('Y-m-d H:i:s');
        $yos = '';
        $img = asset('images\personal\FOTO_DEFAULT.gif');
        $year = date("Y", strtotime('-2 year'));
        $emp = $this->emp->where('emp_number', $emp_number)->first();
        $emp_birthday = date('d-m-Y', strtotime(substr($emp->emp_birthday, 0, 11)));
        $pic = DB::table('emp_picture')->where('emp_number', $emp_number)->first();
        $eRewards = $this->eReward->where('emp_number', $emp_number)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('sub_emp_number', $emp_number)->orderBy('id')->get();
        $trains = $this->train->where('emp_number', $emp_number)->get();
        $edus = $this->edu->where('emp_number', $emp_number)->orderBY('year', 'ASC')->get();

//        $ijin = DB::select("
//            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
//            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
//            on ci.comIDIjin = cmi.id
//            where ci.comEmpNumber = '" . $request->emp_number . "' AND cmi.id <> '4'
//            AND ci.comStartDate >= '" . $year . "-01-01'
//            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
//        ");
        $ijin = DB::connection('websen')->select("
            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
            on ci.comIDIjin = cmi.id INNER JOIN com_member cm
            on ci.comIDKaryawan = cm.id
            where cm.comNIP = '" . $emp->employee_id . "' AND cmi.id <> '4'
            AND ci.comDate >= '" . $year . "-01-01'
            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
        ");

        $ePunish = DB::select("Select d.employee_id,FORMAT(a.hrd_approved_at,'dd-MM-yyyy') as hrd_approved_at,c.name as punish_type,a.punish_reason
        from emp_punishment_request as a INNER JOIN punishment_status as b ON a.punish_type = b.id
        INNER JOIN punishment_type as c ON a.punish_type = c.id
        INNER JOIN employee as d ON a.sub_emp_number = d.emp_number
        where a.punish_status = 3
        and a.sub_emp_number = " . $emp_number . "
        ORDER BY a.hrd_approved_at");

        $eAppraisal = DB::select("select * 
                                from emp_appraisal_result
                                where emp_number = " . $emp_number . "
                                and cast(years as int) between YEAR(GETDATE())-5 and YEAR(GETDATE()) 
                                ORDER BY cast(years as int) ASC");

        $date = new \DateTime($emp->joined_date);
        $now = new \DateTime();
        $interval = $now->diff($date);

        if ($interval->y <= 1) {
            $yos = $interval->y . ' Year - ' . $interval->m . ' Months';
        } else {
            $yos = $interval->y . ' Years -' . $interval->m . ' Months';
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Personal',
            'module' => 'Report',
            'sub_module' => 'Print Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Personal, employee number ' . $emp_number,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);

        return View::make('pages.manage.reports.printPersonal',
                        ['pic' => $pic, 'emp' => $emp, 'emp_birthday' => $emp_birthday, 'yos' => $yos,
                            'ijin' => $ijin, 'eRewards' => $eRewards, 'ePromots' => $ePromots,
                            'ePunish' => $ePunish, 'edus' => $edus, 'trains' => $trains,
                            'eAppraisal' => $eAppraisal]);
    }

    public function printPersonalbod($emp_number, $id_request) {
        //dd($emp_number);
        $nowLog = date('Y-m-d H:i:s');
        $yos = '';
        $img = asset('images\personal\FOTO_DEFAULT.gif');
        $year = date("Y", strtotime('-2 year'));
        $emp = $this->emp->where('emp_number', $emp_number)->first();
        $emp_birthday = date('d-m-Y', strtotime(substr($emp->emp_birthday, 0, 11)));
        $pic = DB::table('emp_picture')->where('emp_number', $emp_number)->first();
        $eRewards = $this->eReward->where('emp_number', $emp_number)->orderBy('id')->get();
        $ePromots = $this->ePromot->where('sub_emp_number', $emp_number)->orderBy('id')->get();
        $trains = $this->train->where('emp_number', $emp_number)->get();
        $edus = $this->edu->where('emp_number', $emp_number)->orderBY('year', 'ASC')->get();

//        $ijin = DB::select("
//            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
//            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
//            on ci.comIDIjin = cmi.id
//            where ci.comEmpNumber = '" . $request->emp_number . "' AND cmi.id <> '4'
//            AND ci.comStartDate >= '" . $year . "-01-01'
//            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
//        ");
        $ijin = DB::connection('websen')->select("
            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
            on ci.comIDIjin = cmi.id INNER JOIN com_member cm
            on ci.comIDKaryawan = cm.id
            where cm.comNIP = '" . $emp->employee_id . "' AND cmi.id <> '4'
            AND ci.comDate >= '" . $year . "-01-01'
            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
        ");

        $ePunish = DB::select("Select d.employee_id,FORMAT(a.hrd_approved_at,'dd-MM-yyyy') as hrd_approved_at,c.name as punish_type,a.punish_reason
        from emp_punishment_request as a INNER JOIN punishment_status as b ON a.punish_type = b.id
        INNER JOIN punishment_type as c ON a.punish_type = c.id
        INNER JOIN employee as d ON a.sub_emp_number = d.emp_number
        where a.punish_status = 3
        and a.sub_emp_number = " . $emp_number . "
        ORDER BY a.hrd_approved_at");

        $eAppraisal = DB::select("select * 
                                from emp_appraisal_result
                                where emp_number = " . $emp_number . "
                                and cast(years as int) between YEAR(GETDATE())-5 and YEAR(GETDATE()) 
                                ORDER BY cast(years as int) ASC");

        $date = new \DateTime($emp->joined_date);
        $now = new \DateTime();
        $interval = $now->diff($date);

        if ($interval->y <= 1) {
            $yos = $interval->y . ' Year - ' . $interval->m . ' Months';
        } else {
            $yos = $interval->y . ' Years -' . $interval->m . ' Months';
        }

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Personal Bod',
            'module' => 'Report',
            'sub_module' => 'Print Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Personal Bod, employee number ' . $emp_number,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);

        return View::make('pages.manage.reports.printPersonalBOD2',
                        ['pic' => $pic, 'emp' => $emp, 'emp_birthday' => $emp_birthday, 'yos' => $yos,
                            'ijin' => $ijin, 'eRewards' => $eRewards, 'ePromots' => $ePromots,
                            'ePunish' => $ePunish, 'edus' => $edus, 'trains' => $trains,
                            'eAppraisal' => $eAppraisal, 'id_request' => $id_request]);
    }

    public function qualification($id) {
        $trains = $this->train->where('emp_number', $id)->get();
        $edus = $this->edu->where('emp_number', $id)->get();
    }

    public function printQualification(Request $request) {
        $nowLog = date('Y-m-d H:i:s');
        $yos = '';
        $img = asset('images\personal\FOTO_DEFAULT.gif');
        $year = date("Y");
        $emp = $this->emp->where('emp_number', $request->emp_number)->first();
        $pic = DB::table('emp_picture')->where('emp_number', $request->emp_number)->first();
        $trains = $this->train->where('emp_number', $request->emp_number)->get();
        $edus = $this->edu->where('emp_number', $request->emp_number)->get();

        $ijin = DB::select("
            select count(cmi.id) as id, cmi.comIjin, CAST(cmi.keterangan as varchar(250)) as keterangan
            FROM com_ijin ci INNER JOIN com_master_perijinan cmi
            on ci.comIDIjin = cmi.id
            where ci.comEmpNumber = '" . $request->emp_number . "' AND cmi.id <> '4'
            AND ci.comStartDate >= '" . $year . "-01-01'
            GROUP BY cmi.comIjin, CAST(cmi.keterangan as varchar(250))
        ");
        $date = new \DateTime($emp->joined_date);
        $now = new \DateTime();
        $interval = $now->diff($date);
        if ($interval->y <= 1) {
            $yos = $interval->m . ' Months - ' . $interval->y . ' Year';
        } else {
            $yos = $interval->m . ' Months - ' . $interval->y . ' Years';
        }
        $view = "
        <table border='0'><tr>
                <td>
        ";
        if ($pic) {
            $view .= "<img style='height: 150px;' src='data:image/jpeg;base64," . base64_encode($pic->epic_picture) . "'/>
                </td>";
        } else {
            $view .= "<img src='" . $img . "'>
                </td>";
        }
        $view .= "<td><table><tr>
		<td style='font-weight: bold'>Employee Name</td>
		<td></td>
		<td>" . $emp->emp_firstname . " " . $emp->emp_middle_name . " " . $emp->emp_lastname . "</td>
	</tr><tr>
		<td style='font-weight: bold'>DOB</td>
		<td></td>
		<td>" . $emp->emp_birthday . "</td>
	</tr><tr>
		<td style='font-weight: bold'>Years of Service</td>
		<td></td>
		<td>" . $yos . "</td>
	</tr><tr>
		<td style='font-weight: bold'>Job Level</td>
		<td></td>
		<td>" . $emp->job_title->job_title . "</td>
	</tr></table></td>
</tr></table>
<h4>Education</h4>
<table border='0'>
    <thead>
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Institution Name</th>
        <th>Major</th>
        <th>Start Date</th>
        <th>End Date</th>
    </tr>
    </thead>
    <tbody>";
        if (!empty($edus)) {
            $no = 1;
            foreach ($edus as $row) {
                $view .= "
                <tr>
                    <td>" . $no . "</td>
                    <td>" . $row->education->name . "</td>
                    <td>" . $row->institute . "</td>
                    <td>" . $row->major . "</td>
                    <td>" . $row->start_date . "</td>
                    <td>" . $row->end_date . "</td>
                </tr>
                ";
                $no++;
            }
        } else {
            $view .= "<tr><td colspan='5'>No Data</td></tr>";
        }

        $view .= "
</tbody>
</table>
<h4>Training</h4>
<table border='0'>
    <thead>
    <tr>
        <th>No</th>
        <th>Training Name</th>
        <th>Sertificate No</th>
        <th>Sertificate Date</th>
        <th>Expired Date</th>
    </tr>
    </thead>
    <tbody>";
        if (!empty($trains)) {
            $no = 1;
            foreach ($trains as $row) {
                $view .= "
                <tr>
                    <td>" . $no . "</td>";
                if ($row->license_id == 1) {
                    $view .= "<td>" . $row->train_name . "</td>";
                } else {
                    $view .= "<td>" . $row->trainning->name . "</td>";
                }
                $view .= "
                    <td>" . $row->license_no . "</td>
                    <td>" . $row->license_issued_date . "</td>
                    <td>" . $row->license_expiry_date . "</td>
                </tr>
                ";
                $no++;
            }
        } else {
            $view .= "<tr><td colspan='5'>No Data</td></tr>";
        }
        $view .= "
</tbody>
    </table>
    <h4>Mutations</h4>
    <table border='0'>
        <thead>
        <tr>
            <th>No</th>
            <th>Mutation From</th>
            <th>Mutation To</th>
            <th>Year</th>
        </tr>
        </thead>
        <tbody>
        <tr><td colspan='4'>No Data</td></tr>
        </tbody>
    </table>
        ";

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Qualification',
            'module' => 'Report',
            'sub_module' => 'Print Personal',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Qualification, employee number ' . $request->emp_number,
            'created_at' => $nowLog,
            'updated_at' => $nowLog,
            'table_activity' => 'employee'
        ]);
        return $view;
    }
}
