<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{

  public function up()
  {
    Schema::create('customers', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->unsignedBigInteger('user_id')->index()->references('id')->on('users')->onDelete('cascade')->nullable();
      $table->string('email')->unique();
      $table->string('firstname')->nullable();
      $table->string('lastname')->nullable();
      $table->string('phone')->nullable();
      $table->string('address')->nullable();
      $table->string('zip')->nullable();
      $table->string('town')->nullable();
      $table->string('stripe_id')->nullable();
    });
  }

  public function down()
  {
    Schema::drop('customers');
  }
}
