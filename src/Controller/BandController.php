<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\BandPriceEnum;
use App\Entity\MediaTypeEnum;
use App\Form\MessageType;
use App\Repository\BandRepository;
use App\Repository\MediaRepository;
use App\Service\ContactMail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/band', name: 'band_')]
class BandController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, BandRepository $bandRepository): Response
    {
        $searchData = $request->get('form') ?: [];
        isset($searchData['query']) ?: $searchData['query'] = "";
        isset($searchData['events']) ?: $searchData['events'] = [];
        isset($searchData['musicStyles']) ?: $searchData['musicStyles'] = [];
        dump($searchData);

        if (isset($searchData['priceCategory'])) {
            foreach ($searchData['priceCategory'] as &$priceCategory) {
                $priceCategory = BandPriceEnum::getType($priceCategory);
            }
        } else {
            $searchData['priceCategory'] = [];
        }

        $bands = $bandRepository->bandSearch(
            $searchData['query'],
            $searchData['events'],
            $searchData['musicStyles'],
            $searchData['priceCategory']
        );

        return $this->render('band/index.html.twig', [
            'bands' => $bands,
            'searchData' => $searchData ?: []
        ]);
    }

    #[Route('/show/{slug}', name: 'show')]
    public function show(
        ContactMail $contactMail,
        Request     $request,
        Band        $band,
    ): Response
    {
        $contactForm = $this->createForm(MessageType::class);
        $contactForm->handleRequest($request);

        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            // data is an array with "name", "phone", "email", and "message" keys
            $contactMail->sendMail($contactForm->getData());
            $this->addFlash("success", "Message envoyé avec succès");
            return $this->redirectToRoute('band_show', ['slug' => $band->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('band/show.html.twig', [
            'contactForm' => $contactForm,
            'band' => $band,
            'linksType' => MediaTypeEnum::getlinks(),
        ]);
    }
}
