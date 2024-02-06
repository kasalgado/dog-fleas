<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Entity\Dog;
use App\Service\DogService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DogServiceTest extends KernelTestCase
{
    private DogService $dogService;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $container = static::getContainer();
        $this->dogService = $container->get(DogService::class);
    }

    public function testCanGetAvailableDog(): void
    {
        $dog = $this->dogService->getAvailableDog();

        $this->assertInstanceOf(Dog::class, $dog);
        $this->assertNotEmpty($dog);
    }
}