<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flea
 *
 * @ORM\Table(name="flea")
 * @ORM\Entity
 */
class Flea
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="timestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $timestamp;

    /**
     * Flea constructor.
     */
    public function __construct()
    {
        $this->timestamp =\DateTime::createFromFormat( "Y-m-d H:i:s",date('Y-m-d H:i:s'));
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime|false
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|false $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }


}
