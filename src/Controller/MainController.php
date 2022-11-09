<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(TrickRepository $trickRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }
}
