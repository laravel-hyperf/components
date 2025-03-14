<?php

declare(strict_types=1);

namespace LaravelHyperf\Support\Facades;

use LaravelHyperf\Support\DateFactory;

/**
 * @see https://carbon.nesbot.com/docs/
 * @see https://github.com/briannesbitt/Carbon/blob/master/src/Carbon/Factory.php
 *
 * @method static void use(mixed $handler)
 * @method static void useDefault()
 * @method static void useCallable(callable $callable)
 * @method static void useClass(string $dateClass)
 * @method static void useFactory(object $factory)
 * @method static \LaravelHyperf\Support\Carbon create($year = 0, $month = 1, $day = 1, $hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromDate($year = null, $month = null, $day = null, $tz = null)
 * @method static false|\LaravelHyperf\Support\Carbon createFromFormat($format, $time, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromTime($hour = 0, $minute = 0, $second = 0, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromTimeString($time, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromTimestamp($timestamp, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromTimestampMs($timestamp, $tz = null)
 * @method static \LaravelHyperf\Support\Carbon createFromTimestampUTC($timestamp)
 * @method static \LaravelHyperf\Support\Carbon createMidnightDate($year = null, $month = null, $day = null, $tz = null)
 * @method static false|\LaravelHyperf\Support\Carbon createSafe($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $tz = null)
 * @method static void disableHumanDiffOption($humanDiffOption)
 * @method static void enableHumanDiffOption($humanDiffOption)
 * @method static mixed executeWithLocale($locale, $func)
 * @method static \LaravelHyperf\Support\Carbon fromSerialized($value)
 * @method static array getAvailableLocales()
 * @method static array getDays()
 * @method static int getHumanDiffOptions()
 * @method static array getIsoUnits()
 * @method static array getLastErrors()
 * @method static string getLocale()
 * @method static int getMidDayAt()
 * @method static null|\LaravelHyperf\Support\Carbon getTestNow()
 * @method static \Symfony\Component\Translation\TranslatorInterface getTranslator()
 * @method static int getWeekEndsAt()
 * @method static int getWeekStartsAt()
 * @method static array getWeekendDays()
 * @method static bool hasFormat($date, $format)
 * @method static bool hasMacro($name)
 * @method static bool hasRelativeKeywords($time)
 * @method static bool hasTestNow()
 * @method static \LaravelHyperf\Support\Carbon instance($date)
 * @method static bool isImmutable()
 * @method static bool isModifiableUnit($unit)
 * @method static bool isMutable()
 * @method static bool isStrictModeEnabled()
 * @method static bool localeHasDiffOneDayWords($locale)
 * @method static bool localeHasDiffSyntax($locale)
 * @method static bool localeHasDiffTwoDayWords($locale)
 * @method static bool localeHasPeriodSyntax($locale)
 * @method static bool localeHasShortUnits($locale)
 * @method static void macro($name, $macro)
 * @method static null|\LaravelHyperf\Support\Carbon make($var)
 * @method static \LaravelHyperf\Support\Carbon maxValue()
 * @method static \LaravelHyperf\Support\Carbon minValue()
 * @method static void mixin($mixin)
 * @method static \LaravelHyperf\Support\Carbon now($tz = null)
 * @method static \LaravelHyperf\Support\Carbon parse($time = null, $tz = null)
 * @method static string pluralUnit(string $unit)
 * @method static void resetMonthsOverflow()
 * @method static void resetToStringFormat()
 * @method static void resetYearsOverflow()
 * @method static void serializeUsing($callback)
 * @method static void setHumanDiffOptions($humanDiffOptions)
 * @method static bool setLocale($locale)
 * @method static void setMidDayAt($hour)
 * @method static void setTestNow($testNow = null)
 * @method static void setToStringFormat($format)
 * @method static void setTranslator(\Symfony\Component\Translation\TranslatorInterface $translator)
 * @method static void setUtf8($utf8)
 * @method static void setWeekEndsAt($day)
 * @method static void setWeekStartsAt($day)
 * @method static void setWeekendDays($days)
 * @method static bool shouldOverflowMonths()
 * @method static bool shouldOverflowYears()
 * @method static string singularUnit(string $unit)
 * @method static \LaravelHyperf\Support\Carbon today($tz = null)
 * @method static \LaravelHyperf\Support\Carbon tomorrow($tz = null)
 * @method static void useMonthsOverflow($monthsOverflow = true)
 * @method static void useStrictMode($strictModeEnabled = true)
 * @method static void useYearsOverflow($yearsOverflow = true)
 * @method static \LaravelHyperf\Support\Carbon yesterday($tz = null)
 *
 * @see \LaravelHyperf\Support\DateFactory
 */
class Date extends Facade
{
    public const DEFAULT_FACADE = DateFactory::class;

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return 'date';
    }

    /**
     * Resolve the facade root instance from the container.
     */
    protected static function resolveFacadeInstance(object|string $name): mixed
    {
        if (! isset(static::$resolvedInstance[$name])) {
            $class = static::DEFAULT_FACADE;

            static::swap(new $class());
        }

        return parent::resolveFacadeInstance($name);
    }
}
