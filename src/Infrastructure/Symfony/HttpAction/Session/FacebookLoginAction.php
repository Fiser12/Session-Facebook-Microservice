<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Session\Infrastructure\Symfony\HttpAction\Session;

use LIN3S\SharedKernel\Application\CommandBus;
use Session\Application\Command\Session\FacebookLogInClientCommand;
use Session\Application\Query\Session\FacebookVerifyAccessToken;
use Session\Application\Query\Session\FacebookVerifyAccessTokenQuery;
use Session\Application\Query\Session\GetJwtOfUser;
use Session\Application\Query\Session\GetJwtOfUserQuery;
use Session\Application\Query\Session\JWTEncodeQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class FacebookLoginAction
{
    private $facebookVerifyAccessToken;
    private $commandBus;
    private $JWTEncode;

    public function __construct(
        FacebookVerifyAccessToken $facebookVerifyAccessToken,
        CommandBus $commandBus,
        GetJwtOfUser $JWTEncode
    )
    {
        $this->facebookVerifyAccessToken = $facebookVerifyAccessToken;
        $this->commandBus = $commandBus;
        $this->JWTEncode = $JWTEncode;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $accessToken = json_decode($request->getContent())->accessToken;
        $facebookId = json_decode($request->getContent())->facebookId;

        $user = $this->facebookVerifyAccessToken->__invoke(
            new FacebookVerifyAccessTokenQuery(
                $accessToken,
                $facebookId
            )
        );

        if (!$user) {
            return new JsonResponse('Is not valid facebook access token', 400);
        }

        $this->commandBus->handle(
            new FacebookLogInClientCommand(
                $user['id'],
                $user['access_token'],
                $user['email'],
                $user['first_name'],
                $user['last_name']
            )
        );

        $jwt = $this->JWTEncode->__invoke(new GetJwtOfUserQuery($user['id']));

        return new JsonResponse(['jwt' => $jwt]);
    }
}
