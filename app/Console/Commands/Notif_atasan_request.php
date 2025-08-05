<?php


namespace App\Console\Commands;
use App\Http\Controllers\Mobile\SalesScheduleController;
use Illuminate\Console\Command;
use App\Http\Controllers\Mobile\MobilecontrollerNewLeads;


use App\Http\Controllers\MetHrisMobile\MobileNotificationController;
class Notif_atasan_request extends Command
{
    function __construct(MobileNotificationController $mobileNotif) {
        parent::__construct();
        $this->mobileNotif = $mobileNotif;
    }

    protected $signature = 'notif_atasan_request';

    public function handle()
    {

        $this->mobileNotif->cronCheckNotificationAttendance();
        $this->mobileNotif->cronCheckNotificationLeave();
        $this->mobileNotif->cronCheckNotificationTraining();

    }

}
