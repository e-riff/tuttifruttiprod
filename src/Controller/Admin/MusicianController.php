<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Musician;
use App\Form\MusicianType;
use App\Repository\MusicianRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/musician', name: 'musician_')]
class MusicianController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(MusicianRepository $musicianRepository): Response
    {
        return $this->render('admin/musician/index.html.twig', [
            'musicians' => $musicianRepository->findBy([], ['lastname' => 'ASC']),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, MusicianRepository $musicianRepository): Response
    {
        $musician = new Musician();
        $form = $this->createForm(MusicianType::class, $musician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicianRepository->save($musician, true);

            return $this->redirectToRoute('admin_musician_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/musician/new.html.twig', [
            'musician' => $musician,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Musician $musician, MusicianRepository $musicianRepository): Response
    {
        $form = $this->createForm(MusicianType::class, $musician);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicianRepository->save($musician, true);

            return $this->redirectToRoute('admin_musician_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/musician/edit.html.twig', [
            'musician' => $musician,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Musician $musician, MusicianRepository $musicianRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$musician->getId(), $request->request->get('_token'))) {
            $musicianRepository->remove($musician, true);
        }

        return $this->redirectToRoute('admin_musician_index', [], Response::HTTP_SEE_OTHER);
    }
}
