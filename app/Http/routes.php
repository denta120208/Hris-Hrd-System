<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('auth.login'));
    //return Redirect::to('https://sso.metropolitanland.com');


});

Route::get('/logout', function () {
   Session::flush();
   return Redirect::to('https://sso.metropolitanland.com/');
});

Route::get('/logoutHRIS', function(){
   Session::flush();
return redirect('https://sso.metropolitanland.com/LogoutAllApps');
});



Route::controller('auth', 'Auth\AuthController', [
    'getLogin' => 'auth.login',
    'getLogout' => 'auth.logout'
]);

//Route::get('/cronCB', ['as' => 'cronCB', 'uses' => 'Crons\CutiController@cronCB']);

Route::any('/SSO/{id}/{ix}', ['as' => 'SSO', 'uses' => 'Services\SSOController@token']);

Route::any('/pa', ['as' => 'pa', 'uses' => 'Appraisal\AppraisalController@index']);
Route::any('/get_pa', ['as' => 'get_pa', 'uses' => 'Appraisal\AppraisalController@get_ecrypt']);

Route::get('/users/{users}/confirm', ['as' => 'users.confirm', 'uses' => 'UserController@confirm' ]);
Route::get('/users/{users}/activate', ['as' => 'users.activate', 'uses' => 'UserController@activate' ]);
//Route::post('/users/getMenus', ['as' => 'users.getMenus', 'uses' => 'UserController@getMenus' ]);
Route::resource('users', 'UserController');

Route::any('/organisasi', ['as' => 'organisasi', 'uses' => 'HRD\Emp\AppraisalController@organisasi']);
Route::any('/organisasi1', ['as' => 'organisasi', 'uses' => 'HRD\Emp\AppraisalController@organisasi1']);
Route::any('/dash_chart', ['as' => 'dash_chart', 'uses' => 'DashboardController@dash_chart']);
Route::any('/dash_chart2', ['as' => 'dash_chart2', 'uses' => 'DashboardController@dash_chart2']);

Route::any('/changePassword', ['as' => 'changePassword', 'uses' => 'DashboardController@changePassword']);
Route::post('/changePass', ['as' => 'changePass', 'uses' => 'UserController@changePass']);
Route::any('/forgot_password', ['as' => 'forgot_password', 'uses' => 'ForgetPasswordController@index' ]);
Route::post('/forgotPassword', ['as' => 'forgotPassword', 'uses' => 'ForgetPasswordController@index' ]);

Route::get('/dashboard', ['as' => 'dashboard', 'uses' => 'DashboardController@index' ]);
Route::get('/dashboard/ckLeave', ['as' => 'dashboard.ckLeave', 'uses' => 'DashboardController@ckLeave' ]);
Route::get('/dashboard/ckTrain', ['as' => 'dashboard.ckTrain', 'uses' => 'DashboardController@ckTrain' ]);

// Employee
Route::any('/emp', ['as' => 'emp', 'uses' => 'Master\EmployeeController@listEmp']);
Route::get('/emp/{id}', ['as' => 'emp', 'uses' => 'Master\EmployeeController@detailEmp']);
Route::any('/personal', ['as' => 'personal', 'uses' => 'Master\EmployeeController@empPersonal']);
Route::get('/personal/getpersonal/{id}', ['as' => 'getPersonal', 'uses' => 'Master\EmployeeController@getPersonal']);
Route::post('/setpersonal', ['as' => 'setpersonal', 'uses' => 'Master\EmployeeController@setPersonal']);
Route::get('/personal/contact/{id}', ['as' => 'personal.contact', 'uses' => 'Master\EmployeeController@getContact']);
Route::post('/setcontact/', ['as' => 'setcontact', 'uses' => 'Master\EmployeeController@setContact']);
Route::get('/personal/setcontact/', ['as' => 'personal.getErContact', 'uses' => 'Master\EmployeeController@getErContact']);
//Route::post('/setcontact/', ['as' => 'setcontact', 'uses' => 'Master\EmployeeController@setContact']);
Route::get('/personal/emergency/{id}', ['as' => 'personal.emergency', 'uses' => 'Master\EmployeeController@getEmergency']);
Route::get('/personal/getEmergencyDtl', ['as' => 'personal.getEmergencyDtl', 'uses' => 'Master\EmployeeController@getEmergencyDtl']);
Route::post('/personal/setEmergencyDtl', ['as' => 'personal.setEmergencyDtl', 'uses' => 'Master\EmployeeController@setEmergencyDtl']);
Route::get('/personal/deleteEmergency/{id}', ['as' => 'personal.deleteEmergency', 'uses' => 'Master\EmployeeController@deleteEmergency']);
Route::get('/personal/dependents/{id}', ['as' => 'personal.dependents', 'uses' => 'Master\EmployeeController@getDependents']);
Route::get('/personal/getDependentsDtl', ['as' => 'personal.getDependentsDtl', 'uses' => 'Master\EmployeeController@getDependentsDtl']);
Route::post('/personal/setDependent', ['as' => 'personal.setDependent', 'uses' => 'Master\EmployeeController@setDependent']);
Route::post('/personal/setDependentsDtl', ['as' => 'personal.setDependentsDtl', 'uses' => 'Master\EmployeeController@setDependentsDtl']);
Route::get('/personal/deleteDependent/{id}', ['as' => 'personal.deleteDependent', 'uses' => 'Master\EmployeeController@deleteDependent']);
Route::get('/personal/immigration/{id}', ['as' => 'personal.immigration', 'uses' => 'Master\EmployeeController@getImmigration']);
Route::get('/personal/job/{id}', ['as' => 'personal.job', 'uses' => 'Master\EmployeeController@getJob']);
Route::get('/personal/getReportToDtl', ['as' => 'personal.getReportToDtl', 'uses' => 'Master\EmployeeController@getReportToDtl']);
Route::post('/personal/setReportTo', ['as' => 'personal.setReportTo', 'uses' => 'Master\EmployeeController@setReportTo']);
Route::get('/personal/salary/{id}', ['as' => 'personal.salary', 'uses' => 'Master\EmployeeController@getSalary']);
Route::post('/download/salary/', ['as' => 'salary.download', 'uses' => 'Master\EmployeeController@downSalary']);
Route::get('/personal/reportTo/{id}', ['as' => 'personal.reportTo', 'uses' => 'Master\EmployeeController@getReportTo']);
Route::get('/personal/qualifications/{id}', ['as' => 'personal.qualifications', 'uses' => 'Master\EmployeeController@getQualifications']);
Route::get('/personal/membership/{id}', ['as' => 'personal.memberships', 'uses' => 'Master\EmployeeController@getMemberships']);
Route::get('/view/contract/{id}', ['as' => 'view.contract', 'uses' => 'Master\EmployeeController@viewContract']);
Route::post('/personal/setEducation', ['as' => 'personal.setEducation', 'uses' => 'Master\EmployeeController@setEducation']);
Route::get('/personal/deleteEducation/{id}', ['as' => 'personal.deleteEducation', 'uses' => 'Master\EmployeeController@deleteEducation']);
Route::post('/personal/setWork', ['as' => 'personal.setWork', 'uses' => 'Master\EmployeeController@setWork']);
Route::get('/personal/deleteWork/{id}', ['as' => 'personal.deleteWork', 'uses' => 'Master\EmployeeController@deleteWork']);
Route::post('/personal/setTrain', ['as' => 'personal.setTrain', 'uses' => 'Master\EmployeeController@setTrain']);
Route::get('/personal/reward/{id}', ['as' => 'personal.reward', 'uses' => 'Master\EmployeeController@getReward']);
// End Employee

// Resign
Route::post('/requestResign', ['as' => 'requestResign', 'uses' => 'Resign\ResignController@requestResign']);
Route::get('/printExitFormInterview', ['as' => 'printExitFormInterview', 'uses' => 'Resign\ResignController@printExitFormInterview']);
// End Resign

// Subordinate
Route::any('/empSub', ['as' => 'empSub', 'uses' => 'Master\EmployeeSubController@listSub']);
// End Subordinate

