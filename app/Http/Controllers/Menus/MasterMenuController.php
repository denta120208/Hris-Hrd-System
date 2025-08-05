<?php
namespace App\Http\Controllers\Menus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, DB, Log;
use App\Models\Menus\Menu;
class MasterMenuController extends Controller{
    protected $menu;
    public function __construct(Menu $menu){
        $this->menu = $menu;

        parent::__construct();
    }
    public function index(){
        $menus = $this->menu->where('show_menu', 1)->where('is_parent', 1)->get();
//        print_r('<pre>');
//        dd($menus);
//        print_r('</pre>');

        return view('pages.Masters.Menus.list', compact('menus'));
    }
    public function create(Menu $menu){

        return view('pages.Masters.Menus.form', compact('menu'));
    }
    public function store(){
        //
    }
    public function show($id){
        //
    }
    public function edit($id){
        $menu = $this->menu->where('id', $id)->first();
        return view('pages.Masters.Menus.form', compact('menu'));
    }
    public function update(Request $request, $id){
        dd($request->all());
    }
    public function confirm(){
        //
    }
    public function destroy(){
        //
    }
}