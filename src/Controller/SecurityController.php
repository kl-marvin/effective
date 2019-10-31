<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\UserRegistrationType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var \Twig_Environment
     */
    private $twig_Environment;
  
    /**
     * @param ObjectManager $em
     */
    public function __construct(ObjectManager $em, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, \Twig_Environment $twig_Environment)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->twig_Environment = $twig_Environment;
        $this->encoder = $encoder;
    }


    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }


    /**
     * @Route("/registration", name="app_registration")
     */
    public function registration(Request $request)
    {
            $user = new User();
            $form = $this->createForm(UserRegistrationType::class, $user);
            $form->handleRequest($request);


            if($form->isSubmitted() && $form->valid()){
                $user->setRole(['ROLE_USER']);
                $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));
                $this->em->persist($user);
                $this->em->flush();
            }

            return $this->render('security/registration.html.twig', [
                'form' => $form->createView(),
                'user' => $this->getUser()
            ]);
          

    }
}
