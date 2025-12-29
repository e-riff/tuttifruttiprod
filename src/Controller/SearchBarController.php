<?php

declare(strict_types=1);

namespace App\Controller;

use App\Domain\Repository\EventRepositoryInterface;
use App\Domain\Repository\MusicStyleRepositoryInterface;
use App\Enums\BandPriceEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

class SearchBarController extends AbstractController
{
    public function searchBar(
        array $searchData,
        EventRepositoryInterface $eventRepository,
        MusicStyleRepositoryInterface $musicStyleRepository,
        RequestStack $requestStack,
    ): Response {
        $eventsChoiceList = [];
        foreach ($eventRepository->findAll() as $event) {
            $eventsChoiceList[$event->getName()] = $event->getName();
        }

        $musicStylesList = [];
        foreach ($musicStyleRepository->findAll() as $musicStyle) {
            $musicStylesList[$musicStyle->getName()] = $musicStyle->getName();
        }

        $searchBar = $this->createFormBuilder($searchData)
            ->add('query', TextType::class, [
                'attr' => [
                    'placeholder' => 'rechercher un groupe, un style',
                    'data-model' => 'searchQuery',
                ],
                'required' => false,
            ])
            ->add('events', ChoiceType::class, [
                'label' => "Type d'événements",
                'choices' => $eventsChoiceList,
                'choice_attr' => function () {
                    return ['data-model' => 'events'];
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('musicStyles', ChoiceType::class, [
                'label' => 'Style de musique',
                'choices' => $musicStylesList,
                'choice_attr' => function () {
                    return ['data-model' => 'musicStyles'];
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('priceCategory', EnumType::class, [
                'label' => 'Catégorie de prix',
                'required' => false,
                'class' => BandPriceEnum::class,
                'expanded' => true,
                'multiple' => true,
                'choice_attr' => function () {
                    return ['data-model' => 'priceCategory'];
                },
                'choice_label' => function (BandPriceEnum $choice) {
                    return $choice->value;
                },
            ])
            ->setMethod('GET')
            ->getForm();

        $rawData = $requestStack->getParentRequest()?->query->get('data');
        $decodedData = [];
        if (is_string($rawData) && '' !== $rawData) {
            $decodedData = json_decode($rawData, true) ?? [];
        }

        return $this->render('band/_searchBarBand.html.twig', [
            'searchBar' => $searchBar,
            'data' => $decodedData,
        ]);
    }
}
