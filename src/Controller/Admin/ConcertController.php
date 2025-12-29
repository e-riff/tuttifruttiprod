<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Domain\Model\Concert;
use App\Domain\Repository\ConcertRepositoryInterface;
use App\Form\ConcertType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('concert', name: 'concert_')]
class ConcertController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(ConcertRepositoryInterface $concertRepository): Response
    {
        return $this->render('admin/concert/index.html.twig', [
            'concerts' => $concertRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, ConcertRepositoryInterface $concertRepository): Response
    {
        $concert = new Concert();
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertRepository->save($concert, true);

            return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/concert/new.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        #[MapEntity(id: 'id')]
        Concert $concert,
        ConcertRepositoryInterface $concertRepository,
    ): Response {
        $form = $this->createForm(ConcertType::class, $concert);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $concertRepository->save($concert, true);

            return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/concert/edit.html.twig', [
            'concert' => $concert,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        #[MapEntity(id: 'id')]
        Concert $concert,
        ConcertRepositoryInterface $concertRepository,
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $concert->getId(), $request->request->get('_token'))) {
            $concertRepository->remove($concert, true);
        }

        return $this->redirectToRoute('admin_concert_index', [], Response::HTTP_SEE_OTHER);
    }
}
