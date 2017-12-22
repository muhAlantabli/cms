<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Eloquent\SoftDeletes;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('parent')->unsigned()->nullable();
            $table->foreign('parent')->references('id')->on('categories');
            
            $table->string('image');
            
            $table->integer('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            
            $table->integer('updated_by')->unsigned();
            $table->foreign('updated_by')->references('id')->on('users');

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
        Schema::dropIfExists('categories');
    }
}
