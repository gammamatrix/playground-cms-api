<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS Routes: Page
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/cms/page',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {

    Route::get('/{page:slug}', [
        'as' => 'playground.cms.api.pages.slug',
        'uses' => 'PageController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/cms/pages',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.api.pages',
        'uses' => 'PageController@index',
    ])->can('index', Playground\Cms\Models\Page::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.api.pages.create',
        'uses' => 'PageController@create',
    ])->can('create', Playground\Cms\Models\Page::class);

    Route::get('/edit/{page}', [
        'as' => 'playground.cms.api.pages.edit',
        'uses' => 'PageController@edit',
    ])->whereUuid('page')
        ->can('edit', 'page');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.cms.api.pages.go',
    //     'uses' => 'PageController@go',
    // ]);

    Route::get('/{page}', [
        'as' => 'playground.cms.api.pages.show',
        'uses' => 'PageController@show',
    ])->whereUuid('page')
        ->can('detail', 'page');

    Route::get('/{page}/revisions', [
        'as' => 'playground.cms.api.pages.revisions',
        'uses' => 'PageController@revisions',
    ])->whereUuid('page')
        ->can('revisions', 'page');

    Route::get('/revision/{page_revision}', [
        'as' => 'playground.cms.api.pages.revision',
        'uses' => 'PageController@revision',
    ])->whereUuid('page')
        ->can('viewRevision', 'page_revision');

    Route::put('/revision/{page_revision}', [
        'as' => 'playground.cms.api.pages.revision.restore',
        'uses' => 'PageController@restoreRevision',
    ])->whereUuid('page_revision')
        ->can('restoreRevision', 'page_revision');

    // API

    Route::put('/lock/{page}', [
        'as' => 'playground.cms.api.pages.lock',
        'uses' => 'PageController@lock',
    ])->whereUuid('page')
        ->can('lock', 'page');

    Route::delete('/lock/{page}', [
        'as' => 'playground.cms.api.pages.unlock',
        'uses' => 'PageController@unlock',
    ])->whereUuid('page')
        ->can('unlock', 'page');

    Route::delete('/{page}', [
        'as' => 'playground.cms.api.pages.destroy',
        'uses' => 'PageController@destroy',
    ])->whereUuid('page')
        ->can('delete', 'page')
        ->withTrashed();

    Route::put('/restore/{page}', [
        'as' => 'playground.cms.api.pages.restore',
        'uses' => 'PageController@restore',
    ])->whereUuid('page')
        ->can('restore', 'page')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.api.pages.post',
        'uses' => 'PageController@store',
    ])->can('store', Playground\Cms\Models\Page::class);

    // Route::put('/', [
    //     'as'   => 'playground.cms.api.pages.put',
    //     'uses' => 'PageController@store',
    // ])->can('store', \Playground\Cms\Models\Page::class);
    //
    // Route::put('/{page}', [
    //     'as'   => 'playground.cms.api.pages.put.id',
    //     'uses' => 'PageController@store',
    // ])->whereUuid('page')->can('update', 'page');

    Route::patch('/{page}', [
        'as' => 'playground.cms.api.pages.patch',
        'uses' => 'PageController@update',
    ])->whereUuid('page')->can('update', 'page');
});
