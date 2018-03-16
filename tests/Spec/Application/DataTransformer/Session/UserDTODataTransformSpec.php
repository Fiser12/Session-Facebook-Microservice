<?php

namespace Spec\Session\Application\DataTransformer\Session;

use PhpSpec\ObjectBehavior;
use Session\Application\DataTransformer\Session\UserDTODataTransform;

class UserDTODataTransformSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(UserDTODataTransform::class);
    }
}
