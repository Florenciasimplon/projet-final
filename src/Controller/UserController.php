<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\Query\Expr\OrderBy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    
    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user, SluggerInterface $slugger, RestaurantRepository $restaurantRepository, TemoignageRepository $temoignageRepository, ReservationRepository $reservationRepository): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request); 
        $picture = $form->get('picture')->getData();
        $restaurant = $restaurantRepository->findOneBy(['user'=>$this->getUser()]);
        $temoignages = $temoignageRepository->findBy(['restaurant'=>$restaurant]);
        $reservations = $reservationRepository->findBy(['user'=>$this->getUser()]);
        $reservationslist = $reservationRepository->findBy(['restautant'=>$restaurant]);
       
        $temoignageUser = $temoignageRepository->findBy(['user'=>$this->getUser()]);
        

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','vos modifications sont sauvegardées');
            if ($picture !== null) {
                $user->setPicture($this->upload($picture, 'picture', $slugger));
            }        

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit',[
                'id'=>$user->getId(),
            ]);
        }
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'restaurant'=> $restaurant,
            'temoignages'=>$temoignages,
            'temoignageUser'=>$temoignageUser,
            'reservations'=>$reservations,
            'reservationlist'=>$reservationslist,
            
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
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
