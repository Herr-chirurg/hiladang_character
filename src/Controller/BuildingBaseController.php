<?php

namespace App\Controller;

use App\Entity\BuildingBase;
use App\Form\BuildingBaseType;
use App\Repository\BuildingBaseRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/building/base')]
final class BuildingBaseController extends AbstractController
{
    #[Route(name: 'app_building_base_index', methods: ['GET'])]
    public function index(BuildingBaseRepository $buildingBaseRepository): Response
    {
        return $this->render('building_base/index.html.twig', [
            'building_bases' => $buildingBaseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_building_base_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $buildingBase = new BuildingBase();
        $form = $this->createForm(BuildingBaseType::class, $buildingBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($buildingBase);
            $entityManager->flush();

            return $this->redirectToRoute('app_building_base_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('building_base/new.html.twig', [
            'building_base' => $buildingBase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_building_base_show', methods: ['GET'])]
    public function show(BuildingBase $buildingBase): Response
    {
        return $this->render('building_base/show.html.twig', [
            'building_base' => $buildingBase,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_building_base_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BuildingBase $buildingBase, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BuildingBaseType::class, $buildingBase);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_building_base_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('building_base/edit.html.twig', [
            'building_base' => $buildingBase,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_building_base_delete', methods: ['POST'])]
    public function delete(Request $request, BuildingBase $buildingBase, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$buildingBase->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($buildingBase);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_building_base_index', [], Response::HTTP_SEE_OTHER);
    }
}
