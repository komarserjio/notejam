<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Pad;
use AppBundle\Form\Type\PadType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PadController
 *
 */
class PadController extends Controller
{

    /**
     * Lists all pads.
     *
     * @return Response
     */
    public function listAction()
    {
        return $this->render(
            'AppBundle:Pad:list.html.twig',
            array('pads' => $this->getUser()->getPads())
        );
    }

    /**
     * List all notes for a pad.
     *
     * @Route("/pads/{id}/notes", name="pad_notes")
     * @Method("GET")
     *
     * @return Response
     */
    public function notesAction(Pad $pad, Request $request)
    {
        $orderBy = $request->query->get('order', 'name');
        $notes = $this->get('app.repository.note')->findBy(
            ['pad' => $pad->getId()],
            $this->buildOrderBy($orderBy)
        );

        return $this->render('AppBundle:Pad:notes.html.twig', [
            'notes' => $notes,
            'pad' => $pad
        ]);
    }

    /**
     * Returns the order by field

     * @param string $orderBy
     *
     * @return array
     */
    private function buildOrderBy($orderBy = 'name')
    {
        return [
            'name' => ['name' => 'ASC'],
            '-name' => ['name' => 'DESC'],
        ][$orderBy];
    }

    /**
     * Creates a new pad.
     *
     * @Route("/pads/create", name="pad_create")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $pad = new Pad();
        $pad->setUser($this->getUser());

        $form = $this->createForm(new PadType(), $pad);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($pad);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Pad is successfully created'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('AppBundle:Pad:create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit an existing pad.
     *
     * @Route("/pads/{id}/edit", name="pad_edit")
     * @Method({"GET", "POST"})
     *
     * @param Pad     $pad
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Pad $pad, Request $request)
    {
        $form = $this->createForm(new PadType(), $pad);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Pad is successfully updated'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('AppBundle:Pad:edit.html.twig', [
            'form' => $form->createView(), 'pad' => $pad
        ]);
    }

    /**
     * Delete a pad.
     *
     * @Route("/pads/{id}/delete", name="pad_delete")
     * @Method({"GET", "POST"})
     *
     * @param Pad     $pad
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction(Pad $pad, Request $request)
    {
        if ($pad->getUser()->getId() !== $this->getUser()->getId()) {
            throw $this->createNotFoundException('Pad not found');
        }

        if ($request->isMethod('POST')) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pad);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                'Pad is successfully deleted'
            );

            return $this->redirect($this->generateUrl('homepage'));
        }

        return $this->render('AppBundle:Pad:delete.html.twig', [
            'pad' => $pad
        ]);
    }
}

