<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCitationsTypesTable extends Migration {

	public function up()
	{
		Schema::create('citations_types', function(Blueprint $table) {
			$table->increments('id');
			$table->string('description')->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('citations_types');
	}
}