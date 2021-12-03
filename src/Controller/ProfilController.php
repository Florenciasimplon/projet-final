<?php

namespace App\Controller;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     */
    public function index(): Response
    {


        return $this->render('profil/index.html.twig', [
            'controller_name' => 'ProfilController',
            'user' => $this->getUser(),
            'user1' => $this->getUser(),
        ]);
        
    }
    
}
