<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fields', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('collection_id');
            $table->string('name');
            $table->string('label');
            $table->string('type');
            $table->string('form_label');
            $table->string('form_element');
            $table->string('form_instructions')->nullable();
            $table->integer('sort')->default(0);
            $table->text('db');

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
        Schema::drop('fields');
    }
}
