<?php

namespace Spec\Session\Application\Query\Session;

use Session\Application\Query\Session\JWTDecodeQuery;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JWTDecodeQuerySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('jwt');
    }

    function it_is_type()
    {
        $this->shouldHaveType(JWTDecodeQuery::class);
    }

    function it_is_initializable()
    {
        $this->jwt()->shouldReturn('jwt');
    }
}
