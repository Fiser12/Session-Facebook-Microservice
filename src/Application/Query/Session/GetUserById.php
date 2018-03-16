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

use Session\Domain\Model\Session\PublicId;
use Session\Domain\Model\Session\UserRepository;
use LIN3S\SharedKernel\Exception\Exception;
use Session\Domain\Model\Session\User;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class GetUserById
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserByIdQuery $query): array
    {
        $user = $this->userRepository->userOfPublicId(PublicId::generate($query->id()));

        if(null === $user) {
            throw new Exception('User does not exist');
        }

        $friends = [];
        foreach($user->usersFollowed() as $friend) {
            $friends[] = $friend->id()->id();
        }

        $roles = [];
        foreach($user->roles() as $role) {
            $roles[] = $role->role();
        }

        /** @var User $user */
        return [
            'id' => $user->publicId()->id(),
            'email' => $user->email()->email(),
            'friends' => $friends,
            'roles' => $roles,
            'firstName' => $user->fullName()->firstName()->firstName(),
            'lastName' => $user->fullName()->lastName()->lastName()
        ];
    }
}

