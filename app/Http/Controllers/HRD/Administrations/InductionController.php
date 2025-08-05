<?php

namespace App\Http\Controllers\HRD\Administrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Employee, App\Models\Inductions\Induction, App\Models\Inductions\InductionResult;
use Session;

class InductionController extends Controller{
    protected $emp;
    protected $ind;
    protected $indR;
    public function __construct(Employee $emp, Induction $ind, InductionResult $indR){
        $this->emp = $emp;
        $this->ind = $ind;
        $this->indR = $indR;
        parent::__construct();
    }
    public function index(){
        $now = date('Y-m-d H:i:s');
        if($this->checkPermission() == false){ return redirect(route('auth.logout'))->with('alert-error',"You Unauthorize to Access");}

        $inds = $this->ind->where('status', '1')->where('pnum', Session::get('pnum'))->where('pnum', Session::get('pnum'))->get();
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Introduction Index',
            'module' => 'Administration',
            'sub_module' => 'Introduction',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Introduction Index ' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'induction_trainning'
        ]);
        
        return view('pages.manage.inductions.index', compact('inds'));
    }
    public function create(Induction $ind){
        $now = date('Y-m-d H:i:s');
        if($this->checkPermission() == false){ return redirect(route('auth.logout'))->with('alert-error',"You Unauthorize to Access");}

        \DB::table('log_activity')->insert([
            'action' => 'HRD View Create Introduction',
            'module' => 'Administration',
            'sub_module' => 'Introduction',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Create Introduction' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'induction_trainning'
        ]);
        
        return view('pages.manage.inductions.form', compact('ind'));
    }
    public function store(Request $request){
        $now = date('Y-m-d H:i:s');
        if($this->checkPermission() == false){ return redirect(route('auth.logout'))->with('alert-error',"You Unauthorize to Access");}
        $this->ind->insert([
            'name' => $request->name,
            'url_gform' => $request->url_gform,
            'status' => '1',
            'project_code' => Session::get('project'),
            'pnum' => Session::get('pnum'),
            'ptype' => Session::get('ptype'),
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Session::get('username')
        ]);
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View Store Introduction',
            'module' => 'Administration',
            'sub_module' => 'Introduction',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View Store Introduction, name'.$request->name ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => 'induction_trainning'
        ]);
        
        return redirect(route('hrd.induction'));
    }
    public function file_list(){
        $now = date('Y-m-d H:i:s');
        if($this->checkPermission() == false){ 
            return redirect(route('auth.logout'))->with('alert-error',"You Unauthorize to Access");
        }
        $files = '';
        
        \DB::table('log_activity')->insert([
            'action' => 'HRD View File List',
            'module' => 'Administration',
            'sub_module' => 'Introduction',
            'modified_by' => Session::get('name'),
            'description' => 'HRD View File List,' ,
            'created_at' => $now,
            'updated_at' => $now,
            'table_activity' => ''
        ]);
        
        return view('pages.manage.inductions.form', compact('files'));
    }
}