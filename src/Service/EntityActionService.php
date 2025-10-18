<?php

namespace App\Service;

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

    public function getActions(string $route, ?Object $object = null): array
    {
        
        $array = explode( "_", $route);

        $mode = $array[2];

        switch ($mode) {
            case "index":
                return $this->getIndexActions($array[1]);
            case "show":
                return $this->getShowActions($array[1], $object);
            case "edit":
                return $this->getEditActions($array[1], $object);

        }

        return [];
    }

    public function getIndexActions(String $class): array {

        //$enabled = $mode == "show" && $user instanceof User && $this->security->getUser() == $user;
        //$this->router->generate('app_user_edit', ['id' => $user->getId()])

        $array = [];
        
        array_push($array, [
            'label' => 'Nouveau',
            'icon' => 'fa-solid fa-plus',
            'url' => $this->router->generate('app_' . $class . '_new')
        ]);

        array_push($array, [
            'label' => 'Filtrer',
            'icon' => 'fa-solid fa-filter',
            'url' => ""
        ]);

        return $array;
    }

    public function getShowActions(String $class, Object $object): array {

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate('app_' . $class . '_index')
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-pen-to-square',
            'url' => $this->router->generate('app_' . $class . '_edit', ['id' => $object->getId()])
        ]);
        
        array_push($array, [
            'label' => 'Echanger',
            'icon' => 'fa-solid fa-handshake-angle',
            'url' => ""
        ]);
        
        array_push($array, [
            'label' => 'Supprimer',
            'icon' => 'fa-solid fa-skull',
            'url' => $this->router->generate('app_' . $class . '_delete', ['id' => $object->getId()])
        ]);

        return $array;
    }

    public function getEditActions(String $class, Object $object): array {

        $array = [];
        
        array_push($array, [
            'label' => 'Retour',
            'icon' => 'fa-solid fa-arrow-left',
            'url' => $this->router->generate('app_' . $class . '_show', ['id' => $object->getId()])
        ]);

        array_push($array, [
            'label' => 'Editer',
            'icon' => 'fa-solid fa-pen-to-square',
            'url' => ""
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