// Leave
Route::any('/myLeave', ['as' => 'myLeave', 'uses' => 'Leave\LeaveController@myLeave']);
Route::any('/applLeave', ['as' => 'applLeave', 'uses' => 'Leave\LeaveController@applLeave']);
Route::post('/getBal', ['as' => 'getBal', 'uses' => 'Leave\LeaveController@getBal']);
Route::post('/saveLeave', ['as' => 'saveLeave', 'uses' => 'Leave\LeaveController@saveLeave']);
Route::any('/apvLeave', ['as' => 'apvLeave', 'uses' => 'Leave\LeaveController@apvLeave']);
Route::post('/setLeave', ['as' => 'setLeave', 'uses' => 'Leave\LeaveController@setLeave']);
Route::any('/balLeave', ['as' => 'balLeave', 'uses' => 'Leave\LeaveController@balLeave']);
Route::get('/cancel_Leave/{id}', ['as' => 'cancel_Leave', 'uses' => 'Leave\LeaveController@cancel_Leave']);
// End Leave

// Trainning
Route::any('/listTrainning', ['as' => 'listTrainning', 'uses' => 'Trainning\TrainningController@listTrainning']);
Route::any('/requestTrainning', ['as' => 'requestTrainning', 'uses' => 'Trainning\TrainningController@requestForm']);
Route::get('/getVendorTrain', ['as' => 'getVendorTrain', 'uses' => 'Trainning\TrainningController@getVendorTrain']);
Route::post('/setVendorTrain', ['as' => 'setVendorTrain', 'uses' => 'Trainning\TrainningController@setVendorTrain']);
Route::post('/saveTraining', ['as' => 'saveTraining', 'uses' => 'Trainning\TrainningController@saveTraining']);
Route::any('/listApprove', ['as' => 'listApprove', 'uses' => 'Trainning\TrainningController@listApprove']);
Route::get('/appTrain/{id}', ['as' => 'appTrain', 'uses' => 'Trainning\TrainningController@appvSup']);
// End Trainning

// Attendance
Route::any('/attendance', ['as' => 'attendance', 'uses' => 'Attendance\AttendanceController@index']);
Route::any('/attendanceRequest', ['as' => 'attendanceRequest', 'uses' => 'Attendance\AttendanceController@attendanceRequest']);
Route::any('/attendance2', ['as' => 'attendance2', 'uses' => 'Attendance\AttendanceController@indexOld']);
Route::any('/appAtt', ['as' => 'appAtt', 'uses' => 'Attendance\AttendanceController@approveAttendance']);
Route::get('/getAttLeave', ['as' => 'getAttLeave', 'uses' => 'Attendance\AttendanceController@getAttLeave']);
Route::post('/setAttLeave', ['as' => 'setAttLeave', 'uses' => 'Attendance\AttendanceController@setAttLeave']);
Route::post('/setAttLeaveWithoutAttend', ['as' => 'setAttLeaveWithoutAttend', 'uses' => 'Attendance\AttendanceController@setAttLeaveWithoutAttend']);
Route::get('/getAttApv', ['as' => 'getAttApv', 'uses' => 'Attendance\AttendanceController@getAttApv']);
Route::post('/setAttAppv', ['as' => 'setAttAppv', 'uses' => 'Attendance\AttendanceController@setAttAppv']);
Route::any('/attSub', ['as' => 'attSub', 'uses' => 'Attendance\AttendanceController@attSub']);
// End Attendance

// Appraisal
Route::any('/appraisal', ['as' => 'appraisal', 'uses' => 'Master\EmpAppraisalController@index']);
Route::get('/appraisal/{id}/add', ['as' => 'appraisal.add', 'uses' => 'Master\EmpAppraisalController@appraisal']);
Route::get('/appraisal/{evaluation}/final/{evaluator}', ['as' => 'appraisal.final', 'uses' => 'Master\EmpAppraisalController@finalAppraisal']);
Route::get('/getAppraisal', ['as' => 'getAppraisal', 'uses' => 'Master\EmpAppraisalController@getAppraisal']);
Route::post('/setAppraisal', ['as' => 'setAppraisal', 'uses' => 'Master\EmpAppraisalController@setAppraisal']);
// End Appraisal

// OverTime
Route::any('/overtimeRequest', ['as' => 'overtimeRequest', 'uses' => 'OverTime\OverTimeController@index']);
Route::post('/overtimeRequest/add', ['as' => 'overtimeRequest.add', 'uses' => 'OverTime\OverTimeController@applOverTime']);
Route::post('/overtimeRequest/save', ['as' => 'overtimeRequest.save', 'uses' => 'OverTime\OverTimeController@saveOverTime']);
Route::get('/overTimeAppv', ['as' => 'overTimeAppv', 'uses' => 'OverTime\OverTimeController@apvOverTime']);
Route::post('/setOverTime', ['as' => 'setOverTime', 'uses' => 'OverTime\OverTimeController@setOverTime']);
// End OverTime

// Perjalan Dinas
Route::any('/perjalanDinasRequest', ['as' => 'perjalanDinasRequest', 'uses' => 'PerjalanDinas\PDController@index']);
Route::any('/perjalanDinasRequest/add', ['as' => 'perjalanDinasRequest.add', 'uses' => 'PerjalanDinas\PDController@applPD']);
Route::post('/perjalanDinasRequest/save', ['as' => 'perjalanDinasRequest.save', 'uses' => 'PerjalanDinas\PDController@savePD']);
Route::get('/perjalanDinasAppv', ['as' => 'perjalanDinasAppv', 'uses' => 'PerjalanDinas\PDController@apvPD']);
Route::post('/setPerjalanDinas', ['as' => 'setPerjalanDinas', 'uses' => 'PerjalanDinas\PDController@setPD']);
// End Perjalan Dinas

// Mutations
Route::any('/mutation', ['as' => 'mutation', 'uses' => 'Mutations\MutationController@index']);
Route::any('/mutation/add', ['as' => 'mutation.add', 'uses' => 'Mutations\MutationController@applMutation']);
Route::post('/mutation/save', ['as' => 'mutation.save', 'uses' => 'Mutations\MutationController@saveMutation']);
Route::get('/mutationApv', ['as' => 'mutationApv', 'uses' => 'Mutations\MutationController@apvMutation']);
Route::post('/setMutation', ['as' => 'setMutation', 'uses' => 'Mutations\MutationController@setMutation']);
Route::post('/listDept', ['as' => 'listDept', 'uses' => 'Mutations\MutationController@listDept']);
// End Mutations

// Promotions
Route::any('/promotion', ['as' => 'promotion', 'uses' => 'Promotions\PromotionController@index']);
Route::any('/promotion/add', ['as' => 'promotion.add', 'uses' => 'Promotions\PromotionController@addPromote']);
Route::post('/promotion/save', ['as' => 'promotion.save', 'uses' => 'Promotions\PromotionController@savePromotion']);
Route::post('/job_from', ['as' => 'job_from', 'uses' => 'Promotions\PromotionController@job_from']);
Route::post('/delPromotion', ['as' => 'delPromotion', 'uses' => 'Promotions\PromotionController@delPromotion']);
// End Promotions

// Demotions
Route::any('/demotion', ['as' => 'demotion', 'uses' => 'Demotions\DemotionController@index']);
Route::any('/demotion/add', ['as' => 'demotion.add', 'uses' => 'Demotions\DemotionController@addDemote']);
Route::post('/demotion/save', ['as' => 'demotion.save', 'uses' => 'Demotions\DemotionController@saveDemotion']);
Route::get('/printDemotion/{id}', ['as' => 'printDemotion', 'uses' => 'Demotions\DemotionController@printDemotion']);
Route::post('/delDemotion', ['as' => 'delDemotion', 'uses' => 'Demotions\DemotionController@delDemotion']);
// End Demotions

