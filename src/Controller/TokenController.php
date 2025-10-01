<?php

namespace App\Controller;

use App\Entity\Token;
use App\Form\TokenType;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/token')]
final class TokenController extends AbstractController
{
    #[Route(name: 'app_token_index', methods: ['GET'])]
    public function index(TokenRepository $tokenRepository): Response
    {
        return $this->render('token/index.html.twig', [
            'tokens' => $tokenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_token_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $token = new Token();
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($token);
            $entityManager->flush();

            return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('token/new.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_token_show', methods: ['GET'])]
    public function show(Token $token): Response
    {
        return $this->render('token/show.html.twig', [
            'token' => $token,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_token_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Token $token, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TokenType::class, $token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('token/edit.html.twig', [
            'token' => $token,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_token_delete', methods: ['POST'])]
    public function delete(Request $request, Token $token, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$token->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($token);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_token_index', [], Response::HTTP_SEE_OTHER);
    }
}
