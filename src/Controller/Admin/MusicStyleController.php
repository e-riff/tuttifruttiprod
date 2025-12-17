<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\MusicStyle;
use App\Form\MusicStyleType;
use App\Repository\MusicStyleRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/musicstyle', name: 'musicStyle_')]
class MusicStyleController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(MusicStyleRepository $musicStyleRepository): Response
    {
        return $this->render('admin/music_style/index.html.twig', [
            'music_styles' => $musicStyleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, MusicStyleRepository $musicStyleRepository): Response
    {
        $musicStyle = new MusicStyle();
        $form = $this->createForm(MusicStyleType::class, $musicStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicStyle->setSlug((string) $slugger->slug($musicStyle->getName()));
            $musicStyleRepository->save($musicStyle, true);

            return $this->redirectToRoute('admin_musicStyle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/music_style/new.html.twig', [
            'music_style' => $musicStyle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(
        #[MapEntity(id: 'id')]
        MusicStyle $musicStyle
    ): Response {
        return $this->render('admin/music_style/index.html.twig', [
            'music_style' => $musicStyle,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        SluggerInterface $slugger,
        #[MapEntity(id: 'id')]
        MusicStyle $musicStyle,
        MusicStyleRepository $musicStyleRepository,
    ): Response {
        $form = $this->createForm(MusicStyleType::class, $musicStyle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $musicStyle->setSlug((string) $slugger->slug($musicStyle->getName()));
            $musicStyleRepository->save($musicStyle, true);

            return $this->redirectToRoute('admin_musicStyle_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/music_style/edit.html.twig', [
            'music_style' => $musicStyle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function delete(
        Request $request,
        #[MapEntity(id: 'id')]
        MusicStyle $musicStyle,
        MusicStyleRepository $musicStyleRepository,
    ): Response {
        if ($this->isCsrfTokenValid('delete'.$musicStyle->getId(), $request->request->get('_token'))) {
            $musicStyleRepository->remove($musicStyle, true);
        }

        return $this->redirectToRoute('admin_musicStyle_index', [], Response::HTTP_SEE_OTHER);
    }
}
