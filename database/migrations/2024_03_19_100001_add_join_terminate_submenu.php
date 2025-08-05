<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddJoinTerminateSubmenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Dapatkan ID menu Reports
        $reportsMenu = DB::table('menus')
            ->where('title', 'Reports')
            ->first();

        if ($reportsMenu) {
            // Tambahkan submenu Join & Terminate
            DB::table('menus')->insert([
                'title' => 'Join & Terminate',
                'uri' => 'hrd/rJoinTerminate',
                'parent_id' => $reportsMenu->id,
                'is_parent' => 0,
                'show_menu' => 1,
                'icon' => 'fa fa-users',
                'manage_status' => 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('menus')
            ->where('uri', 'hrd/rJoinTerminate')
            ->delete();
    }
} 