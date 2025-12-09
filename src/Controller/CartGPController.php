<?php

namespace App\Controller;

use App\Entity\CartGP;
use App\Form\CartGPType;
use App\Repository\CartGPRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart_gp')]
final class CartGPController extends AbstractController
{

    #[Route('/new', name: 'app_cartGP_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cartGP = new CartGP();
        $form = $this->createForm(CartGPType::class, $cartGP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cartGP);
            $entityManager->flush();

            return $this->redirectToRoute('app_cartGP_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cart_gp/new.html.twig', [
            'cartGP' => $cartGP,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cartGP_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CartGP $cartGP, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CartGPType::class, $cartGP);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cartGP_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cart_gp/edit.html.twig', [
            'cartGP' => $cartGP,
            'form' => $form,
        ]);
    }

}
