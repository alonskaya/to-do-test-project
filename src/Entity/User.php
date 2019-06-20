<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Jasny\Auth\User as AuthUser;

/**
 * User
 *
 * @ORM\Table(name="user_info", uniqueConstraints={@ORM\UniqueConstraint(name="user_info", columns={"email"})}))
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements AuthUser
{
    /**
     * @var integer|null
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="email", type="string", length=320, nullable=false, unique=true)
     */
    private $email;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    private $password;

    /**
     * @var string
     */
    private $plainPassword;

    /**
     * @var string|null
     *
     * @ORM\Column(name="last_name", type="string", length=35, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=35, nullable=true)
     */
    private $firstName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var ArrayCollection|ToDoList[]
     *
     * @OneToMany(targetEntity="ToDoList", mappedBy="author")
     */
    private $toDos;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->creationDate = new \DateTime();
        $this->toDos        = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    private function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $email
     *
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $lastName
     *
     * @return $this
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $firstName
     *
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param \DateTime $dateTime
     *
     * @return $this
     */
    public function setCreationDate(\DateTime $dateTime): self
    {
        $this->creationDate = $dateTime;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @return ArrayCollection|ToDoList[]
     */
    public function getToDos()
    {
        return $this->toDos;
    }

    /**
     * @param ArrayCollection|ToDoList[] $toDos
     *
     * @return $this
     */
    public function setToDos($toDos): self
    {
        $this->toDos = $toDos;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     *
     * @return User
     */
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->getLastName() . ' ' . $this->getFirstName();
    }

    /**
     * Get user's username
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->getEmail();
    }

    /**
     * Get user's hashed password
     *
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->getPassword();
    }

    /**
     * Event called on login.
     *
     * @return boolean  false cancels the login
     */
    public function onLogin()
    {
        return true;
    }

    /**
     * Event called on logout.
     *
     * @return void
     */
    public function onLogout()
    {
        // TODO: Implement onLogout() method.
    }
}
