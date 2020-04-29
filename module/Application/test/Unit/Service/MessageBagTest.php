<?php


namespace ApplicationTest\Unit\Service;


use Application\Entity\ErrorMessage;
use Application\Entity\InfoMessage;
use Application\Entity\MessageBagInterface;
use Application\Service\MessageBag;
use PHPUnit\Framework\TestCase;

/**
 * Class ContentTest
 *
 * @package ApplicationTest\Unit\Service
 */
class MessageBagTest extends TestCase
{
    protected $messageBag;

    /**
     *
     */
    protected function setUp(): void
    {
        $this->messageBag = new MessageBag();
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenMessageTypeNotSupported(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->messageBag->addMessage('test', 'not_supported');
    }

    /**
     * @test
     */
    public function shouldAddMessageToBagWhenTypeIsSupported(): void
    {
        $this->messageBag->addMessage('test', ErrorMessage::TYPE);

        $this->assertNotEmpty($this->messageBag->getMessages());
    }

    /**
     * @test
     */
    public function shouldGetOnlyInfoMessages(): void
    {
        $this->messageBag->addMessage('test', InfoMessage::TYPE);
        $this->messageBag->addMessage('test', ErrorMessage::TYPE);
        $this->messageBag->addMessage('test', ErrorMessage::TYPE);

        $this->assertSame(1, count($this->messageBag->getInfoMessages()));
    }

    /**
     * @test
     */
    public function shouldGetOnlyErrorMessages(): void
    {
        $this->messageBag->addMessage('test', InfoMessage::TYPE);
        $this->messageBag->addMessage('test', ErrorMessage::TYPE);
        $this->messageBag->addMessage('test', ErrorMessage::TYPE);

        $this->assertSame(2, count($this->messageBag->getErrorMessages()));
    }


}
