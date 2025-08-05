<?php


namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Crons\AbsenController;

class cronIMPByDate extends Command{
    protected $signature = 'cronIMPByDate';

    protected $description = 'cronIMPByDate';

    public function __construct(AbsenController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->syncIMPByDate();
    }

}