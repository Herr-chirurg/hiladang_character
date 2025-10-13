<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FooterController extends AbstractController
{
    #[Route('/footer', name: 'app_footer')]
    public function index(): Response
    {
        return $this->render('partials/_footer.html.twig', [
            'app_version_date' => $this->getParameter('app.version_date'),
            'app_version_commit' => $this->getParameter('app.version_commit'),
            'app_environment' => $this->getParameter('app.environment')
        ]);
    }
}
