<?php

namespace Spec\Session\Application\Command\Session;

use BenGorUser\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use Session\Application\Command\Session\FacebookLogInClientCommand;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Session\Application\Command\Session\FacebookLogInClient;
use Session\Domain\Model\Session\User;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UsersFollowed;
use BenGorUser\User\Domain\Model\UserEmail;

class FacebookLogInClientSpec extends ObjectBehavior
{
    function let(UserRepository $repository, EntityManager $entityManager)
    {
        $this->beConstructedWith($repository, $entityManager);
    }
    function it_is_type()
    {
        $this->shouldHaveType(FacebookLogInClient::class);
    }

    function it_is_invoke_and_exists_user(
        UserRepository $repository,
        EntityManager $entityManager,
        FacebookLogInClientCommand $command,
        User $user
    )
    {
        $command->facebookId()->willReturn('facebookId');
        $command->facebookAccessToken()->willReturn('accessToken');
        $command->email()->willReturn('email@icloud.com');
        $command->firstName()->willReturn('firstName');
        $command->lastName()->willReturn('lastName');
        $command->usersFollowers()->willReturn([]);

        $repository->userOfEmail(Argument::type(UserEmail::class))->willReturn($user);

        $user->connectToFacebook(
            Argument::type(UserFacebookId::class),
            Argument::type(UserFacebookAccessToken::class)
        )->shouldBeCalled();

        $user->updateUsersFollowed(Argument::type(UsersFollowed::class))->shouldBeCalled();
        $entityManager->persist($user)->shouldBeCalled();
        $entityManager->flush()->shouldBeCalled();
        $this->__invoke($command);
    }
}
