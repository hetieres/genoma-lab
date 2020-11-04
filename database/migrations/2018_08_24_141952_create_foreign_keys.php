<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('categories_id')->references('id')->on('categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('media_types_id')->references('id')->on('media_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('vehicles_id')->references('id')->on('vehicles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('langs_id')->references('id')->on('langs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('news_status_id')->references('id')->on('news_status')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('citations_types_id')->references('id')->on('citations_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('users_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('data_imports', function(Blueprint $table) {
			$table->foreign('news_id')->references('id')->on('news')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('vehicles', function(Blueprint $table) {
			$table->foreign('country_id')->references('id')->on('countries')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('vehicles', function(Blueprint $table) {
			$table->foreign('status_vehicles_id')->references('id')->on('status_vehicles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_categories_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_media_types_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_vehicles_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_langs_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_news_status_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_citations_types_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_users_id_foreign');
		});
		Schema::table('data_imports', function(Blueprint $table) {
			$table->dropForeign('data_imports_news_id_foreign');
		});
		Schema::table('vehicles', function(Blueprint $table) {
			$table->dropForeign('vehicles_country_id_foreign');
		});
		Schema::table('vehicles', function(Blueprint $table) {
			$table->dropForeign('vehicles_status_vehicles_id_foreign');
		});
	}
}