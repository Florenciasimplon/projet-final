<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Restaurant;
use App\Entity\User;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\UserRepository;
use DateTime;
use Proxies\__CG__\App\Entity\Restaurant as EntityRestaurant;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reservation")
 */
class ReservationController extends AbstractController
{


      /**
     * @Route("/{id}/new", name="reservation_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserRepository $userRepository, Restaurant $restaurant, MailerInterface $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        $user = $userRepository->findOneBy(['id'=>$restaurant->getUser()->getId()]);
        // dd($user);
        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setUser($this->getUser());
            $reservation->setRestautant($restaurant);
            $date = new DateTime();
            // dd($user, $reservation);
     
            $email = (new TemplatedEmail())
                ->from(new Address($this->getUser()->getEmail()))
                ->to($user->getEmail())
                ->subject('Reservation')
                ->htmlTemplate('email/reservation.html.twig')
                ->context([
                   "user"=>$this->getUser(),
                   'restaurant'=>$restaurant,
                   'reservation'=>$reservation
                ]);
    
            $mailer->send($email);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($reservation);
            $entityManager->flush();
            $this->addFlash('success','Votre reservations à bien été enregistrée');
            return $this->redirectToRoute('user_edit',[
             'id'=>$this->getUser()->getId()
            ]);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'restaurant' => $restaurant,
            'user'=> $this->getUser() ?  $this->getUser() : '',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_show", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'user' => $this->getUser(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reservation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reservation $reservation): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reservation_index');
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $this->addFlash('Delete','Reservation annuler avec succès');
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_edit',[
            'id'=>$this->getUser()->getId(),
        ]);
    }
}
