<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Notejam\NoteBundle\Entity\Pad;
use Notejam\NoteBundle\Form\Type\PadType;

class PadController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NotejamNoteBundle:Pad:index.html.twig');
    }

    public function createAction() 
    {
        $form = $this->createForm(new PadType(), new Pad());
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

