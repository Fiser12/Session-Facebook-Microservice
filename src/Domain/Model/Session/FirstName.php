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

use LIN3S\SharedKernel\Exception\Exception;

class FirstName
{
    private $firstName;

    public function __construct(string $fistName)
    {
        try {
            $this->saveFirstName($fistName);
        } catch (Exception $e) {

        }
    }

    public function firstName() : string
    {
        return $this->firstName;
    }

    protected function saveFirstName(string $firstName): void
    {
        if(empty($firstName)){
            throw new Exception("First name is empty");
        }
        $this->firstName = $firstName;
    }

}