<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Service\ContactMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, ContactMail $contactMail): Response
    {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactMail->sendMail($contactForm->getData());
            $this->addFlash("success", "Message envoyé avec succès");
            return $this->redirectToRoute('index',[], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home/index.html.twig', [
            'contactForm' => $contactForm,
        ]);
    }
}
