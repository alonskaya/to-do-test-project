<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * To-do list
 *
 * @ORM\Table(name="to_do_list", uniqueConstraints={@ORM\UniqueConstraint(name="to_do_list", columns={"author, title"})}))
 * @ORM\Entity(repositoryClass="App\Repository\ToDoListRepository")
 */
class ToDoList
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
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="done", type="boolean", nullable=false)
     */
    private $done = false;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="author", referencedColumnName="id")
     * })
     */
    private $author;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function getDone(): bool
    {
        return $this->done;
    }

    /**
     * @param bool $done
     *
     * @return $this
     */
    public function setDone(bool $done): self
    {
        $this->done = $done;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return $this
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;

        return $this;
    }
}
