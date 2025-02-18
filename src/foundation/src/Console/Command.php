<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Console;

use FriendsOfHyperf\CommandSignals\Traits\InteractsWithSignals;
use FriendsOfHyperf\PrettyConsole\Traits\Prettyable;
use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Event\AfterExecute;
use Hyperf\Command\Event\AfterHandle;
use Hyperf\Command\Event\BeforeHandle;
use Hyperf\Command\Event\FailToHandle;
use Hyperf\Coroutine\Coroutine;
use LaravelHyperf\Context\ApplicationContext;
use LaravelHyperf\Support\Traits\HasLaravelStyleCommand;
use Swoole\ExitException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

use function Hyperf\Coroutine\run;

abstract class Command extends HyperfCommand
{
    use HasLaravelStyleCommand;
    use InteractsWithSignals;
    use Prettyable;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->disableDispatcher($input);
        $method = method_exists($this, 'handle') ? 'handle' : '__invoke';

        $callback = function () use ($method): int {
            try {
                $this->eventDispatcher?->dispatch(new BeforeHandle($this));
                $statusCode = ApplicationContext::getContainer()
                    ->call([$this, $method]);
                if (is_int($statusCode)) {
                    $this->exitCode = $statusCode;
                }
                $this->eventDispatcher?->dispatch(new AfterHandle($this));
            } catch (Throwable $exception) {
                if (class_exists(ExitException::class) && $exception instanceof ExitException) {
                    return $this->exitCode = (int) $exception->getStatus();
                }

                if (! $this->eventDispatcher) {
                    throw $exception;
                }

                $this->getApplication()?->renderThrowable($exception, $this->output);

                $this->exitCode = self::FAILURE;

                $this->eventDispatcher->dispatch(new FailToHandle($this, $exception));
            } finally {
                $this->eventDispatcher?->dispatch(new AfterExecute($this, $exception ?? null));
            }

            return $this->exitCode;
        };

        if ($this->coroutine && ! Coroutine::inCoroutine()) {
            run($callback, $this->hookFlags);
        } else {
            $callback();
        }

        return $this->exitCode >= 0 && $this->exitCode <= 255 ? $this->exitCode : self::INVALID;
    }
}
