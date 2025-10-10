<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Log;
use App\Form\CharacterEditType;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/character')]
final class CharacterController extends AbstractController
{
    #[Route(name: 'app_character_index', methods: ['GET'])]
    public function index(CharacterRepository $characterRepository): Response
    {
        return $this->render('character/index.html.twig', [
            'characters' => $characterRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_character_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $character = new Character();
        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($character);
            $entityManager->flush();

            return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('character/new.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_show', methods: ['GET'])]
    public function show(Character $character): Response
    {
        return $this->render('character/show.html.twig', [
            'character' => $character,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CharacterEditType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = 

            $logs = new ArrayCollection();

            $new_value = $form->get('name')->getData(); 
            if ($new_value != $character->getName()) {
                $old_value = $character->getName();
                $log = new Log;
                $log->setFieldName('name');
                $log->setOldValue($old_value)->setNewValue($new_value);
                $logs->add($log);
                $character->setEndActivity($new_value);
            }

            $new_value = $form->get('title')->getData(); 
            if ($new_value != $character->getTitle()) {
                $old_value = $character->getTitle();
                $log = new Log;
                $log->setFieldName('title');
                $log->setOldValue($old_value)->setNewValue($new_value);
                $logs->add($log);
                $character->setEndActivity($new_value);
            }

            $added_value = $form->get('level_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getLevel();
                $log = new Log;
                $log->setFieldName('level');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setLevel($old_value + $added_value);
            }

            $added_value = $form->get('gp_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getGp();
                $log = new Log;
                $log->setFieldName('gp');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setGp($old_value + $added_value);
            }

            $added_value = $form->get('pr_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getPr();
                $log = new Log;
                $log->setFieldName('pr');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setPr($old_value + $added_value);
            }

            $added_value = $form->get('xp_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getXpCurrent();
                $log = new Log;
                $log->setFieldName('xp_current');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setXpCurrent($old_value + $added_value);
            }

            $added_value = $form->get('xp_mj_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getXpCurrentMj();
                $log = new Log;
                $log->setFieldName('xp_current_mj');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setXpCurrentMj($old_value + $added_value);
            }

            $added_value = $form->get('activity_add')->getData(); 
            if ($added_value) {
                $old_value = $character->getEndActivity();
                $log = new Log;
                $log->setFieldName('end_activity');
                $log->setOldValue($old_value)->setNewValue($old_value + $added_value);
                $logs->add($log);
                $character->setEndActivity($old_value + $added_value);
            }

            foreach ($logs as $log) {
                $log
                ->setItemType(Character::class)
                ->setItemId($character->getId())
                ->setDescription($form->get('description')->getData())
                ->setUserId($character->getOwner()->getUserIdentifier());
                
                $entityManager->persist($log);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_character_edit', ['id' => $character->getId()]);
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_character_delete', methods: ['POST'])]
    public function delete(Request $request, Character $character, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$character->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($character);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_character_index', [], Response::HTTP_SEE_OTHER);
    }
}
