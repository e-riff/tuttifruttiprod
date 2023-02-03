<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use App\Form\BandType;
use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/band', name:'band_')]
class BandController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(BandRepository $bandRepository): Response
    {
        return $this->render('admin/band/index.html.twig', [
            'bands' => $bandRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger ,BandRepository $bandRepository): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $band->setSlug($slugger->slug($band->getName()));
            $bandRepository->save($band, true);

            return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/band/new.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Band $band): Response
    {
        return $this->render('admin/band/show.html.twig', [
            'band' => $band,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bandRepository->save($band, true);

            return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$band->getId(), $request->request->get('_token'))) {
            $bandRepository->remove($band, true);
        }

        return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
    }
}
