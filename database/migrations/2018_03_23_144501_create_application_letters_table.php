<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_letters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->text('apply_letter')->nullable();
            $table->string('excepted_salary')->nullable();
            $table->string('uploaded_cv')->nullable();
            $table->string('status')->default('unanswered');
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
        Schema::dropIfExists('application_letters');
    }
}
