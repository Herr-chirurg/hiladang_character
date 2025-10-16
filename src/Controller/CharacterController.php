<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\Log;
use App\Form\CharacterEditType;
use App\Form\CharacterType;
use App\Repository\CharacterRepository;
use App\Repository\LogRepository;
use App\Service\WBLService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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
    public function new(Request $request, EntityManagerInterface $entityManager, WBLService $wBLUtil): Response
    {
        $character = new Character();

        $form = $this->createForm(CharacterType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $character->setOwner($this->getUser());

            $character->setLevel(3);
            $character->setGP($wBLUtil->levelToMinGP($character->getLevel()));
            $character->setXpCurrent(0);
            $character->setXpCurrentMJ(0);
            $character->setEndActivity(new \DateTime('yesterday'));

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
    public function show(Character $character, WBLService $wBLUtil): Response
    {
 
        return $this->render('character/show.html.twig', [
            'user' => $this->getUser(),
            'character' => $character,
            'totalXP' => $wBLUtil->levelToMinXP($character->getLevel()),
            'XPNiveauSuivant' => $wBLUtil->levelToMinXP($character->getLevel()+1),
            'GV' => $wBLUtil->levelAndXPToGV($character->getLevel(), $character->getXpCurrent())
        ]);
    }

    #[Route('/{id}/edit', name: 'app_character_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Character $character, EntityManagerInterface $entityManager, WBLService $wBLUtil): Response
    {

        if ($this->getUser() != $character->getOwner()) {
            throw new AccessDeniedException();
        }
        
        $form = $this->createForm(CharacterEditType::class, $character);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logs = new ArrayCollection();

            $new_name = $form->get('name')->getData(); 
            if ($new_name) {
                $character->setName($new_name);
            }

            $new_title = $form->get('title')->getData(); 
            if ($new_title) {
                $character->setTitle($new_title);
            }

            $level_add = $form->get('level_add')->getData(); 
            if ($level_add) {
                $old_value = $character->getLevel();
                $character->setLevel($old_value + $level_add);
            }

            $gp_add = $form->get('gp_add')->getData(); 
            if ($gp_add) {
                $old_value = $character->getGp();
                $character->setGp($old_value + $gp_add);
            }

            $pr_add = $form->get('pr_add')->getData(); 
            if ($pr_add) {
                $old_value = $character->getPr();
                $character->setPr($old_value + $pr_add);
            }

            $xp_add = $form->get('xp_add')->getData(); 
            if ($xp_add) {
                $old_value = $character->getXpCurrent();
                $character->setXpCurrent($old_value + $xp_add);
            }

            $xp_mj_add = $form->get('xp_mj_add')->getData(); 
            if ($xp_mj_add) {
                $old_value = $character->getXpCurrentMj();
                $character->setXpCurrentMj($old_value + $xp_mj_add);
            }

            $activity_add = $form->get('activity_add')->getData();
            if ($activity_add) {
                $date = new \DateTime('now');
                $symbol = $activity_add>0 ? "+ " : "- ";
                $character->setEndActivity($date->modify($symbol . abs($activity_add) . ' days'));
            }

            //Pas de conditions ici, ce cas est censé toujours arriver
            $description = $form->get('description')->getData();
            $character->setLastActionDescription($description);
            
            $entityManager->flush();

            return $this->redirectToRoute('app_character_edit', ['id' => $character->getId()]);
        }

        return $this->render('character/edit.html.twig', [
            'character' => $character,
            'form' => $form,
            'totalXP' => $wBLUtil->levelToMinXP($character->getLevel()),
            'XPNiveauSuivant' => $wBLUtil->levelToMinXP($character->getLevel()+1),
            'GV' => $wBLUtil->levelAndXPToGV($character->getLevel(), $character->getXpCurrent())
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
