<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use AppBundle\Entity\User;
use AppBundle\Form\Type\UserType;
use AppBundle\Form\Type\ChangePasswordType;

/**
 * Class UserController
 *
 */
class UserController extends Controller
{

    /**
     * @param $name
     *
     * @return Response
     */
    public function indexAction($name)
    {
        return $this->render('AppBundle:User:index.html.twig', array('name' => $name));
    }

    /**
     * Signup form.
     *
     * @Route("/signup", name="user_signup")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function signupAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.default_entity_manager');

            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
            $user->setPassword($password);

            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Account is created. Now you can sign in.'
            );

            return $this->redirect($this->generateUrl('user_signin'));

        }

        return $this->render('AppBundle:User:signup.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Sign in form.
     *
     * @Route("/signin", name="user_signin")
     * @Method("GET")
     *
     * @return Response
     */
    public function signinAction(Request $request)
    {
        $session = $request->getSession();
        $form = $this->createFormBuilder(new User())
                     ->setAction($this->generateUrl('login_check'))
                     ->add('email', 'text')
                     ->add('password', 'password')
                     ->add('save', 'submit', array('label' => 'Sign in'))
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

        return $this->render('AppBundle:User:signin.html.twig', [
            'form' => $form->createView()]
        );
    }

    /**
     * Forgot password form.
     *
     * @Route("/forgot-password", name="user_forgot_password")
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function forgotPasswordAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('email', 'email')
            ->add('save', 'submit')
            ->getForm();

        $form->handleRequest($request);
        if ($form->isValid()) {
            $data = $form->getData();
            $repository = $this->getDoctrine()->getRepository('AppBundle:User');
            $user = $repository->findOneByEmail($data['email']);
            if ($user) {
                // silly way to generate password
                $newPassword = substr(md5(time() . $user->getSalt()), 0, 8);
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($newPassword, $user->getSalt());
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

        return $this->render(
            'AppBundle:User:forgot-password.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * User settings form.
     *
     * @Route("/settings", name="user_settings")
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function settingsAction(Request $request)
    {
        $form = $this->createForm(new ChangePasswordType());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $passwordData = $form->getData();
            $user = $this->getUser();
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($passwordData['new_password'], $user->getSalt());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Password is successfully changed'
            );
        }

        return $this->render('AppBundle:User:settings.html.twig', [
            'form' => $form->createView()]
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
        // this controller will not be executed,
        // as the route is handled by the Security system
    }
}
