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

use HTW\PhotoWebBundle\Entity\Photo;

class PhotoController extends Controller
{

	/**
     * @Route("/upload")
     */
    public function uploadAction(Request $request)
    {
    	$user = $this->getUser()->getId();
	    $photo = new Photo($user);
	    $form = $this->createFormBuilder($photo)
	        ->add('name')
	        ->add('description')
	        ->add('file')
	        ->add('save', 'submit')
	        ->add('saveAndAdd', 'submit')
	        ->getForm();

	    $form->handleRequest($request);

		if ($form->isValid()) {
		    $em = $this->getDoctrine()->getManager();

		    $em->persist($photo);
		    $em->flush();

		    $this->get('session')->getFlashBag()->add('notice', 'Your image was uploaded successfully'); 

		    // Stay on the upload page if second button is clicked
		    if($form->get('saveAndAdd')->isClicked()) {
		    	return $this->redirect($this->generateUrl('htw_photoweb_photo_upload'));
		    }

		    return $this->redirect($this->generateUrl('htw_photoweb_myarea_index'));
		}

	    return $this->render('HTWPhotoWebBundle:Photo:upload.html.twig', array('form' => $form->createView()));
    }
}
