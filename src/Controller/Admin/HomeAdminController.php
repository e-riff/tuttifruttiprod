<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class HomeAdminController extends AbstractController
{
    #[Route('/board', name: 'board', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('admin/board.html.twig', [
        ]);
    }
}