<?php

namespace Notejam\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NotejamUserBundle:User:index.html.twig', array('name' => $name));
    }

    public function signupAction()
    {
        // code...
    }

    public function signinAction()
    {
        // code...
    }

    public function forgotPasswordAction()
    {
        // code...
    }

    public function settingsAction()
    {
        // code...
    }
}
