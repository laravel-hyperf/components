<?php

declare(strict_types=1);

namespace LaravelHyperf\Tests\Mail;

use Hyperf\Config\Config;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSource;
use Hyperf\ViewEngine\Factory;
use LaravelHyperf\Bus\Queueable;
use LaravelHyperf\Filesystem\Filesystem;
use LaravelHyperf\Filesystem\FilesystemManager;
use LaravelHyperf\Mail\Contracts\Mailable as MailableContract;
use LaravelHyperf\Mail\Mailable;
use LaravelHyperf\Mail\Mailer;
use LaravelHyperf\Mail\SendQueuedMailable;
use LaravelHyperf\Queue\Contracts\ShouldQueue;
use LaravelHyperf\Support\Testing\Fakes\QueueFake;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mailer\Transport\TransportInterface;

/**
 * @internal
 * @coversNothing
 */
class MailableQueuedTest extends TestCase
{
    protected function tearDown(): void
    {
        m::close();
    }

    public function testQueuedMailableSent()
    {
        $queueFake = new QueueFake($this->getContainer());
        $mailer = $this->getMockBuilder(Mailer::class)
            ->setConstructorArgs($this->getMocks())
            ->onlyMethods(['createMessage', 'to'])
            ->getMock();
        $mailer->setQueue($queueFake);
        $mailable = new MailableQueueableStub();
        $queueFake->assertNothingPushed();
        $mailer->send($mailable);
        $queueFake->assertPushedOn(null, SendQueuedMailable::class);
    }

    public function testQueuedMailableWithAttachmentSent()
    {
        $queueFake = new QueueFake($this->getContainer());
        $mailer = $this->getMockBuilder(Mailer::class)
            ->setConstructorArgs($this->getMocks())
            ->onlyMethods(['createMessage'])
            ->getMock();
        $mailer->setQueue($queueFake);
        $mailable = new MailableQueueableStub();
        $attachmentOption = ['mime' => 'image/jpeg', 'as' => 'bar.jpg'];
        $mailable->attach('foo.jpg', $attachmentOption);
        $this->assertIsArray($mailable->attachments);
        $this->assertCount(1, $mailable->attachments);
        $this->assertEquals($mailable->attachments[0]['options'], $attachmentOption);
        $queueFake->assertNothingPushed();
        $mailer->send($mailable);
        $queueFake->assertPushedOn(null, SendQueuedMailable::class);
    }

    public function testQueuedMailableWithAttachmentFromDiskSent()
    {
        $app = $this->getContainer();
        $this->getMockBuilder(Filesystem::class)
            ->getMock();
        $filesystemFactory = $this->getMockBuilder(FilesystemManager::class)
            ->setConstructorArgs([$app])
            ->getMock();
        $app->set('filesystem', $filesystemFactory);
        $queueFake = new QueueFake($app);
        $mailer = $this->getMockBuilder(Mailer::class)
            ->setConstructorArgs($this->getMocks())
            ->onlyMethods(['createMessage'])
            ->getMock();
        $mailer->setQueue($queueFake);
        $mailable = new MailableQueueableStub();
        $attachmentOption = ['mime' => 'image/jpeg', 'as' => 'bar.jpg'];

        $mailable->attachFromStorage('/', 'foo.jpg', $attachmentOption);

        $this->assertIsArray($mailable->diskAttachments);
        $this->assertCount(1, $mailable->diskAttachments);
        $this->assertEquals($mailable->diskAttachments[0]['options'], $attachmentOption);

        $queueFake->assertNothingPushed();
        $mailer->send($mailable);
        $queueFake->assertPushedOn(null, SendQueuedMailable::class);
    }

    protected function getMocks()
    {
        return ['smtp', m::mock(Factory::class), m::mock(TransportInterface::class)];
    }

    protected function getContainer(array $config = []): Container
    {
        $container = new Container(
            new DefinitionSource([
                ConfigInterface::class => fn () => new Config($config),
                MailableContract::class => fn () => m::mock(MailableContract::class),
            ])
        );

        ApplicationContext::setContainer($container);

        return $container;
    }
}

class MailableQueueableStub extends Mailable implements ShouldQueue
{
    use Queueable;

    public function build(): static
    {
        $this->subject('lorem ipsum')
            ->html('foo bar baz')
            ->to('foo@example.tld');

        return $this;
    }
}
