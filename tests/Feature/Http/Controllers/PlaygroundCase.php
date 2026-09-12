<?php

/**
 * Playground
 */

declare(strict_types=1);

namespace Tests\Feature\Playground\Cms\Api\Http\Controllers;

use Playground\Test\Feature\Http\Controllers\Resource;

/**
 * \Tests\Feature\Playground\Cms\Api\Http\Controllers\PlaygroundCase
 */
class PlaygroundCase extends TestCase
{
    use Resource\Playground\CreateJsonTrait;
    use Resource\Playground\DestroyJsonTrait;
    use Resource\Playground\EditJsonTrait;
    use Resource\Playground\IndexJsonTrait;
    use Resource\Playground\LockJsonTrait;
    use Resource\Playground\RestoreJsonTrait;
    use Resource\Playground\RestoreRevisionJsonTrait;
    use Resource\Playground\RevisionJsonTrait;
    use Resource\Playground\RevisionsJsonTrait;
    use Resource\Playground\ShowJsonTrait;
    use Resource\Playground\StoreJsonTrait;
    use Resource\Playground\UnlockJsonTrait;
    use Resource\Playground\UpdateJsonTrait;

    protected bool $setUpUserForPlayground = true;
}
