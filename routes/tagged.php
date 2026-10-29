<?php

/**
 * Playground
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Playground\Cms\Models\Tagged;

/*
|--------------------------------------------------------------------------
| CMS API Routes: Tagged
|--------------------------------------------------------------------------
|
|
*/

Route::group([
    'prefix' => 'api/cms/tagged',
    'middleware' => config('playground-cms-api.middleware.default'),
    'namespace' => '\Playground\Cms\Api\Http\Controllers',
], function () {

    // API

    Route::delete('/{tagged}', [
        'as' => 'playground.cms.api.tagged.destroy',
        'uses' => 'TaggedController@destroy',
    ])->whereUuid('tagged')->can('delete', 'tagged')->withTrashed();

    Route::post('/', [
        'as' => 'playground.cms.api.tagged.post',
        'uses' => 'TaggedController@store',
    ])->can('store', Tagged::class);
});
