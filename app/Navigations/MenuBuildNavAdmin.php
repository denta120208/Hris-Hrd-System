<?php

namespace App\Navigations;

use Session, DB, Log;
//use App\Menu;

class MenuBuildNav {
    public static function menus(){
        $now = date('Y-m-d H:i:s');
        $day = date("N",strtotime($now));
        $menu = array();
        $perms = Session::get('perms');
        $query = DB::select(DB::raw("
        SELECT DISTINCT p.* FROM menus as p INNER JOIN menus as c ON p.id = c.parent_id
        WHERE c.id IN (".$perms.")
        UNION ALL
        SELECT * FROM menus WHERE id IN (".$perms.");
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
                $menu[$i]['icon'] = $row->icon;
                $i++;
            }
        }
        $html_out = '<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Dashboard</a></li>';

        for ($i = 1; $i <= count($menu); $i++){
            if (is_array($menu[$i])){    // must be by construction but let's keep the errors home
                if ($menu[$i]['show'] && $menu[$i]['parent'] == 0){    // are we allowed to see this menu?
                    $uri = $menu[$i]['uri'];
                    if ($menu[$i]['is_parent'] == TRUE) {
                        $html_out .= '<li class="dropdown"><a href="'.$menu[$i]['uri'].'" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$menu[$i]['title'].' <span class="caret"></span></a>';
                    }else{
                        $html_out .= '<li><a href="'.url($uri).'">'.$menu[$i]['title'].'</a>';
                    }
                    // loop through and build all the child submenus.
                    $html_out .= self::get_childs($menu, $menu[$i]['id'], "nav-second-level");
                    $html_out .= '</li>';
                }
            }
        }
        $html_out .= '</ul></div></div></nav>';
        return $html_out;
    }
    public static function get_childs($menu, $parent_id, $level){
        $has_subcats = FALSE;
        $html_out  = '';
        $html_out .= '<ul class="dropdown-menu">';
        for ($i = 1; $i <= count($menu); $i++){
            if (is_array($menu[$i])){
                if ($menu[$i]['show'] && $menu[$i]['parent'] == $parent_id){    // are we allowed to see this menu?
                    $has_subcats = TRUE;
                    $uri = $menu[$i]['uri'];
                    if ($menu[$i]['is_parent'] == TRUE){
                        $html_out .= '<li><a href="javascript:void(0)">'.$menu[$i]['title'].'<span class="fa arrow"></span></a></li>';
                    }
                    else{
                        $html_out .= '<li><a href="'.url($uri).'" id="'.$uri.'">'.$menu[$i]['title'].'</a></li>';
                    }
//                    $html_out .= self::get_childs($menu, $menu[$i]['id'], "nav-second-level");
//                    $html_out .= '</li>';
                }
            }
        }
        $html_out .= '</ul>';
        return ($has_subcats) ? $html_out : FALSE;
    }
}