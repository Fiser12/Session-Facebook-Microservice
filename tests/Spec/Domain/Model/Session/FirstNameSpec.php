<?php

namespace Spec\Session\Domain\Model\Session;

use Session\Domain\Model\Session\FirstName;
use PhpSpec\ObjectBehavior;

class FirstNameSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('Pepe');
    }

    function it_is_type()
    {
        $this->shouldHaveType(FirstName::class);
    }

    function it_is_initializable()
    {
        $this->firstName()->shouldBe('Pepe');
    }
}
