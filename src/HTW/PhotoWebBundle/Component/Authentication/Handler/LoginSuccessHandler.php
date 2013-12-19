<?php

namespace HTW\PhotoWebBundle\Component\Authentication\Handler;

use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationSuccessHandler;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

class LoginSuccessHandler extends DefaultAuthenticationSuccessHandler
{
	
	public function onAuthenticationSuccess(Request $request, TokenInterface $token) {
		
		if ($request->isXmlHttpRequest()) {
			$json = array(
				'error' => false,
			);

			return new Response(json_encode($json));
		}

		return parent::onAuthenticationSuccess($request, $token);
	}
}