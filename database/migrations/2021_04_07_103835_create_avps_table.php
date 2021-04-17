<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAvpsTable extends Migration
{

  public function up()
  {
    Schema::create('avps', function (Blueprint $table) {
      $table->increments('id');
      $table->timestamps();
      $table->integer('project_id')->unsigned();
      $table->string('url');
      $table->string('token');
      $table->string('avp_url');
      $table->string('filename');
      $table->boolean('payed')->default(false);
    });
  }

  public function down()
  {
    Schema::drop('avps');
  }
}
