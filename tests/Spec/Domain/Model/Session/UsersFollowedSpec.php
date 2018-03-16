<?php

namespace Spec\Session\Domain\Model\Session;

use Session\Domain\Model\Session\UsersFollowed;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UsersFollowedSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UsersFollowed::class);
    }
}
