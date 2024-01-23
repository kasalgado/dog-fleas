<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\DogRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="dog")
 * @ORM\Entity(repositoryClass=DogRepository::class)
 */
class Dog
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @ORM\Column(name="age", type="integer", nullable=false)
     */
    private int $age;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private string $name;

    /**
     * @ORM\Column(name="timestamp", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private DateTime $timestamp;

    /**
     * @ORM\OneToMany(targetEntity=Flea::class, mappedBy="dog")
     */
    private Collection $fleas;

    /**
     * Dog constructor.
     */
    public function __construct()
    {
        $this->timestamp = DateTime::createFromFormat( "Y-m-d H:i:s", date('Y-m-d H:i:s'));
        $this->fleas = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return Dog
     */
    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Dog
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime|false
     */
    public function getTimestamp(): DateTime|false
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime $timestamp
     * @return Dog
     */
    public function setTimestamp(DateTime $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return Collection<int, Flea>
     */
    public function getFleas(): Collection
    {
        return $this->fleas;
    }

    public function addFlea(Flea $flea): static
    {
        if (!$this->fleas->contains($flea)) {
            $this->fleas[] = $flea;
            $flea->setDog($this);
        }

        return $this;
    }

    public function removeFlea(Flea $flea): static
    {
        if ($this->fleas->removeElement($flea)) {
            // set the owning side to null (unless already changed)
            if ($flea->getDog() === $this) {
                $flea->setDog(null);
            }
        }

        return $this;
    }
}
