<?php

declare(strict_types=1);

namespace App\Infrastructure\Symfony\Controller;

use App\Application\Band\SearchBands;
use App\Application\Contact\SendBandContactMessage;
use App\Domain\Band\BandSearchCriteria;
use App\Domain\Enum\BandPriceEnum;
use App\Domain\Enum\MediaTypeEnum;
use App\Infrastructure\Doctrine\Entity\Band;
use App\Infrastructure\Symfony\Form\MessageType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BandController extends AbstractController
{
    #[Route('/groupes', name: 'band_index')]
    public function index(Request $request, SearchBands $searchBands): Response
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

        $bands = $searchBands(new BandSearchCriteria(
            $searchData['query'],
            $searchData['events'],
            $searchData['musicStyles'],
            $searchData['priceCategory']
        ));

        return $this->render('band/index.html.twig', [
            'bands' => $bands,
            'searchData' => $searchData,
        ]);
    }

    #[Route('/groupes/{slug}', name: 'band_show')]
    public function show(
        SendBandContactMessage $sendBandContactMessage,
        Request $request,
        #[MapEntity(mapping: ['slug' => 'slug'])]
        Band $band,
    ): Response {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $sendBandContactMessage($band, $contactForm->getData());
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
