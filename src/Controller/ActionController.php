<?php

namespace App\Controller;

use App\Service\EntityActionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ActionController extends AbstractController
{
    #[Route('/action', name: 'app_action')]
    public function index(EntityActionService $actionService, Object $object): Response
    {
        return $this->render('partials/_action.html.twig', [
            'object' => (new \ReflectionClass($object))->getShortName(),
            'actions' => $actionService->getActions(object: $object),
        ]);
    }
}
