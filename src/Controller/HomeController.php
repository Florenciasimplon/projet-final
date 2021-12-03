<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(RestaurantRepository $restaurantRepository, TemoignageRepository $temoignageRepository, UserRepository $userRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
            'temoignage' => $temoignageRepository->findBy([],[], 3),
            'user' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/admin", name="homeAdmin")
     */
    public function indexAdmin(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'Admin',
        ]);
    }

}
