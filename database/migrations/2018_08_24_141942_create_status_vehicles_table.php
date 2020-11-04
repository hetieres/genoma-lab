<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatusVehiclesTable extends Migration {

	public function up()
	{
		Schema::create('status_vehicles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('status_vehicles');
	}
}