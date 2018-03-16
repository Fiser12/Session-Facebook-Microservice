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

namespace Session\Application\DataTransformer\Session;

use BenGorUser\User\Application\DataTransformer\UserDTODataTransformer;
use Session\Domain\Model\Session\User;

/**
 * @author Ruben Garcia <ruben.garcia@opendeusto.es>
 */
class UserDTODataTransform extends UserDTODataTransformer
{
    /**
     * The domain user.
     *
     * @var User
     */
    protected $user;

    public function write($aUser)
    {
        if (!$aUser instanceof User) {
            throw new \InvalidArgumentException(sprintf('Expected instance of %s', User::class));
        }
        $this->user = $aUser;
    }

    public function read(): array
    {
        $readParent = parent::read();

        return array_merge($readParent, [
            'facebook_id' => $this->user->facebookId()->id(),
            'first_name' => $this->user->fullName()->firstName()->firstName(),
            'last_name' => $this->user->fullName()->lastName()->lastName(),
            'public_id' => $this->user->publicId()->id(),
        ]);
    }
}
