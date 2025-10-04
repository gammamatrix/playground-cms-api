<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Playground\Cms\Api\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
// use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Playground\PackageInfo;

/**
 * \Playground\Cms\Api\Http\Controllers\Controller
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;
    // use DispatchesJobs;

    /**
     * @var array<string, string>
     */
    public array $packageInfo = [
        'module_label' => 'CMS',
        'module_label_plural' => 'CMSs',
        'module_route' => 'playground.cms.api',
        'module_slug' => 'cms',
        'privilege' => 'playground-cms-api',
    ];

    public function packageInfo(): PackageInfo
    {
        return new PackageInfo()->setOptions($this->packageInfo);
    }
}
