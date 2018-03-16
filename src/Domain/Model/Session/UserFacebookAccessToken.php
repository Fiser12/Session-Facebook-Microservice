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

namespace Session\Domain\Model\Session;

class UserFacebookAccessToken
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function token()
    {
        return $this->token;
    }
    public function equals(UserFacebookAccessToken $aToken)
    {
        return $this->token === $aToken->token();
    }

    public function __toString()
    {
        return $this->token();
    }
}
