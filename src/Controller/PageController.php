<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository, ParameterBagInterface $parameterBagInterface): Response
    {
        $webSiteName = 'CinéScore';
        $home_movies_limit = $parameterBagInterface->get('home_movies_limit');




        $movies = $movieRepository->findMoviesWithCriteria(null, $home_movies_limit);


        return $this->render('page/index.html.twig', [
            'webSiteName' => $webSiteName,
            'movies' => $movies,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        $webSiteName = 'CinéScore';
        return $this->render('page/about.html.twig', [
            'webSiteName' => $webSiteName,
        ]);
    }
}
