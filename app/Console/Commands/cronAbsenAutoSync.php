<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronAbsenAutoSync extends Command{
    protected $signature = 'cronAbsenAutoSync';

    protected $description = 'cronAbsenAutoSync';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->tarikAbsenAutoSync();
    }

}