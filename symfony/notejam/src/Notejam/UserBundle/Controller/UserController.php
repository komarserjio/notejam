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
            $em = $this->getDoctrine()->getManager();
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
                     ->add('password', 'password')
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

    public function forgotPasswordAction(Request $request)
    {
        $form = $this->createFormBuilder()
                     ->add('email', 'email')
                     ->add('save', 'submit')
                     ->getForm();

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $repository = $this->getDoctrine()
                                   ->getRepository('NotejamUserBundle:User');
                $user = $repository->findOneByEmail($data['email']);
                if ($user) {
                    // silly way to generate password
                    $newPassword = substr(
                        md5(time() . $user->getSalt()), 0, 8);
                    $factory = $this->get('security.encoder_factory');
                    $encoder = $factory->getEncoder($user);
                    $password = $encoder->encodePassword(
                        $newPassword, $user->getSalt());
                    $user->setPassword($password);

                    $em = $this->getDoctrine()->getManager();
                    $em->persist($user);
                    $em->flush();

                    $message = \Swift_Message::newInstance()
                        ->setSubject('Notejam password')
                        ->setFrom('noreply@notejamapp.com')
                        ->setTo($user->getEmail())
                        ->setBody("Your new password is {$newPassword}");
                    $this->get('mailer')->send($message);

                    $this->get('session')->getFlashBag()->add(
                        'success',
                        'New password sent to your inbox'
                    );
                } else {
                    $this->get('session')->getFlashBag()->add(
                        'error',
                        "User with given email doesn't exist"
                    );
                }
            }
        }

        return $this->render(
            'NotejamUserBundle:User:forgot-password.html.twig', 
            array('form' => $form->createView())
        );
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

                $em = $this->getDoctrine()->getManager();
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
