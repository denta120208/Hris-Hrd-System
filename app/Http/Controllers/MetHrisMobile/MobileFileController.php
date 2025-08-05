<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileFileController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();


    }

    public function getAllFiles(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if($request->take)
        {
            $files = DB::table("file_download")
                ->where("status_file", 1)
                ->take($request->take)
                ->get();


        } else {
            $files = DB::table("file_download")
                ->where("status_file", 1)
                ->get();




        }


        return response()->json($files, 200);

    }


    public function getAllFiles2(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        if($request->take)
        {
            $files = DB::table("file_download")
                ->where("status_file", 1)
                ->take($request->take)
                ->orderBy('order_by')
                ->get();


            for($i= 0; $i < count($files);$i++){

                $cek_dtl = DB::table("file_download_dtl")
                    ->where("id_file", $files[$i]->id)
                    ->first();
                $count_download = 0;
                $count_view = 0;

                if($cek_dtl){
                    $download = DB::select("
                select sum(download_count) as download from file_download_dtl 
                where id_file = ".$files[$i]->id);

                    $view = DB::select("
                select sum(mobile_view_count) as view_files from file_download_dtl 
                where id_file = ".$files[$i]->id);

                    $count_download = $download[0]->download;
                    $count_view = $view[0]->view_files;
                } else {
                    $count_download = 0;
                    $count_view = 0;
                }


                $result[$i]= [
                    "files" => $files[$i],
                    "count_download" => $count_download,
                    "count_view" => $count_view

                ];

            }

        } else {
            $files = DB::table("file_download")
                ->where("status_file", 1)
                ->get();


            for($i= 0; $i < count($files);$i++){

                $cek_dtl = DB::table("file_download_dtl")
                    ->where("id_file", $files[$i]->id)
                    ->first();

                if($cek_dtl){
                    $download = DB::select("
                select sum(download_count) as download from file_download_dtl 
                where id_file = ".$files[$i]->id);

                    $view = DB::select("
                select sum(mobile_view_count) as view_files from file_download_dtl 
                where id_file = ".$files[$i]->id);

                    $count_download = $download[0]->download;
                    $count_view = $view[0]->view_files;
                } else {
                    $count_download = 0;
                    $count_view = 0;
                }


                $result= [
                    $files,
                    "count_download" => $count_download,
                    "count_view" => $count_view,

                ];

            }

        }


        return response()->json($result, 200);

    }


    public function addDownloadViewCount(Request $request){
//        if ($request->header('APP-ID') == $this->getMobileAppsID()) {
//
//        } else {
//            $result = ["result" => "Apps key not valid.", "status" => 0];
//            return response()->json($result, 200);
//        }

        $file_emp = DB::table("file_download_dtl")
                ->where("id_file", $request->id_file)
                ->where("emp_number", $request->emp_number)
                ->first();

        if($file_emp){
            $add_view = $file_emp->mobile_view_count + 1;
            DB::table("file_download_dtl")
                ->where("id", $file_emp->id)
                ->update([
                    "mobile_view_count" => $add_view
                ]);
            $result = ["result" => "Successfully update log file.", "status" => 1];

        } else {
            DB::table("file_download_dtl")
                ->insert([
                   "id_file" => $request->id_file,
                   "emp_number" => $request->emp_number,
                   "download_count" => 1,
                   "mobile_view_count" => 1
                ]);
            $result = ["result" => "Successfully add log file.", "status" => 1];


        }

            return response()->json($result, 200);

    }

}
