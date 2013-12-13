<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PadController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NotejamNoteBundle:Pad:index.html.twig', array('name' => $name));
    }

    public function createAction() 
    {
        // code...
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

