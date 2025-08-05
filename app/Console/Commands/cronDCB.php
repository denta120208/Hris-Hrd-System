<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\CutiController;

class cronDCB extends Command{
    protected $signature = 'cronDCB';

    protected $description = 'Command description';

    public function __construct(CutiController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->deleteDoubleCB();
    }

}