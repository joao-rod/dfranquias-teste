<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CattleController extends AbstractController
{
    #[Route('/cattle', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('cattle/index.html.twig', [
            'controller_name' => 'CattleController',
        ]);
    }
}
