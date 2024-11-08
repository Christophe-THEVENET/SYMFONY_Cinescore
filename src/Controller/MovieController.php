<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Review;
use App\Form\ReviewType;
use App\Repository\MovieRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;



class MovieController extends AbstractController
{


    // ********************** tous les films ****************************
    #[Route('/movies', name: 'app_movies')]
    public function index(MovieRepository $movieRepository, Request $request): Response
    {
        // utilise order by avec tableau vide pour tout récup et trier
         /* $movies = $movieRepository->findBy([], ['id' => 'DESC']);   */

        // nouvelle requete avec possibilité de filtrer les films par genre
        $genreId = $request->get('genreId');
         $movies = $movieRepository->findMoviesWithCriteria($genreId);




        return $this->render('movie/index.html.twig', [
            'movies' => $movies,
        ]);
    }

    // *************************** voir 1 film *******************************
    #[Route('/movie/{id}', name: 'app_movie_show', methods: ['GET', 'POST'])]
    public function show(Movie $movie,  Request $request, EntityManagerInterface $em, Security $security, ReviewRepository $reviewRepository, MovieRepository $movieRepository, SessionInterface $session): Response
    {


        // on récup l'url courante et on la stocke en session comme page précédente : previous_url
        $session->set('previous_url', $request->getUri());


        // on récup le uer
        $user = $security->getUser();

        // on vérifie si le user a déja posté une review
        $review = $reviewRepository->findOneBy(['movie' => $movie, 'user' => $user]);

        //récup toutes les reviews du film
        $reviewsByMovie = $reviewRepository->findBy(['movie' => $movie,]);

        // si pas de review on en crée une 
        if (!$review) {
            $review = new Review();
            // association du film et de l'utilisateur a la review
            $review->setMovie($movie);
            // récup du user avec le security
            $review->setUser($user);
            $review->setApprouved(false);
        }

        // note moyenne du film
        $averageRateByMovie = round($reviewRepository->getAverageRateByMovie($movie));




        $form = $this->createForm(ReviewType::class, $review);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
        }

        return $this->render('movie/show.html.twig', [
            'movie' => $movie,
            'form' => $form,
            'reviewsByMovie' => $reviewsByMovie,
            'averageRateByMovie' => $averageRateByMovie,
            'user' => $user,
        ]);
    }
}
