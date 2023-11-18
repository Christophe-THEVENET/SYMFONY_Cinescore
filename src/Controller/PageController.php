<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MovieRepository $movieRepository): Response
    {
        $webSiteName = 'CinéScore';

        $movies = $movieRepository->findBy([], ['id' => 'DESC'], 3);

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
