<?php
namespace App\Http\Controllers\Services;


use App\Http\Controllers\Controller;
use App\Models\Master\Employee;

class DownloadController extends Controller{
    protected $emp;
    public function __construct(Employee $emp){
        $this->emp = $emp;
        parent::__construct();
    }
    public function index(){

    }
}