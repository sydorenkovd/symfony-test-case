<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BookCompatibleStatus
 *
 * @ORM\Table(name="book_compatible_status")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookCompatibleStatusRepository")
 */
class BookCompatibleStatus
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
     * @var int
     *
     * @ORM\Column(name="status", type="integer", unique=true)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="allowed_statuses", type="text")
     */
    private $allowedStatuses;


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
     * Set status
     *
     * @param integer $status
     *
     * @return BookCompatibleStatus
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set allowedStatuses
     *
     * @param string $allowedStatuses
     *
     * @return BookCompatibleStatus
     */
    public function setAllowedStatuses($allowedStatuses)
    {
        $this->allowedStatuses = $allowedStatuses;

        return $this;
    }

    /**
     * Get allowedStatuses
     *
     * @return string
     */
    public function getAllowedStatuses()
    {
        return $this->allowedStatuses;
    }
}

