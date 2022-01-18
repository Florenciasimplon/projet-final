<?php

namespace App\Controller;

use App\Repository\RestaurantRepository;
use App\Repository\TemoignageRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
            'temoignage' => $temoignageRepository->findBy([],['date' => 'DESC'],3),
            'user' => $userRepository->findAll(),
        ]);
    }
    /**
     * @Route("/contact", name="contact", methods={"GET","POST"})
     */
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createFormBuilder()
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('telephone', NumberType::class)
            ->add('message', TextareaType::class)
            ->getForm();
            
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $email = (new TemplatedEmail())
            //adresse à changer une fois mis en prod $data['email']
                        ->from(new Address($data['email'], $data['nom'].' '. $data['prenom']))
                        ->to('florenciasimplon@gmail.com')
                        ->subject('Prise de contact')
                        ->htmlTemplate('email/email.html.twig')
                        ->context([
                            'nom' => $data['nom'],
                            'prenom' => $data['prenom'],
                            'telephone' => $data['telephone'],
                            'message' => $data['message']
                        ]);
    
            $mailer->send($email);
            $this->addFlash('success', "Votre message a bien été envoyé");
            return $this->redirectToRoute('home');

        }
        return $this->render('email/contact.html.twig', [
            'form' =>$form->createView(),
        ]);
    }
    

}
