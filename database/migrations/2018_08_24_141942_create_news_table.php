<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	public function up()
	{
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->string('title');
			$table->text('summary')->nullable();
			$table->longText('text');
			$table->date('dt_publication')->nullable()->index('rel');
			$table->integer('categories_id')->unsigned()->nullable();
			$table->integer('media_types_id')->unsigned()->nullable();
			$table->integer('vehicles_id')->unsigned()->nullable();
			$table->integer('langs_id')->unsigned()->nullable();
			$table->integer('news_status_id')->unsigned();
			$table->integer('citations_types_id')->unsigned()->nullable();
			$table->string('author')->nullable();
			$table->string('publishing')->nullable();
			$table->string('caption_image')->nullable();
			$table->boolean('highlight')->nullable()->default(0);
			$table->string('pages')->nullable();
			$table->string('url')->nullable();
			$table->string('url_fapesp')->nullable()->index('rel');
			$table->integer('users_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('news');
	}
}