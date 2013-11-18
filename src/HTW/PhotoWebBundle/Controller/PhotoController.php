<?php

namespace HTW\PhotoWebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use HTW\PhotoWebBundle\Entity\Photo;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class PhotoController extends Controller
{
    public function uploadAction(Request $request)
    {
    	$user = $this->getUser()->getId();
	    $photo = new Photo($user);
	    $form = $this->createFormBuilder($photo)
	        ->add('name')
	        ->add('description')
	        ->add('file')
	        ->add('save', 'submit')
	        ->getForm();

	    $form->handleRequest($request);

		if ($form->isValid()) {
		    $em = $this->getDoctrine()->getManager();

		    $em->persist($photo);
		    $em->flush();

		    return $this->redirect($this->generateUrl('htw_photo_web_photo_upload'));
		}

	    return $this->render('HTWPhotoWebBundle:Default:photo_upload.html.twig', array('form' => $form->createView()));
    }
}
