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

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class FacebookVerifyAccessTokenQuery
{
    private $accessToken;
    private $facebookId;

    public function __construct(string $accessToken, string $facebookId)
    {
        $this->accessToken = $accessToken;
        $this->facebookId = $facebookId;
    }

    public function accessToken(): string
    {
        return $this->accessToken;
    }

    public function facebookId(): string
    {
        return $this->facebookId;
    }
}
