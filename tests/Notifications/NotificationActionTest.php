<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Notifications;

use LaravelHyperf\Notifications\Action;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @coversNothing
 */
class NotificationActionTest extends TestCase
{
    public function testActionIsCreatedProperly()
    {
        $action = new Action('Text', 'url');

        $this->assertSame('Text', $action->text);
        $this->assertSame('url', $action->url);
    }
}
