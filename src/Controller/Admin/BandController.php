<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use App\Entity\Media;
use App\Entity\MediaTypeEnum;
use App\Form\BandType;
use App\Form\MediaImageType;
use App\Form\MediaLinkType;
use App\Form\MediaSoundcloudType;
use App\Form\MediaYoutubeType;
use App\Repository\BandRepository;
use App\Repository\ConcertRepository;
use App\Repository\MediaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/band', name: 'band_')]
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
    public function new(Request $request, SluggerInterface $slugger, BandRepository $bandRepository): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $band->setSlug($slugger->slug($band->getName()));
            $bandRepository->save($band, true);

            return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/band/new.html.twig', [
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
    public function edit(
        Request $request,
        SluggerInterface $slugger,
        Band $band,
        BandRepository $bandRepository
    ): Response {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $band->setSlug($slugger->slug($band->getName()));
            $bandRepository->save($band, true);

            return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/band/edit.html.twig', [
            'band' => $band,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/media', name: 'media', methods: ['GET', 'POST'])]
    public function media(
        Request $request,
        Band $band,
        MediaRepository $mediaRepository,
    ): Response {
        $media = new Media();
        $youtubeForm = $this->createForm(MediaYoutubeType::class, $media);
        $soundcloudForm = $this->createForm(MediaSoundcloudType::class, $media);
        $mediaLinkForm = $this->createForm(MediaLinkType::class, $media);
        $mediaImageForm = $this->createForm(MediaImageType::class, $media);

        $youtubeForm->handleRequest($request);
        if ($youtubeForm->isSubmitted() && $youtubeForm->isValid()) {
            $media->setBand($band);
            $media->setMediaType(MediaTypeEnum::YOUTUBE);

            $rawLink = $youtubeForm->get('link')->getData();
            parse_str(parse_url($rawLink, PHP_URL_QUERY), $queryParameters);
            $link = $queryParameters['v'] ?? $rawLink;

            $media->setLink($link);
            $mediaRepository->save($media, true);

            $this->addFlash('success', 'Video ajoutée !');
            return $this->redirectToRoute('admin_band_media', ['id' => $band->getId()], Response::HTTP_SEE_OTHER);
        }

        $soundcloudForm->handleRequest($request);
        if ($soundcloudForm->isSubmitted() && $soundcloudForm->isValid()) {
            $media->setBand($band);
            $media->setMediaType(MediaTypeEnum::SOUNDCLOUD);
            $mediaRepository->save($media, true);

            $this->addFlash('success', 'Piste soundcloud ajoutée !');
            return $this->redirectToRoute('admin_band_media', ['id' => $band->getId()], Response::HTTP_SEE_OTHER);
        }

        $mediaLinkForm->handleRequest($request);
        if ($mediaLinkForm->isSubmitted() && $mediaLinkForm->isValid()) {
            $media->setBand($band);
            $mediaRepository->save($media, true);

            $this->addFlash('success', 'Lien Ajouté !');
            return $this->redirectToRoute('admin_band_media', ['id' => $band->getId()], Response::HTTP_SEE_OTHER);
        }

        $mediaImageForm->handleRequest($request);
        if ($mediaImageForm->isSubmitted() && $mediaImageForm->isValid()) {
            $media->setBand($band);
            $media->setMediaType(MediaTypeEnum::IMAGE);
            $mediaRepository->save($media, true);

            $this->addFlash('success', 'Image Ajoutée !');
            return $this->redirectToRoute('admin_band_media', ['id' => $band->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/band/media.html.twig', [
            'band' => $band,
            'youtubeForm' => $youtubeForm,
            'soundcloudForm' => $soundcloudForm,
            'mediaLinkForm' => $mediaLinkForm,
            'mediaImageForm' => $mediaImageForm,
            'linksType' => MediaTypeEnum::getlinks(),
        ]);
    }

    #[Route('/{band}/media/{media}', name: 'media_delete', methods: ['POST'])]
    public function mediaDelete(Request $request, Media $media, Band $band, MediaRepository $mediaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $media->getId(), $request->request->get('_token'))) {
            $mediaRepository->remove($media, true);
        }

        return $this->redirectToRoute('admin_band_media', ['id' => $band->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{band}/concert', name: 'concert', methods: ['GET', 'POST'])]
    public function concert(
        Band $band,
        ConcertRepository $concertRepository,
    ): Response {
        return $this->render('admin/band/concert.html.twig', [
            'band' => $band,
            'concerts' => $concertRepository->findBy(['band' => $band]),
        ]);
    }


    #[Route('/{id}', name: 'delete', methods: ['POST'])]
    public function bandDelete(Request $request, Band $band, BandRepository $bandRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $band->getId(), $request->request->get('_token'))) {
            $bandRepository->remove($band, true);
        }

        return $this->redirectToRoute('admin_band_index', [], Response::HTTP_SEE_OTHER);
    }
}
