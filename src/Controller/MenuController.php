<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\MenuType;
use App\Repository\MenuRepository;
use App\Repository\RestaurantRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/menu")
 */
class MenuController extends AbstractController
{
    /**
     * @Route("/{id}", name="menu_index", methods={"GET"})
     */
    public function index(MenuRepository $menuRepository,Restaurant $restaurant): Response
    {
        return $this->render('menu/index.html.twig', [
            'menus' => $menuRepository->findBy(['restaurant' => $restaurant->getId()]),
        ]);
    }

    /**
     * @Route("/{id}/new", name="menu_new", methods={"GET","POST"})
     */
    public function new(Request $request, RestaurantRepository $restaurantRepository, Restaurant $restaurant): Response
    {
        $menu = new Menu();
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);
        $restaurant = $restaurantRepository->findOneBy(['user'=>$this->getUser()]);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $menu->setRestaurant($restaurantRepository->findOneBy(['user'=>$this->getUser()]));

            $entityManager->persist($menu);
            $entityManager->flush();

            return $this->redirectToRoute('menu_index',[
                'id'=>$restaurant->getId(),
               
            ]
        );
        }

        return $this->render('menu/new.html.twig', [
            'menu' => $menu,
            'restaurant'=> $restaurant,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/show", name="menu_show", methods={"GET"})
     */
    public function show(Menu $menu, Restaurant $restaurant): Response
    {
        return $this->render('menu/show.html.twig', [
            'id'=>$restaurant->getId(),
            'menu' => $menu,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="menu_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Menu $menu, Restaurant $restaurant): Response
    {
        $form = $this->createForm(MenuType::class, $menu);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('menu_index',[
                'id'=>$restaurant->getId(),
            ]);
        }

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="menu_delete", methods={"POST"})
     */
    public function delete(Request $request, Menu $menu): Response
    {
      
        if ($this->isCsrfTokenValid('delete'.$menu->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($menu);
            $entityManager->flush();
        }

        return $this->redirectToRoute('menu_index',[
            'id'=>$menu->getRestaurant()->getId()
        ]);
       
    }
}