// ST/SP
Route::any('/stsp', ['as' => 'stsp', 'uses' => 'Punhisments\STSPController@index']);
Route::any('/stsp_appr', ['as' => 'stsp', 'uses' => 'Punhisments\STSPController@punish_appr']);
Route::any('/stsp/add', ['as' => 'stsp.add', 'uses' => 'Punhisments\STSPController@addPunishment']);
Route::post('/stsp/save', ['as' => 'stsp.save', 'uses' => 'Punhisments\STSPController@savePunishment']);
Route::get('/stsp/edit/{id}', ['as' => 'stsp.edit', 'uses' => 'Punhisments\STSPController@editPunishment']);
Route::post('/stsp/update', ['as' => 'stsp.update', 'uses' => 'Punhisments\STSPController@saveEPunishment']);
Route::get('/delStsp/{id}', ['as' => 'delStsp', 'uses' => 'Punhisments\STSPController@delPunishment']);
Route::get('/apprStsp/{id}', ['as' => 'apprStsp', 'uses' => 'Punhisments\STSPController@apprPunishment']);
Route::post('/stsp/edits/', ['as' => 'stsp.edits', 'uses' => 'Punhisments\STSPController@saveEPunishment']);
Route::get('/printSTSP/{id}', ['as' => 'printSTSP', 'uses' => 'Punhisments\STSPController@printSTSP']);
// End ST/SP

// Reports
Route::get('/hrd/rKomposisi', ['as' => 'hrd.rKomposisi', 'uses' => 'HRD\Reports\KomposisiController@statusEmp']);
Route::get('/hrd/rJoinTerminate', ['as' => 'hrd.rJoinTerminate', 'uses' => 'HRD\Reports\KomposisiController@joinTerminate']);
Route::get('/hrd/addJoinTerminateMenu', ['as' => 'hrd.addJoinTerminateMenu', 'uses' => 'HRD\Reports\KomposisiController@addJoinTerminateMenu']);
Route::get('/hrd/appraisal_emp', ['as' => 'hrd.appraisal_emp', 'uses' => 'HRD\Reports\AppraisalController@index']);

Route::post('/hrd/view_appraisal_emp', ['as' => 'hrd.view_appraisal_emp', 'uses' => 'HRD\Reports\AppraisalController@viewDataAppraisal']);

// Download File
Route::any('/induction', ['as' => 'induction', 'uses' => 'HRD\Administrations\InductionController@index']);
//Route::any('/stsp/add', ['as' => 'stsp.add', 'uses' => 'Punhisments\STSPController@addPunishment']);
//Route::post('/stsp/save', ['as' => 'stsp.save', 'uses' => 'Punhisments\STSPController@savePunishment']);
//Route::get('/stsp/edit/{id}', ['as' => 'stsp.edit', 'uses' => 'Punhisments\STSPController@editPunishment']);
//Route::post('/stsp/update', ['as' => 'stsp.update', 'uses' => 'Punhisments\STSPController@saveEPunishment']);
//Route::post('/delStsp', ['as' => 'delStsp', 'uses' => 'Punhisments\STSPController@delPunishment']);
//Route::post('/stsp/edits/', ['as' => 'stsp.edits', 'uses' => 'Punhisments\STSPController@saveEPunishment']);
//Route::get('/printSTSP/{id}', ['as' => 'printSTSP', 'uses' => 'Punhisments\STSPController@printSTSP']);
// End Download File

// Recruitment
Route::any('/recruitment', ['as' => 'recruitment', 'uses' => 'Recruitment\EmpRecruitmentController@index']);
Route::any('/recruitment/search', ['as' => 'recruitment.search', 'uses' => 'Recruitment\EmpRecruitmentController@index']);
Route::post('/recruitment/setReqVacan', ['as' => 'recruitment.setReqVacan', 'uses' => 'Recruitment\EmpRecruitmentController@setReqVacan']);
Route::get('/recruitment/getReqVacan', ['as' => 'recruitment.getReqVacan', 'uses' => 'Recruitment\EmpRecruitmentController@getReqVacan']);
Route::get('/recruitment/{id}/view', ['as' => 'recruitment.view', 'uses' => 'Recruitment\EmpRecruitmentController@show']);

Route::any('/recruitment/{id}/apply', ['as' => 'recruitment.apply', 'uses' => 'Recruitment\RecruitmentController@apply']);
// End Recruitment

// Termination Approval
Route::any('/terminationApproval', ['as' => 'terminationApproval', 'uses' => 'TerminationApproval\TerminationApprovalController@index']);
Route::post('/terminationApproval/approve/{id}', ['as' => 'terminationApproval.approve', 'uses' => 'TerminationApproval\TerminationApprovalController@approveTermination']);
Route::post('/terminationApproval/reject/{id}', ['as' => 'terminationApproval.reject', 'uses' => 'TerminationApproval\TerminationApprovalController@rejectTermination']);
// End Termination Approval

// -- HRD Route --
//Route::get('/hrd/dashboard', ['as' => 'hrd.dashboard', 'uses' => 'DashboardController@hrd_index' ]);

// Attendance DW Report (Join & Terminate Section)
Route::post('/hrd/rekap_absendw', [
    'as' => 'hrd.rekap_absendw',
    'uses' => 'HRD\Reports\AttendanceController@rekapDW'
]);

Route::any('/hrd/employee', ['as' => 'hrd.employee', 'uses' => 'HRD\Emp\EmployeeController@index' ]);
Route::get('/hrd/viewEmp/{id}', ['as' => 'hrd.viewEmp', 'uses' => 'HRD\Emp\EmployeeController@viewEmp' ]);
Route::get('/personalEmp/', ['as' => 'personalEmp', 'uses' => 'HRD\Emp\EmployeeController@personalEmp' ]);
Route::get('/personalEmp/personal/{id}', ['as' => 'personalEmp.personal', 'uses' => 'HRD\Emp\EmployeeController@personalEmp' ]);
Route::post('/personalEmp/setPersonal/', ['as' => 'personalEmp.setPersonal', 'uses' => 'HRD\Emp\EmployeeController@setPersonalEmp']);
Route::get('/personalEmp/job/{id}', ['as' => 'personalEmp.job', 'uses' => 'HRD\Emp\EmployeeController@jobEmp' ]);
Route::post('/personalEmp/jobDtl/', ['as' => 'personalEmp.jobDtl', 'uses' => 'HRD\Emp\EmployeeController@setJobEmp']);
Route::get('/personalEmp/contact/{id}', ['as' => 'personalEmp.contact', 'uses' => 'HRD\Emp\EmployeeController@contactEmp' ]);
Route::post('/personalEmp/contactDtl/', ['as' => 'personalEmp.contactDtl', 'uses' => 'HRD\Emp\EmployeeController@setContactEmp']);
Route::get('/personalEmp/dependents/{id}', ['as' => 'personalEmp.dependents', 'uses' => 'HRD\Emp\EmployeeController@dependentsEmp' ]);
Route::post('/personalEmp/setDependent', ['as' => 'personalEmp.setDependent', 'uses' => 'HRD\Emp\EmployeeController@setDependentsEmp' ]);
Route::get('/personalEmp/delDependent/{id}', ['as' => 'personalEmp.delDependent', 'uses' => 'HRD\Emp\EmployeeController@delDependentsEmp' ]);
Route::get('/personalEmp/emergency/{id}', ['as' => 'personalEmp.emergency', 'uses' => 'HRD\Emp\EmployeeController@emergencyEmp' ]);
Route::get('/personalEmp/getEmergencyDtl/', ['as' => 'personal.getEmergencyDtl', 'uses' => 'HRD\Emp\EmployeeController@getEmergencyDtl' ]);
Route::post('/personalEmp/setEmergencyDtl/', ['as' => 'personalEmp.setEmergencyDtl', 'uses' => 'HRD\Emp\EmployeeController@setEmergencyDtl' ]);
Route::get('/personalEmp/deleteEmergency/{id}', ['as' => 'personalEmp.deleteEmergency', 'uses' => 'HRD\Emp\EmployeeController@deleteEmergency']);
Route::get('/personalEmp/qualifications/{id}', ['as' => 'personalEmp.qualifications', 'uses' => 'HRD\Emp\EmployeeController@qualificationsEmp' ]);
Route::post('/personalEmp/setEducation/', ['as' => 'personalEmp.setEducation', 'uses' => 'HRD\Emp\EmployeeController@setEducation' ]);
Route::get('/personalEmp/deleteEducation/{id}', ['as' => 'personalEmp.deleteEducation', 'uses' => 'HRD\Emp\EmployeeController@deleteEducation']);
Route::post('/personalEmp/setWork/', ['as' => 'personalEmp.setWork', 'uses' => 'HRD\Emp\EmployeeController@setWork' ]);
Route::get('/personalEmp/deleteWork/{id}', ['as' => 'personalEmp.deleteWork', 'uses' => 'HRD\Emp\EmployeeController@deleteWork']);
Route::post('/personalEmp/setTrain', ['as' => 'personalEmp.setTrain', 'uses' => 'HRD\Emp\EmployeeController@setTrain']);
Route::get('/personalEmp/deleteTrain/{id}', ['as' => 'personalEmp.deleteTrain', 'uses' => 'HRD\Emp\EmployeeController@deleteTrain']);
Route::get('/personalEmp/reward_punish/{id}', ['as' => 'personalEmp.reward_punish', 'uses' => 'HRD\Emp\EmployeeController@getRewardPunishEmp' ]);
Route::get('/personalEmp/getRewardDtl/', ['as' => 'personalEmp.getRewardDtl', 'uses' => 'HRD\Emp\EmployeeController@getRewardDtl']);
Route::post('/personalEmp/setRewardDtl/', ['as' => 'personalEmp.setReward', 'uses' => 'HRD\Emp\EmployeeController@setRewardDtl']);
Route::get('/personalEmp/getPromotDtl/', ['as' => 'personalEmp.getPromotDtl', 'uses' => 'HRD\Emp\EmployeeController@getPromotDtl']);
Route::post('/personalEmp/setPromotDtl/', ['as' => 'personalEmp.setPromotDtl', 'uses' => 'HRD\Emp\EmployeeController@setPromotDtl']);

