<?php

/**
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | contains the "web" middleware group. Now create something great!
 * |
 */

/* Rotas de Autenticação de usuário */
Auth::routes();
Route::get('/password/new/{token}', 'Auth\NewPasswordController@create')->name('auth-create-password-form');
Route::post('/password/new', 'Auth\ResetPasswordController@reset')->name('auth-create-password-post');

/* Rotas do Administrador */
Route::group(['prefix' => 'fapesp', 'middleware' => ['auth']], function () {
    Route::get('/', 'PostController@index')->name('dashboard');

    // materias
    Route::group(['prefix' => 'materia'], function () {
        Route::get('/', 'PostController@index')->name('post-list');
        Route::get('/destaques', 'PostController@order')->name('post-order');
        // Route::get('/{id}', 'PostController@edit')->name('post-edit');
        Route::get('/nova', 'PostController@edit')->name('post-new');
        Route::get('/{id}/{history_id?}', 'PostController@edit')->name('post-edit');
        Route::get('/compare/{id}/{history_id}', 'PostController@comparation')->name('post-comparation');
    });

    // testes genecticos
    Route::group(['prefix' => 'testes-geneticos'], function () {
        Route::get('/', 'GeneticTestController@index')->name('import-test');
    });

    // users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users')->middleware('admin');
        Route::get('/profile', 'UserController@profile')->name('users-profile');
    });

    // sessions
    Route::group(['prefix' => 'session'], function () {
        Route::get('/{id}', 'SessionController@edit')->name('session-edit')->middleware('admin');
    });

});


/* Rotas do Administrador EN */
Route::group(['prefix' => 'fapesp-en', 'middleware' => ['auth']], function () {
    Route::get('/', 'PostController@index')->name('dashboard-en');

    // materias
    Route::group(['prefix' => 'materia'], function () {
        Route::get('/', 'PostController@index')->name('post-list-en');
        Route::get('/destaques', 'PostController@order')->name('post-order-en');
        // Route::get('/{id}', 'PostController@edit')->name('post-edit');
        Route::get('/nova', 'PostController@edit')->name('post-new-en');
        Route::get('/{id}/{history_id?}', 'PostController@edit')->name('post-edit-en');
        Route::get('/compare/{id}/{history_id}', 'PostController@comparation')->name('post-comparation-en');
    });

    // users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users-en')->middleware('admin-en');
        Route::get('/profile', 'UserController@profile')->name('users-profile-en');
    });

    // sessions
    Route::group(['prefix' => 'session'], function () {
        Route::get('/{id}', 'SessionController@edit')->name('session-edit-en')->middleware('admin');
    });

});

/* Rota para limpar cache */
Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
});

/* Rota para Robots.txt */
Route::get('robots.txt', function () {
    $robots = new \Robots\Robots;

    // If on the live server
    if (App::environment() == 'production') {
        $robots->addUserAgent('*')->addDisallow("/fapesp")/* ->addSitemap('sitemap.xml') */;
    } else {
        // If you're on any other server, tell everyone to go away.
        $robots->addUserAgent('*')->addDisallow("/");
    }
    return response($robots->generate(), 200)->header('Content-Type', 'text/plain');
});


/* Site map */
Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap');
Route::get('/sitemap.xml/{slug?}/{pg?}', 'SitemapController@internals')->name('sitemap-internals');


Route::get('/import', 'DataImportController@import')->name('import');


/* Rotas do site  PT */
Route::get('/', 'SiteController@index')->name('home');
Route::get('/especialidades', 'SiteController@especialidades')->name('especialidades');
Route::get('/pesquisa', 'SiteController@pesquisa')->name('pesquisa');

Route::get('/teste/{id?}', 'SiteController@teste')->name('teste');
Route::match(array('GET','POST'), '/solicitar-teste/{id?}', 'SiteController@solicitacao')->name('solicitacao');



/* Rotas do site  EN */
Route::group(['prefix' => 'en'], function () {
    Route::get('/', 'SiteController@index')->name('home-en');
    Route::get('/search', 'SiteController@search')->name('search-en');
});

/* Rotas do site gerais */
Route::get('/{slug?}/{id?}', 'SiteController@detalhe')->name('detalhe');
// Route::get('/{title}/{id}/{page?}', 'SiteController@detail')->name('detalhe');




// Route::get('/coronavirus', 'SiteController@coronavirus')->name('coronavirus');
// Route::get('/paises/{description}/{id}/{page?}', 'SiteController@country')->name('country');
// Route::get('/{id}', 'SiteController@detail');
