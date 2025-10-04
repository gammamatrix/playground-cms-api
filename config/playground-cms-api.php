<?php

/**
 * Playground
 */

declare(strict_types=1);

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
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_CMS_API_MIDDLEWARE_AUTH', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_CMS_API_MIDDLEWARE_GUEST', [
            'web',
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
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
        Playground\Cms\Models\Page::class => Playground\Cms\Api\Policies\PagePolicy::class,
        Playground\Cms\Models\PageRevision::class => Playground\Cms\Api\Policies\PagePolicy::class,
        Playground\Cms\Models\Snippet::class => Playground\Cms\Api\Policies\SnippetPolicy::class,
        Playground\Cms\Models\SnippetRevision::class => Playground\Cms\Api\Policies\SnippetPolicy::class,
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
