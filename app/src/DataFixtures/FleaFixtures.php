<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Service\FleaService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FleaFixtures extends Fixture
{
    private FleaService $fleaService;

    /**
     * @param FleaService $fleaService
     */
    public function __construct(FleaService $fleaService)
    {
        $this->fleaService = $fleaService;
    }

    /**
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $this->fleaService->createNewFleas(10);
    }
}