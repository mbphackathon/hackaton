<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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

        $manager = $this->container->get('app.login');
        $manager->gotoGoogleLogin();

        return array();
    }

     /**
     * @Route("/linkedin", name="login_linkedin")
     */
    public function linkedinLoginAction(Request $request)
    {

        $manager = $this->container->get('app.login');
        $manager->gotoLinkedinLogin();

        return array();
    }
}
