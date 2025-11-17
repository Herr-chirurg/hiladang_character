<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Scenario;
use App\Entity\Token;
use App\Form\ScenarioType;
use App\Repository\CharacterRepository;
use App\Repository\ScenarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/scenario')]
final class ScenarioController extends AbstractController
{
    #[Route(name: 'app_scenario_index', methods: ['GET'])]
    public function index(ScenarioRepository $scenarioRepository): Response
    {
        return $this->render('scenario/index.html.twig', [
            'scenarios' => $scenarioRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_scenario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scenario = new Scenario();
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $scenario->setStatus(Scenario::STATUS_PUBLISHED);

            $scenario->setGameMaster($this->getUser());

            $entityManager->persist($scenario);
            $entityManager->flush();

            return $this->redirectToRoute('app_scenario_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('scenario/new.html.twig', [
            'scenario' => $scenario,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scenario_show', methods: ['GET'])]
    public function show(Scenario $scenario): Response
    {
        return $this->render('scenario/show.html.twig', [
            'scenario' => $scenario,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_scenario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scenario $scenario, EntityManagerInterface $entityManager, CharacterRepository $characterRepository): Response
    {
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_scenario_index', [], Response::HTTP_SEE_OTHER);
        }

        $characters = $characterRepository->findCharactersNotInScenario($scenario);

        return $this->render('scenario/edit.html.twig', [
            'scenario' => $scenario,
            'characters' => $characters,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_scenario_delete', methods: ['POST'])]
    public function delete(Request $request, Scenario $scenario, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$scenario->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($scenario);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_scenario_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{scenarioId}/add/{characterId}', name: 'app_scenario_character_add', methods: ['POST'])]
    public function addCharacter(Request $request, 
        #[MapEntity(id: 'scenarioId')] Scenario $scenario, 
        #[MapEntity(id: 'characterId')] Character $character, 
        EntityManagerInterface $entityManager): Response
    {

        if (!$scenario->getCharacters()->contains($character)) {
            $scenario->addCharacter($character);

            $token = new Token();
            $token->setScenario($scenario);
            $token->setCharacter($character);
            $token->setTotalRate(100);

            $token->setType("PJ");

            $scenario->addToken($token);

            $entityManager->persist($token);

        } else {

        }

        $entityManager->persist($scenario);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_scenario_edit', ['id' => $scenario->getId()], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{scenarioId}/remove/{tokenId}', name: 'app_scenario_character_remove', methods: ['POST'])]
    public function removeCharacter(Request $request, 
        #[MapEntity(id: 'scenarioId')] Scenario $scenario, 
        #[MapEntity(id: 'tokenId')] Token $token, 
        EntityManagerInterface $entityManager): Response
    {

        if ($scenario->getTokens()->contains($token)) {
            $scenario->removeToken($token);

            $scenario->removeCharacter($token->getCharacter());

            $entityManager->remove($token);            
            //$this->addFlash('success', 'Le personnage "' . $character->getName() . '" a été retiré au scénario.');
        } else {
            //$this->addFlash('warning', 'Le personnage "' . $character->getName() . '" n\'est pas dans le scénario.');
        }

        $entityManager->flush();

        return $this->redirectToRoute('app_scenario_edit', ['id' => $scenario->getId()], Response::HTTP_SEE_OTHER);
    }
    
}
