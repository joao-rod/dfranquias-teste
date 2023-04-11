<?php

namespace App\Controller;

use App\Entity\Cattle;
use App\Form\CattleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CattleController extends AbstractController
{
    #[Route('/cattle', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('cattle/index.html.twig');
    }

    #[Route('/cattle/create', name: 'new_cattle')]
    public function create(EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CattleType::class);
        $data['form'] = $form;

        // $cattle = new Cattle;
        // $cattle->setCod(293);

        // $em->persist($cattle);
        // $em->flush();

        return $this->renderForm('cattle/create.html.twig', $data);
    }
}
