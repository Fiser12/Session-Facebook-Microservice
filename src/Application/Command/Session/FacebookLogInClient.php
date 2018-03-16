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

use Facebook\Facebook;
use Session\Domain\Model\Session\FirstName;
use Session\Domain\Model\Session\FullName;
use Session\Domain\Model\Session\LastName;
use Session\Domain\Model\Session\User;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UsersFollowed;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class FacebookLogInClient
{
    private $repository;
    private $entityManager;
    private $facebook;

    public function __construct(
        UserRepository $repository,
        EntityManager $entityManager,
        Facebook $facebook
    )
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
        $this->facebook = $facebook;
    }

    public function __invoke(FacebookLogInClientCommand $command): void
    {
        $email = new UserEmail($command->email());
        $accessToken = new UserFacebookAccessToken($command->facebookAccessToken());
        $usersFollowed = $this->usersFollowed($accessToken);
        $facebookId = new UserFacebookId($command->facebookId());
        $fullName = new FullName(
            new FirstName($command->firstName()),
            new LastName($command->lastName())
        );
        $userId = new UserId($command->facebookId());
        $user = $this->repository->userOfEmail($email);

        if (null === $user) {
            $user = User::signUp(
                $userId,
                $email
            );
        }

        $user->connectToFacebook(
            $facebookId,
            $accessToken,
            $usersFollowed,
            $fullName
        );

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function usersFollowed(UserFacebookAccessToken $accessToken): UsersFollowed
    {
        $usersFollowedReturned = new UsersFollowed();

        foreach ($this->followUsersFromApi($accessToken) as $userFollowed) {
            $user = $this->repository->userOfId(new UserId($userFollowed));
            if ($user === null) {
                continue;
            }
            $usersFollowedReturned->add($user);
        }

        return $usersFollowedReturned;
    }

    private function followUsersFromApi(UserFacebookAccessToken $accessToken): array
    {
        $this->facebook->setDefaultAccessToken($accessToken->token());
        $response = $this->facebook->get('/me/friends');
        $usersFollowersApi = $response->getDecodedBody();

        $usersFollowers = [];

        if (!isset($usersFollowersApi["data"])) {
            return [];
        }

        foreach ($usersFollowersApi["data"] as $followUser) {
            if (isset($followUser["id"])) {
                $usersFollowers[] = $followUser["id"];
            }
        }

        return $usersFollowers;
    }
}

