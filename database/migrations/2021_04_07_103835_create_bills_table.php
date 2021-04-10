<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBillsTable extends Migration {

	public function up()
	{
		Schema::create('bills', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('url');
			$table->string('project_id');
		});
	}

	public function down()
	{
		Schema::drop('bills');
	}
}