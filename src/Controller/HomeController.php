<?php

namespace App\Controller;

use App\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request): Response
    {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $contactForm->getData();
        }

        return $this->renderForm('home/index.html.twig', [
            'contactForm' => $contactForm,
        ]);
    }
}
