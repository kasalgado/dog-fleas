<?php
/**
 * Created by PhpStorm.
 * User: 00010230
 * Date: 16.10.2019
 * Time: 11:49
 */

namespace App\Controller;

use App\Repository\DogRepository;
use App\Repository\FleaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class DemoController extends AbstractController
{
    /**
     * @var DogRepository
     */
    private $dogRepository;

    /**
     * @var FleaRepository
     */
    private $fleaRepository;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
                                DogRepository $dogRepository,
                                FleaRepository $fleaRepository,
                                TranslatorInterface $translator
    )
    {
        $translatorInstance = $translator;
        $fleaRepositoryInstance = $fleaRepository;

        /* get the repository */
        $this->dogRepository = $dogRepository;
        $this->fleaRepository = $fleaRepositoryInstance;
        $this->translator = $translatorInstance;
    }

    /**
     * @Route ("/", name="index")
     */
    public function index()
    {
        $title = $this->translator->
        trans('title', [], 'system');
        $subtitle = $this->translator->
        trans('subtitle', [], 'system');
        $dogList = $this->dogRepository->
        getAll();
        return $this->
        render('views/index.html.twig', ['title' => $title,'subtitle' => $subtitle,'dog_list' => $dogList]);
    }


}