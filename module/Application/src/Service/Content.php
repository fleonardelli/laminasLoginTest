<?php


namespace Application\Service;


use Application\Entity\Content as ContentEntity;
use Auth\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;

/**
 * Class Content
 *
 * @package Application\Service
 */
class Content
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * Content constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $title
     * @param string $text
     *
     * @param User   $user
     *
     * @return int
     */
    public function create(string $title, string $text, User $user): int
    {
        $content = new ContentEntity();
        /** @var User $detachedUser */
        $detachedUser = $this->entityManager->getRepository(User::class)
            ->find($user->getId());

        $content->setUser($detachedUser)
            ->setTitle($title)
            ->setText($text);

        $this->entityManager->persist($content);
        $this->entityManager->flush();

        return $content->getId();
    }

}
