<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('phone')->nullable();
            $table->string('languages')->nullable();
            $table->string('work_time')->nullable();
            $table->string('salary')->nullable();
            $table->string('cv_files')->nullable();
            $table->string('address')->nullable();
            $table->integer('views')->nullable();
            $table->string('verify_code')->nullable();
            $table->integer('verify')->default(0);
            $table->date('date_of_birth')->nullable();
            $table->integer('status')->default(0);
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('employees');
    }
}
