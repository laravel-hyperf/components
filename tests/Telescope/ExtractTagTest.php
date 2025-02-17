<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Telescope;

use LaravelHyperf\Mail\Mailable;
use LaravelHyperf\Telescope\ExtractTags;
use LaravelHyperf\Telescope\FormatModel;

/**
 * @internal
 * @coversNothing
 */
class ExtractTagTest extends FeatureTestCase
{
    protected bool $migrateRefresh = true;

    public function testExtractTagFromArrayContainingFlatCollection()
    {
        $flatCollection = $this->createEntry();

        $tag = FormatModel::given($flatCollection->first());
        $extractedTag = ExtractTags::fromArray([$flatCollection]);

        $this->assertSame($tag, $extractedTag[0]);
    }

    public function testExtractTagFromArrayContainingDeepCollection()
    {
        $deepCollection = $this->createEntry()->groupBy('type')->get();

        $tag = FormatModel::given($deepCollection->first()->first());
        $extractedTag = ExtractTags::fromArray([$deepCollection]);

        $this->assertSame($tag, $extractedTag[0]);
    }

    public function testExtractTagFromMailable()
    {
        $deepCollection = $this->createEntry()->groupBy('type')->get();
        $mailable = new DummyMailableWithData($deepCollection);

        $tag = FormatModel::given($deepCollection->first()->first());
        $extractedTag = ExtractTags::from($mailable);

        $this->assertSame($tag, $extractedTag[0]);
    }
}

class DummyMailableWithData extends Mailable
{
    private $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }

    public function build()
    {
        return $this->from('from@laravel-hyperf.com')
            ->to('to@laravel-hyperf.com')
            ->view('mail', ['raw' => 'simple text content'])
            ->with([
                'mailData' => $this->mailData,
            ]);
    }
}
