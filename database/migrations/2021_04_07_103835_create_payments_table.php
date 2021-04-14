<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration
{

  public function up()
  {
    Schema::create('payments', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->string('quote_id');
      $table->integer('amount');
      $table->integer('customer_id');
    });
  }

  public function down()
  {
    Schema::drop('payments');
  }
}
