<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Cms\Api\Policies\PagePolicy;
use Playground\Cms\Api\Policies\SnippetPolicy;
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;

/**
 * Playground: CMS API Configuration and Environment Variables
 */
return [

    /*
    |--------------------------------------------------------------------------
    | About Information
    |--------------------------------------------------------------------------
    |
    | By default, information will be displayed about this package when using:
    |
    | `artisan about`
    |
    */

    'about' => (bool) env('PLAYGROUND_CMS_API_ABOUT', true),

    /*
    |--------------------------------------------------------------------------
    | Loading
    |--------------------------------------------------------------------------
    |
    | By default, translations and views are loaded.
    |
    */

    'load' => [
        'policies' => (bool) env('PLAYGROUND_CMS_API_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_CMS_API_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_CMS_API_LOAD_TRANSLATIONS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Middleware
    |--------------------------------------------------------------------------
    |
    |
    */

    'middleware' => [
        'default' => env('PLAYGROUND_CMS_API_MIDDLEWARE_DEFAULT', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_CMS_API_MIDDLEWARE_AUTH', [
            'web',
            SubstituteBindings::class,
            'auth:sanctum',
            EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_CMS_API_MIDDLEWARE_GUEST', [
            'web',
            SubstituteBindings::class,
            EnsureFrontendRequestsAreStateful::class,
        ]),
    ],

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    |
    */

    'policies' => [
        Page::class => PagePolicy::class,
        PageRevision::class => PagePolicy::class,
        Snippet::class => SnippetPolicy::class,
        SnippetRevision::class => SnippetPolicy::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Revisions
    |--------------------------------------------------------------------------
    |
    |
    */

    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_CMS_API_REVISIONS_OPTIONAL', false),
        'pages' => (bool) env('PLAYGROUND_CMS_API_REVISIONS_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_API_REVISIONS_SNIPPETS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    |
    */

    'routes' => [
        'pages' => (bool) env('PLAYGROUND_CMS_API_ROUTES_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_API_ROUTES_SNIPPETS', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Abilities
    |--------------------------------------------------------------------------
    |
    |
    */

    'abilities' => [
        'admin' => [
            'playground-cms-api:*',
        ],
        'manager' => [
            'playground-cms-api:page:*',
            'playground-cms-api:snippet:*',
        ],
        'user' => [
            'playground-cms-api:page:view',
            'playground-cms-api:page:viewAny',
            'playground-cms-api:snippet:view',
            'playground-cms-api:snippet:viewAny',
        ],
    ],
];
