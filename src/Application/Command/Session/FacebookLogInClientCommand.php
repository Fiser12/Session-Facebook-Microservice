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

namespace Session\Application\Command\Session;

class FacebookLogInClientCommand
{
    private $facebookId;
    private $firstName;
    private $lastName;
    private $email;
    private $facebookAccessToken;

    public function __construct(
        string $facebookId,
        string $facebookAccessToken,
        string $email,
        string $firstName,
        ?string $lastName
    )
    {
        $this->facebookId = $facebookId;
        $this->email = $email;
        $this->facebookAccessToken = $facebookAccessToken;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function facebookId() : string
    {
        return $this->facebookId;
    }

    public function email() : string
    {
        return $this->email;
    }

    public function facebookAccessToken(): string
    {
        return $this->facebookAccessToken;
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    public function lastName() : ?string
    {
        return $this->lastName;
    }
}
