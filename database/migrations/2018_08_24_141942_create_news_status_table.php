<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsStatusTable extends Migration {

	public function up()
	{
		Schema::create('news_status', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('news_status');
	}
}