<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediaTypesTable extends Migration {

	public function up()
	{
		Schema::create('media_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('media_types');
	}
}