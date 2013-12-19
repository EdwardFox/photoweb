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
     * @Route("/")
     */
    public function searchAction()
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
        }

        $form = $this->createFormBuilder($defaultValues)
            ->setAction($this->generateUrl('htw_photoweb_search_form'))
            ->add('name', 'text')
            ->add('search', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            return $this->redirect($this->generateUrl('htw_photoweb_search_results', array('name' => $data['name'])));
        }

        return $this->render('HTWPhotoWebBundle:Search:form.html.twig', array('form' => $form->createView()));  
    }

    /**
     * @Route("/results")
     */
    public function resultsAction(Request $request)
    {
        $name = $request->query->get('name');

        $repository = $this->getDoctrine()
            ->getRepository('HTWPhotoWebBundle:Photo');

        $query = $repository->createQueryBuilder('p')
            ->where('LOWER(p.name) LIKE LOWER(:name)')
            ->setParameter('name', '%'.$name.'%')
            ->getQuery();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $this->get('request')->query->get('page', 1),
            28
        );

        return $this->render('HTWPhotoWebBundle:Search:results.html.twig', array('pagination' => $pagination));
    }
}
