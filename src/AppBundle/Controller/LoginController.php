<?php

namespace AppBundle\Controller;

use JDLX\SocialLogin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/login")
 */
class LoginController extends Controller
{
    /**
     * @Route("/google", name="login_google")
     */
    public function googleLoginAction(Request $request)
    {
        /** @var SocialLogin $manager */
        $manager = $this->container->get('app.login');
        $manager->gotoGoogleLogin();

        return new Response('ok');
    }

     /**
     * @Route("/linkedin", name="login_linkedin")
     */
    public function linkedinLoginAction(Request $request)
    {
        /** @var SocialLogin $manager */
        $manager = $this->container->get('app.login');
        $manager->gotoLinkedinLogin();

        return $this->render('Login/login.html.twig', []);
    }
}
