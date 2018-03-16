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

namespace Session\Application\Query\Session;

use Facebook\Facebook;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class FacebookVerifyAccessToken
{
    private $facebook;

    public function __construct(Facebook $facebook)
    {
        $this->facebook = $facebook;
    }

    public function __invoke(FacebookVerifyAccessTokenQuery $query): array
    {
        $this->facebook->setDefaultAccessToken($query->accessToken());

        $longAccessToken = $this->facebook->getOAuth2Client()->getLongLivedAccessToken($query->accessToken());
        $result = ['access_token' => $longAccessToken->getValue()];

        $this->facebook->setDefaultAccessToken($longAccessToken);

        $response = $this->facebook->get('/me?fields=id,first_name,last_name,email');
        $result = array_merge($response->getDecodedBody(), $result);

        return $result;
    }
}

