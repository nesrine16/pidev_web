<?php

namespace PaletteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PaletteBundle:Default:index.html.twig');
    }
}
