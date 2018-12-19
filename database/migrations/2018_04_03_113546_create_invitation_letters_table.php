<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_letters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->text('invitation_letter')->nullable();
            $table->tinyInteger('canceled')->comment('0-not canceled, 1-canceled')->default(0);
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
        Schema::dropIfExists('invitation_letters');
    }
}
