<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Repository\BandRepository;
use App\Service\ContactMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request        $request,
        ContactMail    $contactMail,
        BandRepository $bandRepository
    ): Response
    {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactMail->sendMail($contactForm->getData());
            $this->addFlash("success", "Message envoyé avec succès");
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $contactForm,
            'bands' => $bandRepository->findAllWithPicture()
        ]);
    }
}
