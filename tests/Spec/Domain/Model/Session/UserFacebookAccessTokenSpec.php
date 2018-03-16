<?php

namespace Spec\Session\Domain\Model\Session;

use Session\Domain\Model\Session\UserFacebookAccessToken;
use PhpSpec\ObjectBehavior;

class UserFacebookAccessTokenSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Token');
    }

    function it_is_type()
    {
        $this->shouldHaveType(UserFacebookAccessToken::class);
    }

    function it_is_initializable()
    {
        $this->token()->shouldBe('Token');
    }
}
