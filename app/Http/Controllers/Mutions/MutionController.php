<?php

namespace App\Http\Controllers\Mutions;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB, Session, App\Models\Master\Employee;
use App\Models\Mutations\MutationRequest, App\Models\Mutations\MutationStatus;

class MutionController extends Controller{
    protected $emp;
    protected $mReq;
    protected $mStat;
    public function __construct(Employee $emp, MutationRequest $mReq, MutationStatus $mStat){
        $this->emp = $emp;
        $this->mReq = $mReq;
        $this->mStat = $mStat;
        parent::__construct();
    }

    public function index(){
        $emp = $this->emp->where('employee_id', Session::get('username'))->first();
        $requests = $this->mReq->where('emp_number', $emp->emp_number)->get();
        return view('pages.mutation.index', compact('emp', 'requests'));
    }
}
