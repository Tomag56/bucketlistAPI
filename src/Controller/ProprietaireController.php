<?php

namespace App\Controller;

use App\Entity\Proprietaire;
use App\Form\ProprietaireType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProprietaireController extends AbstractController
{
    #[Route('/proprietaire', name: 'app_proprietaire')]
    public function index(Request $request,
                          EntityManagerInterface $entityManager): Response
    {
        $proprietaire = new Proprietaire();
        $formProprio = $this->createForm(ProprietaireType::class, $proprietaire);
        $formProprio -> handleRequest($request);
        return $this->render('proprietaire/index.html.twig', [
            'formProprio' => $formProprio->createView(),
        ]);
    }
}
