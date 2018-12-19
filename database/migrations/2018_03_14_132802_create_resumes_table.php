<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->nullable();
            $table->string('image')->nullable();
            $table->string('country')->default('Armenia');
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('web_site')->nullable();
            $table->text('self_description')->nullable();
            $table->string('university_name')->nullable();
            $table->string('degree')->nullable();
            $table->text('education_description')->nullable();
            $table->string('job_title')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->text('job_description')->nullable();
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
        Schema::dropIfExists('resumes');
    }
}
