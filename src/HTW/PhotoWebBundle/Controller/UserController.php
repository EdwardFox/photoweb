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

use HTW\PhotoWebBundle\Entity\User;


class UserController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET")
     * @Template("HTWPhotoWebBundle:User:list.html.twig", vars={"users"})
     */
    public function listAction()
    {
    	$users = $this->getDoctrine()
        ->getRepository('HTWPhotoWebBundle:User')
        ->findAll();

    	return array('users' => $users);
    }


    /**
     * @Route("/{user}")
     * @ParamConverter("user", class="HTWPhotoWebBundle:user")
     * @Method("GET")
     * @Template("HTWPhotoWebBundle:User:show.html.twig", vars={"user"})
     */
    public function showAction() {}

}
