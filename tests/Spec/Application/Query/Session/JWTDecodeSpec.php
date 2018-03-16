<?php

namespace Spec\Session\Application\Query\Session;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\DefaultEncoder;
use Prophecy\Argument;
use Session\Application\Query\Session\JWTDecode;
use PhpSpec\ObjectBehavior;
use Session\Application\Query\Session\JWTDecodeQuery;

class JWTDecodeSpec extends ObjectBehavior
{
    function let(DefaultEncoder $encoder)
    {
        $this->beConstructedWith($encoder);
    }

    function it_is_type()
    {
        $this->shouldHaveType(JWTDecode::class);
    }

    function it_is_initializable(DefaultEncoder $encoder, JWTDecodeQuery $command)
    {
        $command->jwt()->willReturn(
            'eyJhbGciOiJSUzI1NiJ9.eyJpZCI6IjE5NjgyNTM2NDAwNTk4NTIiLCJlbWFpbCI6ImZpc2VyMTJAaWNsb3VkLmNvbSIsImZpcnN0X25hbWUiOiJSdWJcdTAwZTluIiwibGFzdF9uYW1lIjoiR2FyY1x1MDBlZGEiLCJpYXQiOjE1MTgyNzU5NTIsImV4cCI6MTUxODI3OTU1Mn0.AMBTvGICWl5nw7ztgOaZbQHxOGK1JYYAD3g8I5Ot6X3192exvvaHbRw87-TkXD3u9qkWk_Nd2g9nvV5GEkRdwIyRx_jbfahvLspSorVt8K9V-YUm8xJt3ThkSQecDmd68DAmzfT_nxc02x-QijaaVu3z5GEGN8xAlDw3E_6ZohL13yKJaZKSbxg_F0LrStvvo31G4rMHuzIW0KFzYu3aKCGugucd3d9IJlUhSXegHj52uhDBuHlSKL9XvBuwEKnKM3g9lzjW55olV8Ir7xapBFhM5WD8n0zeX458IEb5tN-UF2T6VJCcUne9sJp3ZalUIBTHrvAO2rOLtwkQVPVAp05q61oZ8Z-wAnKs3Ej6HFIoKIhDUPAD1z1S7j25MfQe7kOLwMNlJN9zjwzpP69_RNYKTJMRosBgjSKNuDRcHuwjW4hdvSfd0SOMPuZB352I77z9RC2H70c6iQ8zeuF73g3X7Acr4hHS_8MT1XbQVtyld-EU-pf35Poah4J7e7VqUZTGWOZH3x7CciDlEOMG1gU39JcRPSOQK82VEzZC-GkundG1x87Vb_VWmhRjowDXMsFzL4mehvEpsl6s9eM_uL8HB0N175icYxtvsRbBZweD4yxzDIy7xt3YNhqojoyQ9ezryS_82FYxjonlasfX-bddHf-vWcEzv6eFQvdQiZk'
        );

        $data = ['user-data'];

        $encoder->decode(Argument::type("string"))
            ->willReturn($data);
        $this->__invoke($command)->shouldReturn($data);
    }

}
