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
        $form = $this->createForm(new NoteType(), new Note());
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $note = $form->getData();
                $note->setUser(
                    $this->get('security.context')->getToken()->getUser()
                );

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

    public function editAction() 
    {
        // code...
    }

    public function deleteAction() 
    {
        // code...
    }
}
