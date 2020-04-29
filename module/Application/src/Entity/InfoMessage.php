<?php


namespace Application\Entity;

/**
 * Class InfoMessage
 *
 * @package Application\Entity
 */
class InfoMessage implements MessageBagInterface
{
    /** @const string  */
    const TYPE = 'info';

    /** @var string */
    private $message;

    /**
     * InfoMessage constructor.
     *
     * @param string $message
     */
    public function __construct(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }
}
