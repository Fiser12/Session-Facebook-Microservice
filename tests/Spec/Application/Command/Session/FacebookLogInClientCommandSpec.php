<?php

namespace Spec\Session\Application\Command\Session;

use Session\Application\Command\Session\FacebookLogInClientCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FacebookLogInClientCommandSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            'facebookId',
            'accessToken',
            'email',
            'firstName',
            'lastName',
            []
        );
    }

    function it_is_type()
    {
        $this->shouldHaveType(FacebookLogInClientCommand::class);
    }

    function it_is_initializable()
    {
        $this->facebookId()->shouldReturn('facebookId');
        $this->facebookAccessToken()->shouldReturn('accessToken');
        $this->email()->shouldReturn('email');
        $this->firstName()->shouldReturn('firstName');
        $this->lastName()->shouldReturn('lastName');
        $this->usersFollowers()->shouldReturn([]);

    }
}
