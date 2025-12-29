<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Repository\BandRepositoryInterface;
use App\Form\MessageType;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request $request,
        MailerService $contactMail,
        BandRepositoryInterface $bandRepository,
    ): Response {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactMail->sendContactMail($contactForm->getData());
            $this->addFlash('success', 'Message envoyé avec succès');

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $contactForm,
            'bands' => $bandRepository->findAllWithPicture(),
        ]);
    }
}
