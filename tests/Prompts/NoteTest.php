<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Prompts;

use LaravelHyperf\Prompts\Prompt;
use PHPUnit\Framework\TestCase;

use function LaravelHyperf\Prompts\note;

/**
 * @backupStaticProperties enabled
 * @internal
 * @coversNothing
 */
class NoteTest extends TestCase
{
    public function testRendersNote()
    {
        Prompt::fake();

        note('Hello, World!');

        Prompt::assertOutputContains('Hello, World!');
    }
}
