<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class AccueilController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        $prenom = 'Julien';
        $couleurs = ['Rouge', 'Bleu', 'Vert'];
        return $this->render('accueil/index.html.twig',
            [
                "prenom" => $prenom,
                "couleurs" => $couleurs
            ]);
    }


    #[Route('/{id}',
        name: 'accueil_index_avec_id',
    requirements: ["id"=>'\d+'])]

    public function indexavecId($id): Response
    {

        $resultat = $id+2;
        return $this->render('accueil/indexavecid.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/about',
        name: 'accueil_about',
        requirements: ["id"=>'\d+'])]

    public function about(): Response
    {

        return $this->render('accueil/about.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }

    #[Route('/ajout',
        name: '_ajout')]

    public function form(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $voiture= new Voiture();
//        $voiture->setNbPortes(3); donner la value 3 au formulaire
        $form = $this->createForm(VoitureType::class, $voiture);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($voiture);
            $entityManager->flush();
            return $this->redirectToRoute('wish_list');
        }
        return $this->render('accueil/ajout.html.twig', [
          'nouvelleVoiture' => $voiture,
            "form"=>$form->createView()
        ]);
    }




}
