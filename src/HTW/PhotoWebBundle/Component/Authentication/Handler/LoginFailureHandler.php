<?php

namespace HTW\PhotoWebBundle\Component\Authentication\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authentication\DefaultAuthenticationFailureHandler;
use Symfony\Component\Security\Http\HttpUtils;


class LoginFailureHandler extends DefaultAuthenticationFailureHandler
{
	
	public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
            {
                        if ($request->isXmlHttpRequest()) {
                                $json = array(
                                        'has_error'        => true,
                                        'error'     => $exception->getMessage()
                                );

                                return new Response(json_encode($json));
                        }

                        return parent::onAuthenticationFailure($request, $exception);
            }
}