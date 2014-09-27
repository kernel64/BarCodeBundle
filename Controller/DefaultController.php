<?php

namespace Mabs\BarCodeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MabsBarCodeBundle:Default:index.html.twig', array('name' => $name));
    }
}
