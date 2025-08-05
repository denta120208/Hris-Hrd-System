<?php

//Route::get('/', function () {
//    return redirect(route('auth.login'));
//});
// MetHris Mobile
//Route::post('/m/Mlogin', ['as' => 'm.Mlogin', 'uses' => 'MetHrisMobile\MetHrisMobileController@Mlogin']);
//Route::post('/doLogin', ['as' => 'doLogin', 'uses' => 'MetHrisMobile\MetHrisMobileController@Mlogin']);
Route::get('/m/testData', ['middleware' => 'cors', 'as' => 'm.testData', 'uses' => 'MetHrisMobile\MetHrisMobileController@testData']);
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
Route::post('/m/deleteLeaves', ['middleware' => 'cors', 'as' => 'm.deleteLeaves', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteLeaves']);
Route::get('/m/getAttendance/{id}', ['middleware' => 'cors', 'as' => 'm.getAttendance', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendance']);
Route::post('/m/getAttendancewithdate', ['middleware' => 'cors', 'as' => 'm.getAttendancewithdate', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendancewithdate']);
Route::get('/m/getAttendancedetails/{id}', ['middleware' => 'cors', 'as' => 'm.getAttendancedetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendancedetails']);
Route::post('/m/addAttendancerequest', ['middleware' => 'cors', 'as' => 'm.addAttendancerequest', 'uses' => 'MetHrisMobile\MetHrisMobileController@addAttendancerequest']);
Route::get('/m/getAttendancereqapprove/{id}', ['middleware' => 'cors', 'as' => 'm.getAttendancereqapprove', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendancereqapprove']);
Route::post('/m/rejectAttendance', ['middleware' => 'cors', 'as' => 'm.rejectAttendance', 'uses' => 'MetHrisMobile\MetHrisMobileController@rejectAttendance']);
Route::post('/m/approveAttendance', ['middleware' => 'cors', 'as' => 'm.approveAttendance', 'uses' => 'MetHrisMobile\MetHrisMobileController@approveAttendance']);
Route::get('/m/getAttendancehrd/{id}', ['middleware' => 'cors', 'as' => 'm.getAttendancehrd', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendancehrd']);
Route::post('/m/updateAttendancehrd', ['middleware' => 'cors', 'as' => 'm.updateAttendancehrd', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateAttendancehrd']);
Route::post('/m/rejectAttendancehrd', ['middleware' => 'cors', 'as' => 'm.rejectAttendancehrd', 'uses' => 'MetHrisMobile\MetHrisMobileController@rejectAttendancehrd']);
Route::get('/m/searchPersonel/{id}', ['middleware' => 'cors', 'as' => 'm.searchPersonel', 'uses' => 'MetHrisMobile\MetHrisMobileController@searchPersonel']);
Route::get('/m/getJobtitle/{id}', ['middleware' => 'cors', 'as' => 'm.getJobtitle', 'uses' => 'MetHrisMobile\MetHrisMobileController@getJobtitle']);
Route::get('/m/getLocation/{id}', ['middleware' => 'cors', 'as' => 'm.getLocation', 'uses' => 'MetHrisMobile\MetHrisMobileController@getLocation']);
Route::get('/m/getSubunit/{id}', ['middleware' => 'cors', 'as' => 'm.getSubunit', 'uses' => 'MetHrisMobile\MetHrisMobileController@getSubunit']);
Route::get('/m/getEmploymentstatus/{id}', ['middleware' => 'cors', 'as' => 'm.getEmploymentstatus', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEmploymentstatus']);
Route::post('/m/updateJob', ['middleware' => 'cors', 'as' => 'm.updateJob', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateJob']);
Route::get('/m/getDependents/{id}', ['middleware' => 'cors', 'as' => 'm.getDependents', 'uses' => 'MetHrisMobile\MetHrisMobileController@getDependents']);
Route::get('/m/getDependentsdetails/{id}', ['middleware' => 'cors', 'as' => 'm.getDependentsdetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getDependentsdetails']);
Route::post('/m/addDependents', ['middleware' => 'cors', 'as' => 'm.addDependents', 'uses' => 'MetHrisMobile\MetHrisMobileController@addDependents']);
Route::post('/m/deleteDependents', ['middleware' => 'cors', 'as' => 'm.deleteDependents', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteDependents']);
Route::post('/m/updateDependents', ['middleware' => 'cors', 'as' => 'm.updateDependents', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateDependents']);
Route::get('/m/getProfilepicture/{id}', ['middleware' => 'cors', 'as' => 'm.getProfilepicture', 'uses' => 'MetHrisMobile\MetHrisMobileController@getProfilepicture']);
Route::get('/m/getEmprewards/{id}', ['middleware' => 'cors', 'as' => 'm.getEmprewards', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEmprewards']);
Route::get('/m/getEmppromotion/{id}', ['middleware' => 'cors', 'as' => 'm.getEmppromotion', 'uses' => 'MetHrisMobile\MetHrisMobileController@getEmppromotion']);
Route::get('/m/getNotification/{id}', ['middleware' => 'cors', 'as' => 'm.getNotification', 'uses' => 'MetHrisMobile\MetHrisMobileController@getNotification']);
Route::post('/m/updateDependents', ['middleware' => 'cors', 'as' => 'm.updateDependents', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateDependents']);
Route::post('/m/addUserhp', ['middleware' => 'cors', 'as' => 'm.addUserhp', 'uses' => 'MetHrisMobile\MetHrisMobileController@addUserhp']);
Route::post('/m/postNotification', ['middleware' => 'cors', 'as' => 'm.postNotification', 'uses' => 'MetHrisMobile\MetHrisMobileController@postNotification']);
Route::post('/m/addTraining', ['middleware' => 'cors', 'as' => 'm.addTraining', 'uses' => 'MetHrisMobile\MetHrisMobileController@addTraining']);
Route::get('/m/getTrainingdetails/{id}', ['middleware' => 'cors', 'as' => 'm.getTrainingdetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getTrainingdetails']);
Route::post('/m/updateTraining', ['middleware' => 'cors', 'as' => 'm.updateTraining', 'uses' => 'MetHrisMobile\MetHrisMobileController@updateTraining']);
Route::post('/m/deleteTraining', ['middleware' => 'cors', 'as' => 'm.deleteTraining', 'uses' => 'MetHrisMobile\MetHrisMobileController@deleteTraining']);
Route::get('/m/testNotif', ['middleware' => 'cors', 'as' => 'm.testNotif', 'uses' => 'MetHrisMobile\MetHrisMobileController@test']);
Route::get('/m/testNotif2', ['middleware' => 'cors', 'as' => 'm.testNotif2', 'uses' => 'HRD\Emp\AppraisalController@test']);
Route::get('/m/getNews/{id}', ['middleware' => 'cors', 'as' => 'm.getNews', 'uses' => 'MetHrisMobile\MetHrisMobileController@getNews']);
Route::get('/m/getNewsdetails/{id}', ['middleware' => 'cors', 'as' => 'm.getNewsdetails', 'uses' => 'MetHrisMobile\MetHrisMobileController@getNewsdetails']);
Route::get('/m/getOvertime/{id}', ['middleware' => 'cors', 'as' => 'm.getOvertime', 'uses' => 'MetHrisMobile\MetHrisMobileController@getOvertime']);
Route::post('/m/addOvertime', ['middleware' => 'cors', 'as' => 'm.addOvertime', 'uses' => 'MetHrisMobile\MetHrisMobileController@addOvertime']);
Route::get('/m/getOvertimewithdate/{id}/{start_date}/{end_date}', ['middleware' => 'cors', 'as' => 'm.getOvertimewithdate', 'uses' => 'MetHrisMobile\MetHrisMobileController@getOvertimewithdate']);
Route::get('/m/getOvertimerequest/{id}', ['middleware' => 'cors', 'as' => 'm.getOvertimerequest', 'uses' => 'MetHrisMobile\MetHrisMobileController@getOvertimerequest']);
Route::post('/m/actionOvertime', ['middleware' => 'cors', 'as' => 'm.actionOvertime', 'uses' => 'MetHrisMobile\MetHrisMobileController@actionOvertime']);
Route::get('/m/checkVersionApp/{id}', ['middleware' => 'cors', 'as' => 'm.checkVersionApp', 'uses' => 'MetHrisMobile\MetHrisMobileController@checkVersionApp']);
Route::get('/m/getAttendanceType', ['middleware' => 'cors', 'as' => 'm.getAttendanceType', 'uses' => 'MetHrisMobile\MetHrisMobileController@getAttendanceType']);
Route::get('/m/getHolidayDate', ['middleware' => 'cors', 'as' => 'm.getHolidayDate', 'uses' => 'MetHrisMobile\MetHrisMobileController@getHolidayDate']);


//Demo
Route::get('/m/getDemoEmpPicture/{id}', ['middleware' => 'cors', 'as' => 'm.getDemoEmpPicture', 'uses' => 'MetHrisMobile\MobileDemoController@getDemoEmpPicture']);



//API v2

//UserController
Route::get('/m/getUserProfile', ['middleware' => 'cors', 'as' => 'm.getUserProfile', 'uses' => 'MetHrisMobile\MobileUserController@getUserProfile']);
Route::get('/m/getUserPicture', ['middleware' => 'cors', 'as' => 'm.getUserPicture', 'uses' => 'MetHrisMobile\MobileUserController@getUserPicture']);
//Route::get('/m/getAttendanceV2', ['middleware' => 'cors', 'as' => 'm.getAttendanceV2', 'uses' => 'MetHrisMobile\MobileUserController@getAttendanceV2']);
Route::get('/m/getAttendanceNowV2', ['middleware' => 'cors', 'as' => 'm.getAttendanceNowV2', 'uses' => 'MetHrisMobile\MobileUserController@getAttendanceNowV2']);
Route::get('/m/getPersonelDetailsV2', ['middleware' => 'cors', 'as' => 'm.getPersonelDetailsV2', 'uses' => 'MetHrisMobile\MobileUserController@getPersonelDetailsV2']);
Route::get('/m/getEmployeeJobV2', ['middleware' => 'cors', 'as' => 'm.getEmployeeJobV2', 'uses' => 'MetHrisMobile\MobileUserController@getEmployeeJobV2']);
Route::get('/m/getEmployeeReportToV2', ['middleware' => 'cors', 'as' => 'm.getEmployeeReportToV2', 'uses' => 'MetHrisMobile\MobileUserController@getEmployeeReportToV2']);
Route::post('/m/userChangePassword', ['middleware' => 'cors', 'as' => 'm.userChangePassword', 'uses' => 'MetHrisMobile\MobileUserController@userChangePassword']);
Route::post('/m/userChangePassword1', ['middleware' => 'cors', 'as' => 'm.userChangePassword1', 'uses' => 'MetHrisMobile\MobileUserController@userChangePassword1']);
Route::get('/m/cancelAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.cancelAttendanceRequest', 'uses' => 'MetHrisMobile\MobileUserController@cancelAttendanceRequest']);
Route::get('/m/getAllRequestAtasan', ['middleware' => 'cors', 'as' => 'm.getAllRequestAtasan', 'uses' => 'MetHrisMobile\MobileUserController@getAllRequestAtasan']);
Route::post('/m/userChangePasswordFirstTime', ['middleware' => 'cors', 'as' => 'm.userChangePasswordFirstTime', 'uses' => 'MetHrisMobile\MobileUserController@userChangePasswordFirstTime']);
Route::post('/m/userChangePasswordFirstTime1', ['middleware' => 'cors', 'as' => 'm.userChangePasswordFirstTime1', 'uses' => 'MetHrisMobile\MobileUserController@userChangePasswordFirstTime1']);


//AttendanceController
Route::get('/m/getAttendanceV2', ['middleware' => 'cors', 'as' => 'm.getAttendanceV2', 'uses' => 'MetHrisMobile\MobileAttendanceController@getAttendanceV2']);
Route::get('/m/getAttendancewithdateV2', ['middleware' => 'cors', 'as' => 'm.getAttendancewithdateV2', 'uses' => 'MetHrisMobile\MobileAttendanceController@getAttendancewithdateV2']);
Route::get('/m/getEmployeeAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.getEmployeeAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@getEmployeeAttendanceRequest']);
Route::get('/m/getEmployeeAttendanceHistory', ['middleware' => 'cors', 'as' => 'm.getEmployeeAttendanceHistory', 'uses' => 'MetHrisMobile\MobileAttendanceController@getEmployeeAttendanceHistory']);
Route::post('/m/addEmployeeAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.addEmployeeAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@addEmployeeAttendanceRequest']);
Route::get('/m/cancelAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.cancelAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@cancelAttendanceRequest']);
Route::get('/m/getAtasanAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.getAtasanAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@getAtasanAttendanceRequest']);
Route::get('/m/approveAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.approveAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@approveAttendanceRequest']);
Route::get('/m/approveAttendanceRequest1', ['middleware' => 'cors', 'as' => 'm.approveAttendanceRequest1', 'uses' => 'MetHrisMobile\MobileAttendanceController@approveAttendanceRequest1']);
Route::get('/m/rejectAttendanceRequest', ['middleware' => 'cors', 'as' => 'm.rejectAttendanceRequest', 'uses' => 'MetHrisMobile\MobileAttendanceController@rejectAttendanceRequest']);
Route::get('/m/getLocation', ['middleware' => 'cors', 'as' => 'm.getLocation', 'uses' => 'MetHrisMobile\MobileAttendanceController@getLocation']);
Route::get('/m/getAttendanceLocation', ['middleware' => 'cors', 'as' => 'm.getAttendanceLocation', 'uses' => 'MetHrisMobile\MobileAttendanceController@getAttendanceLocation']);
Route::post('/m/signInAttendance', ['middleware' => 'cors', 'as' => 'm.signInAttendance', 'uses' => 'MetHrisMobile\MobileAttendanceController@signInAttendance']);
Route::post('/m/signOutAttendance', ['middleware' => 'cors', 'as' => 'm.signOutAttendance', 'uses' => 'MetHrisMobile\MobileAttendanceController@signOutAttendance']);
Route::get('/m/checkLocationProject', ['middleware' => 'cors', 'as' => 'm.checkLocationProject', 'uses' => 'MetHrisMobile\MobileAttendanceController@checkLocationProject']);



//AuthController
Route::post('/m/doLoginV2', ['middleware' => 'cors', 'as' => 'm.doLoginV2', 'uses' => 'MetHrisMobile\MobileAuthController@doLogin']);
Route::get('/m/checkDataUserLogin', ['middleware' => 'cors', 'as' => 'm.checkDataUserLogin', 'uses' => 'MetHrisMobile\MobileAuthController@checkDataUserLogin']);
Route::get('/m/testHash', ['middleware' => 'cors', 'as' => 'm.testHash', 'uses' => 'MetHrisMobile\MobileAuthController@testHash']);
Route::get('/m/doLogoutApps', ['middleware' => 'cors', 'as' => 'm.doLogoutApps', 'uses' => 'MetHrisMobile\MobileAuthController@doLogoutApps']);


//Leave Contreoller
Route::get('/m/getLeaveEmp', ['middleware' => 'cors', 'as' => 'm.getLeaveEmp', 'uses' => 'MetHrisMobile\MobileLeaveController@getLeaveEmp']);
Route::post('/m/applyEmployeeLeave', ['middleware' => 'cors', 'as' => 'm.applyEmployeeLeave', 'uses' => 'MetHrisMobile\MobileLeaveController@applyEmployeeLeave1']);
Route::get('/m/getEmployeeLeaveRequest', ['middleware' => 'cors', 'as' => 'm.getEmployeeLeaveRequest', 'uses' => 'MetHrisMobile\MobileLeaveController@getEmployeeLeaveRequest']);
Route::get('/m/cancelEmployeeLeaveRequest', ['middleware' => 'cors', 'as' => 'm.cancelEmployeeLeaveRequest', 'uses' => 'MetHrisMobile\MobileLeaveController@cancelEmployeeLeaveRequest']);
Route::get('/m/getEmployeeLeaveHistory', ['middleware' => 'cors', 'as' => 'm.getEmployeeLeaveHistory', 'uses' => 'MetHrisMobile\MobileLeaveController@getEmployeeLeaveHistory']);
Route::get('/m/getAtasanLeaveRequest', ['middleware' => 'cors', 'as' => 'm.getAtasanLeaveRequest', 'uses' => 'MetHrisMobile\MobileLeaveController@getAtasanLeaveRequest']);
Route::post('/m/approveEmployeeLeave', ['middleware' => 'cors', 'as' => 'm.approveEmployeeLeave', 'uses' => 'MetHrisMobile\MobileLeaveController@approveEmployeeLeave']);
Route::post('/m/approveEmployeeLeave1', ['middleware' => 'cors', 'as' => 'm.approveEmployeeLeave1', 'uses' => 'MetHrisMobile\MobileLeaveController@approveEmployeeLeave1']);
Route::post('/m/rejectEmployeeLeave', ['middleware' => 'cors', 'as' => 'm.rejectEmployeeLeave', 'uses' => 'MetHrisMobile\MobileLeaveController@rejectEmployeeLeave']);
Route::get('/m/getLeaveTypeActive', ['middleware' => 'cors', 'as' => 'm.getLeaveTypeActive', 'uses' => 'MetHrisMobile\MobileLeaveController@getLeaveTypeActive']);
Route::get('/m/getLeaveWithType', ['middleware' => 'cors', 'as' => 'm.getLeaveWithType', 'uses' => 'MetHrisMobile\MobileLeaveController@getLeaveWithType']);
Route::get('/m/getAllPIC', ['middleware' => 'cors', 'as' => 'm.getAllPIC', 'uses' => 'MetHrisMobile\MobileLeaveController@getAllPIC']);


//Emergency Controller
Route::get('/m/getEmergencyContact', ['middleware' => 'cors', 'as' => 'm.getEmergencyContact', 'uses' => 'MetHrisMobile\MobileEmergencyContactController@getEmergencyContact']);
Route::post('/m/addDataEmergencyContact', ['middleware' => 'cors', 'as' => 'm.addDataEmergencyContact', 'uses' => 'MetHrisMobile\MobileEmergencyContactController@addDataEmergencyContact']);
Route::post('/m/updateDataEmergencyContact', ['middleware' => 'cors', 'as' => 'm.updateDataEmergencyContact', 'uses' => 'MetHrisMobile\MobileEmergencyContactController@updateDataEmergencyContact']);
Route::get('/m/deleteDataEmergencyContact', ['middleware' => 'cors', 'as' => 'm.deleteDataEmergencyContact', 'uses' => 'MetHrisMobile\MobileEmergencyContactController@deleteDataEmergencyContact']);


//Depndents Controller
Route::get('/m/getEmployeeDependents', ['middleware' => 'cors', 'as' => 'm.getEmployeeDependents', 'uses' => 'MetHrisMobile\MobileDependentsController@getEmployeeDependents']);
Route::post('/m/addEmployeeDependents', ['middleware' => 'cors', 'as' => 'm.addEmployeeDependents', 'uses' => 'MetHrisMobile\MobileDependentsController@addEmployeeDependents']);
Route::post('/m/updateEmployeeDependents', ['middleware' => 'cors', 'as' => 'm.updateEmployeeDependents', 'uses' => 'MetHrisMobile\MobileDependentsController@updateEmployeeDependents']);
Route::get('/m/deleteEmployeeDependents', ['middleware' => 'cors', 'as' => 'm.deleteEmployeeDependents', 'uses' => 'MetHrisMobile\MobileDependentsController@deleteEmployeeDependents']);


//Qualification Controller
Route::get('/m/getEmployeeEducation', ['middleware' => 'cors', 'as' => 'm.getEmployeeEducation', 'uses' => 'MetHrisMobile\MobileQualificationController@getEmployeeEducation']);
Route::get('/m/getEmployeeTraining', ['middleware' => 'cors', 'as' => 'm.getEmployeeTraining', 'uses' => 'MetHrisMobile\MobileQualificationController@getEmployeeTraining']);
Route::get('/m/getEmployeeWorkexperience', ['middleware' => 'cors', 'as' => 'm.getEmployeeWorkexperience', 'uses' => 'MetHrisMobile\MobileQualificationController@getEmployeeWorkexperience']);
Route::get('/m/getTrainingTopic', ['middleware' => 'cors', 'as' => 'm.getTrainingTopic', 'uses' => 'MetHrisMobile\MobileQualificationController@getTrainingTopic']);
Route::get('/m/getTrainingVendor', ['middleware' => 'cors', 'as' => 'm.getTrainingVendor', 'uses' => 'MetHrisMobile\MobileQualificationController@getTrainingVendor']);
Route::post('/m/addTrainingVendor', ['middleware' => 'cors', 'as' => 'm.addTrainingVendor', 'uses' => 'MetHrisMobile\MobileQualificationController@addTrainingVendor']);
Route::get('/m/getEmployeeTrainingRequest', ['middleware' => 'cors', 'as' => 'm.getEmployeeTrainingRequest', 'uses' => 'MetHrisMobile\MobileQualificationController@getEmployeeTrainingRequest']);
Route::get('/m/getEmployeeTrainingHistory', ['middleware' => 'cors', 'as' => 'm.getEmployeeTrainingHistory', 'uses' => 'MetHrisMobile\MobileQualificationController@getEmployeeTrainingHistory']);
Route::get('/m/cancelRequestTraining', ['middleware' => 'cors', 'as' => 'm.cancelRequestTraining', 'uses' => 'MetHrisMobile\MobileQualificationController@cancelRequestTraining']);
Route::post('/m/addRequestTraining', ['middleware' => 'cors', 'as' => 'm.addRequestTraining', 'uses' => 'MetHrisMobile\MobileQualificationController@addRequestTraining']);
Route::get('/m/getAtasanTrainingRequest', ['middleware' => 'cors', 'as' => 'm.getAtasanTrainingRequest', 'uses' => 'MetHrisMobile\MobileQualificationController@getAtasanTrainingRequest']);
Route::get('/m/approveRequestTraining', ['middleware' => 'cors', 'as' => 'm.approveRequestTraining', 'uses' => 'MetHrisMobile\MobileQualificationController@approveRequestTraining']);
Route::get('/m/rejectRequestTraining', ['middleware' => 'cors', 'as' => 'm.rejectRequestTraining', 'uses' => 'MetHrisMobile\MobileQualificationController@rejectRequestTraining']);
Route::get('/m/getLevelEducation', ['middleware' => 'cors', 'as' => 'm.getLevelEducation', 'uses' => 'MetHrisMobile\MobileQualificationController@getLevelEducation']);
Route::post('/m/addNewEducation', ['middleware' => 'cors', 'as' => 'm.addNewEducation', 'uses' => 'MetHrisMobile\MobileQualificationController@addNewEducation']);
Route::post('/m/updateDataEducation', ['middleware' => 'cors', 'as' => 'm.updateDataEducation', 'uses' => 'MetHrisMobile\MobileQualificationController@updateDataEducation']);
Route::post('/m/addNewWorkExperience', ['middleware' => 'cors', 'as' => 'm.addNewWorkExperience', 'uses' => 'MetHrisMobile\MobileQualificationController@addNewWorkExperience']);
Route::post('/m/updateWorkExperienceInfo', ['middleware' => 'cors', 'as' => 'm.updateWorkExperienceInfo', 'uses' => 'MetHrisMobile\MobileQualificationController@updateWorkExperienceInfo']);
Route::get('/m/deleteDataEducation', ['middleware' => 'cors', 'as' => 'm.deleteDataEducation', 'uses' => 'MetHrisMobile\MobileQualificationController@deleteDataEducation']);
Route::get('/m/deleteDataWorkExperience', ['middleware' => 'cors', 'as' => 'm.deleteDataWorkExperience', 'uses' => 'MetHrisMobile\MobileQualificationController@deleteDataWorkExperience']);


//Reward Punishment Controller
Route::get('/m/getEmployeeRewards', ['middleware' => 'cors', 'as' => 'm.getEmployeeRewards', 'uses' => 'MetHrisMobile\MobileRewardsPunishmentController@getEmployeeRewards']);
Route::get('/m/getEmployeePromotions', ['middleware' => 'cors', 'as' => 'm.getEmployeePromotions', 'uses' => 'MetHrisMobile\MobileRewardsPunishmentController@getEmployeePromotions']);
Route::get('/m/getEmployeePunishments', ['middleware' => 'cors', 'as' => 'm.getEmployeePunishments', 'uses' => 'MetHrisMobile\MobileRewardsPunishmentController@getEmployeePunishments']);


//Notification Controller
Route::get('/m/TestsendNotifalluser', ['middleware' => 'cors', 'as' => 'm.TestsendNotifalluser', 'uses' => 'MetHrisMobile\MobileNotificationController@TestsendNotifalluser']);
Route::get('/m/requestLeaveNotification/{id}', ['middleware' => 'cors', 'as' => 'm.requestLeaveNotification', 'uses' => 'MetHrisMobile\MobileNotificationController@requestLeaveNotification']);
Route::get('/m/postNotifUser/{emp_number}/{title}/{desc}', ['middleware' => 'cors', 'as' => 'm.postNotifUser', 'uses' => 'MetHrisMobile\MobileNotificationController@postNotifUser']);
Route::get('/m/getAllNotificationNotRead', ['middleware' => 'cors', 'as' => 'm.getAllNotificationNotRead', 'uses' => 'MetHrisMobile\MobileNotificationController@getAllNotificationNotRead']);
Route::get('/m/getAllNotification', ['middleware' => 'cors', 'as' => 'm.getAllNotificationNotRead', 'uses' => 'MetHrisMobile\MobileNotificationController@getAllNotification']);
Route::get('/m/getAllNotificationGeneral', ['middleware' => 'cors', 'as' => 'm.getAllNotificationGeneral', 'uses' => 'MetHrisMobile\MobileNotificationController@getAllNotificationGeneral']);
Route::get('/m/cronCheckAttendance', ['middleware' => 'cors', 'as' => 'm.cronCheckAttendance', 'uses' => 'MetHrisMobile\MobileNotificationController@cronCheckAttendance']);
Route::get('/m/cronCheckNotificationLeave', ['middleware' => 'cors', 'as' => 'm.cronCheckNotificationLeave', 'uses' => 'MetHrisMobile\MobileNotificationController@cronCheckNotificationLeave']);
Route::get('/m/cronCheckNotificationTraining', ['middleware' => 'cors', 'as' => 'm.cronCheckNotificationTraining', 'uses' => 'MetHrisMobile\MobileNotificationController@cronCheckNotificationTraining']);
Route::get('/m/cronCheckNotificationAttendance', ['middleware' => 'cors', 'as' => 'm.cronCheckNotificationAttendance', 'uses' => 'MetHrisMobile\MobileNotificationController@cronCheckNotificationAttendance']);
Route::get('/m/clearAllNotification', ['middleware' => 'cors', 'as' => 'm.clearAllNotification', 'uses' => 'MetHrisMobile\MobileNotificationController@clearAllNotification']);
Route::get('/m/cronCheckBirthday', ['middleware' => 'cors', 'as' => 'm.cronCheckBirthday', 'uses' => 'MetHrisMobile\MobileNotificationController@cronCheckBirthday']);



//Personel Controller
Route::get('/m/getEmployeePersonelList', ['middleware' => 'cors', 'as' => 'm.getEmployeePersonelList', 'uses' => 'MetHrisMobile\MobilePersonelController@getEmployeePersonelList']);
Route::get('/m/getNation', ['middleware' => 'cors', 'as' => 'm.getNation', 'uses' => 'MetHrisMobile\MobilePersonelController@getNation']);
Route::get('/m/getAgama', ['middleware' => 'cors', 'as' => 'm.getAgama', 'uses' => 'MetHrisMobile\MobilePersonelController@getAgama']);
Route::post('/m/updateDataPersonal', ['middleware' => 'cors', 'as' => 'm.updateDataPersonal', 'uses' => 'MetHrisMobile\MobilePersonelController@updateDataPersonal']);
Route::post('/m/updateContactDetailsInfo', ['middleware' => 'cors', 'as' => 'm.updateContactDetailsInfo', 'uses' => 'MetHrisMobile\MobilePersonelController@updateContactDetailsInfo']);
Route::post('/m/updateSocialMedia', ['middleware' => 'cors', 'as' => 'm.updateSocialMedia', 'uses' => 'MetHrisMobile\MobilePersonelController@updateSocialMedia']);


//Apps Settings
Route::get('/m/getAppsSettings', ['middleware' => 'cors', 'as' => 'm.getAppsSettings', 'uses' => 'MetHrisMobile\MobileAppSettingsController@getAppsSettings']);
Route::get('/m/getAppsHelp', ['middleware' => 'cors', 'as' => 'm.getAppsHelp', 'uses' => 'MetHrisMobile\MobileAppSettingsController@getAppsHelp']);


//SSO Controller
Route::post('/m/doLoginSSO', ['middleware' => 'cors', 'as' => 'm.doLoginSSO', 'uses' => 'MetHrisMobile\MobileSSOController@doLoginSSO']);


//File Controller
Route::get('/m/getAllFiles', ['middleware' => 'cors', 'as' => 'm.getAllFiles', 'uses' => 'MetHrisMobile\MobileFileController@getAllFiles']);
Route::get('/m/addDownloadViewCount', ['middleware' => 'cors', 'as' => 'm.addDownloadViewCount', 'uses' => 'MetHrisMobile\MobileFileController@addDownloadViewCount']);
Route::get('/m/getAllFiles2', ['middleware' => 'cors', 'as' => 'm.getAllFiles2', 'uses' => 'MetHrisMobile\MobileFileController@getAllFiles2']);



//Induction Controller
Route::get('/m/getAllInductionTraining', ['middleware' => 'cors', 'as' => 'm.getAllInductionTraining', 'uses' => 'MetHrisMobile\MobileInductionTrainingController@getAllInductionTraining']);


Route::get('/m/getEmpLoyalty/{id}', ['middleware' => 'cors', 'as' => 'm.getEmpLoyalty', 'uses' => 'MetHrisMobile\MobileEmpLoyalty@getDataEmp']);

Route::get('/m/getAllEmp/', ['middleware' => 'cors', 'as' => 'm.getAllEmp', 'uses' => 'MetHrisMobile\MobileEmpLoyalty@getAllEmp']);