<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_dependents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ed_emp_id', 50);
            $table->string('ed_name', 255);
            $table->string('ed_relationship', 50);
            $table->date('ed_date_of_birth');
            $table->timestamps();
        });

        // Add foreign key separately to avoid issues with SQL Server
        Schema::table('employee_dependents', function (Blueprint $table) {
            $table->foreign('ed_emp_id')
                  ->references('emp_number')
                  ->on('employee')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_dependents');
    }
} 