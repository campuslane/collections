<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('models', function (Blueprint $table) {

            $table->increments('id');
            $table->integer('collection_id');
            $table->string('file');
            $table->string('namespace');
            $table->string('class');
            $table->string('class_with_namespace');
            $table->string('table');
            $table->string('guarded');
            $table->string('fillable');
            $table->string('protected');
            $table->string('rules');

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
        Schema::drop('models');
    }
}
