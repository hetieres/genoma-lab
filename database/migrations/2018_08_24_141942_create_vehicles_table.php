<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesTable extends Migration {

	public function up()
	{
		Schema::create('vehicles', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->nullable();
			$table->integer('country_id')->unsigned()->nullable();
			$table->integer('status_vehicles_id')->unsigned();
			$table->string('state')->nullable();
			$table->string('city')->nullable();
			$table->string('url')->nullable();
			$table->integer('import_id')->unique()->nullable();
			$table->integer('unify_id')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('vehicles');
	}
}