<?php


namespace Auth\Entity;

use Application\Entity\Content;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password")
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login")
     */
    private $lastLogin;

    /**
     * @var PersistentCollection|Content[]
     *
     * @ORM\OneToMany(targetEntity="Application\Entity\Content", mappedBy="user",
     *     cascade={"persist", "remove"})
     */
    private $contents;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin(): \DateTime
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin(\DateTime $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return Content[]|PersistentCollection
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param Content[]|PersistentCollection $contents
     */
    public function setContents($contents): void
    {
        $this->contents = $contents;
    }

}
