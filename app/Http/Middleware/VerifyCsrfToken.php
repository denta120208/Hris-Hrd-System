<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/doLogin', '/updateProfile',
        '/m/register', '/m/getReward', '/m/getProfile', '/m/doUpdateProfile',
        '/m/listRedeem', '/m/appPIN', '/m/setPIN','/m/getPoint','/m/setReward', '/m/setRedeem', '/m/hisRedeem/',
        '/m/cekRegister', '/m/Mlogin/', '/m/attendanceList', '/m/applyLeave', '/m/approveLeave', '/m/myLeavewithtype/', '/m/balLeavewithtype',
        '/m/hitungHari', '/m/updatePersonelDetails', '/m/updateContactDetails', '/m/addEmergency', '/m/updateEmergencyContact', '/m/deleteEmergencyContacts',
        '/m/addEducation', '/m/updateEducation', '/m/deleteEducation', '/m/addWorkexperience', '/m/updateWorkexperience', '/m/deleteWorkexperience', '/m/changePassword',
        '/m/updateLeave', '/m/addLeaves', '/m/deleteLeaves', '/m/getAttendancewithdate', '/m/addAttendancerequest','/m/rejectAttendance','/m/approveAttendance',
        '/m/updateAttendancehrd', '/m/rejectAttendancehrd', '/m/updateJob', '/m/addDependents', '/m/deleteDependents', '/m/updateDependents', '/m/addUserhp','/m/postNotification',
        '/m/addTraining', '/m/updateTraining','/m/deleteTraining','/m/testNotif2','/m/addOvertime','/m/actionOvertime','/m/doLoginV2','/m/addDataEmergencyContact','/m/updateDataEmergencyContact',
        '/m/addEmployeeDependents','/m/updateEmployeeDependents','/m/applyEmployeeLeave','/m/approveEmployeeLeave','/m/rejectEmployeeLeave','/m/userChangePassword','/m/addEmployeeAttendanceRequest'
        ,'/m/addTrainingVendor','/m/addRequestTraining','/m/userChangePasswordFirstTime','/m/doLoginSSO', '/m/updateDataPersonal', '/m/updateContactDetailsInfo', '/m/updateSocialMedia'
    ];
}
