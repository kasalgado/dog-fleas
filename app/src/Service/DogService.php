<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Dog;
use App\Repository\DogRepository;
use App\Repository\FleaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class DogService
{
    private DogRepository $dogRepository;
    private FleaRepository $fleaRepository;
    private FleaService $fleaService;
    private ManagerRegistry $registry;
    private EntityManagerInterface $entityManager;

    /**
     * @param DogRepository $dogRepository
     * @param FleaRepository $fleaRepository
     * @param FleaService $fleaService
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        DogRepository $dogRepository,
        FleaRepository $fleaRepository,
        FleaService $fleaService,
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
    ) {
        $this->dogRepository = $dogRepository;
        $this->fleaService = $fleaService;
        $this->fleaRepository = $fleaRepository;
        $this->registry = $registry;
        $this->entityManager = $entityManager;
    }

    /**
     * @return Dog
     */
    public function getAvailableDog(): Dog
    {
        $dogIds = $this->fleaService->getPopulatedDogIds();

        if (empty($dogIds)) {
            $dog = $this->registry->getRepository(Dog::class)->findOneBy([]);
        } else {
            $dog = $this->dogRepository->findOneAvailable($dogIds);

            if ($dog === null) {
                $lowPopulatedDogId = $this->fleaRepository->findOneDogIdWithLowPopulation();
                $dog = $this->registry->getRepository(Dog::class)->find($lowPopulatedDogId);
            }
        }

        return $dog;
    }

    /**
     * @param Dog $dog
     * @return void
     */
    public function removeFleasFromDogAndUpdateFlea(Dog $dog): void
    {
        foreach ($dog->getFleas() as $flea) {
            $flea->setRemoved(true);
            $this->entityManager->persist($flea);
            $dog->removeFlea($flea);
        }

        $this->entityManager->persist($dog);
        $this->entityManager->flush();
    }
}