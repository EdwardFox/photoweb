<?php

namespace HTW\PhotoWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('HTWPhotoWebBundle:Default:index.html.twig');
    }
}
