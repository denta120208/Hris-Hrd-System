<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronAbsenByDateMT extends Command{
    protected $signature = 'cronAbsenByDateMT';

    protected $description = 'cronAbsenByDateMT';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->tarikAbsenByDateMT();
    }

}