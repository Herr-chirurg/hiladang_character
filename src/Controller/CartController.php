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

#[Route('/cartGP')]
final class CartGPController extends AbstractController
{
    #[Route(name: 'app_cartGP_index', methods: ['GET'])]
    public function index(CartGPRepository $cartGPRepository): Response
    {
        return $this->render('cartGP/index.html.twig', [
            'cartGPs' => $cartGPRepository->findAll(),
        ]);
    }

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

        return $this->render('cartGP/new.html.twig', [
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

        return $this->render('cartGP/edit.html.twig', [
            'cartGP' => $cartGP,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_cartGP_delete', methods: ['POST'])]
    public function delete(Request $request, CartGP $cartGP, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cartGP->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($cartGP);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cartGP_index', [], Response::HTTP_SEE_OTHER);
    }
}
