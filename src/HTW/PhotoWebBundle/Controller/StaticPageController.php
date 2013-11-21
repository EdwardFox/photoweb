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
     * @Route("/about")
     * @Method("GET")
     * @Template("HTWPhotoWebBundle:StaticPage:general.html.twig", vars={"static_content"})
     */
    public function aboutAction()
    {
    	$content = "About Page content";

    	return array('static_content' => $content);
    }

    /**
     * @Route("/contact")
     * @Method("GET")
     * @Template("HTWPhotoWebBundle:StaticPage:general.html.twig", vars={"static_content"})
     */
    public function contactAction()
    {
    	$content = "Contact Page content";

    	return array('static_content' => $content);
    }
}