Route::get('/personalEmp/getPunishDtl/', ['as' => 'personalEmp.getPunishDtl', 'uses' => 'HRD\Emp\EmployeeController@getPunishDtl']);
Route::post('/personalEmp/setPunishDtl/', ['as' => 'personalEmp.setPunishDtl', 'uses' => 'HRD\Emp\EmployeeController@setPunishDtl']);


Route::get('/personalEmp/getSupReportTo/', ['as' => 'personalEmp.getSupReportTo', 'uses' => 'HRD\Emp\EmployeeController@getSupReportTo']);
Route::get('/personalEmp/getReportToDtl/', ['as' => 'personalEmp.getReportToDtl', 'uses' => 'HRD\Emp\EmployeeController@getReportToDtl']);
Route::post('/personalEmp/setReportTo/', ['as' => 'personalEmp.setReportTo', 'uses' => 'HRD\Emp\EmployeeController@setReportTo']);
Route::get('/personalEmp/deleteReportTo/{id}', ['as' => 'personalEmp.deleteReportTo', 'uses' => 'HRD\Emp\EmployeeController@deleteReportTo']);
Route::get('/personalEmp/{id}/empPic/', ['as' => 'personalEmp.empPic', 'uses' => 'HRD\Emp\EmployeeController@empPic' ]);
Route::post('/personalEmp/setEmpPic/', ['as' => 'personalEmp.setEmpPic', 'uses' => 'HRD\Emp\EmployeeController@setEmpPic' ]);
Route::post('/personalEmp/setWork/', ['as' => 'personalEmp.setWork', 'uses' => 'HRD\Emp\EmployeeController@setWork' ]);
Route::post('/hrd/createEmp', ['as' => 'hrd.createEmp', 'uses' => 'HRD\Emp\EmployeeController@createEmp' ]);
Route::post('/hrd/search_emp', ['as' => 'hrd.search_emp', 'uses' => 'HRD\Emp\EmployeeController@search_emp']);
Route::get('/hrd/search_emp_get', ['as' => 'hrd.search_emp_get', 'uses' => 'HRD\Emp\EmployeeController@search_emp_get']);
Route::post('/getEmpName', ['as' => 'getEmpName', 'uses' => 'HRD\Emp\EmployeeController@getEmpName']);
Route::post('/getEmpNIK', ['as' => 'getEmpNIK', 'uses' => 'HRD\Emp\EmployeeController@getEmpNIK']);
Route::post('/hrd/addEmp', ['as' => 'hrd.addEmp', 'uses' => 'HRD\Emp\EmployeeController@addEmp']);
Route::post('/hrd/addEmpDW', ['as' => 'hrd.addEmpDW', 'uses' => 'HRD\Emp\EmployeeController@addEmpDW']);
Route::post('/hrd/terminate', ['as' => 'hrd.terminate', 'uses' => 'HRD\Emp\EmployeeController@terminateEmp']);
Route::post('/hrd/unterminate', ['as' => 'hrd.unterminate', 'uses' => 'HRD\Emp\EmployeeController@unterminateEmp']);
Route::get('/hrd/renewContract/{id}', ['as' => 'hrd.renewContract', 'uses' => 'HRD\Emp\EmployeeController@renewContract' ]);
Route::post('/hrd/setRenewContract/{id}', ['as' => 'hrd.setRenewContract', 'uses' => 'HRD\Emp\EmployeeController@setRenewContract' ]);
Route::get('/hrd/printContract/{id}', ['as' => 'hrd.printContract', 'uses' => 'HRD\Emp\EmployeeController@printContract' ]);
Route::get('/hrd/editContract/{id}', ['as' => 'hrd.editContract', 'uses' => 'HRD\Emp\EmployeeController@editContract']);
Route::post('/hrd/updateContract/{id}', ['as' => 'hrd.updateContract', 'uses' => 'HRD\Emp\EmployeeController@updateContract']);
Route::get('/hrd/deleteContract/{id}', ['as' => 'hrd.deleteContract', 'uses' => 'HRD\Emp\EmployeeController@deleteContract']);
Route::post('/hrd/find_emp', ['as' => 'hrd.find_emp', 'uses' => 'HRD\Emp\EmployeeController@find_emp' ]);
Route::post('/hrd/find_emp2', ['as' => 'hrd.find_emp2', 'uses' => 'HRD\Emp\EmployeeController@find_emp2' ]); // Find Emp Autocomplete From Leave
Route::get('/hrd/printSK/{id}', ['as' => 'hrd.printSK', 'uses' => 'HRD\Emp\EmployeeController@printSK']);
Route::get('/hrd/administrationDocument/{id}', ['as' => 'hrd.administrationDocument', 'uses' => 'HRD\Emp\EmployeeController@administrationDocument' ]);

Route::any('/hrd/intern', ['as' => 'hrd.intern', 'uses' => 'HRD\Emp\InternController@index' ]);
Route::post('/hrd/addIntern', ['as' => 'hrd.addIntern', 'uses' => 'HRD\Emp\InternController@addIntern']);
Route::post('/hrd/search_emp_intern', ['as' => 'hrd.search_emp_intern', 'uses' => 'HRD\Emp\InternController@search_emp_intern']);

