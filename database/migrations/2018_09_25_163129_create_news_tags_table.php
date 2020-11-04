<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTagsTable extends Migration {

	public function up()
	{
		Schema::create('news_tags', function(Blueprint $table) {
			$table->integer('tag_id')->unsigned();
			$table->integer('news_id')->unsigned();
			$table->timestamps();
			$table->primary(['tag_id', 'news_id']);
		});
	}

	public function down()
	{
		Schema::drop('news_tags');
	}
}