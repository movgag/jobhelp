<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('application_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('application_notifications');
    }
}
