<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsVacansiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs_vacansies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->nullable();
            $table->integer('region_id')->nullable();
            $table->string('place')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('type_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('closing_date')->nullable();
            $table->integer('salary')->nullable();
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
        Schema::dropIfExists('jobs_vacansies');
    }
}
