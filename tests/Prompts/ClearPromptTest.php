<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Prompts;

use LaravelHyperf\Prompts\Prompt;
use PHPUnit\Framework\TestCase;

use function LaravelHyperf\Prompts\clear;

/**
 * @backupStaticProperties enabled
 * @internal
 * @coversNothing
 */
class ClearPromptTest extends TestCase
{
    public function testPromptClear()
    {
        Prompt::fake();

        clear();

        Prompt::assertOutputContains("\033[H\033[J");
    }
}
