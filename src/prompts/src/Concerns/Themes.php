<?php

declare(strict_types=1);

namespace LaravelHyperf\Prompts\Concerns;

use InvalidArgumentException;
use LaravelHyperf\Prompts\Clear;
use LaravelHyperf\Prompts\ConfirmPrompt;
use LaravelHyperf\Prompts\MultiSearchPrompt;
use LaravelHyperf\Prompts\MultiSelectPrompt;
use LaravelHyperf\Prompts\Note;
use LaravelHyperf\Prompts\PasswordPrompt;
use LaravelHyperf\Prompts\PausePrompt;
use LaravelHyperf\Prompts\Progress;
use LaravelHyperf\Prompts\SearchPrompt;
use LaravelHyperf\Prompts\SelectPrompt;
use LaravelHyperf\Prompts\Spinner;
use LaravelHyperf\Prompts\SuggestPrompt;
use LaravelHyperf\Prompts\Table;
use LaravelHyperf\Prompts\TextareaPrompt;
use LaravelHyperf\Prompts\TextPrompt;
use LaravelHyperf\Prompts\Themes\Default\ClearRenderer;
use LaravelHyperf\Prompts\Themes\Default\ConfirmPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\MultiSearchPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\MultiSelectPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\NoteRenderer;
use LaravelHyperf\Prompts\Themes\Default\PasswordPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\PausePromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\ProgressRenderer;
use LaravelHyperf\Prompts\Themes\Default\SearchPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\SelectPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\SpinnerRenderer;
use LaravelHyperf\Prompts\Themes\Default\SuggestPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\TableRenderer;
use LaravelHyperf\Prompts\Themes\Default\TextareaPromptRenderer;
use LaravelHyperf\Prompts\Themes\Default\TextPromptRenderer;

trait Themes
{
    /**
     * The name of the active theme.
     */
    protected static string $theme = 'default';

    /**
     * The available themes.
     *
     * @var array<string, array<class-string<\LaravelHyperf\Prompts\Prompt>, class-string<callable&object>>>
     */
    protected static array $themes = [
        'default' => [
            TextPrompt::class => TextPromptRenderer::class,
            TextareaPrompt::class => TextareaPromptRenderer::class,
            PasswordPrompt::class => PasswordPromptRenderer::class,
            SelectPrompt::class => SelectPromptRenderer::class,
            MultiSelectPrompt::class => MultiSelectPromptRenderer::class,
            ConfirmPrompt::class => ConfirmPromptRenderer::class,
            PausePrompt::class => PausePromptRenderer::class,
            SearchPrompt::class => SearchPromptRenderer::class,
            MultiSearchPrompt::class => MultiSearchPromptRenderer::class,
            SuggestPrompt::class => SuggestPromptRenderer::class,
            Spinner::class => SpinnerRenderer::class,
            Note::class => NoteRenderer::class,
            Table::class => TableRenderer::class,
            Progress::class => ProgressRenderer::class,
            Clear::class => ClearRenderer::class,
        ],
    ];

    /**
     * Get or set the active theme.
     *
     * @throws InvalidArgumentException
     */
    public static function theme(?string $name = null): string
    {
        if ($name === null) {
            return static::$theme;
        }

        if (! isset(static::$themes[$name])) {
            throw new InvalidArgumentException("Prompt theme [{$name}] not found.");
        }

        return static::$theme = $name;
    }

    /**
     * Add a new theme.
     *
     * @param array<class-string<\LaravelHyperf\Prompts\Prompt>, class-string<callable&object>> $renderers
     */
    public static function addTheme(string $name, array $renderers): void
    {
        if ($name === 'default') {
            throw new InvalidArgumentException('The default theme cannot be overridden.');
        }

        static::$themes[$name] = $renderers;
    }

    /**
     * Get the renderer for the current prompt.
     */
    protected function getRenderer(): callable
    {
        $class = get_class($this);

        return new (static::$themes[static::$theme][$class] ?? static::$themes['default'][$class])($this);
    }

    /**
     * Render the prompt using the active theme.
     */
    protected function renderTheme(): string
    {
        $renderer = $this->getRenderer();

        return $renderer($this);
    }
}
