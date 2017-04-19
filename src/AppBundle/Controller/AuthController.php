<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

use AppBundle\Entity\User;

/**
 * @Route("/auth")
 */
class AuthController extends Controller
{
    /**
     * @Route("/Google/callback", name="auth_google")
     *
     */
    public function googleCallbackAction(Request $request)
    {
        $manager = $this->container->get('app.login');
        $data = $manager->getGoogleUserData();

        $user = new User();
        $user->setLastname($data['family_name']);
        $user->setFirstname($data['given_name']);
        $user->setThumbnail($data['picture']);
        $user->setEmail($data['email']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        die(var_dump('ok'));
        return $this->redirectToRoute('home');
    }

}