Route::any('/hrd/leaveEmp', ['as' => 'hrd.leave', 'uses' => 'HRD\Leave\LeaveController@leaveEmp' ]);
Route::any('/hrd/searchLeave', ['as' => 'hrd.searchLeave', 'uses' => 'HRD\Leave\LeaveController@searchLeaveEmp' ]);
Route::any('/hrd/leaveHistory', ['as' => 'hrd.leaveHistory', 'uses' => 'HRD\Leave\LeaveController@leaveHistory' ]);
Route::post('/hrd/searchLeaveHistory', ['as' => 'hrd.searchLeaveHistory', 'uses' => 'HRD\Leave\LeaveController@searchLeaveHistory' ]);
Route::get('/hrd/getLeaveEmp/', ['as' => 'hrd.getLeaveEmp', 'uses' => 'HRD\Leave\LeaveController@getLeaveEmp' ]);
Route::post('/hrd/setLeaveEmp/', ['as' => 'hrd.setLeaveEmp', 'uses' => 'HRD\Leave\LeaveController@setLeaveEmp' ]);
Route::get('/hrd/delLeaveEmp/{id}', ['as' => 'hrd.delLeaveEmp', 'uses' => 'HRD\Leave\LeaveController@delLeaveEmp' ]);
Route::post('/hrd/dedLeaveEmp/', ['as' => 'hrd.dedLeaveEmp', 'uses' => 'HRD\Leave\LeaveController@dedLeaveEmp' ]);
Route::get('/hrd/leaveType/', ['as' => 'hrd.getLeave', 'uses' => 'HRD\Leave\LeaveController@getLeave' ]);
Route::post('/hrd/setLeaveType/', ['as' => 'hrd.setLeaveType', 'uses' => 'HRD\Leave\LeaveController@setLeaveType' ]);
Route::get('/hrd/delLeaveType/{id}', ['as' => 'hrd.delLeaveType', 'uses' => 'HRD\Leave\LeaveController@delLeaveType' ]);
Route::any('/hrd/holiday', ['as' => 'hrd.holiday', 'uses' => 'HRD\Leave\HolidayController@index']);
Route::any('/hrd/holiday/filter', ['as' => 'hrd.holidayFilter', 'uses' => 'HRD\Leave\HolidayController@filter']);
Route::any('/hrd/getHoliday', ['as' => 'hrd.getHoliday', 'uses' => 'HRD\Leave\HolidayController@getHoliday']);
Route::any('/hrd/delHoliday/{id}', ['as' => 'hrd.delHoliday', 'uses' => 'HRD\Leave\HolidayController@delHoliday']);
Route::post('/hrd/setHoliday', ['as' => 'hrd.setHoliday', 'uses' => 'HRD\Leave\HolidayController@setHoliday']);
Route::any('hrd/leave', ['as' => 'hrd.leaveEmp', 'uses' => 'HRD\Leave\LeaveController@leaveHis']);
Route::post('/hrd/setAppLeave/', ['as' => 'hrd.setAppLeave', 'uses' => 'HRD\Leave\LeaveController@setAppLeave' ]);

Route::any('/hrd/trainEmp', ['as' => 'hrd.trainEmp', 'uses' => 'HRD\Training\TrainingController@trainEmpList']);
Route::get('/hrd/getTrainEmp', ['as' => 'hrd.getTrainEmp', 'uses' => 'HRD\Training\TrainingController@getTrainEmp']);
Route::post('/hrd/setTrainEmp', ['as' => 'hrd.setTrainEmp', 'uses' => 'HRD\Training\TrainingController@setTrainEmp']);
Route::get('/hrd/appTrain/{id}', ['as' => 'hrd.appTrain', 'uses' => 'HRD\Training\TrainingController@appTrain']);
Route::get('/hrd/delTrain/{id}', ['as' => 'hrd.delTrain', 'uses' => 'HRD\Training\TrainingController@delTrain']);
Route::get('/hrd/print_training', ['as' => 'hrd.print_training', 'uses' => 'HRD\Training\TrainingController@print_training']);
Route::post('/hrd/setTrainTopik', ['as' => 'hrd.setTrainTopik', 'uses' => 'HRD\Training\TrainingController@setTrainTopik']);
Route::post('/hrd/setVendorTrain', ['as' => 'hrd.setVendorTrain', 'uses' => 'HRD\Training\TrainingController@setVendorTrain']);

Route::any('/hrd/inout', ['as' => 'hrd.inout', 'uses' => 'HRD\Attendance\AttController@inout_index']);
Route::post('/hrd/inout_search_emp', ['as' => 'hrd.inout_search_emp', 'uses' => 'HRD\Attendance\AttController@search_emp']);
Route::any('/hrd/attReq', ['as' => 'hrd.attReq', 'uses' => 'HRD\Attendance\AttController@attReq']);
Route::any('/hrd/appAtt/{id}', ['as' => 'hrd.appAtt', 'uses' => 'HRD\Attendance\AttController@appAtt']);
Route::any('/hrd/attReqLeave', ['as' => 'hrd.appAttLeave', 'uses' => 'HRD\Attendance\AttController@setAttAppLeave']);
Route::any('/hrd/setReqLeave', ['as' => 'hrd.setAttLeave', 'uses' => 'HRD\Attendance\AttController@setAttLeave']);
Route::any('/hrd/attReqList', ['as' => 'hrd.attReqList', 'uses' => 'HRD\Attendance\AttController@attReqList']);


Route::post('/hrd/setYearAppraisal', ['as' => 'hrd.setYearAppraisal', 'uses' => 'HRD\Emp\AppraisalController@setAppraisalYear']);
//Route::post('/hrd/setEvaluator', ['as' => 'hrd.setEvaluator', 'uses' => 'HRD\Emp\AppraisalController@setEvaluator']);

Route::any('/hrd/appraisal', ['as' => 'hrd.appraisal', 'uses' => 'HRD\Emp\AppraisalController@index']);
Route::any('/hrd/addEmpAppraisal', ['as' => 'hrd.addEmpAppraisal', 'uses' => 'HRD\Emp\AppraisalController@empAppraisal']);
Route::get('/hrd/deleteEmpAppraisal/{id}', ['as' => 'hrd.deleteEmpAppraisal', 'uses' => 'HRD\Emp\AppraisalController@deleteEmpAppraisal']);
Route::post('/hrd/empAssignAdd', ['as' => 'hrd.empAssignAdd', 'uses' => 'HRD\Emp\AppraisalController@empAssignAdd']);
Route::get('/hrd/getAssign', ['as' => 'hrd.getAssign', 'uses' => 'HRD\Emp\AppraisalController@getAssign']);
Route::get('/hrd/appraisal/{id}/view', ['as' => 'hrd.appraisal.view', 'uses' => 'HRD\Emp\AppraisalController@view']);
Route::any('/hrd/evaluator', ['as' => 'hrd.evaluator', 'uses' => 'HRD\Emp\AppraisalController@evaluator']);
Route::post('/hrd/setEvaluator', ['as' => 'hrd.setEvaluator', 'uses' => 'HRD\Emp\AppraisalController@setEvaluator']);
Route::get('/hrd/getEvaluator', ['as' => 'hrd.getEvaluator', 'uses' => 'HRD\Emp\AppraisalController@getEvaluator']);
Route::get('/hrd/getEvaluator', ['as' => 'hrd.getEvaluator', 'uses' => 'HRD\Emp\AppraisalController@getEvaluator']);
Route::get('/hrd/deleteEvaluator/{id}', ['as' => 'hrd.deleteEvaluator', 'uses' => 'HRD\Emp\AppraisalController@deleteEvaluator']);
Route::post('/hrd/getEvaluated', ['as' => 'hrd.getEvaluated', 'uses' => 'HRD\Emp\AppraisalController@getEvaluated']);
Route::get('/hrd/getResult', ['as' => 'hrd.getResult', 'uses' => 'HRD\Emp\AppraisalController@getResult']);
Route::any('/hrd/rekap', ['as' => 'hrd.rekap', 'uses' => 'HRD\Emp\AppraisalController@rekap']);

Route::any('/hrd/overTime', ['as' => 'hrd.overTime', 'uses' => 'HRD\OverTime\OverTimeController@index']);
Route::post('/hrd/overtimeRequest/add', ['as' => 'hrd.overtime.add', 'uses' => 'HRD\OverTime\OverTimeController@addOverTime']);
Route::post('/hrd/overtimeRequest/save', ['as' => 'hrd.overtime.save', 'uses' => 'HRD\OverTime\OverTimeController@saveOverTime']);
Route::any('/hrd/overtimeRequestList', ['as' => 'hrd.otReqList', 'uses' => 'HRD\OverTime\OverTimeController@otReqList']);

Route::any('/hrd/mutation', ['as' => 'hrd.mutation', 'uses' => 'HRD\Mutations\MutationController@index']);
Route::any('/hrd/setMutation', ['as' => 'hrd.setMutation', 'uses' => 'HRD\Mutations\MutationController@setMutation']);
Route::get('hrd/printMutation/{id}', ['as' => 'hrd.printMutation', 'uses' => 'HRD\Mutations\MutationController@printMutation']);

