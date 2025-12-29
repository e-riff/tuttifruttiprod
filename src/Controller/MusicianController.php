<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Repository\MusicianRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/musician', name: 'musician')]
class MusicianController extends AbstractController
{
    #[Route('/', name: '_index', methods: ['GET'])]
    public function index(MusicianRepositoryInterface $musicianRepository): Response
    {
        return $this->render('musician/index.html.twig', [
            'musicians' => $musicianRepository->findAll(),
        ]);
    }
}
