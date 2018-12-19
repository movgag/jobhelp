<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation_notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('invitation_id')->nullable();
            $table->integer('employee_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->string('canceled')->comment('0-not canceled, 1-canceled')->default(0);
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
        Schema::dropIfExists('invitation_notifications');
    }
}