Route::any('/hrd/perjalanDinas', ['as' => 'hrd.perjalanDinas', 'uses' => 'HRD\PerjalanDinas\PDController@index']);
Route::any('/hrd/perjalanDinasRequest/add', ['as' => 'hrd.perjalanDinasRequest.add', 'uses' => 'HRD\PerjalanDinas\PDController@addPD']);
Route::post('/hrd/perjalanDinasRequest/save', ['as' => 'hrd.perjalanDinasRequest.save', 'uses' => 'HRD\PerjalanDinas\PDController@savePD']);

Route::any('/hrd/recruitment', ['as' => 'hrd.recruitment', 'uses' => 'HRD\Recruitment\RecruitmentController@index']);
Route::get('/hrd/recruitment/getVacan', ['as' => 'hrd.recruitment.getVacan', 'uses' => 'HRD\Recruitment\RecruitmentController@getVacan']);

Route::any('/hrd/recruitment/vacan/create', ['as' => 'hrd.recruitment.create', 'uses' => 'HRD\Recruitment\RecruitmentController@create']);
Route::post('/hrd/recruitment/vacan/store', ['as' => 'hrd.vacan.store', 'uses' => 'HRD\Recruitment\RecruitmentController@store']);

Route::any('/hrd/recruitment/vacan/{id}/edit', ['as' => 'hrd.recruitment.edit', 'uses' => 'HRD\Recruitment\RecruitmentController@edit']);
Route::any('/hrd/recruitment/vacan/update/{id}', ['as' => 'hrd.vacan.update', 'uses' => 'HRD\Recruitment\RecruitmentController@update']);

Route::get('/hrd/recruitment/{id}/show', ['as' => 'hrd.recruitment.show', 'uses' => 'HRD\Recruitment\RecruitmentController@show']);

//HRD Adjust Appraisal
Route::any('/hrd/AdjAppraisal', ['as' => 'hrd.AdjAppraisal', 'uses' => 'HRD\Emp\AppraisalController@AdjAppraisal']);
Route::post('/hrd/viewAdjAppraisal', ['as' => 'hrd.viewAdjAppraisal', 'uses' => 'HRD\Emp\AppraisalController@viewAdjAppraisal']);
Route::post('/setAdjAppraisal', ['as' => 'setAdjAppraisal', 'uses' => 'HRD\Emp\AppraisalController@setAdjAppraisal']);
Route::post('/finalisasiAdj', ['as' => 'finalisasiAdj', 'uses' => 'HRD\Emp\AppraisalController@finalisasiAdj']);
Route::post('/uploadAttachmentAdj', ['as' => 'uploadAttachmentAdj', 'uses' => 'HRD\Emp\AppraisalController@uploadAttachmentAdj']);
Route::get('/downloadFileAttachmentAdj/{id}', ['as' => 'downloadFileAttachmentAdj', 'uses' => 'HRD\Emp\AppraisalController@downloadFileAttachmentAdj'
]);

// HRD Promotions
Route::any('hrd/promotion', ['as' => 'hrd.promotion', 'uses' => 'HRD\Promotions\PromotionController@index']);
Route::any('hrd/promotion/add', ['as' => 'hrd.promotion.add', 'uses' => 'HRD\Promotions\PromotionController@addPromote']);
// Route::post('hrd/promotion/save', ['as' => 'hrd.promotion.save', 'uses' => 'HRD\Promotions\PromotionController@savePD']);
Route::post('hrd/promotion/save', ['as' => 'hrd.promotion.save', 'uses' => 'HRD\Promotions\PromotionController@savePromotion']);
Route::get('hrd/promotionAppv', ['as' => 'hrd.promotionAppv', 'uses' => 'HRD\Promotions\PromotionController@apvPD']);
Route::post('hrd/setPromotion', ['as' => 'hrd.setPromotion', 'uses' => 'HRD\Promotions\PromotionController@setPromotion']);
Route::get('hrd/setPromotionBOD/{id}', ['as' => 'hrd.setPromotionBOD', 'uses' => 'HRD\Promotions\PromotionController@setPromotionBOD']);
Route::post('hrd/setPromotionHRProcess', ['as' => 'hrd.setPromotionHRProcess', 'uses' => 'HRD\Promotions\PromotionController@setPromotionHRProcess']);

Route::get('hrd/printPromotion/{id}', ['as' => 'hrd.printPromotion', 'uses' => 'HRD\Promotions\PromotionController@printPromotion']);
Route::get('hrd/promotion/getEmp', ['as' => 'promotion.getEmp', 'uses' => 'HRD\Promotions\PromotionController@getEmp']);
//Route::post('hrd/promotion/getEmp', ['as' => 'promotion.getEmp', 'uses' => 'HRD\Promotions\PromotionController@getEmp']);

Route::any('hrd/promotionapprlv1', ['as' => 'hrd.promotionapprlv1', 'uses' => 'HRD\Promotions\PromotionController@listRequestPromote']);
Route::get('hrd/promotionapprbod', ['as' => 'hrd.promotionapprbod', 'uses' => 'HRD\Promotions\PromotionController@listRequestPromoteBOD']);
Route::get('hrd/promotionhrprocess', ['as' => 'hrd.promotionhrprocess', 'uses' => 'HRD\Promotions\PromotionController@listRequestPromoteHRProcess']);
// End HRD Promotions

// HRD Demotions
Route::any('hrd/demotion', ['as' => 'hrd.demotion', 'uses' => 'HRD\Demotions\DemotionController@index']);
Route::any('hrd/demotion/add', ['as' => 'hrd.demotion.add', 'uses' => 'HRD\Demotions\DemotionController@addDemote']);
Route::post('hrd/demotion/save', ['as' => 'hrd.demotion.save', 'uses' => 'HRD\Demotions\DemotionController@saveDemotion']);
Route::post('hrd/delDemotion', ['as' => 'hrd.delDemotion', 'uses' => 'HRD\Demotions\DemotionController@delDemotion']);
// End HRD Demotions

// HRD Sync
Route::any('/hrd/sync', ['as' => 'hrd.sync', 'uses' => 'HRD\Sync\SyncController@sync' ]);
Route::post('/hrd/syncProcess', ['as' => 'hrd.syncProcess', 'uses' => 'HRD\Sync\SyncController@syncProcess' ]);

// Report
Route::any('/hrd/rPersonal', ['as' => 'hrd.rPersonal', 'uses' => 'HRD\Reports\RPersonalController@index']);
Route::post('/hrd/search_rPersonal', ['as' => 'hrd.search_rPersonal', 'uses' => 'HRD\Reports\RPersonalController@search']);
Route::get('/hrd/vPersonal/{id}', ['as' => 'hrd.vPersonal', 'uses' => 'HRD\Reports\RPersonalController@view']);
Route::get('/hrd/pPersonal/{id}', ['as' => 'hrd.pPersonal', 'uses' => 'HRD\Reports\RPersonalController@printPersonal']);

// Reports Routes
Route::group(['prefix' => 'hrd', 'middleware' => ['auth']], function () {
    Route::get('rJoinTerminate', 'HRD\Reports\JoinTerminateController@index');
});

// Join & Terminate Report
Route::get('/report_emp_join_terminate', [
    'as' => 'report_emp_join_terminate', 
    'uses' => 'HRD\Reports\JoinTerminateController@reportJoinTerminate'
]);
Route::get('/report_emp_terminate', [
    'as' => 'report_emp_terminate', 
    'uses' => 'HRD\Reports\JoinTerminateController@reportTerminate'
]);

// End Report

// Inductions
Route::any('/hrd/induction', ['as' => 'hrd.induction', 'uses' => 'HRD\Administrations\InductionController@index']);
Route::any('/hrd/induction/add', ['as' => 'hrd.induction.add', 'uses' => 'HRD\Administrations\InductionController@create']);
Route::post('/hrd/induction/save', ['as' => 'hrd.induction.save', 'uses' => 'HRD\Administrations\InductionController@store']);
Route::any('/hrd/induction/file', ['as' => 'hrd.induction.file', 'uses' => 'HRD\Administrations\InductionController@file_list']);
//Route::post('/stsp/update', ['as' => 'stsp.update', 'uses' => 'HRD\Administrations\InductionController@saveEPunishment']);
//Route::post('/delStsp', ['as' => 'delStsp', 'uses' => 'HRD\Administrations\InductionController@delPunishment']);
//Route::post('/stsp/edits/', ['as' => 'stsp.edits', 'uses' => 'HRD\Administrations\InductionController@saveEPunishment']);
Route::post('/delInduction/', ['as' => 'delInduction', 'uses' => 'HRD\Administrations\InductionController@store']);
// End Inductions

