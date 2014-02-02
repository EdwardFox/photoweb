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
	        ->add('name', 'text')
	        ->add('description', null, array('label' => 'Beschreibung'))
	        ->add('file', null, array('label' => 'Datei'))
            ->add('format', 'choice', array(
                'choices' => array(
                    1 => 'Quadratisch',
                    2 => 'Hochformat',
                    3 => 'Querformat',
                    4 => 'Panorama'
                ),
                'required' => false,
                'empty_value' => 'Wähle das Format',
                'empty_data' => null,
            ))
            ->add('color', 'choice', array(
                'choices' => array(
                    '1' => 'Farbe',
                    '2' => 'Schwarzweiß',
                ),
                'label' => 'Farbe',
                'empty_value' => 'Alle',
                'empty_data' => null,
                'required' => false,
            ))
            ->add('width', 'text', array('label' => 'Breite'))
            ->add('height', 'text', array('label' => 'Höhe'))
	        ->add('save', 'submit', array('attr'=> array('class'=>'test'), 'label' => 'Hinzufügen'))
	        ->add('saveAndAdd', 'submit', array('label' => 'Hinzufügen und weiteres Foto anlegen'))
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

	/**
	 * @Route("/export")
	 * @Method("GET")
	 */
	public function exportAction()
	{
		$userID = $this->getUser()->getId();

		$repository = $this->getDoctrine()
						   ->getRepository('HTWPhotoWebBundle:Photo');

		$query = $repository->createQueryBuilder('p')
							->where('p.user = :userID')
							->setParameter('userID', $userID)
							->getQuery();

		$templating = $this->get('templating');
		$content = $templating->render(
		    'HTWPhotoWebBundle:Photo:export.html.twig',
		    array('photos' => $query->getResult())
		);

		$response = new Response($content);
		$response->headers->set('Content-Type', 'application/xml');

		return $response;
	}
}
