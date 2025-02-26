<?php

declare(strict_types=1);

namespace LaravelHyperf\View\Compilers\Concerns;

use LaravelHyperf\Support\Js;

trait CompilesJs
{
    /**
     * Compile the "@js" directive into valid PHP.
     */
    protected function compileJs(string $expression): string
    {
        return sprintf(
            '<?php echo \%s::from(%s)->toHtml() ?>',
            Js::class,
            $this->stripParentheses($expression)
        );
    }
}
