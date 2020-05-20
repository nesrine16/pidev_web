<?php

namespace FamilleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FamilleBundle:Default:index.html.twig');
    }
}
