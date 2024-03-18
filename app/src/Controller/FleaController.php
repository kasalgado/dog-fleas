<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Flea;
use App\Repository\FleaRepository;
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
    private FleaRepository $repository;

    public function __construct(FleaRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/flea", name="app_flea")
     * @Template
     */
    public function index(): array
    {
        $fleas = $this->repository->findBy([
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
    public function bite(int $id, DogService $dogService, TranslatorInterface $translator): RedirectResponse
    {
        $flea = $this->repository->find($id);

        if ($flea === null) {
            throw new InvalidArgumentException($id . ' was not found!');
        }

        $availableDog = $dogService->getAvailableDog();
        $flea->setDog($availableDog);
        $this->repository->save($flea, true);

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