<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronAbsenByDate extends Command{
    protected $signature = 'cronAbsenByDate';

    protected $description = 'cronAbsenByDate';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->tarikAbsenByDate();
    }

}