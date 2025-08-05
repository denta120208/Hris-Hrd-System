<?php

namespace App\Http\Controllers\MetHrisMobile;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Http\Controllers\Controller, DB;
use App\Models\Leave\LeaveRequest;
use GuzzleHttp\Client;


class MobileDemoController extends Controller
{


    protected $lvReq;


    function __construct(User $user, LeaveRequest $lvReq)
    {
//parent::__construct();
        $this->lvReq = $lvReq;

        $this->user = $user;
// Membuat Halaman(Controller) tidak di Filter Authentication(Login Page)
        $this->beforeFilter('auth', ['except' => 'destroy']);

    }

    public function getDemoEmpPicture($id){

        $img = DB::table("emp_picture")
                ->where("emp_number", $id)
                ->first();
        $picture =  base64_encode( $img->epic_picture );


        return response()->json($picture, 200);

    }
}