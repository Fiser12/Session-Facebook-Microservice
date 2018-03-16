<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Session\Infrastructure\Symfony\HttpAction\Session;

use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;
use Session\Application\Query\Session\JWTDecode;
use Session\Application\Query\Session\JWTDecodeQuery;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class JWTDecodeAction
{
    private $handler;
    private $container;

    public function __construct(JWTDecode $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->container = $container;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->container->getParameter('secret') !== $request->headers->get('token-api')) {
            return new JsonResponse('Secret doesnt exist', 401);
        }

        if (!$jwt = $request->get('jwt')) {
            return new JsonResponse('JWT query not exist', 401);
        }

        try {
            $user = $this->handler->__invoke(
                new JWTDecodeQuery($request->get('jwt'))
            );

            $result = [
                'user' => $user
            ];
            $code = 200;
        } catch (JWTDecodeFailureException $exception) {
            $result = $exception->getMessage();
            $code = 400;
        }

        return new JsonResponse($result, $code);
    }
}
