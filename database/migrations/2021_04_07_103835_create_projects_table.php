<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProjectsTable extends Migration
{

	public function up()
	{
		Schema::create('projects', function (Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
			$table->string('statement')->default('pending');
			$table->string('title');
		});
	}

	public function down()
	{
		Schema::drop('projects');
	}
}
