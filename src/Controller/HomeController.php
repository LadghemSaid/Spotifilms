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
    public function index(SeriesRepository $series_Repo)
    {
$series =$series_Repo->findBy(array(), array('id' => 'DESC'),15);
        return $this->render('home/index.html.twig', [
            "series" => $series
        ]);
    }
}
