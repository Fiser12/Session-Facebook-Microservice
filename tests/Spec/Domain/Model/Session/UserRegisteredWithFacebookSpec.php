<?php

namespace Spec\Session\Domain\Model\Session;

use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Session\Domain\Model\Session\FullName;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UserRegisteredWithFacebook;
use PhpSpec\ObjectBehavior;

class UserRegisteredWithFacebookSpec extends ObjectBehavior
{
    function let(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $facebookAccessToken
    )
    {
        $this->beConstructedWith(
            new UserId(),
            $fullName,
            $facebookId,
            $facebookAccessToken,
            new UserEmail('email@icloud.com')
        );
    }

    function it_is_type()
    {
        $this->shouldHaveType(UserRegisteredWithFacebook::class);
    }

    function it_is_initializable(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $facebookAccessToken
    )
    {
        $this->id()->shouldBeObject(UserId::class);
        $this->fullName()->shouldBe($fullName);
        $this->facebookId()->shouldBe($facebookId);
        $this->facebookAccessToken()->shouldBe($facebookAccessToken);
        $this->email()->shouldBeObject(UserEmail::class);
    }
}
