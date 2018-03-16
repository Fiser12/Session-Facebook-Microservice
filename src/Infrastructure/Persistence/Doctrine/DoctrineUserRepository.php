<?php

namespace Session\Infrastructure\Persistence\Doctrine;

use BenGorUser\DoctrineORMBridge\Infrastructure\Persistence\DoctrineORMUserRepository;
use Session\Domain\Model\Session\PublicId;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UserRepository;

class DoctrineUserRepository extends DoctrineORMUserRepository implements UserRepository
{
    public function userOfPublicId(PublicId $publicId)
    {
        return $this->findOneBy(['publicId.id' => $publicId->id()]);
    }

    public function userOfFacebookId(UserFacebookId $facebookId)
    {
        return $this->findOneBy(['facebookId.id' => $facebookId->id()]);
    }

}