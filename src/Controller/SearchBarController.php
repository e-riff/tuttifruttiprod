<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\MusicStyle;
use App\Repository\EventRepository;
use App\Repository\MusicStyleRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class SearchBarController extends AbstractController
{
    public function searchBar(
        array                $searchData,
        EventRepository      $eventRepository,
        MusicStyleRepository $musicStyleRepository
    ): Response
    {
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
                    'data-model' => "searchQuery",
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
                'label' => "Style de musique",
                'choices' => $musicStylesList,
                'choice_attr' => function () {
                    return ['data-model' => 'musicStyles'];
                },
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->setMethod('GET')
            ->getForm();

        return $this->render('band/_searchBarBand.html.twig', [
            'searchBar' => $searchBar,
        ]);
    }
}
