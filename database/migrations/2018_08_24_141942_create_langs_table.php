<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLangsTable extends Migration {

	public function up()
	{
		Schema::create('langs', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('langs');
	}
}