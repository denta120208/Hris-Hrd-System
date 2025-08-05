<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdministrationDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administration_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('emp_number', 50);
            $table->integer('document_type');
            $table->string('updated_by', 100)->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });

        // Tambahkan foreign key setelah tabel dibuat
        Schema::table('administration_documents', function (Blueprint $table) {
            $table->foreign('emp_number')
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
        Schema::dropIfExists('administration_documents');
    }
} 