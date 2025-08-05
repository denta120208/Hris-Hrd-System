<?php

namespace App\Http\Controllers\HRD\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class JoinTerminateController extends Controller
{
    public function reportJoinTerminate(Request $request)
    {
        // Get projects for dropdown
        $projects = DB::table('location')
                     ->select('id', 'name')
                     ->where('ID_COMPANY_INT', 0)
                     ->get();

        // Initialize variables
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $projectId = $request->get('project_id');

        // Get data from stored procedure
        $arr = DB::select("exec sp_join_terminate_report ?, ?, ?", [$startDate, $endDate, $projectId]);

        if ($startDate && $endDate) {
            $joinedEmployees = collect($arr)->where('status', 'JOIN')->count();
            $terminatedEmployees = collect($arr)->where('status', 'TERMINATE')->count();
        } else {
            $joinedEmployees = 0;
            $terminatedEmployees = 0;
        }

        return view('pages.manage.reports.komposisi_emp.join_terminate', 
            compact('arr', 'startDate', 'endDate', 'joinedEmployees', 'terminatedEmployees', 'projects'));
    }

    public function reportTerminate(Request $request)
    {
        // Get projects for dropdown
        $projects = DB::table('location')
                     ->select('id', 'name')
                     ->where('ID_COMPANY_INT', 0)
                     ->get();

        // Initialize variables
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');
        $projectId = $request->get('project_id');

        // Get data from stored procedure
        $arr = DB::select("exec sp_join_terminate_report ?, ?, ?", [$startDate, $endDate, $projectId]);

        // Filter only terminated employees
        $arr = collect($arr)->where('status', 'TERMINATE')->all();

        if ($startDate && $endDate) {
            $terminatedEmployees = count($arr);
        } else {
            $terminatedEmployees = 0;
        }

        return view('pages.manage.reports.komposisi_emp.Terminate', 
            compact('arr', 'startDate', 'endDate', 'terminatedEmployees', 'projects'));
    }
} 