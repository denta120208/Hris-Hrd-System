<?php

namespace App\Http\Controllers\Recruitment;

use Illuminate\Http\Request;

use App\Http\Requests, DB, Session, Log;
use App\Http\Controllers\Controller, App\Models\Master\Employee, App\Models\Recruitment\JobVacancy;
use App\Models\Recruitment\JobCandidate, App\Models\Recruitment\JobCandidateDependent, App\Models\Recruitment\JobCandidateEducation;
use App\Models\Recruitment\JobCandidateEmergency, App\Models\Recruitment\JobCandidateHobbies, App\Models\Recruitment\JobCandidateLanguage;
use App\Models\Recruitment\JobCandidateNewsMagz, App\Models\Recruitment\JobCandidateReadingAct, App\Models\Recruitment\JobCandidateSocialAct;
use App\Models\Recruitment\JobCandidateWorkExp;

class RecruitmentController extends Controller{
    protected $vacan;
    public function __construct(JobVacancy $vacan){
        $this->vacan = $vacan;
        parent::__construct();
    }
    public function apply($id){
//        $vacans = $this->vacan->where('id', $id)->first();, compact('vacans')
        return view('pages.recruit.form');
    }
    public function create(){
        //
    }
    public function store(Request $request)
    {
        //
    }
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }
    public function update(Request $request, $id)
    {
        //
    }
    public function destroy($id)
    {
        //
    }
}
