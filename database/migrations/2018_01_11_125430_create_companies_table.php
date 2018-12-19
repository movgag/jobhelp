<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('address')->nullable();
            $table->string('coordinate')->nullable();
            $table->string('web_site')->nullable();
            $table->string('image')->nullable();
            $table->integer('status')->default(0);
            $table->integer('views')->default(0);
            $table->string('verify_code')->nullable(0);
            $table->integer('verify')->default(0);
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
        Schema::drop('companies');
    }
}
