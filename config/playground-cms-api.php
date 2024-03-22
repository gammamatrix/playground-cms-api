<?php

declare(strict_types=1);

return [
    'middleware' => [
        'default' => env('PLAYGROUND_CMS_API_MIDDLEWARE_DEFAULT', [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'auth' => env('PLAYGROUND_CMS_API_MIDDLEWARE_AUTH', [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            'auth:sanctum',
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
        'guest' => env('PLAYGROUND_CMS_API_MIDDLEWARE_GUEST', [
            Illuminate\Routing\Middleware\SubstituteBindings::class,
            Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]),
    ],
    'policies' => [
        Playground\Cms\Models\Snippet::class => Playground\Cms\Api\Policies\SnippetPolicy::class,
        Playground\Cms\Models\SnippetRevision::class => Playground\Cms\Api\Policies\SnippetPolicy::class,
        Playground\Cms\Models\Page::class => Playground\Cms\Api\Policies\PagePolicy::class,
        Playground\Cms\Models\PageRevision::class => Playground\Cms\Api\Policies\PagePolicy::class,
    ],
    'load' => [
        'policies' => (bool) env('PLAYGROUND_CMS_API_LOAD_POLICIES', true),
        'routes' => (bool) env('PLAYGROUND_CMS_API_LOAD_ROUTES', true),
        'translations' => (bool) env('PLAYGROUND_CMS_API_LOAD_TRANSLATIONS', true),
    ],
    'revisions' => [
        'optional' => (bool) env('PLAYGROUND_CMS_API_ROUTES_OPTIONAL', false),
        'pages' => (bool) env('PLAYGROUND_CMS_API_REVISIONS_PAGES', true),
        'snippets' => (bool) env('PLAYGROUND_CMS_API_REVISIONS_SNIPPETS', true),
    ],
    'routes' => [
        'snippets' => (bool) env('PLAYGROUND_CMS_API_ROUTES_SNIPPETS', true),
        'pages' => (bool) env('PLAYGROUND_CMS_API_ROUTES_PAGES', true),
    ],

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
        // 'guest' => [
        //     'deny',
        // ],
        // 'guest' => [
        //     'app:view',

        //     'playground:view',

        //     'playground-auth:logout',
        //     'playground-auth:reset-password',

        //     'playground-cms-api:page:view',
        //     'playground-cms-api:page:viewAny',
        //     'playground-cms-api:snippet:view',
        //     'playground-cms-api:snippet:viewAny',
        // ],
    ],
];
