<?php

namespace Notejam\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Notejam\UserBundle\Entity\User;
use Notejam\UserBundle\Form\Type\UserType;
use Notejam\UserBundle\Form\Type\ChangePasswordType;


class UserController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NotejamUserBundle:User:index.html.twig', array('name' => $name));
    }

    public function signupAction(Request $request)
    {
        $form = $this->createForm(new UserType(), new User());

        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $form->handleRequest($request);
            if ($form->isValid()) {
                $user = $form->getData();

                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword(
                    $user->getPassword(), $user->getSalt());
                $user->setPassword($password);

                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Now you can sign in'
                );
                return $this->redirect($this->generateUrl('signin'));
            }
        }
        return $this->render(
            'NotejamUserBundle:User:signup.html.twig',
            array('form' => $form->createView())
        );
    }

    public function signinAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();
        $user = new User();
        $form = $this->createFormBuilder(new User())
                     ->setAction($this->generateUrl('login_check'))
                     ->add('email', 'text')
                     ->add('password', 'text')
                     ->add('save', 'submit')
                     ->getForm();
 
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }
        if ($error) {
            $this->get('session')->getFlashBag()->add(
                'error',
                $error->getMessage()
            );
        }
 
        return $this->render(
            'NotejamUserBundle:User:signin.html.twig', 
            array('form' => $form->createView())
        );
    }

    public function forgotPasswordAction()
    {
        // code...
    }

    public function settingsAction(Request $request)
    {
        $form = $this->createForm(new ChangePasswordType());
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $passwordData = $form->getData();
                $user = $this->get('security.context')->getToken()->getUser();
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword(
                    $passwordData['new_password'], $user->getSalt());
                $user->setPassword($password);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Password successfully changed'
                );
            }
        }
        return $this->render(
            'NotejamUserBundle:User:settings.html.twig',
            array('form' => $form->createView())
        );
    }
}
