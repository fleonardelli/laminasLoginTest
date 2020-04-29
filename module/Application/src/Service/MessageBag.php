<?php


namespace Application\Service;


use Application\Entity\ErrorMessage;
use Application\Entity\InfoMessage;
use Application\Entity\MessageBagInterface;

/**
 * Class MessageBag
 *
 * @package Application\Service
 */
class MessageBag
{
    /** @var MessageBagInterface[] */
    protected $messages;

    /**
     * @param string $message
     * @param string $type
     */
    public function addMessage(string $message, string $type): void
    {
        if (!in_array($type, [InfoMessage::TYPE, ErrorMessage::TYPE])) {
            throw new \InvalidArgumentException('Type not supported');
        }

        if (ErrorMessage::TYPE == $type) {
            $this->messages[] = new ErrorMessage($message);
        }

        if (InfoMessage::TYPE == $type) {
            $this->messages[] = new InfoMessage($message);
        }
    }

    /**
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages ?? [];
    }

    /**
     * @return array
     */
    public function getInfoMessages(): array
    {
        return array_filter(
            $this->getMessages(),
            function (MessageBagInterface $messageEntity) {
                return $messageEntity->getType() == InfoMessage::TYPE;
            }
        );
    }

    /**
     * @return array
     */
    public function getErrorMessages(): array
    {
        return array_filter(
            $this->getMessages(),
            function (MessageBagInterface $messageEntity) {
                return $messageEntity->getType() == ErrorMessage::TYPE;
            }
        );
    }

}
