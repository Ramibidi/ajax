<?php

namespace App\Controller;

use App\Entity\User1;
use App\Form\RegistrationType;
use Doctrine\ORM\Mapping\Id;
//use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use phpDocumentor\Reflection\PseudoTypes\False_;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{

    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User1();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            //return $this->redirectToRoute('security_ajax');
        }
        $users = $this->getDoctrine()
            ->getRepository(User1::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($users as $user) {
                $temp = array(
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),

                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView(), 'users' => $users
        ]);
    }



    /**
     * @Route("/connexion", name="security_login")
     */
    public function login()
    {

        return $this->render('security/login.html.twig');
        // $this->redirectToRoute('blog');

    }




    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout()
    {
        //return $this->render('security/login.html.twig');
    }





    /** 
     * @Route("/user/ajax , name="security_ajax") 
     */
    public function ajaxAction(Request $request)
    {
        $users = $this->getDoctrine()
            ->getRepository(User1::class)
            ->findAll();

        if ($request->isXmlHttpRequest() || $request->query->get('showJson') == 1) {
            $jsonData = array();
            $idx = 0;
            foreach ($users as $user) {
                $temp = array(
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                );
                $jsonData[$idx++] = $temp;
            }
            return new JsonResponse($jsonData);
        } else {
            return $this->render('user/ajax.html.twig');
        }
    }
}