//HRD process
Route::get('hrd/HrdProcess', ['as' => 'HrdProcess', 'uses' => 'HRD\HrdProcess\HrdProcessController@index']);
Route::post('hrd/HrdProcess/upload/{id}', ['as' => 'HrdProcess.upload', 'uses' => 'HRD\HrdProcess\HrdProcessController@upload']);
Route::post('hrd/HrdProcess/terminate/{id}', ['as' => 'HrdProcess.terminate', 'uses' => 'HRD\HrdProcess\HrdProcessController@terminate']);
Route::post('hrd/HrdProcess/approve/{id}', ['as' => 'HrdProcess.approve', 'uses' => 'HRD\HrdProcess\HrdProcessController@approve']);
Route::post('hrd/HrdProcess/reject/{id}', ['as' => 'HrdProcess.reject', 'uses' => 'HRD\HrdProcess\HrdProcessController@reject']);
Route::get('hrd/HrdProcess/download/{id}', ['as' => 'HrdProcess.download', 'uses' => 'HRD\HrdProcess\HrdProcessController@download']);
//End HRD process

//HRD printout
Route::get('hrd/Printout/printSuratPerintahKerja/{id}', ['as' => 'Printout.printSuratPerintahKerja', 'uses' => 'HRD\Printout\PrintoutController@printSuratPerintahKerja']);
Route::get('hrd/Printout/printSuratKeputusan/{id}', ['as' => 'Printout.printSuratKeputusan', 'uses' => 'HRD\Printout\PrintoutController@printSuratKeputusan']);
Route::get('hrd/Printout/printSuratKeputusanTMJ/{id}', ['as' => 'Printout.printSuratKeputusanTMJ', 'uses' => 'HRD\Printout\PrintoutController@printSuratKeputusanTMJ']);
Route::get('hrd/Printout/printSuratPernyataanKontrakKerja/{id}', ['as' => 'Printout.printSuratPernyataanKontrakKerja', 'uses' => 'HRD\Printout\PrintoutController@printSuratPernyataanKontrakKerja']);
Route::get('hrd/Printout/printSuratPernyataanMenjagaRahasiaPerusahaan/{id}', ['as' => 'Printout.printSuratPernyataanMenjagaRahasiaPerusahaan', 'uses' => 'HRD\Printout\PrintoutController@printSuratPernyataanMenjagaRahasiaPerusahaan']);
Route::get('hrd/Printout/printSuratPernyataanBerakhirHubunganKerja/{id}', ['as' => 'Printout.printSuratPernyataanBerakhirHubunganKerja', 'uses' => 'HRD\Printout\PrintoutController@printSuratPernyataanBerakhirHubunganKerja']);

//End HRD printout

// -- HRD Route --

