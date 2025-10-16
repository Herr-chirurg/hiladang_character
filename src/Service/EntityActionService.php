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

    public function getActions(Object $object, String $mode): array
    {
        get_class($object);

        switch ($object::class) {
            case Character::class:
                return $this->getCharacterActions($object, $mode);
            case User::class:
                return $this->getUserActions($object, $mode);
        }
        return [];
    }

    public function getUserActions(User $user, String $mode): array {

        $enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $user;

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate($mode == "show" ? 'app_user_index' : 'app_user_show')
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-pen-to-square',
            'url' => $enabled ? $this->router->generate('app_user_edit', ['id' => $user->getId()]) : ""
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);
        
        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => $enabled ? $this->router->generate('app_user_delete', ['id' => $user->getId()]) : ""
        ]);

        return $array;
    }

    public function getCharacterActions(Character $character, String $mode): array {

        $user = $this->security->getUser();

        $enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $character->getOwner();

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate($mode == "show" ? 'app_character_index' : 'app_character_show')
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-pen-to-square',
            'url' => $enabled ? $this->router->generate('app_character_edit', ['id' => $character->getId()]) : ""
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);

        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => $enabled ? $this->router->generate('app_character_delete', ['id' => $character->getId()]) : ""
        ]);

        return $array;
    }
}