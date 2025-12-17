<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Band;
use App\Enums\BandPriceEnum;
use App\Enums\MediaTypeEnum;
use App\Form\MessageType;
use App\Repository\BandRepository;
use App\Service\MailerService;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/band', name: 'band_')]
class BandController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, BandRepository $bandRepository): Response
    {
        $searchData = array_merge(
            [
                'query' => '',
                'events' => [],
                'musicStyles' => [],
                'priceCategory' => [],
            ],
            $request->query->all('form')
        );

        $searchData['priceCategory'] = array_map(
            fn (string $code): BandPriceEnum => BandPriceEnum::getType($code),
            $searchData['priceCategory']
        );

        $bands = $bandRepository->bandSearch(
            $searchData['query'],
            $searchData['events'],
            $searchData['musicStyles'],
            $searchData['priceCategory']
        );

        return $this->render('band/index.html.twig', [
            'bands' => $bands,
            'searchData' => $searchData,
        ]);
    }

    #[Route('/show/{slug}', name: 'show')]
    public function show(
        MailerService $mailer,
        Request $request,
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Band $band,
    ): Response {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $mailer->sendContactMailForBand($band, $contactForm->getData());
            $this->addFlash('success', 'Message envoyé avec succès');

            return $this->redirectToRoute('band_show', ['slug' => $band->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('band/show.html.twig', [
            'contactForm' => $contactForm,
            'band' => $band,
            'linksType' => MediaTypeEnum::getlinks(),
        ]);
    }
}
