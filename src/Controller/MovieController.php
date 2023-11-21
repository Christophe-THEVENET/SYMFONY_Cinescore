<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

setlocale(LC_TIME, 'fr_FR.UTF-8');


class MovieController extends AbstractController
{


    // ****************** tous les films ****************************
    #[Route('/movie', name: 'app_movie')]
    public function index(MovieRepository $movieRepository): Response
    {
        // utilise order by avec tableau vide pour tout récup et trier
        $movies = $movieRepository->findBy([], ['id' => 'DESC']);

        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    // ****************** voir 1 film ****************************
    #[Route('/movie/{id}', name: 'app_movie_show', methods: ['GET'])]
    public function show(Movie $movie): Response
    {



        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);





        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'form' => $form
        ]);
    }
}
