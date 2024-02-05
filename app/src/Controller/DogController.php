<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Dog;
use App\Service\DogService;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class DogController extends AbstractController
{
    /**
     * @Route("/dog", name="app_dog")
     * @Template
     */
    public function index(ManagerRegistry $registry): array
    {
        $dogs = $registry->getRepository(Dog::class)->findAll();

        return [
            'dogs' => $dogs,
        ];
    }

    /**
     * @Route("/dog/wash/{id}", name="app_dog_wash", requirements={"id": "\d+"})
     */
    public function wash(int $id, ManagerRegistry $registry, DogService $dogService): RedirectResponse
    {
        $dog = $registry->getRepository(Dog::class)->find($id);

        if ($dog === null) {
            throw new InvalidArgumentException($id . ' was not found!');
        }

        $dogService->removeFleasFromDogAndUpdateFlea($dog);
        $this->addFlash('notice', 'Dog ' . $dog->getId() . ' was washed!');

        return $this->redirectToRoute('app_dog');
    }
}