<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronAbsen extends Command{
    protected $signature = 'cronAbsen';

    protected $description = 'cronAbsen';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->tarikAbsen();
    }

}