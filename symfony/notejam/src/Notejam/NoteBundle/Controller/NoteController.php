<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Notejam\NoteBundle\Entity\Note;
use Notejam\NoteBundle\Form\Type\NoteType;

class NoteController extends Controller
{
    public function indexAction()
    {
        return $this->render('NotejamNoteBundle:Note:index.html.twig');
    }

    public function viewAction() 
    {
        // code...
    }

    public function createAction(Request $request) 
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $form = $this->createForm(new NoteType($user), new Note());
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $note = $form->getData();
                $note->setUser($user);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($note);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Note was successfully created'
                );
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render(
            'NotejamNoteBundle:Note:create.html.twig',
            array('form' => $form->createView())
        );
    }

    public function editAction($id, Request $request) 
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $note = $this->getDoctrine()
                    ->getRepository('NotejamNoteBundle:Note')
                    ->findOneBy(array('id' => $id, 
                                      'user' => $user));

        $form = $this->createForm(new NoteType($user), $note);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Note was successfully updated'
                );
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render(
            'NotejamNoteBundle:Note:edit.html.twig',
            array('form' => $form->createView(), 'note' => $note)
        );
    }

    public function deleteAction() 
    {
        // code...
    }
}
