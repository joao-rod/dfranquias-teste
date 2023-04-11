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
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cattle = new Cattle;

        $form = $this->createForm(CattleType::class, $cattle);
        $form->handleRequest($request); 

        // $data['form'] = $form;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cattle);
            $entityManager->flush();
        
            $this->addFlash('success', 'Animal adicionado com sucesso!');

            return $this->redirectToRoute('homepage');
        }

        // return $this->renderForm('cattle/create.html.twig', $data);
        return $this->render('cattle/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
