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


class SearchController extends Controller
{
    /**
     * @Route("/old")
     */
    public function resultsAction()
    {
        return $this->render('HTWPhotoWebBundle:Search:search.html.twig');  
    }

    /**
     * @Route("/form")
     */
    public function formAction(Request $request, $originalRequest = null)
    {
        $defaultValues = array();
        if($originalRequest != null) {
            $defaultValues['name'] = $originalRequest->query->get('name');
            $defaultValues['format'] = $originalRequest->query->get('format');
            $defaultValues['color'] = $originalRequest->query->get('color');
            $defaultValues['width'] = $originalRequest->query->get('width');
            $defaultValues['height'] = $originalRequest->query->get('height');
        }

        $form = $this->createFormBuilder($defaultValues)
            ->setAction($this->generateUrl('htw_photoweb_search_form'))
            ->add('name', 'text', array('required' => false))
            ->add('format', 'choice', array(
                'choices' => array(
                    '1' => 'Quadratisch',
                    '2' => 'Hochformat',
                    '3' => 'Querformat',
                    '4' => 'Panorama'
                ),
                'required' => false,
                'empty_value' => 'Alle',
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
            ->add('width', 'text', array('label' => 'Breite in px', 'required' => false))
            ->add('height', 'text', array('label' => 'Höhe in px', 'required' => false))
            ->add('search', 'submit', array('label' => 'Suchen'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $this->redirect($this->generateUrl('htw_photoweb_search_search', array(
                'name' => $data['name'],
                'format' => $data['format'],
                'color' => $data['color'],
                'width' => $data['width'],
                'height' => $data['height'],
            )));
        }

        return $this->render('HTWPhotoWebBundle:Search:form.html.twig', array('form' => $form->createView()));  
    }

    /**
     * @Route("/")
     */
    public function searchAction(Request $request)
    {
        $name = $request->query->get('name') ? $request->query->get('name') : '%';
        $format = $request->query->get('format') ? $request->query->get('format') : '%';
        $color = $request->query->get('color') ? $request->query->get('color') : '%';
        $width = $request->query->get('width') ? $request->query->get('width') : '%';
        $height = $request->query->get('height') ? $request->query->get('height') : '%';
        
        $repository = $this->getDoctrine()
            ->getRepository('HTWPhotoWebBundle:Photo');

        $query = $repository->createQueryBuilder('p')
            ->where('LOWER(p.name) LIKE LOWER(:name) OR LOWER(p.description) LIKE LOWER(:desc)')
            ->andWhere('p.format LIKE :format OR p.format IS NULL')
            ->andWhere('p.color LIKE :color OR p.color IS NULL')
            ->andWhere('p.width LIKE :width OR p.width IS NULL')
            ->andWhere('p.height LIKE :height OR p.height IS NULL')
            ->setParameter('name', '%'.$name.'%')
            ->setParameter('desc', '%'.$name.'%')
            ->setParameter('format', '%'.$format.'%')
            ->setParameter('color', '%'.$color.'%')
            ->setParameter('width', '%'.$width.'%')
            ->setParameter('height', '%'.$height.'%')
            ->orderBy('p.id', 'DESC')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            16
        );

        return $this->render('HTWPhotoWebBundle:Search:results.html.twig', array('pagination' => $pagination));
    }
}
