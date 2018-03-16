<?php

namespace Spec\Session\Domain\Model\Session;

use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use Session\Domain\Model\Session\FullName;
use Session\Domain\Model\Session\User;
use PhpSpec\ObjectBehavior;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UsersFollowed;

class UserSpec extends ObjectBehavior
{
    function let(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $accessToken,
        UsersFollowed $usersFollowed
    )
    {
        $this->beConstructedSignUpWithFacebook(
            new UserId(),
            $fullName,
            $facebookId,
            new UserEmail('email@email.com'),
            $accessToken,
            $usersFollowed
        );
        $usersFollowed->getValues()->willReturn([]);
    }

    function it_is_type()
    {
        $this->shouldHaveType(User::class);
    }

    function it_is_initializable(
        FullName $fullName,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $accessToken
    )
    {
        $this->fullName()->shouldReturn($fullName);
        $this->facebookId()->shouldReturn($facebookId);
        $this->facebookAccessToken()->shouldReturn($accessToken);
        $this->usersFollowed()->shouldReturnAnInstanceOf(UsersFollowed::class);
    }
}
