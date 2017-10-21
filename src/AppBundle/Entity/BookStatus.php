<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookStatus
 *
 * @ORM\Table(name="book_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookStatusRepository")
 */
class BookStatus
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="status_name", type="string", length=255)
     */
    private $statusName;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Book", mappedBy="bookStatus")
     * @ORM\JoinColumn(name="id", referencedColumnName="status")
     */
    private $books;

    /**
     * @return mixed
     */
    public function getBooks()
    {
        return $this->books;
    }

    /**
     * @param mixed $books
     */
    public function setBooks($books)
    {
        $this->books = $books;
    }
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set statusName
     *
     * @param string $statusName
     *
     * @return BookStatus
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;

        return $this;
    }

    /**
     * Get statusName
     *
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusName;
    }
}

