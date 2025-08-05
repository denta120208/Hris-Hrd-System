<?php


namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Http\Controllers\Mobile\MobilecontrollerNewLeads;


use App\Http\Controllers\MetHrisMobile\MobileNotificationController;
class Notif_attendancenotvalid extends Command
{
    function __construct(MobileNotificationController $mobileNotif) {
        parent::__construct();
        $this->mobileNotif = $mobileNotif;
    }

    protected $signature = 'notif_attendancenotvalid';

    public function handle()
    {
        $this->mobileNotif->cronCheckAttendance();
        $this->mobileNotif->cronCheckBirthday();

    }

}
