<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotifController;

class cronContract extends Command
{
    protected $signature = 'cronContract';

    protected $description = 'Command description';

    public function __construct(NotifController $data){
        parent::__construct();
        $this->data = $data;
    }
    public function handle(){
        $this->data->index();
    }
}
