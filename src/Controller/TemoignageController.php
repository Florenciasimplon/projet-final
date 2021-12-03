<?php

namespace App\Controller;

use App\Entity\Temoignage;
use App\Entity\User;
use App\Form\TemoignageType;
use App\Repository\RestaurantRepository;
use App\Repository\TemoignageRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/temoignage")
 */
class TemoignageController extends AbstractController
{
    /**
     * @Route("/", name="temoignage_index", methods={"GET"})
     */
    public function index(TemoignageRepository $temoignageRepository): Response
    {
        return $this->render('temoignage/index.html.twig', [
            'temoignages' => $temoignageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="temoignage_new", methods={"GET","POST"})
     */
    public function new(Request $request, RestaurantRepository $restaurantRepository): Response
    {
        $temoignages = new Temoignage();
        $form = $this->createForm(TemoignageType::class, $temoignages);
        $form->handleRequest($request);
        $idRestaurant = $request->get('idRestaurant');
        $restaurant = $restaurantRepository->findOneBy(["id" => $idRestaurant]);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $temoignages->setUser($this->getUser());
            $temoignages->setRestaurant($restaurant);
            
            $date = new DateTime();
            $temoignages->setDate($date);
            $entityManager->persist($temoignages);
            $entityManager->flush();

            return $this->redirectToRoute('temoignage_index');
        }

        return $this->render('temoignage/new.html.twig', [
            'temoignage' => $temoignages,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temoignage_show", methods={"GET"})
     */
    public function show(Temoignage $temoignage): Response
    {
        return $this->render('temoignage/show.html.twig', [
            'temoignage' => $temoignage,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="temoignage_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Temoignage $temoignage): Response
    {
        $form = $this->createForm(TemoignageType::class, $temoignage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('temoignage_index');
        }

        return $this->render('temoignage/edit.html.twig', [
            'temoignage' => $temoignage,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="temoignage_delete", methods={"POST"})
     */
    public function delete(Request $request, Temoignage $temoignage): Response
    {
        if ($this->isCsrfTokenValid('delete'.$temoignage->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($temoignage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('temoignage_index');
    }
}
