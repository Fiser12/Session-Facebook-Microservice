<?php

namespace Session\Domain\Model\Session;

use BenGorUser\User\Domain\Model\UserRepository as BaseUserRepository;

interface UserRepository extends BaseUserRepository
{
    public function userOfPublicId(PublicId $publicId);
    
    public function userOfFacebookId(UserFacebookId $facebookId);
}