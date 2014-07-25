<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Notejam\NoteBundle\Entity\Note;
use Notejam\NoteBundle\Form\Type\NoteType;

class NoteController extends Controller
{
    public function listAction(Request $request)
    {
        $orderBy = $request->query->get('order', 'name');
        $user = $this->get('security.context')->getToken()->getUser();
        $notes = $this->getDoctrine()
                      ->getRepository('NotejamNoteBundle:Note')
                      ->findBy(array('user' => $user),
                               $this->_buildOrderBy($orderBy));
        return $this->render('NotejamNoteBundle:Note:list.html.twig', array(
            'notes' => $notes
        ));
    }

    private function _buildOrderBy($orderBy = 'name')
    {
        return array(
            'name' => array('name' => 'ASC'),
            '-name' => array('name' => 'DESC'),
            'updated_at' => array('updated_at' => 'ASC'),
            '-updated_at' => array('updated_at' => 'DESC')
        )[$orderBy];
    }

    public function viewAction($id, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $note = $this->getDoctrine()
                    ->getRepository('NotejamNoteBundle:Note')
                    ->findOneBy(array('id' => $id,
                                      'user' => $user));
        return $this->render('NotejamNoteBundle:Note:view.html.twig', array(
            'note' => $note
        ));
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $pad = $this->getDoctrine()
                    ->getRepository('NotejamNoteBundle:Pad')
                    ->findOneBy(array('id' => $request->query->get('pad')));

        $user = $this->get('security.context')->getToken()->getUser();
        $note = new Note();
        $note->setPad($pad);

        $form = $this->createForm(new NoteType($user), $note);
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $note = $form->getData();
                $note->setUser($user);

                $em->persist($note);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Note is successfully created'
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
                    'Note is successfully updated'
                );
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render(
            'NotejamNoteBundle:Note:edit.html.twig',
            array('form' => $form->createView(), 'note' => $note)
        );
    }

    public function deleteAction($id, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $note = $this->getDoctrine()
                    ->getRepository('NotejamNoteBundle:Note')
                    ->findOneBy(array('id' => $id,
                                      'user' => $user));
        if ($request->getMethod() == 'POST') {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($note);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Note is successfully deleted'
            );
            return $this->redirect($this->generateUrl('homepage'));
        }
        return $this->render(
            'NotejamNoteBundle:Note:delete.html.twig',
            array('note' => $note)
        );
    }
}
