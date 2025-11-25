<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Scenario;
use App\Entity\Token;
use App\Form\ScenarioType;
use App\Repository\CharacterRepository;
use App\Repository\ScenarioRepository;
use App\Repository\TokenRepository;
use App\Service\WBLService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

    #[IsGranted('ROLE_GAMEMASTER'), Route('/new', name: 'app_scenario_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $scenario = new Scenario();
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $scenario->setStatus(Scenario::STATUS_CREATED);

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
    public function show(Scenario $scenario, WBLService $wBLService): Response
    {
        foreach ($scenario->getTokens() as $token) {
            $token->setDeltaPrFromLevel(
                $wBLService->rewardExtraPR($scenario->getLevel(), $token->getCharacter()->getLevel()));
        }

        return $this->render('scenario/show.html.twig', [
            'scenario' => $scenario,
        ]);
    }

    #[IsGranted('edit', subject: 'scenario'), Route('/{id}/edit', name: 'app_scenario_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Scenario $scenario, EntityManagerInterface $entityManager, 
        TokenRepository $tokenRepository, ScenarioRepository $scenarioRepository, CharacterRepository $characterRepository,
        WBLService $wBLService): Response
    {
        $form = $this->createForm(ScenarioType::class, $scenario);
        $form->handleRequest($request);

        foreach ($scenario->getTokens() as $token) {
            $token->setDeltaPrFromLevel(
                $wBLService->rewardExtraPR($scenario->getLevel(), $token->getCharacter()->getLevel()));
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $characters = $scenarioRepository->findCharactersNotInScenario($scenario);

            if ($request->request->has('addToken')) {

                $character = $characterRepository->find($request->request->get('addToken'));

                $token = new Token();
                $token->setScenario($scenario);
                $token->setCharacter($character);
                $token->setTotalRate(100);
                $token->setDeltaPr(100);

                $token->setType("PJ");

                $scenario->addToken($token);
                $entityManager->persist($token);
            } 

            if ($request->request->has('removeToken')) {

                $token = $tokenRepository->find( $request->request->get('removeToken'));
                
                if ($scenario->getTokens()->contains($token)) {
                    $scenario->removeToken($token);
                    $entityManager->remove($token);
                }
                        
            }
            
            $entityManager->flush();

            
            return $this->redirectToRoute('app_scenario_edit', ['id' => $scenario->getId()]);
        }

        $characters = $scenarioRepository->findCharactersNotInScenario($scenario);

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

    #[Route('/award/{id}', name: 'app_scenario_award', methods: ['POST'])]
    public function awardToken(Request $request, Scenario $scenario, EntityManagerInterface $entityManager, WBLService $wBLService): Response
    {
        $scenario->setStatus(Scenario::STATUS_AWARDED);

        foreach ($scenario->getTokens() as $token) {
            $token->setPr($token->getDeltaPr() + 
                $wBLService->rewardExtraPR(
                    $token->getCharacter()->getLevel(), 
                    $token->getScenario()->getLevel()));
            $token->setUsageRate($token->getTotalRate());  
            $token->setStatus(Token::STATUS_AWARDED);
        }
        
        $entityManager->flush();

        return $this->redirectToRoute('app_scenario_show', ['id' => $scenario->getId()], Response::HTTP_SEE_OTHER);
    }

}
