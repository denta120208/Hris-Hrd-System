<?php

namespace App\Http\Controllers\HRD\Reports;

use Illuminate\Http\Request;

use App\Http\Requests;
use Session, DB, Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class AppraisalController extends Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function index() {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        $project = DB::table('location')->where('code', Session::get('project'))->first();

        if (Session::get('project') == 'HO') {
            $dataLocation = DB::table('location')->get();
        } else {
            $dataLocation = DB::table('location')->where('code', Session::get('project'))->get();
        }

        $dataDirOpsId = \DB::table("job_department")->whereIn('id', array(508,509,510,511,512))->get();
        
        $location_id = NULL;
        $dirops_dept_id = NULL;
        $periodYear = NULL;

        $viewData = 0;

        $dataAppraisal = [];
        $param = [
            "location_id" => NULL,
            "dirops_dept_id" => NULL,
            "periodYear" => NULL
        ];
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Appraisal Index',
            'module' => 'Report',
            'sub_module' => 'Appraisal Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Appraisal Index ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'location, job_department'
        ]);
        
        return view('pages.manage.reports.appraisal.appraisal', compact('viewData','location_id','dirops_dept_id','periodYear','year','dataLocation','dataDirOpsId','dataAppraisal','param'));
    }

    public function viewDataAppraisal(Request $request) {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        if (Session::get('project') == 'HO') {
            $dataLocation = DB::table('location')->get();
        } else {
            $dataLocation = DB::table('location')->where('code', Session::get('project'))->get();
        }
        $dataDirOpsId = \DB::table("job_department")->whereIn('id', array(508,509,510,511,512))->get();

        $periodYear = $request->periodYear;

        $viewData = 1;

        if (Session::get('project') == 'HO') {
            if(!empty($request->location_id)) {
                $dataWhereDirOps = \DB::table("dirops_project")
                    ->where('dirops_dept_id','=',$request->dirops_dept_id)
                    ->where('location_id','=',$request->location_id)
                    ->get();
    
                $location_id = $request->location_id;
            }
            else {
    
                $dataWhereDirOps = \DB::table("dirops_project")
                    ->where('dirops_dept_id','=',$request->dirops_dept_id)
                    ->whereNotIn('location_id', array(1))
                    ->get();
                
                $location_id = 0;
            }
        } else {
            if(!empty($request->location_id)) {
                $dataWhereDirOps = \DB::table("dirops_project")
                    ->where('dirops_dept_id','=',$request->dirops_dept_id)
                    ->where('location_id','=',$request->location_id)
                    ->get();
    
                $location_id = $request->location_id;
            }
            else {
                return redirect()->route('hrd.appraisal_emp')->withErrors(['error' => 'Please Select Project']);
            }
        }

        if (!empty($request->dirops_dept_id)) {
            $dirops_dept_id = $request->dirops_dept_id;
        }
        else {
            $dirops_dept_id = 0;
        }

        if(empty($request->location_id) && empty($request->dirops_dept_id) &&
            empty($request->periodYear)) {
            $whereAnd = "";
        }
        else {
            $whereAnd = "AND";
        }

        if(!empty($request->location_id)) {
            if(empty($request->dirops_dept_id)) {
                $whereAnd .= " a.location_id = '".$request->location_id."' AND";
            }
        }

        // if(!empty($request->dirops_dept_id)) {
        //     if(!empty($request->location_id)) {
        //         foreach($dataWhereDirOps as $dirOps) {
        //             if($dirOps->location_id == 1) {
        //                 $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND ".$dirOps->division." AND";
        //             }
        //             else {
        //                 $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND";
        //             }
        //         }
        //     }
        //     else {
        //         $loc_id = '';
        //         $division = '';
        //         foreach($dataWhereDirOps as $dirOps) {
        //             if($dirOps->location_id <> 0) {
        //                 $loc_id .= $dirOps->location_id.",";
        //             }
        //             $division .= $dirOps->division;
        //         }
        //         $whereAnd .= " ((".$division.") OR a.location_id in (".substr($loc_id, 0, -1).")) AND";
        //     }
        // }

        if(!empty($request->periodYear)) {
            $whereAnd .= " h.period = '".$request->periodYear."' AND";
            $year = $request->periodYear;
        }

        $whereAnd = $whereAnd == "" ? $whereAnd : substr($whereAnd, 0, -4);
        // dd($whereAnd);
        $dataAppraisal = \DB::select("SELECT final_result.location_name,final_result.nik,final_result.emp_fullname,final_result.division,
                                        final_result.department,final_result.employment_status,final_result.code_appraisal,final_result.nilai_awal,
                                        final_result.item_pengurangan,
                                        --(final_result.nilai_awal - final_result.item_pengurangan) as nilai_akhir,
                                        final_result.period_year,final_result.count_evaluator,final_result.count_evaluator_submit,
                                        final_result.count_eval_submit_draft,
                                        (
                                            CASE WHEN (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0) THEN 'Final' ELSE 'Not Final Yet' END
                                        ) as status_appraisals,
                                        final_result.joined_date,
                                        final_result.emp_number,final_result.job_title_code,final_result.job_title,final_result.termination_id
                                        FROM (
                                            SELECT a.emp_number, b.name as location_name, a.employee_id as nik, a.emp_fullname, d.name as division, 
                                            e.job_dept_desc as department, c.name as employment_status, ISNULL(g.code_appraisal,'-') as code_appraisal, 
                                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            ELSE 
                                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            END as nilai_awal, 
                                            --0 as item_pengurangan, 
                                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            ELSE 
                                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            END as nilai_akhir, 
                                            ISNULL(h.period,'-') as period_year,
                                            (
                                                SELECT COUNT(*)
                                                FROM emp_evaluator AS ev
                                                WHERE ev.emp_evaluation = a.emp_number
                                                and ev.is_delete = 0
                                            ) as count_evaluator,
                                            (
                                                SELECT COUNT(*)
                                                FROM (
                                                    SELECT COUNT(eapp1.emp_evaluator) as temp_count
                                                    FROM emp_appraisal AS eapp1
                                                    WHERE eapp1.emp_number = a.emp_number
                                                    AND eapp1.period = h.period
                                                    GROUP BY eapp1.emp_evaluator
                                                ) as temp_count_submit
                                            ) as count_evaluator_submit,
                                            (
                                                SELECT COUNT(*)
                                                FROM emp_appraisal AS eapp
                                                WHERE eapp.emp_number = a.emp_number
                                                AND eapp.period = h.period
                                                AND appraisal_status <> 2
                                            ) as count_eval_submit_draft,
                                            (
                                                Select ISNULL(SUM(pns_score.score),0) as total_score
                                                from (
                                                    Select a.sub_emp_number,a.emp_id,a.punish_type,b.job_title_code,isnull(c.score,0) as score
                                                    from emp_punishment_request as a LEFT JOIN employee as b ON a.sub_emp_number = b.emp_number
                                                    LEFT JOIN appraisal_stsp_score as c ON a.punish_type = c.punish_type_id AND  b.job_title_code = c.job_title_id
                                                    where a.punish_status = 3
                                                    and YEAR(hrd_approved_at) =  $periodYear
                                                ) as pns_score
                                                where pns_score.sub_emp_number = a.emp_number
                                            ) as item_pengurangan,
                                            a.joined_date,a.job_title_code,i.job_title,a.termination_id
                                            FROM employee AS a
                                            LEFT JOIN location AS b ON a.location_id = b.id
                                            LEFT JOIN employment_status AS c ON a.emp_status = c.id
                                            LEFT JOIN job_category AS d ON a.eeo_cat_code = d.id
                                            LEFT JOIN job_department AS e ON a.job_dept_id = e.id
                                            LEFT JOIN emp_appraisal_type AS f ON a.emp_number = f.emp_number
                                            LEFT JOIN appraisal_type AS g ON f.appraisal_type_id = g.id
                                            LEFT JOIN emp_appraisal_value AS h ON a.emp_number = h.emp_number
                                            LEFT JOIN job_title as i ON a.job_title_code = i.id
                                            WHERE a.emp_status IN (1,2,5)
                                            and a.termination_id IN (0)
                                            $whereAnd
                                        ) as final_result
                                        where (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0)
                                        order by final_result.job_title_code DESC, final_result.joined_date ASC");

        foreach($dataAppraisal as $key => $data) {
            $dataAppraisal[$key]->nilai_akhir = $data->nilai_awal - $data->item_pengurangan;

            $evaluators = DB::select("SELECT e.emp_number, ev.evaluator_status, e.emp_firstname, e.emp_middle_name, e.emp_lastname, j.id, j.job_title, e.emp_fullname
                FROM emp_evaluator ev INNER JOIN employee e
                left join job_title as j on j.id = e.job_title_code
                ON ev.emp_number = e.emp_number
                WHERE ev.is_delete = 0
                and ev.emp_evaluation = '".$data->emp_number."'
            ");

            // Fungsi untuk mengurutkan array berdasarkan j.id dan e.emp_fullname
            usort($evaluators, function($a, $b) {
                // Pertama urutkan berdasarkan j.id
                if ($a->id == $b->id) {
                    // Jika j.id sama, urutkan berdasarkan emp_fullname
                    return strcmp($a->emp_fullname, $b->emp_fullname);
                }
                // Jika j.id berbeda, urutkan berdasarkan j.id
                if ($a->id < $b->id) {
                    return -1;
                } elseif ($a->id > $b->id) {
                    return 1;
                }
                return 0;
            });

            $arr_appraisal_value = [];
            foreach($evaluators as $key2 => $item) {
                // $val_appr = DB::select("
                //     SELECT SUM(ea.appraisal_value) AS appraisal_value
                //     FROM emp_appraisal ea
                //     WHERE ea.period = '".$periodYear."' AND ea.emp_number = '".$data->emp_number."' AND
                //     ea.emp_evaluator = '".$item->emp_number."'
                // ");

                $val_appr = DB::select("
                    SELECT ea.appraisal_value
                    FROM emp_appraisal_evaluator ea
                    WHERE ea.period = '".$periodYear."' AND ea.emp_number = '".$data->emp_number."' AND
                    ea.emp_evaluator = '".$item->emp_number."'
                ");

                // $evaluators[$key2]->appraisal_value = empty($val_appr[0]->appraisal_value) ? 0 : $val_appr[0]->appraisal_value;
                array_push($arr_appraisal_value, (empty($val_appr[0]->appraisal_value) ? 0 : (float) $val_appr[0]->appraisal_value));
            }

            $dataAppraisal[$key]->appraisal_value_per_evaluators = count($arr_appraisal_value) <= 0 ? "0" : implode(" | ", $arr_appraisal_value);
        }
        
        $param = [
            "location_id" => $request->location_id,
            "dirops_dept_id" => $request->dirops_dept_id,
            "periodYear" => $request->periodYear
        ];

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Report Appraisal',
            'module' => 'Report',
            'sub_module' => 'Appraisal Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Report Appraisal ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'location, job_department'
        ]);
        
        return view('pages.manage.reports.appraisal.appraisal', compact('viewData','location_id','dirops_dept_id','periodYear','year','dataLocation','dataDirOpsId','dataAppraisal','param'));
    }

    public function printDataAppraisal($location_id,$dirops_dept_id,$periodYear) {
        $now = date('Y-m-d H:i:s');
        $year = date("Y");
        if (Session::get('project') == 'HO') {
            $dataLocation = DB::table('location')->get();
        } else {
            $dataLocation = DB::table('location')->where('code', Session::get('project'))->get();
        }
        $dataDirOpsId = \DB::table("job_department")->whereIn('id', array(508,509,510,511,512))->get();

        $project = Session::get('project');
        $location_id = $location_id;
        $dirops_dept_id = $dirops_dept_id;
        $periodYear = $periodYear;
        
        if(!empty($dirops_dept_id) || $dirops_dept_id <> 0) {
            $diropsDataTemp = \DB::table("job_department")->where('id','=',$dirops_dept_id)->get();
            $diropsData = $diropsDataTemp[0]->job_dept_desc;
        }
        else {
            $diropsData = 'All Dir Ops';
        }
        
        if(!empty($location_id) || $location_id <> 0) {
            $dataWhereDirOps = \DB::table("dirops_project")
                ->where('dirops_dept_id','=',$dirops_dept_id)
                ->where('location_id','=',$location_id)
                ->get();

            $locationDataTemp = \DB::table("location")->where('id','=',$location_id)->get();
            $locationData = $locationDataTemp[0]->name;
        }
        else {
            $dataWhereDirOps = \DB::table("dirops_project")
                ->where('dirops_dept_id','=',$dirops_dept_id)
                ->whereNotIn('location_id', array(1))
                ->get();

            $locationData = 'All Project';
        }

        if((empty($location_id) || $location_id == 0) && (empty($dirops_dept_id) || $dirops_dept_id == 0) &&
            empty($periodYear)) {
            $whereAnd = "";
        }
        else {
            $whereAnd = "AND";
        }

        if(!empty($location_id) || $location_id <> 0) {
            if(empty($dirops_dept_id) || $dirops_dept_id == 0) {
                $whereAnd .= " a.location_id = '".$location_id."' AND";
            }
        }

        if(!empty($dirops_dept_id) || $dirops_dept_id <> 0) {
            if(!empty($location_id) || $location_id <> 0) {
                foreach($dataWhereDirOps as $dirOps) {
                    if($dirOps->location_id == 1) {
                        $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND ".$dirOps->division." AND";
                    }
                    else {
                        $whereAnd .= " a.location_id = '".$dirOps->location_id."' AND";
                    }
                }
            }
            else {
                $loc_id = '';
                $division = '';
                foreach($dataWhereDirOps as $dirOps) {
                    if($dirOps->location_id <> 0) {
                        $loc_id .= $dirOps->location_id.",";
                    }
                    $division .= $dirOps->division;
                }
                $whereAnd .= " ((".$division.") OR a.location_id in (".substr($loc_id, 0, -1).")) AND";
            }
        }

        if(!empty($periodYear)) {
            $whereAnd .= " h.period = '".$periodYear."' AND";
            $year = $periodYear;
        }

        $whereAnd = $whereAnd == "" ? $whereAnd : substr($whereAnd, 0, -4);
        // dd($whereAnd);
        $dataAppraisal = \DB::select("SELECT final_result.location_name,final_result.nik,final_result.emp_fullname,final_result.division,
                                        final_result.department,final_result.employment_status,final_result.code_appraisal,final_result.nilai_awal,
                                        final_result.item_pengurangan,
                                        --(final_result.nilai_awal - final_result.item_pengurangan) as nilai_akhir,
                                        final_result.period_year,final_result.count_evaluator,final_result.count_evaluator_submit,
                                        final_result.count_eval_submit_draft,
                                        (
                                            CASE WHEN (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0) THEN 'Final' ELSE 'Not Final Yet' END
                                        ) as status_appraisals,
                                        final_result.joined_date,
                                        final_result.emp_number,final_result.job_title_code,final_result.job_title,final_result.termination_id
                                        FROM (
                                            SELECT a.emp_number, b.name as location_name, a.employee_id as nik, a.emp_fullname, d.name as division, 
                                            e.job_dept_desc as department, c.name as employment_status, ISNULL(g.code_appraisal,'-') as code_appraisal, 
                                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            ELSE 
                                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            END as nilai_awal, 
                                            --0 as item_pengurangan, 
                                            CASE WHEN ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G') = 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G'
                                                THEN ISNULL(h.sup_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            ELSE 
                                                ISNULL(h.dir_value, 'ZCRMNaF4ko5wKBjtmMCMK+tjpuXQGu6RvG/PLOYXY0dpqvVnc36aBBi/Ag3WtC+G')
                                            END as nilai_akhir, 
                                            ISNULL(h.period,'-') as period_year,
                                            (
                                                SELECT COUNT(*)
                                                FROM emp_evaluator AS ev
                                                WHERE ev.emp_evaluation = a.emp_number
                                                and ev.is_delete = 0
                                            ) as count_evaluator,
                                            (
                                                SELECT COUNT(*)
                                                FROM (
                                                    SELECT COUNT(eapp1.emp_evaluator) as temp_count
                                                    FROM emp_appraisal AS eapp1
                                                    WHERE eapp1.emp_number = a.emp_number
                                                    AND eapp1.period = h.period
                                                    GROUP BY eapp1.emp_evaluator
                                                ) as temp_count_submit
                                            ) as count_evaluator_submit,
                                            (
                                                SELECT COUNT(*)
                                                FROM emp_appraisal AS eapp
                                                WHERE eapp.emp_number = a.emp_number
                                                AND eapp.period = h.period
                                                AND appraisal_status <> 2
                                            ) as count_eval_submit_draft,
                                            (
                                                Select ISNULL(SUM(pns_score.score),0) as total_score
                                                from (
                                                    Select a.sub_emp_number,a.emp_id,a.punish_type,b.job_title_code,isnull(c.score,0) as score
                                                    from emp_punishment_request as a LEFT JOIN employee as b ON a.sub_emp_number = b.emp_number
                                                    LEFT JOIN appraisal_stsp_score as c ON a.punish_type = c.punish_type_id AND  b.job_title_code = c.job_title_id
                                                    where a.punish_status = 3
                                                    and YEAR(hrd_approved_at) =  $periodYear
                                                ) as pns_score
                                                where pns_score.sub_emp_number = a.emp_number
                                            ) as item_pengurangan,
                                            a.joined_date,a.job_title_code,i.job_title,a.termination_id
                                            FROM employee AS a
                                            LEFT JOIN location AS b ON a.location_id = b.id
                                            LEFT JOIN employment_status AS c ON a.emp_status = c.id
                                            LEFT JOIN job_category AS d ON a.eeo_cat_code = d.id
                                            LEFT JOIN job_department AS e ON a.job_dept_id = e.id
                                            LEFT JOIN emp_appraisal_type AS f ON a.emp_number = f.emp_number
                                            LEFT JOIN appraisal_type AS g ON f.appraisal_type_id = g.id
                                            LEFT JOIN emp_appraisal_value AS h ON a.emp_number = h.emp_number
                                            LEFT JOIN job_title as i ON a.job_title_code = i.id
                                            WHERE a.emp_status IN (1,2,5)
                                            and a.termination_id IN (0)
                                            $whereAnd
                                        ) as final_result
                                        where (count_evaluator = count_evaluator_submit AND count_eval_submit_draft <= 0)
                                        order by final_result.job_title_code DESC, final_result.joined_date ASC");

        foreach($dataAppraisal as $key => $data) {
            $dataAppraisal[$key]->nilai_akhir = $data->nilai_awal - $data->item_pengurangan;

            $evaluators = DB::select("SELECT e.emp_number, ev.evaluator_status, e.emp_firstname, e.emp_middle_name, e.emp_lastname, j.id, j.job_title, e.emp_fullname
                FROM emp_evaluator ev INNER JOIN employee e
                left join job_title as j on j.id = e.job_title_code
                ON ev.emp_number = e.emp_number
                WHERE ev.is_delete = 0
                and ev.emp_evaluation = '".$data->emp_number."'
            ");

            // Fungsi untuk mengurutkan array berdasarkan j.id dan e.emp_fullname
            usort($evaluators, function($a, $b) {
                // Pertama urutkan berdasarkan j.id
                if ($a->id == $b->id) {
                    // Jika j.id sama, urutkan berdasarkan emp_fullname
                    return strcmp($a->emp_fullname, $b->emp_fullname);
                }
                // Jika j.id berbeda, urutkan berdasarkan j.id
                if ($a->id < $b->id) {
                    return -1;
                } elseif ($a->id > $b->id) {
                    return 1;
                }
                return 0;
            });

            $arr_appraisal_value = [];
            foreach($evaluators as $key2 => $item) {
                // $val_appr = DB::select("
                //     SELECT SUM(ea.appraisal_value) AS appraisal_value
                //     FROM emp_appraisal ea
                //     WHERE ea.period = '".$periodYear."' AND ea.emp_number = '".$data->emp_number."' AND
                //     ea.emp_evaluator = '".$item->emp_number."'
                // ");

                $val_appr = DB::select("
                    SELECT ea.appraisal_value
                    FROM emp_appraisal_evaluator ea
                    WHERE ea.period = '".$periodYear."' AND ea.emp_number = '".$data->emp_number."' AND
                    ea.emp_evaluator = '".$item->emp_number."'
                ");

                // $evaluators[$key2]->appraisal_value = empty($val_appr[0]->appraisal_value) ? 0 : $val_appr[0]->appraisal_value;
                array_push($arr_appraisal_value, (empty($val_appr[0]->appraisal_value) ? 0 : (float) $val_appr[0]->appraisal_value));
            }

            $dataAppraisal[$key]->appraisal_value_per_evaluators = count($arr_appraisal_value) <= 0 ? "0" : implode(" | ", $arr_appraisal_value);
        }
        
        $param = [
            "location_id" => $location_id,
            "dirops_dept_id" => $dirops_dept_id,
            "periodYear" => $periodYear
        ];

        \DB::table('log_activity')->insert([
            'action' => 'HRD Print Report Appraisal',
            'module' => 'Report',
            'sub_module' => 'Appraisal Report',
            'modified_by' => Session::get('name'),
            'description' => 'HRD Print Report Appraisal ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'location, job_department'
        ]);
        
        return view('pages.manage.reports.appraisal.pdfCetakDataAppraisal', compact('project','diropsData','locationData','location_id','dirops_dept_id','periodYear','year','dataLocation','dataDirOpsId','dataAppraisal','param'));
    }

    public function updateEncryptionAppraisal(){
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $now = date('Y-m-d', strtotime($dateNow));

        $dataAppraisal = \DB::select("SELECT a.id, a.emp_number, a.appraisal_value, a.hrd_value
            FROM emp_appraisal as a
            ORDER BY a.created_at ASC");
        
        foreach ($dataAppraisal as $appraisal)
        {
            DB::table('emp_appraisal')
            ->where('id','=',$appraisal->id)
            ->update([
                'appraisal_value'=>$appraisal->appraisal_value,
                'hrd_value'=>$appraisal->hrd_value
            ]);
        }
    }

    public function updateEncryptionAppraisalValue(){
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $now = date('Y-m-d', strtotime($dateNow));

        $dataAppraisal = \DB::select("SELECT a.id, a.emp_number, a.emp_value, a.sup_value, a.dir_value, a.hrd_value, a.final_value
            FROM emp_appraisal_value as a
            ORDER BY a.created_at ASC");
        
        foreach ($dataAppraisal as $appraisal)
        {
            DB::table('emp_appraisal_value')
            ->where('id','=',$appraisal->id)
            ->update([
                'emp_value'=>$appraisal->emp_value,
                'sup_value'=>$appraisal->sup_value,
                'dir_value'=>$appraisal->dir_value,
                'hrd_value'=>$appraisal->hrd_value,
                'final_value'=>$appraisal->final_value
            ]);
        }
    }

    public function updateEncryptionAppraisalValueHistorical(){
        $dateNow = Carbon::parse(Carbon::now(new \DateTimeZone('Asia/Jakarta')));
        $now = date('Y-m-d', strtotime($dateNow));

        $dataAppraisal = \DB::select("SELECT a.id, a.employee_id, a.value_angka, a.value_huruf, a.value_box9
            FROM emp_appraisal_value_historical as a
            ORDER BY a.created_at ASC");
        
        foreach ($dataAppraisal as $appraisal)
        {
            DB::table('emp_appraisal_value_historical')
            ->where('id','=',$appraisal->id)
            ->update([
                'value_angka'=>$appraisal->value_angka,
                'value_huruf'=>$appraisal->value_huruf,
                'value_box9'=>$appraisal->value_box9
            ]);
        }
    }
}
