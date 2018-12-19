<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeJobsVacansiesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jobs_vacansies', function (Blueprint $table) {
            $table->tinyInteger('status')->after('salary')->comment('1-active , 0-passive')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs_vacansies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
