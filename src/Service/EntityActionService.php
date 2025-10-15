<?php

namespace App\Service;

use App\Entity\Character;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EntityActionService
{
    // Injectez ici le Router (pour générer les liens) et le Security (pour les droits)
    private $router;
    private $security;

    public function __construct(UrlGeneratorInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function getActions(Object $object): array
    {
        get_class($object);

        switch ($object::class) {
            case Character::class:
                return $this->getCharacterActions($object);
            case User::class:
                return $this->getUserActions($object);
        }
        return [];
    }

    public function getUserActions(User $user): array {

        $securityUser = $this->security->getUser();
        if ($securityUser instanceof User) {
            $owner = $user == $securityUser;
        }

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate('app_user_index')
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-lock',
            'url' => $owner ? $this->router->generate('app_user_edit', ['id' => $user->getId()]) : ""
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);
        
        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => $owner ? $this->router->generate('app_user_delete', ['id' => $user->getId()]) : ""
        ]);

        return $array;
    }

    public function getCharacterActions(Character $character): array {

        $user = $this->security->getUser();

        if ($user instanceof User) {
            $owner = $user == $character->getOwner();
        }

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate('app_character_index')
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-lock',
            'url' => $owner ? $this->router->generate('app_character_edit', ['id' => $character->getId()]) : ""
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);
        
        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => $owner ? $this->router->generate('app_character_delete', ['id' => $character->getId()]) : ""
        ]);

        return $array;
    }
}