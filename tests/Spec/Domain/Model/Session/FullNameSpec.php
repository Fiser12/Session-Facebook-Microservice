<?php

namespace Spec\Session\Domain\Model\Session;

use Session\Domain\Model\Session\FirstName;
use Session\Domain\Model\Session\FullName;
use PhpSpec\ObjectBehavior;
use Session\Domain\Model\Session\LastName;

class FullNameSpec extends ObjectBehavior
{
    function let(FirstName $firstName, LastName $lastName)
    {
        $this->beConstructedWith($firstName, $lastName);
    }

    function it_is_type()
    {
        $this->shouldHaveType(FullName::class);
    }

    function it_is_initializable(FirstName $firstName, LastName $lastName)
    {
        $this->firstName()->shouldBe($firstName);
        $this->lastName()->shouldBe($lastName);
    }
}
