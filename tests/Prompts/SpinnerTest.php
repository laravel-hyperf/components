<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Prompts;

use LaravelHyperf\Foundation\Testing\Concerns\RunTestsInCoroutine;
use LaravelHyperf\Prompts\Prompt;
use PHPUnit\Framework\TestCase;

use function LaravelHyperf\Prompts\spin;

/**
 * @backupStaticProperties enabled
 * @internal
 * @coversNothing
 */
class SpinnerTest extends TestCase
{
    use RunTestsInCoroutine;

    public function testSpinner()
    {
        Prompt::fake();

        $result = spin(function () {
            return 'done';
        }, 'Running...');

        $this->assertSame('done', $result);

        Prompt::assertOutputContains('Running...');
    }
}
