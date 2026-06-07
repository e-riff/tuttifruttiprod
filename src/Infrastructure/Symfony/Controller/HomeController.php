<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use App\Application\Band\ListFeaturedBands;
use App\Application\Contact\SendContactMessage;
use App\Infrastructure\Symfony\Form\MessageType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        Request $request,
        SendContactMessage $sendContactMessage,
        ListFeaturedBands $listFeaturedBands,
        TranslatorInterface $translator,
    ): Response {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $sendContactMessage($contactForm->getData());
            $this->addFlash('success', $translator->trans('flash.contact.success'));

            return $this->redirectToRoute('index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('home/index.html.twig', [
            'contactForm' => $contactForm,
            'featuredBands' => $listFeaturedBands(),
        ]);
    }
}
