<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Note;
use AppBundle\Form\Type\NoteType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NoteController
 *
 */
class NoteController extends Controller
{
    /**
     * Lists all notes.
     *
     * @Route("/", name="homepage")
     * @Method("GET")
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $orderBy = $request->query->get('order', 'name');
        $user = $this->getUser();
        $notes = $this->get('app.repository.note')
                      ->findBy(array('user' => $user), $this->buildOrderBy($orderBy));

        return $this->render('AppBundle:Note:list.html.twig', array(
            'notes' => $notes
        ));
    }

    /**
     * Returns the order by field
     *
     * @param string $orderBy
     *
     * @return array
     */
    private function buildOrderBy($orderBy = 'name')
    {
        return [
            'name' => array('name' => 'ASC'),
            '-name' => array('name' => 'DESC'),
            'updated_at' => array('updated_at' => 'ASC'),
            '-updated_at' => array('updated_at' => 'DESC')
        ][$orderBy];
    }

    /**
     * Creates a new note.
     *
     * @Route("/notes/create", name="note_create")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $user = $this->getUser();
        $padId = $request->query->get('pad');

        $em = $this->getDoctrine()->getManager();

        $note = new Note();
        if ($padId) {
            $pad = $this->get('app.repository.pad')->find($padId);
            $note->setPad($pad);
        }

        $form = $this->createForm(new NoteType($user), $note);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $note = $form->getData();
            $note->setUser($user);

            $em->persist($note);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Note is successfully created');

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('AppBundle:Note:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Shows a note detail page.
     *
     * @Route("/notes/view/{id}", name="note_view")
     * @Method("GET")
     *
     * @param Note    $note
     * @param Request $request
     *
     * @return Response
     */
    public function viewAction(Note $note, Request $request)
    {
        return $this->render('AppBundle:Note:view.html.twig', [
            'note' => $note
        ]);
    }

    /**
     * Edits a note.
     *
     * @Route("/notes/{id}/edit", name="note_edit")
     * @Method({"GET", "POST"})
     *
     * @param Note    $note
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Note $note, Request $request)
    {
        $form = $this->createForm(new NoteType($this->getUser()), $note);
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

        return $this->render('AppBundle:Note:edit.html.twig', [
            'form' => $form->createView(),
            'note' => $note
        ]);
    }

    /**
     * Deletes a note.
     *
     * @Route("/notes/{id}/delete", name="note_delete")
     * @Method({"GET", "POST"})
     *
     * @param Note    $note
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction(Note $note, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($note);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            'Note is successfully deleted'
        );

        return $this->redirect($this->generateUrl('homepage'));
    }
}
