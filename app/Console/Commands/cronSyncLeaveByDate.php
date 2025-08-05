<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronSyncLeaveByDate extends Command{
    protected $signature = 'cronSyncLeaveByDate';

    protected $description = 'cronSyncLeaveByDate';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->syncCutiByDate();
    }

}