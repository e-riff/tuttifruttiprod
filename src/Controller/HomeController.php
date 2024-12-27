<?php

namespace App\Controller;

use App\Form\MessageType;
use App\Repository\BandRepository;
use App\Service\MailerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request         $request,
        MailerService   $contactMail,
        BandRepository  $bandRepository,
        MailerInterface $mailer,
    ): Response
    {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        $email = (new Email())
            ->from('contact@jardin-sonore.fr')
            ->to('emeric.riff@gmail.com')
            ->subject('Time for Symfony Mailer!')
            ->text('Sending emails is fun again!');
        $mailer->send($email);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $contactMail->sendContactMail($contactForm->getData());
            $this->addFlash("success", "Message envoyé avec succès");
            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $contactForm,
            'bands' => $bandRepository->findAllWithPicture()
        ]);
    }
}
