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

use Symfony\Component\Validator\Constraints as Assert;

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
    public function contactAction(Request $request) { 
        
        $form = $this->createFormBuilder()
            ->add('name', 'text', array(
                'label' => 'Ihr Name',
                'constraints' => array(
                    new Assert\NotBlank(),
                )
            ))
            ->add('email', 'email', array(
                'label' => 'Ihre E-Mail Adresse',
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email(array(
                        'message' => 'Die Adresse "{{ value }}" ist keine valide E-Mail Adresse.',
                        'checkMX' => false,
                    ))
                )
            ))
            ->add('message', 'textarea', array(
                'label' => 'Ihre Nachricht an uns',
                'constraints' => array(
                    new Assert\NotBlank()
                )
            ))
            ->add('send', 'submit', array('label' => 'Nachricht abschicken'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $message = \Swift_Message::newInstance()
                ->setSubject('Neue Nachricht von '. $data['name'] .' über Fotoweb!')
                ->setFrom(array('photoweb@delphinus.uberspace.de' => 'FotoWeb'))
                ->setReplyTo(array($data['email'] => $data['name']))
                ->setTo('patrick.jean.bauer@googlemail.com')
                ->setBody($data['message']);
            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add(
                'success',
                'Vielen Dank, Ihre Nachricht wurde entgegen genommen.'
            );

            return $this->redirect($this->generateUrl('htw_photoweb_staticpage_contact'));
        }

        return array('form' => $form->createView()); 
    }
}
