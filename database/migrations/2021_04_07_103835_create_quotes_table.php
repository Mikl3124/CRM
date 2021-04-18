<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateQuotesTable extends Migration
{

  public function up()
  {
    Schema::create('quotes', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->integer('project_id')->unsigned();
      $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade')->nullable();;
      $table->integer('customer_id')->unsigned();
      $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
      $table->string('filename');
      $table->string('url');
      $table->string('token');
      $table->integer('amount');
      $table->set('state', ['pending', 'accepted', 'payed', 'declined'])->default('pending');
    });
  }

  public function down()
  {
    Schema::drop('quotes');
  }
}
