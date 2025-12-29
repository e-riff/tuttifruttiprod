<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Repository\ConcertRepositoryInterface;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/concerts', name: 'app_concert_')]
class ConcertController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('concert/index.html.twig', []);
    }

    #[Route('/confirmed', name: 'get_confirmed_concert', methods: ['GET'])]
    public function getConcertForm(
        ConcertRepositoryInterface $concertRepository,
        NormalizerInterface $normalizer,
        #[MapQueryParameter('start')]
        ?string $start = null,
    ): Response {
        $dateToFetchFrom = null !== $start ? new DateTime($start) : new DateTime('today midnight');
        $concerts = $concertRepository->findConfirmedConcerts($dateToFetchFrom);
        $normalizedConcerts = $normalizer->normalize(
            $concerts,
            'json',
            ['fullcalendar' => true]
        );

        return new JsonResponse($normalizedConcerts);
    }
}
