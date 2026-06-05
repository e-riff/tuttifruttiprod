<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/association', name: 'association_')]
class AssociationController extends AbstractController
{
    #[Route('/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AssociationRepository $associationRepository): Response
    {
        $association = $associationRepository->findOneBy([]) ?? new Association();
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $associationRepository->save($association, true);

            return $this->redirectToRoute('admin_association_edit', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }
}
