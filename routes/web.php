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
        Route::get('/{id}', 'PostController@edit')->name('post-edit');
        Route::get('/nova', 'PostController@edit')->name('post-edit');
    });

    // users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@index')->name('users')->middleware('admin');
        Route::get('/profile', 'UserController@profile')->name('users-profile');
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

/* Rotas do site */
Route::get('/', 'SiteController@index')->name('home');
Route::get('/pesquisa', 'SiteController@search')->name('search');
Route::get('/educacaodifusoes', 'SiteController@educacaodifusoes')->name('educacaodifusoes');
Route::get('/videos', 'SiteController@videos')->name('videos');
Route::get('/pesquisas', 'SiteController@pesquisas')->name('pesquisas');



Route::group(['prefix' => 'projetos-apoiados'], function () {
    Route::get('/tecnologias', 'SiteController@tecnologias')->name('tecnologias');
    Route::get('/suplementos', 'SiteController@suplementos')->name('suplementos');
});


Route::get('/conhecaogenoma', 'SiteController@conhecaogenoma')->name('conhecaogenoma');
Route::get('/projetospesquisas', 'SiteController@projetospesquisa')->name('projetospesquisa');
Route::get('/namidia', 'SiteController@namidia')->name('namidia');


Route::get('/{slug?}/{id?}', 'SiteController@detalhe')->name('detalhe');
Route::get('/{title}/{id}/{page?}', 'SiteController@detail')->name('details');




// Route::get('/coronavirus', 'SiteController@coronavirus')->name('coronavirus');
// Route::get('/paises/{description}/{id}/{page?}', 'SiteController@country')->name('country');
// Route::get('/{id}', 'SiteController@detail');
