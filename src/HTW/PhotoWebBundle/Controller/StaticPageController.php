<?php
namespace HTW\PhotoWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;



class StaticPageController extends Controller
{
    /**
     * @Route("/privacy")
     * @Template("HTWPhotoWebBundle:StaticPage:privacy.html.twig")
     */
    public function privacyAction() { return array(); }

    /**
     * @Route("/imprint")
     * @Template("HTWPhotoWebBundle:StaticPage:imprint.html.twig")
     */
    public function imprintAction() { return array(); }

    /**
     * @Route("/contact")
     * @Template("HTWPhotoWebBundle:StaticPage:contact.html.twig")
     */
    public function contactAction() { return array(); }
}
