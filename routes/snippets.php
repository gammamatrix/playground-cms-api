<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CMS Routes: Snippet
|--------------------------------------------------------------------------
|
|
*/
Route::group([
    'prefix' => 'api/cms/snippet',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {

    Route::get('/{snippet:slug}', [
        'as' => 'playground.cms.api.snippets.slug',
        'uses' => 'SnippetController@show',
    ])->where('slug', '[a-zA-Z0-9\-]+');
});

Route::group([
    'prefix' => 'api/cms/snippets',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {
    Route::get('/', [
        'as' => 'playground.cms.api.snippets',
        'uses' => 'SnippetController@index',
    ])->can('index', Playground\Cms\Models\Snippet::class);

    // UI

    Route::get('/create', [
        'as' => 'playground.cms.api.snippets.create',
        'uses' => 'SnippetController@create',
    ])->can('create', Playground\Cms\Models\Snippet::class);

    Route::get('/edit/{snippet}', [
        'as' => 'playground.cms.api.snippets.edit',
        'uses' => 'SnippetController@edit',
    ])->whereUuid('snippet')
        ->can('edit', 'snippet');

    // Route::get('/go/{id}', [
    //     'as'   => 'playground.cms.api.snippets.go',
    //     'uses' => 'SnippetController@go',
    // ]);

    Route::get('/{snippet}', [
        'as' => 'playground.cms.api.snippets.show',
        'uses' => 'SnippetController@show',
    ])->whereUuid('snippet')
        ->can('detail', 'snippet');

    Route::get('/{snippet}/revisions', [
        'as' => 'playground.cms.api.snippets.revisions',
        'uses' => 'SnippetController@revisions',
    ])->whereUuid('snippet')
        ->can('revisions', 'snippet');

    Route::get('/revision/{snippet_revision}', [
        'as' => 'playground.cms.api.snippets.revision',
        'uses' => 'SnippetController@revision',
    ])->whereUuid('snippet')
        ->can('viewRevision', 'snippet_revision');

    Route::put('/revision/{snippet_revision}', [
        'as' => 'playground.cms.api.snippets.revision.restore',
        'uses' => 'SnippetController@restoreRevision',
    ])->whereUuid('snippet_revision')
        ->can('restoreRevision', 'snippet_revision');

    // API

    Route::put('/lock/{snippet}', [
        'as' => 'playground.cms.api.snippets.lock',
        'uses' => 'SnippetController@lock',
    ])->whereUuid('snippet')
        ->can('lock', 'snippet');

    Route::delete('/lock/{snippet}', [
        'as' => 'playground.cms.api.snippets.unlock',
        'uses' => 'SnippetController@unlock',
    ])->whereUuid('snippet')
        ->can('unlock', 'snippet');

    Route::delete('/{snippet}', [
        'as' => 'playground.cms.api.snippets.destroy',
        'uses' => 'SnippetController@destroy',
    ])->whereUuid('snippet')
        ->can('delete', 'snippet')
        ->withTrashed();

    Route::put('/restore/{snippet}', [
        'as' => 'playground.cms.api.snippets.restore',
        'uses' => 'SnippetController@restore',
    ])->whereUuid('snippet')
        ->can('restore', 'snippet')
        ->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.api.snippets.post',
        'uses' => 'SnippetController@store',
    ])->can('store', Playground\Cms\Models\Snippet::class);

    // Route::put('/', [
    //     'as'   => 'playground.cms.api.snippets.put',
    //     'uses' => 'SnippetController@store',
    // ])->can('store', \Playground\Cms\Models\Snippet::class);
    //
    // Route::put('/{snippet}', [
    //     'as'   => 'playground.cms.api.snippets.put.id',
    //     'uses' => 'SnippetController@store',
    // ])->whereUuid('snippet')->can('update', 'snippet');

    Route::patch('/{snippet}', [
        'as' => 'playground.cms.api.snippets.patch',
        'uses' => 'SnippetController@update',
    ])->whereUuid('snippet')->can('update', 'snippet');
});
