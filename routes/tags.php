<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Cms\Models\Tag;

/*
|--------------------------------------------------------------------------
| CMS API Routes: Tag
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/cms/tag',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {

    Route::get('/{tag:slug}', [
        'as' => 'playground.cms.api.tags.slug',
        'uses' => 'TagController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/cms/tags',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.api.tags',
        'uses' => 'TagController@index',
    ])->can('index', Tag::class);

    Route::post('/index', [
        'as' => 'playground.cms.api.tags.index',
        'uses' => 'TagController@index',
    ])->can('index', Tag::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.api.tags.create',
        'uses' => 'TagController@create',
    ])->can('create', Tag::class);

    Route::get('/edit/{tag}', [
        'as' => 'playground.cms.api.tags.edit',
        'uses' => 'TagController@edit',
    ])->whereUuid('tag')->can('edit', 'tag');

    // Route::get('/go/{id}', [
    //     'as' => 'playground.cms.api.tags.go',
    //     'uses' => 'TagController@go',
    // ]);

    Route::get('/{tag}', [
        'as' => 'playground.cms.api.tags.show',
        'uses' => 'TagController@show',
    ])->whereUuid('tag')->can('detail', 'tag')->withTrashed();

    // API

    Route::put('/lock/{tag}', [
        'as' => 'playground.cms.api.tags.lock',
        'uses' => 'TagController@lock',
    ])->whereUuid('tag')->can('lock', 'tag');

    Route::delete('/lock/{tag}', [
        'as' => 'playground.cms.api.tags.unlock',
        'uses' => 'TagController@unlock',
    ])->whereUuid('tag')->can('unlock', 'tag');

    Route::delete('/{tag}', [
        'as' => 'playground.cms.api.tags.destroy',
        'uses' => 'TagController@destroy',
    ])->whereUuid('tag')->can('delete', 'tag')->withTrashed();

    Route::put('/restore/{tag}', [
        'as' => 'playground.cms.api.tags.restore',
        'uses' => 'TagController@restore',
    ])->whereUuid('tag')->can('restore', 'tag')->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.api.tags.post',
        'uses' => 'TagController@store',
    ])->can('store', Tag::class);

    // Route::put('/', [
    //     'as' => 'playground.cms.api.tags.put',
    //     'uses' => 'TagController@store',
    // ])->can('store', Playground\Cms\Models\Tag::class);
    //
    // Route::put('/{tag}', [
    //     'as' => 'playground.cms.api.tags.put.id',
    //     'uses' => 'TagController@store',
    // ])->whereUuid('tag')->can('update', 'tag');

    Route::patch('/{tag}', [
        'as' => 'playground.cms.api.tags.patch',
        'uses' => 'TagController@update',
    ])->whereUuid('tag')->can('update', 'tag');
});
