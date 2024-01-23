<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\FleaRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FleaRepository::class)
 */
class Flea
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(name="timestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $timestamp;

    /**
     * @ORM\Column(type="boolean", options={"default"=false})
     */
    private bool $removed;

    /**
     * @ORM\ManyToOne(targetEntity=Dog::class, inversedBy="fleas")
     * @ORM\JoinColumn(nullable=true)
     */
    private ?Dog $dog;

    public function __construct()
    {
        $this->timestamp = DateTime::createFromFormat( "Y-m-d H:i:s", date('Y-m-d H:i:s'));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime|false
     */
    public function getTimestamp(): DateTime|false
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime|null $timestamp
     * @return Flea
     */
    public function setTimestamp(?DateTime $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRemoved(): bool
    {
        return $this->removed;
    }

    /**
     * @param bool $removed
     * @return $this
     */
    public function setRemoved(bool $removed): static
    {
        $this->removed = $removed;

        return $this;
    }

    public function getDog(): ?Dog
    {
        return $this->dog;
    }

    public function setDog(?Dog $dog): static
    {
        $this->dog = $dog;

        return $this;
    }
}
