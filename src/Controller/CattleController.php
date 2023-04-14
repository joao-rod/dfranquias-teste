<?php

namespace App\Controller;

use App\Entity\Cattle;
use App\Form\CattleType;
use App\Repository\CattleRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CattleController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(CattleRepository $cattleRepository): Response
    {
        $data['titlePage'] = 'Todos os registros';
        $data['subTitle'] = 'Registros cadastrados no sistema';
        $data['cattles'] = $cattleRepository->findAll();

        $report['milk'] = $cattleRepository->sumMilk();

        return $this->render('cattle/index.html.twig', ['data' => $data, 'report' => $report]);
    }


    #[Route('/cattle/create', name: 'new_cattle')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cattle = new Cattle;

        $form = $this->createForm(CattleType::class, $cattle);
        $form->handleRequest($request); 

        $data['titlePage'] = 'Novo registro';
        $data['subTitle'] = 'Cadastrar novo animal no sistema';
        $data['form'] = $form;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cattle);
            $entityManager->flush();
        
            $this->addFlash('success', 'Animal adicionado com sucesso!!');

            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('cattle/create.html.twig', $data);
        // return $this->render('cattle/create.html.twig', [
        //     'form' => $form->createView(),
        // ]);
    }


    #[Route('/cattle/update/{id}', name: 'update_cattle')]
    public function update($id, Request $request, EntityManagerInterface $entityManager, CattleRepository $cattleRepository)
    {
        $cattle = $cattleRepository->find($id);

        // $form = $this->createForm(CattleType::class, $cattle)->remove('cod');
        $form = $this->createForm(CattleType::class, $cattle)->add('cod', IntegerType::class, [
            'label' => 'Código do animal',
            'disabled' => true,
        ]);
        $form->handleRequest($request);

        $data['titlePage'] = 'Atualizar registro';
        $data['subTitle'] = 'Modificar dados do animal no sistema';
        $data['form'] = $form;

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            
            $this->addFlash('success', 'Registro alterado com sucesso!!');

            return $this->redirectToRoute('homepage');
        }

        return $this->renderForm('cattle/create.html.twig', $data);
    }
    

    #[Route('/cattle/delete/{id}', name: 'delete_cattle')]
    public function delete($id, EntityManagerInterface $entityManager, CattleRepository $cattleRepository): Response
    {
        $cattle = $cattleRepository->find($id);

        $entityManager->remove($cattle);
        $entityManager->flush();

        $this->addFlash('success', 'Registro deletado com sucesso!!');

        return $this->redirectToRoute('homepage');
    }


    #[Route('/cattle/search', name: 'search_cattle')]
    public function search(Request $request, CattleRepository $cattleRepository): Response
    {
        $codSearch = $request->request->get('search');
        $date = DateTime::createFromFormat("Y-m-d", $codSearch);

        $data['titlePage'] = 'Resultados da sua busca';
        $data['subTitle'] = 'Registros cadastrados encontrados no sistema';
        $data['cattles'] = $cattleRepository->findBy(['birth' => $date]);

        return $this->render('cattle/search.html.twig', $data);
    }


    #[Route('/cattle/show/{id}', name: 'show_cattle')]
    public function show($id, CattleRepository $cattleRepository): Response
    {
        $data['cattle'] = $cattleRepository->find($id);

        return $this->render('cattle/show.html.twig', $data);
    }
}
