<?php

namespace App\Controller;

use App\Entity\Band;
use App\Repository\ConcertRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

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
        ConcertRepository $concertRepository,
        SerializerInterface $serializer,
        #[MapQueryParameter('start')]
        string $start = null,
    ): Response {
        $dateToFetchFrom = new DateTime($start) ?? new DateTime('today midnight');
        $concerts = $concertRepository->findConfirmedConcerts($dateToFetchFrom);
        $jsonConcert = $serializer->normalize($concerts, 'json', ['fullcalendar' => true]);
        return new JsonResponse($jsonConcert);
    }
}
