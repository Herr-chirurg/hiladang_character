<?php

namespace App\Controller;

use App\Entity\Transfer;
use App\Form\TransferType;
use App\Repository\TransferRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/transfer')]
final class TransferController extends AbstractController
{
    #[Route(name: 'app_transfer_index', methods: ['GET'])]
    public function index(TransferRepository $transferRepository): Response
    {
        return $this->render('transfer/index.html.twig', [
            'transfers' => $transferRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_transfer_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $transfer = new Transfer();
        $form = $this->createForm(TransferType::class, $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($transfer);
            $entityManager->flush();

            return $this->redirectToRoute('app_transfer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transfer/new.html.twig', [
            'transfer' => $transfer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transfer_show', methods: ['GET'])]
    public function show(Transfer $transfer): Response
    {
        return $this->render('transfer/show.html.twig', [
            'transfer' => $transfer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transfer_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Transfer $transfer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TransferType::class, $transfer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_transfer_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('transfer/edit.html.twig', [
            'transfer' => $transfer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_transfer_delete', methods: ['POST'])]
    public function delete(Request $request, Transfer $transfer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$transfer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($transfer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_transfer_index', [], Response::HTTP_SEE_OTHER);
    }
}
