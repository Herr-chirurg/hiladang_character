<?php

namespace App\Service;

use App\Entity\Character;
use App\Entity\Scenario;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EntityActionService
{

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
            case Scenario::class:
                return $this->getScenarioActions($object, $mode);
        }
        return [];
    }

    public function getUserActions(User $user, String $mode): array {

        $enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $user;

        $array = [];

        $url_back = "";
        if ($mode == "edition") {
            $url_back = $this->router->generate('app_user_show', ['id' => $user->getId()]);
        } else {
            $url_back = $this->router->generate('app_user_index');
        }
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $url_back
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
            'url' => ""
        ]);

        return $array;
    }

    public function getCharacterActions(Character $character, String $mode): array {

        $user = $this->security->getUser();

        $enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $character->getOwner();

        $array = [];

        $url_back = "";
        if ($mode == "edition") {
            $url_back = $this->router->generate('app_character_show', ['id' => $character->getId()]);
        } else {
            $url_back = $this->router->generate('app_character_index');
        }
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $url_back
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
            'url' => ""
        ]);

        return $array;
    }

    public function getScenarioActions(Scenario $scenario, String $mode): array {

        $user = $this->security->getUser();

        $enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $scenario->getGameMaster();

        $array = [];

        $url_back = "";
        if ($mode == "edition") {
            $url_back = $this->router->generate('app_scenario_show', ['id' => $scenario->getId()]);
        } else {
            $url_back = $this->router->generate('app_scenario_index');
        }
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $url_back
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-pen-to-square',
            'url' => $enabled ? $this->router->generate('app_character_edit', ['id' => $scenario->getId()]) : ""
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);

        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => ""
        ]);

        return $array;
    }
}