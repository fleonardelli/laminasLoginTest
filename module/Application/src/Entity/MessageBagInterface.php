<?php


namespace Application\Entity;

/**
 * This is an example of interface. This could have been done easier.
 *
 * @package Application\Entity
 */
interface MessageBagInterface
{
    /**
     * @return string
     */
    public function getMessage(): string;

    /**
     * @return string
     */
    public function getType(): string;
}
