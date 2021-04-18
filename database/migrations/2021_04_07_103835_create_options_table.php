<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOptionsTable extends Migration
{

  public function up()
  {
    Schema::create('options', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->integer('customer_id')->unsigned();
      $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
      $table->string('description');
      $table->integer('amount');
      $table->integer('quote_id');
    });
  }

  public function down()
  {
    Schema::drop('options');
  }
}
