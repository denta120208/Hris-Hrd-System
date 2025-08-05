<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User, Session, Validation, DB, Log;

class UserController extends Controller
{
    protected $user;
    
    function __construct(User $user) {
        $this->user = $user;
        
        parent::__construct();
    }
   
    public function index()
    {
        $users = $this->user->get();
        return view('pages.users.list_u', compact('users'));
    }

    public function create(User $user){
        $menuESS_parents = DB::select('select * from menus where manage_status = 0');
        $menuESS_childs = DB::select('select * from menus where manage_status = 0 and is_parent = 0');
        $menuSup_parents = DB::select("select * from menus where manage_status = '1'");
        $menuSup_childs = DB::select("select * from menus where manage_status = '1' and is_parent = '0'");
        return view('pages.users.form', compact('user', 'menuESS_parents', 'menuESS_childs', 'menuSup_parents', 'menuSup_childs'));
    }
    public function store(Requests\Users\StoreUserRequest $request)
    {
        $req = implode(',', $request->menu_perms);
        $project = DB::select("select * from project WHERE project_code = '".$request->project_code."'");
        $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'perms_name' => $request->perms_name,
            'permission' => $req,
            'project_code' => $request->project_code,
            'pnum' => $project[0]->code,
            'ptype' => $project[0]->seq,
            'is_manage' => $request->is_manage
        ]);
        Log::info('================CREATE USER===================');
        Log::info('User '.Session::get('name').' has Created A User.');
        Log::info('====================================');
        return redirect(route('users.index'))->with('status', 'A User Has Been Created');
        
    }
    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        return view('pages.users.show', compact('user'));
    }
    public function edit($id)
    {
        $user = $this->user->findOrFail($id);
        $menu_parents = DB::select('select * from menus');
        $menu_childs = DB::select('select * from menus where is_parent = 0');
//        $projects = DB::select("select * from project WHERE project_code <> 'HO'");
        return view('pages.users.form', compact('user', 'menu_parents', 'menu_childs', 'projects'));
    }
    public function changePass(Requests\Users\UpdatePassword $request){
        $plain = $request->password;
        try{
            $user = $this->user->findOrFail(Session::get('userid'));
            $user->fill([
                'password' => $request->password,
                'decrypt' => $request->password
            ])->save();
            return redirect(route('auth.logout'))->with('status', 'Your Password has been change');
        }catch (\ErrorException $e){

        }
    }
    public function update(Requests\Users\UpdateUserRequest $request, $id)
    {   
        $req = implode(',', $request->menu_perms);
        $user = $this->user->findOrFail($id);
        if(!empty($request->password)){
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => $request->password,
                'perms_name' => $request->perms_name,
                'permission' => $req,
                'project_code' => $request->project_code

            ]);
        }else{
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'perms_name' => $request->perms_name,
                'permission' => $req,
                'project_code' => $request->project_code

            ]);
        }
        $user->save();
        Log::info('================EDIT USER===================');
        Log::info('User '.Session::get('name').' has Edited A User.');
        Log::info('====================================');
        return redirect(route('users.index'))->with('status', 'A User Has Been Edited');
    }
    
    public function confirm(Requests\Users\DeleteUserRequest $request, $id){
        $user = $this->user->findOrFail($id);
        $menu_parents = DB::select('select * from menus');
        $menu_childs = DB::select('select * from menus where is_parent = 0');
        
        return view('pages.users.conf_del', compact('user', 'menu_parents', 'menu_childs'));
    }
    public function destroy(Requests\Users\DeleteUserRequest $request, $id)
    {
        $user = $this->user->findOrFail($id);
        $user->fill([
            'status' => false,
            'delete_by' => auth()->user()->id,
            'delete_at' => date('Y-m-d H:i:s')
        ])->save();
        
        Log::info('================DELETE USER===================');
        Log::info('User '.Session::get('name').' has Deleted A User.');
        Log::info('==============================================');
        
        return redirect(route('users.index'))->with('status', 'A User Has Been Deleted');
    }
    public function activate(Requests\Users\DeleteUserRequest $request, $id){
        $user = $this->user->findOrFail($id);
        $user->fill([
            'status' => true,
            'delete_by' => NULL,
            'delete_at' => NULL
        ])->save();
        
        Log::info('================Activate USER===================');
        Log::info('User '.Session::get('name').' has Activate A User.');
        Log::info('==============================================');
        
        return redirect(route('users.index'))->with('status', 'A User Has Been Actived');
    }
    public function profile($id){
        if($id == auth()->user()->id):
            $user = $this->user->findOrFail($id);
            return view('pages.users.form_profile', compact('user'));
        else:
            Log::error('================UPDATE PROFILE===================');
            Log::error('User '.Session::get('name').' trying to access user id '.$id);
            Log::error('==============================================');
            return redirect()->back()->withErrors([
                'error' => 'Forbidden Access, Please Contact Administrator.'
            ]);
        endif;
    }
    public function save_profile(Requests\Users\UpdateProfileRequest $request, $id){
        $user = $this->user->findOrFail($id);
        if(!empty($request->password)){
            $user->fill([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
        }else{
            $user->fill([
                'name' => $request->name,
                'email' => $request->email
            ]);
        }
        $user->save();
        Log::info('================UPDATE USER PROFILE===================');
        Log::info('User '.Session::get('name').' has Updated profile.');
        Log::info('======================================================');
        
        return redirect(route('users.index'))->with('status', 'Password has been changed');
    }
//    public function getMenus(Request $request){}
}
