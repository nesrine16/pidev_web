<?php

namespace trackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@track/Default/index.html.twig');
    }

    public function backAction()
    {

        return $this->render('@track/Default/back.html.twig');

    }
}
