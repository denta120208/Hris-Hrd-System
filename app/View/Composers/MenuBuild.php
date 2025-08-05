<?php

namespace App\View\Composers;

use Session, DB, Log;
use App\Menu;

class MenuBuild{
     public function menu_build(){
        $menu = array();
        $perms = Session::get('perms');
        $query = DB::select(DB::raw("
        SELECT DISTINCT p.* FROM ml_Loyalty..menus as p INNER JOIN ml_Loyalty..menus as c ON p.id = c.parent_id
        WHERE c.id IN (".$perms.")
        UNION ALL
        SELECT * FROM ml_Loyalty..menus WHERE id IN (".$perms.");
        "));
        
        if (!empty($query)){
            $i = 1;
            foreach ($query as $row)
            {
                $menu[$i]['id'] = $row->id;
                $menu[$i]['title'] = $row->title;
                $menu[$i]['uri'] = $row->uri;
                $menu[$i]['parent'] = $row->parent_id;
                $menu[$i]['is_parent'] = $row->is_parent;
                $menu[$i]['show'] = $row->show_menu;
                $i++;
            }
        }
        $html_out = "<div class='navbar-default sidebar' role='navigation'>
	        <div class='sidebar-nav navbar-collapse'>
	            <ul class='nav' id='side-menu'>
                    <li>
                        <a href='". route('dashboard'). "'><i class='fa fa-dashboard fa-fw'></i> Dashboard</a>
                    </li>
       	";
        for ($i = 1; $i <= count($menu); $i++){
            if (is_array($menu[$i])){    // must be by construction but let's keep the errors home
                if ($menu[$i]['show'] && $menu[$i]['parent'] == 0){    // are we allowed to see this menu?
                    $uri = $menu[$i]['uri'];
                    if ($menu[$i]['is_parent'] == TRUE) {
                        $html_out .= '<li><a href="'.$menu[$i]['uri'].'">'.$menu[$i]['title'].'<span class="fa arrow"></span></a>';
                    }else{
                        $html_out .= '<li><a href="'.url($uri).'">'.$menu[$i]['title'].'<span></span></a>';
                    }
                    // loop through and build all the child submenus.
                    $html_out .= $this->get_childs($menu, $menu[$i]['id'], "nav-second-level");

                    $html_out .= '</li>';
                }
            }
        }
        $html_out .= '</ul></div></div>';
        return $html_out;
    }
    function get_childs($menu, $parent_id, $level){
        $has_subcats = FALSE;

        $html_out  = '';
        $html_out .= "<ul class='nav ".$level."'>";
	                	
        for ($i = 1; $i <= count($menu); $i++){
        	if (is_array($menu[$i])){
	            if ($menu[$i]['show'] && $menu[$i]['parent'] == $parent_id){    // are we allowed to see this menu?
                    $has_subcats = TRUE;
                    $uri = $menu[$i]['uri'];	
	                if ($menu[$i]['is_parent'] == TRUE){
                            $html_out .= '<li><a href="javascript:void(0)">'.$menu[$i]['title'].'<span class="fa arrow"></span></a>';
	                }
	                else{
                            $html_out .= '<li><a href="'.url($uri).'">'.$menu[$i]['title'].'<span></span></a>';
	                }	
	                $html_out .= '</li>';
	            }
			}
        }
        $html_out .= '</ul>';
        return ($has_subcats) ? $html_out : FALSE;
    }
}