<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Flea;
use App\Service\DogService;
use App\Service\FleaService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Contracts\Translation\TranslatorInterface;

class FleaController extends AbstractController
{
    /**
     * @Route("/flea", name="app_flea")
     * @Template
     */
    public function index(ManagerRegistry $registry): array
    {
        $fleas = $registry->getRepository(Flea::class)->findBy([
            'dog' => null,
            'removed' => false,
        ]);

        return [
            'fleas' => $fleas,
        ];
    }

    /**
     * @Route("/flea/bite/{id}", name="app_flea_bite", requirements={"id"="\d+"})
     */
    public function bite(
        int $id,
        ManagerRegistry $registry,
        EntityManagerInterface $entityManager,
        DogService $dogService,
        TranslatorInterface $translator,
    ): RedirectResponse {
        $flea = $registry->getRepository(Flea::class)->find($id);

        if ($flea === null) {
            throw new InvalidArgumentException($id . ' was not found!');
        }

        $availableDog = $dogService->getAvailableDog();
        $flea->setDog($availableDog);

        $entityManager->persist($flea);
        $entityManager->flush();

        $this->addFlash('notice', 'Flea ' . $flea->getId() . ' lives in Dog '. $availableDog->getId());

        return $this->redirectToRoute('app_flea');
    }

    /**
     * @Route("/flea/create", name="app_flea_create")
     */
    public function create(FleaService $fleaService): RedirectResponse
    {
        $fleaService->createNewFleas(10);

        return $this->redirectToRoute('app_flea');
    }
}