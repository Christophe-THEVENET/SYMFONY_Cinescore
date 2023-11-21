<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

setlocale(LC_TIME, 'fr_FR.UTF-8');


class MovieController extends AbstractController
{


    // ********************** tous les films ****************************
    #[Route('/movie', name: 'app_movie')]
    public function index(MovieRepository $movieRepository): Response
    {
        // utilise order by avec tableau vide pour tout récup et trier
        $movies = $movieRepository->findBy([], ['id' => 'DESC']);

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    // *************************** voir 1 film *******************************
    #[Route('/movie/{id}', name: 'app_movie_show', methods: ['GET', 'POST'])]
    public function show(Movie $movie,  Request $request, EntityManagerInterface $em, Security $security): Response
    {



        $review = new Review();
        // association du film et de l'utilisateur a la review
        $review->setMovie($movie);
        // récup du user avec le security
        $user = $security->getUser();
        $review->setUser($user);


        $form = $this->createForm(ReviewType::class, $review);
        $review->setApprouved(false);


        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
        }




        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'form' => $form
        ]);
    }
}
