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

use LIN3S\SharedKernel\Exception\Exception;
use Session\Application\Query\Session\GetUserById;
use Session\Application\Query\Session\GetUserByIdQuery;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class GetUserByIdAction
{
    private $handler;
    private $container;

    public function __construct(GetUserById $handler, ContainerInterface $container)
    {
        $this->handler = $handler;
        $this->container = $container;
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->container->getParameter('secret') !== $request->headers->get('token-api')) {
            return new JsonResponse('Secret doesnt exist', 401);
        }

        if (!$id = $request->get('id')) {
            return new JsonResponse('Id query not exist', 401);
        }

        try {
            $user = $this->handler->__invoke(
                new GetUserByIdQuery($request->get('id'))
            );
            $result = [
                'user' => $user
            ];
            $code = 200;
        }
        catch(Exception $exception) {
            $result = [
                'error' => $exception->getMessage()
            ];
            $code = 404;
        }


        return new JsonResponse($result, $code);
    }
}
