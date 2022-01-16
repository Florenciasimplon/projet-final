<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\RestaurantType;
use App\Repository\MenuRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TemoignageRepository;
use PhpParser\Node\Stmt\Use_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/restaurateur")
 */
class RestaurantController extends AbstractController
{
    /**
     * @Route("/", name="restaurant_index", methods={"GET"})
     */
    public function index(RestaurantRepository $restaurantRepository): Response
    {
        return $this->render('restaurant/index.html.twig', [
            'restaurants' => $restaurantRepository->findAll(),
          
        ]);
        
    }

    /**
     * @Route("/{id}/new", name="restaurant_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger ,User $user): Response
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);
        $pictureRestaurants = $form->get('picture_restaurant')->getData();           

        if ($form->isSubmitted() && $form->isValid()) {
            if ($pictureRestaurants !== null) {
                foreach ($pictureRestaurants as $pictureRestaurant){
                    $restaurant->setPictureRestaurant($this->upload($pictureRestaurant, 'picture_restaurant', $slugger));

                }
            }   
            $restaurant->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($restaurant);
            $entityManager->flush();

            return $this->redirectToRoute('restaurant_show',[
                'id'=>$restaurant->getId(),
            ]);
        }

        return $this->render('restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}", name="restaurant_show", methods={"GET"})
     */
    public function show(Restaurant $restaurant, MenuRepository $menuRepository, TemoignageRepository $temoignageRepository, ReservationRepository $reservationRepository): Response
    {
        $restaurantmenu = $menuRepository -> findBy(['restaurant'=> $restaurant -> getId()]);
        $temoignages = $temoignageRepository->findBy(['restaurant'=>$restaurant],['date' => 'DESC']);
        
    
        return $this->render('restaurant/show.html.twig', [
            'restaurant' => $restaurant,
            'menus' => $restaurantmenu,
            'temoignages' => $temoignages,
        ]);

    }

    /**
     * @Route("/{id}/edit", name="restaurant_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Restaurant $restaurant, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);
        $pictureRestaurants = $form->get('picture_restaurant')->getData();           
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','vos modification sont sauvegardées');
           
            if ($pictureRestaurants !== null) {
                $restaurant ->resetPictureRestaurant();
                foreach ($pictureRestaurants as $pictureRestaurant){
                $restaurant->setPictureRestaurant($this->upload($pictureRestaurant, 'picture_restaurant', $slugger));
                }
            
            }
           
            $this->getDoctrine()->getManager()->flush();  
            return $this->redirectToRoute('restaurant_show',[
                'id'=>$restaurant->getId(),
            ]);
        }

        return $this->render('restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView(),
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}", name="restaurant_delete", methods={"POST"})
     */
    public function delete(Request $request, Restaurant $restaurant): Response
    {
        if ($this->isCsrfTokenValid('delete'.$restaurant->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($restaurant);
            $entityManager->flush();
        }

        return $this->redirectToRoute('restaurant_index');
    }




    public function upload($file, $target_directory ,$slugger){
        if ($file) {
                    $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename.'-'.uniqid().'.'.$file->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $file->move(
                            $this->getParameter($target_directory),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
                    return $newFilename;
                }

        }
}
