<?php

namespace App\Controller;


use App\Entity\Utilisateur;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use App\Service\ApiServices;
use App\Service\Censurator;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    #[Route('/wishes', name: 'wish_list')]

    public function list(
        WishRepository $wishRepository,
        ApiServices $apiService
    ): Response
    {
        $apiService->ditBonjour();
        $wishes = $wishRepository->findAll();
        return $this->render('wish/list.html.twig', [
            'wishes' => $wishes
        ]);
    }

    #[Route('/wish/detail/{id}', name: 'wish_list_detail', requirements: ['id' => '\d+'])]
    public function detailListe(
        Wish $id
    ): Response
    {

        return $this->render('wish/detail-list.html.twig', [
            'wishDetail' => $id
        ]);
    }

    #[Route('/wish/ajouter', name: 'wish_ajout')]
    #[IsGranted("ROLE_USER")]
    public function ajoutWish(
        Request $request,
        EntityManagerInterface $entityManager,
        Censurator $censurator
    ): Response
    {

        $wish = new Wish();
        $form = $this->createForm(WishType::class, $wish);
        $form->handleRequest($request);

        $user = $this->getUser()->getUserIdentifier();
        $wish->setDateCreated(new \DateTime('now'));
        $wish->setAuthor($user);
        $wish->setIsPublished('1');




        if ($form->isSubmitted() && $form->isValid()){
            $title = $censurator->purify($wish->getTitle());
            $wish->setTitle($title);

            $description = $censurator->purify($wish->getDescription());
            $wish->setDescription($description);
            $entityManager->persist($wish);
            $entityManager->flush();
            $id = $wish->getId();
            $this->addFlash(
                'success',
                'Idea successfully added!'
            );

            return  $this->redirectToRoute('wish_list_detail',[
                'id' => $id,

            ]);
        }

        return $this->render('wish/ajouter.html.twig', [
            "form"=>$form->createView()

        ]);
    }
}
