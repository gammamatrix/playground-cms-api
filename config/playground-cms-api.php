<?php

/**
 * Playground
 */

declare(strict_types=1);
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Playground\Auth\Policies\Policy;
use Playground\Cms\Api\Policies\PagePolicy;
use Playground\Cms\Api\Policies\SnippetPolicy;
use Playground\Cms\Models\Page;
use Playground\Cms\Models\PageRevision;
use Playground\Cms\Models\Snippet;
use Playground\Cms\Models\SnippetRevision;

/**
 * Playground: CMS API Configuration and Environment Variables
 *
 * @return array{
 *       about: bool,
 *       load: array{
 *           policies: bool,
 *           routes: bool,
 *           translations: bool
 *       },
 *       matrix: array{
 *           enabled: bool,
 *       },
 *       middleware: array{
 *           default: string|string[],
 *           auth: string|string[],
 *           guest: string|string[]
 *       },
 *       policies: array<
 *           class-string<Model>,
 *           class-string<Policy>
 *       >,
 *       revisions: array{
 *           options: bool,
 *           pages: bool,
 *           snippets: bool,
 *       },
 *       routes: array{
 *           pages: bool,
 *           snippets: bool,
 *       },
 *       cache: array{
 *           enable: bool,
 *           page: bool,
 *           page_store: string,
 *           page_ttl: int,
 *           snippet: bool,
 *           snippet_store: string,
 *           snippet_ttl: int,
 *       },
 *       abilities: array<string, string[]>,
 *       sitemap: array{
 *            enable: bool,
 *            guest: bool,
 *            user: bool,
 *            view: string
 *       }
 *   }
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
    | Matrix
    |--------------------------------------------------------------------------
    |
    |
    */

    'matrix' => [
        'enabled' => (bool) env('PLAYGROUND_CMS_API_MATRIX_ENABLED', false),
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
