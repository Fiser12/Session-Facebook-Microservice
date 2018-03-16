<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Session\Domain\Model\Session;


class FullName
{
    private $firstName;
    private $lastName;

    public function __construct(FirstName $firstName, LastName $lastName)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function firstName() : FirstName
    {
        return $this->firstName;
    }

    public function lastName() : LastName
    {
        return $this->lastName;
    }
}