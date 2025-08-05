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


class MobileInductionTrainingController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
        //parent::__construct();


    }

    public function getAllInductionTraining(Request $request){


        $induction_training = DB::table("induction_trainning")
                            ->where("status",1)
                            ->get();
        return response()->json($induction_training, 200);

    }

}
