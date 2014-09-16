<?php

namespace Intaro\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('IntaroUserBundle:Default:index.html.twig', array('name' => $name));
    }
}
