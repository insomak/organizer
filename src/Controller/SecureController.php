<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecureController extends AbstractController
{
    #[Route('/secure', name: 'secure_page')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_USER') && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('secure/index.html.twig');
    }
}
