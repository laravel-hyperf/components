<?php

declare(strict_types=1);

namespace LaravelHyperf\Foundation\Console;

use LaravelHyperf\Foundation\Console\Contracts\Kernel as KernelContract;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class ApplicationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        try {
            return $container->get(KernelContract::class)
                ->getArtisan();
        } catch (Throwable $throwable) {
            $console = new ConsoleOutput();
            $console->setVerbosity(ConsoleOutput::VERBOSITY_VERBOSE);

            (new SymfonyApplication())
                ->renderThrowable($throwable, $console);
        }

        exit;
    }
}
