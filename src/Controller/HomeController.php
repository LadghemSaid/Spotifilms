<?php

namespace App\Controller;

use App\Repository\SeriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(SeriesRepository $seriesRepository)
    {
        $nb_series_affichage = 10;
        $nb_series = $seriesRepository->findHowManySeries();
        $offset = max(0, rand(0, $nb_series - $nb_series_affichage - 1));

        return $this->render('home/index.html.twig', [
            'series' => $seriesRepository->getRandomSeries($nb_series_affichage,$offset)
        ]);
    }
}
