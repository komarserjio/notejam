<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Notejam\NoteBundle\Entity\Pad;
use Notejam\NoteBundle\Form\Type\PadType;

class PadController extends Controller
{
    public function indexAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        return $this->render(
            'NotejamNoteBundle:Pad:index.html.twig', 
            array('pads' => $user->getPads())
        );
    }

    public function createAction(Request $request) 
    {
        $form = $this->createForm(new PadType(), new Pad());
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $pad = $form->getData();
                $pad->setUser(
                    $this->get('security.context')->getToken()->getUser()
                );

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($pad);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'success',
                    'Pad was successfully created'
                );
                return $this->redirect($this->generateUrl('homepage'));
            }
        }
        return $this->render(
            'NotejamNoteBundle:Pad:create.html.twig',
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