// MetHris Mobile
Route::any('/test', ['as' => 'test', 'uses' => 'MetHrisMobile\MetHrisMobileController@test']);
Route::post('/doLogin', ['as' => 'doLogin', 'uses' => 'MetHrisMobile\MetHrisMobileController@Mlogin']);
Route::get('/m/getProfile/{id}', ['middleware' => 'cors', 'as' => 'm.getProfile', 'uses' => 'MetHrisMobile\MetHrisMobileController@getProfile']);
Route::get('/m/getPersonelDetails/{id}', ['middleware' => 'cors', 'as' => 'm.getPersonelDetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getPersonelDetails']);
Route::get('/m/getReportto/{id}', ['middleware' => 'cors', 'as' => 'm.getReportto', 'uses' => 'MetHrisMobile\MetHrisMobileController@getReportto']);
Route::get('/m/getJobInfo/{id}', ['middleware' => 'cors', 'as' => 'm.getJobInfo', 'uses' => 'MetHrisMobile\MetHrisMobileController@getJobInfo']);
Route::get('/m/getReportToJob/{id}', ['middleware' => 'cors', 'as' => 'm.getReportToJob', 'uses' => 'MetHrisMobile\MetHrisMobileController@getReportToJob']);
Route::get('/m/myLeave/{id}', ['middleware' => 'cors', 'as' => 'm.myLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@myLeave']);
Route::get('/m/leaveType/{id}', ['middleware' => 'cors', 'as' => 'm.leaveType', 'uses' => 'MetHrisMobile\MetHrisMobileController@leaveType']);
Route::post('/m/attendanceList', ['middleware' => 'cors', 'as' => 'm.attendanceList', 'uses' => 'MetHrisMobile\MetHrisMobileController@attendanceList']);
Route::get('/m/balLeave/{id}', ['middleware' => 'cors', 'as' => 'm.balLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@balLeave']);
Route::post('/m/applyLeave', ['middleware' => 'cors', 'as' => 'm.applyLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@applyLeave']);
Route::get('/m/getLeaveApprove/{id}', ['middleware' => 'cors', 'as' => 'm.getLeaveApprove', 'uses' => 'MetHrisMobile\MetHrisMobileController@getLeaveApprove']);
Route::get('/m/getLeavedetails/{id}', ['middleware' => 'cors', 'as' => 'm.getLeavedetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getLeavedetails']);
Route::post('/m/approveLeave', ['middleware' => 'cors', 'as' => 'm.approveLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@approveLeave']);
Route::post('/m/myLeavewithtype', ['middleware' => 'cors', 'as' => 'm.myLeavewithtype', 'uses' => 'MetHrisMobile\MetHrisMobileController@myLeavewithtype']);
Route::post('/m/balLeavewithtype', ['middleware' => 'cors', 'as' => 'm.balLeavewithtype', 'uses' => 'MetHrisMobile\MetHrisMobileController@balLeavewithtype']);
Route::post('/m/hitungHari', ['middleware' => 'cors', 'as' => 'm.hitungHari', 'uses' => 'MetHrisMobile\MetHrisMobileController@hitungHari']);
Route::get('/m/gethistoryLeave/{id}', ['middleware' => 'cors', 'as' => 'm.gethistoryLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@gethistoryLeave']);
Route::get('/m/getEmergency/{id}', ['middleware' => 'cors', 'as' => 'm.getEmergency', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEmergency']);
Route::get('/m/getQualifiactions/{id}', ['middleware' => 'cors', 'as' => 'm.getQualifiactions', 'uses' => 'MetHrisMobile\MetHrisMobileController@getQualifiactions']);
Route::get('/m/getEducation/{id}', ['middleware' => 'cors', 'as' => 'm.getEducation', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEducation']);
Route::get('/m/getWorkexperience/{id}', ['middleware' => 'cors', 'as' => 'm.getWorkexperience', 'uses' => 'MetHrisMobile\MetHrisMobileController@getWorkexperience']);
Route::get('/m/getTraining/{id}', ['middleware' => 'cors', 'as' => 'm.getTraining', 'uses' => 'MetHrisMobile\MetHrisMobileController@getTraining']);
Route::get('/m/getAllpersonel/{id}', ['middleware' => 'cors', 'as' => 'm.getAllpersonel', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAllpersonel']);
Route::get('/m/getAttendancenow/{id}', ['middleware' => 'cors', 'as' => 'm.getAttendancenow', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendancenow']);
Route::get('/m/getNationality/{id}', ['middleware' => 'cors', 'as' => 'm.getNationality', 'uses' => 'MetHrisMobile\MetHrisMobileController@getNationality']);
Route::post('/m/updatePersonelDetails', ['middleware' => 'cors', 'as' => 'm.updatePersonelDetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@updatePersonelDetails']);
Route::post('/m/updateContactDetails', ['middleware' => 'cors', 'as' => 'm.updateContactDetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateContactDetails']);
Route::post('/m/addEmergency', ['middleware' => 'cors', 'as' => 'm.addEmergency', 'uses' => 'MetHrisMobile\MetHrisMobileController@addEmergency']);
Route::get('/m/getEmergencyDetails/{id}', ['middleware' => 'cors', 'as' => 'm.getEmergencyDetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEmergencyDetails']);
Route::post('/m/updateEmergencyContact', ['middleware' => 'cors', 'as' => 'm.updateEmergencyContact', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateEmergencyContact']);
Route::post('/m/deleteEmergencyContacts', ['middleware' => 'cors', 'as' => 'm.deleteEmergencyContacts', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteEmergencyContacts']);
Route::get('/m/getEducationinfo/{id}', ['middleware' => 'cors', 'as' => 'm.getEducationinfo', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEducationinfo']);
Route::post('/m/addEducation', ['middleware' => 'cors', 'as' => 'm.addEducation', 'uses' => 'MetHrisMobile\MetHrisMobileController@addEducation']);
Route::get('/m/getEducationdetails/{id}', ['middleware' => 'cors', 'as' => 'm.getEducationdetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEducationdetails']);
Route::post('/m/updateEducation', ['middleware' => 'cors', 'as' => 'm.updateEducation', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateEducation']);
Route::post('/m/deleteEducation', ['middleware' => 'cors', 'as' => 'm.deleteEducation', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteEducation']);
Route::post('/m/addWorkexperience', ['middleware' => 'cors', 'as' => 'm.addWorkexperience', 'uses' => 'MetHrisMobile\MetHrisMobileController@addWorkexperience']);
Route::post('/m/updateWorkexperience', ['middleware' => 'cors', 'as' => 'm.updateWorkexperience', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateWorkexperience']);
Route::post('/m/deleteWorkexperience', ['middleware' => 'cors', 'as' => 'm.deleteWorkexperience', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteWorkexperience']);
Route::get('/m/getWorkexperiencedetails/{id}', ['middleware' => 'cors', 'as' => 'm.getWorkexperiencedetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getWorkexperiencedetails']);
Route::post('/m/changePassword', ['middleware' => 'cors', 'as' => 'm.changePassword', 'uses' => 'MetHrisMobile\MetHrisMobileController@changePassword']);
Route::get('/m/getMyleavedetails/{id}', ['middleware' => 'cors', 'as' => 'm.getMyleavedetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getMyleavedetails']);
Route::post('/m/updateLeave', ['middleware' => 'cors', 'as' => 'm.updateLeave', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateLeave']);
Route::post('/m/addLeaves', ['middleware' => 'cors', 'as' => 'm.addLeaves', 'uses' => 'MetHrisMobile\MetHrisMobileController@addLeaves']);

Route::any('/notif', ['as' => 'notif', 'uses' => 'NotifController@leave']);
Route::get('/notif_leave/{id}', ['as' => 'notif_leave', 'uses' => 'NotifController@notif_leave']);
Route::any('/renewalContract', ['as' => 'renewalContract', 'uses' => 'NotifController@contract']);

Route::get('/tarikabsen', ['as' => 'tarikabsen', 'uses' => 'Crons\AbsenController@tarikAbsen']);

Route::get('/cronAppCuti', ['as' => 'cronAppCuti', 'uses' => 'Crons\CutiController@cronAppCuti']);

Route::get('/hrd/print_appraisal/{id}/{id2}', ['as' => 'hrd.print.appraisal', 'uses' => 'HRD\Emp\AppraisalController@printAppraisal']);

Route::get('/updateEncryptionAppraisal',['as' => 'updateEncryptionAppraisal', 'uses' => 'HRD\Reports\AppraisalController@updateEncryptionAppraisal']);
Route::get('/updateEncryptionAppraisalValue',['as' => 'updateEncryptionAppraisalValue', 'uses' => 'HRD\Reports\AppraisalController@updateEncryptionAppraisalValue']);
Route::get('/updateEncryptionAppraisalValueHistorical',['as' => 'updateEncryptionAppraisalValueHistorical', 'uses' => 'HRD\Reports\AppraisalController@updateEncryptionAppraisalValueHistorical']);

// Report Overtime HRD
Route::get('/overtimeReport', ['as' => 'overtimeReport', 'uses' => 'HRD\Reports\OvertimeController@index']);
Route::get('/viewOvertimeReport', ['as' => 'viewOvertimeReport', 'uses' => 'HRD\Reports\OvertimeController@viewOvertimeReport']);
Route::get('/printOvertimeReport/{id1}/{id2}/{id3}', ['as' => 'printOvertimeReport', 'uses' => 'HRD\Reports\OvertimeController@printOvertimeReport']);
// Report Overtime HRD

Route::group(['middleware' => ['web', 'auth']], function () {
    // Template Contract Routes
    Route::post('hrd/template/add', ['as' => 'hrd.addTemplate', 'uses' => 'HRD\Emp\EmployeeController@addTemplate']);
    Route::post('hrd/template/update', ['as' => 'hrd.updateTemplate', 'uses' => 'HRD\Emp\EmployeeController@updateTemplate']);
    Route::get('hrd/template/delete/{id}', ['as' => 'hrd.deleteTemplate', 'uses' => 'HRD\Emp\EmployeeController@deleteTemplate']);
});


Route::get('/hrd/rEducation', ['as' => 'hrd.rEducation', 'uses' => 'HRD\Reports\EducationController@index']);
Route::post('/hrd/rEducation/search', ['as' => 'hrd.srEducation', 'uses' => 'HRD\Reports\EducationController@search_emp']);
Route::get('/hrd/rEducation/{id}/show', ['as' => 'hrd.rEducation.show', 'uses' => 'HRD\Reports\EducationController@detail']);
Route::get('/hrd/rAge', ['as' => 'hrd.rAge', 'uses' => 'HRD\Reports\KomposisiController@reportUsia']);
Route::get('/hrd/rAge/{id}/show', ['as' => 'hrd.rAge.show', 'uses' => 'HRD\Reports\KomposisiController@reportUsiaShow']);
Route::get('/hrd/rGender', ['as' => 'hrd.rGender', 'uses' => 'HRD\Reports\KomposisiController@reportGender']);
Route::get('/hrd/absen', ['as' => 'hrd.absen', 'uses' => 'HRD\Reports\AttendanceController@index']);
Route::get('/hrd/absen_perorang', ['as' => 'hrd.absen_perorang', 'uses' => 'HRD\Reports\AttendanceController@index_perorg']);
Route::post('/hrd/rekap_perorang', ['as' => 'hrd.rekap_perorang', 'uses' => 'HRD\Reports\AttendanceController@rekap_perorg']);
Route::post('/hrd/rekap_absen', ['as' => 'hrd.rekap_absen', 'uses' => 'HRD\Reports\AttendanceController@rekap']);
Route::get('/hrd/absendw', ['as' => 'hrd.absendw', 'uses' => 'HRD\Reports\AttendanceController@absenDW']);
Route::get('/hrd/absen_dw_perorang', ['as' => 'hrd.absen_dw_perorang', 'uses' => 'HRD\Reports\AttendanceController@index_dw_perorg']);
Route::post('/hrd/rekap_dw_perorang', ['as' => 'hrd.rekap_dw_perorang', 'uses' => 'HRD\Reports\AttendanceController@rekap_dw_perorg']);
Route::post('/hrd/rekap_absendw', ['as' => 'hrd.rekap_absendw', 'uses' => 'HRD\Reports\AttendanceController@rekapDW']);

// Data Karyawan Routes
Route::get('/hrd/data_karyawan', ['as' => 'hrd.data_karyawan', 'uses' => 'HRD\Reports\DataKaryawanController@index']);
Route::post('/hrd/data_karyawan/view', ['as' => 'hrd.view_data_karyawan', 'uses' => 'HRD\Reports\DataKaryawanController@viewDataKaryawan']);
Route::get('/employee/file/{type}/{emp_number}', ['as' => 'employee.file', 'uses' => 'HRD\Emp\EmployeeController@getEmployeeFile']);;