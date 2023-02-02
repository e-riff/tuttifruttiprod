<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;

class SearchBarController extends AbstractController
{
    public function searchBar(array $searchData): Response
    {
        $searchBar = $this->createFormBuilder($searchData)
            ->add('searchQuery', TextType::class, [
                'attr' => [
                    'placeholder' => 'rechercher un groupe, un style'
                ],
                'required' => false,
            ])
            ->setMethod('GET')
            ->setAction($this->generateUrl('band_index'))
            ->getForm();

        return $this->renderForm('band/_searchBarBand.html.twig', [
            'searchBar' => $searchBar,
        ]);
    }
}
