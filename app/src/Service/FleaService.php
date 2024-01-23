<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Flea;
use App\Repository\FleaRepository;
use Doctrine\ORM\EntityManagerInterface;

class FleaService
{
    private FleaRepository $fleaRepository;
    private EntityManagerInterface $entityManager;

    /**
     * @param FleaRepository $fleaRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(FleaRepository $fleaRepository, EntityManagerInterface $entityManager)
    {
        $this->fleaRepository = $fleaRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getPopulatedDogIds(): array
    {
        $dogIds = [];
        $fleas = $this->fleaRepository->findHomed();

        /** @var Flea $flea */
        foreach ($fleas as $flea) {
            $dogIds[$flea->getDog()->getId()] = $flea->getDog()->getId();
        }

        return $dogIds;
    }

    /**
     * @param int $total
     * @return void
     */
    public function createNewFleas(int $total = 20): void
    {
        for ($i = 0; $i < $total; $i++) {
            $flea = new Flea();
            $flea->setRemoved(false);

            $this->entityManager->persist($flea);
        }

        $this->entityManager->flush();
    }
}