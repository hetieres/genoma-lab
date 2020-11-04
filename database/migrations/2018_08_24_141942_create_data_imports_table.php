<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataImportsTable extends Migration {

	public function up()
	{
		Schema::create('data_imports', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('news_id')->unsigned();
			$table->string('news_id_import');
			$table->string('url');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('data_imports');
	}
}