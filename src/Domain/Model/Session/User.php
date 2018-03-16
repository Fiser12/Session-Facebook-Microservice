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

use BenGorUser\User\Domain\Model\Event\UserLoggedIn;
use BenGorUser\User\Domain\Model\User as BaseUser;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserRole;

class User extends BaseUser
{
    private const ROLE_CLIENT = 'ROLE_CLIENT';

    private $facebookId;
    private $usersFollowed;
    private $facebookAccessToken;
    private $fullName;
    private $publicId;

    protected function __construct(
        UserId $anId,
        UserEmail $anEmail,
        ?FullName $fullName = null,
        ?UserPassword $aPassword = null,
        ?UserFacebookId $facebookId = null,
        ?UserFacebookAccessToken $facebookAccessToken = null,
        ?UsersFollowed $usersFollowed = null
    )
    {
        $userRoles = array_map(function ($role) {
            return new UserRole($role);
        }, self::availableRoles());

        parent::__construct($anId, $anEmail, $userRoles, $aPassword);

        $this->usersFollowed = $usersFollowed;
        $this->facebookAccessToken = $facebookAccessToken;
        $this->fullName = $fullName;
        $this->facebookId = $facebookId;
        $this->facebookAccessToken = $facebookAccessToken;
        $this->publicId = PublicId::generate();

        $this->publish(
            new UserLoggedIn(
                $this->id,
                $this->email
            )
        );
    }


    public function facebookId(): ?UserFacebookId
    {
        return $this->facebookId;
    }

    public function usersFollowed(): ?UsersFollowed
    {
        return $this->usersFollowed === null ? null : new UsersFollowed($this->usersFollowed->getValues());

    }

    public function facebookAccessToken(): ?UserFacebookAccessToken
    {
        return $this->facebookAccessToken;
    }

    public function fullName(): ?FullName
    {
        return $this->fullName;
    }

    public function publicId(): PublicId
    {
        return $this->publicId;
    }

    public function connectToFacebook(
        UserFacebookId $facebookId,
        UserFacebookAccessToken $accessToken,
        UsersFollowed $usersFollowed,
        FullName $fullName
    ): void
    {
        $this->facebookId = $facebookId;
        $this->lastLogin = new \DateTimeImmutable();
        $this->facebookAccessToken = $accessToken;
        $this->usersFollowed = $usersFollowed;
        $this->fullName = $fullName;

        $this->publish(
            new UserRegisteredWithFacebook(
                $this->id,
                $fullName,
                $facebookId,
                $accessToken,
                $this->email
            )
        );
    }

    public static function signUp(
        UserId $id,
        UserEmail $email,
        ?UserPassword $password = null,
        array $userRoles = null
    )
    {
        return new self(
            $id,
            $email,
            null,
            null,
            null,
            null,
            null
        );
    }

    public static function availableRoles(): array
    {
        return [
            self::ROLE_CLIENT,
        ];
    }
}

