<?php

namespace Notejam\NoteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class NoteController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NotejamNoteBundle:Note:index.html.twig', array('name' => $name));
    }

    public function viewAction() 
    {
        // code...
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
