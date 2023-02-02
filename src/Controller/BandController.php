<?php

namespace App\Controller;

use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/groupes', name: 'band_')]
class BandController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(BandRepository $bandRepository): Response
    {
        $bands = $bandRepository->findBy([], [], 100);
        return $this->render('band/index.html.twig', [
            'bands' => $bands,
        ]);
    }
}
