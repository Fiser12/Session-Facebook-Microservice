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

use BenGorUser\User\Domain\Model\UserId;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder;
use Session\Domain\Model\Session\User;
use Session\Domain\Model\Session\UserRepository;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class GetJwtOfUser
{
    private $encoder;
    private $userRepository;

    public function __construct(DefaultEncoder $encoder, UserRepository $userRepository)
    {
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetJwtOfUserQuery $query): string
    {
        $user = $this->userRepository->userOfId(new UserId($query->id()));
        /** @var User $user */
        $userValues = [
            'id' => $user->publicId()->id(),
            'email' => $user->email()->email(),
            'first_name' => $user->fullName()->firstName()->firstName(),
            'last_name' => $user->fullName()->lastName()->lastName(),
        ];

        return $this->encoder->encode($userValues);

    }
}

