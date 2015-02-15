<?php

namespace spec\Workly\Domain\Model\Quality;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\UuidIdentity;

class QualitySpec extends ObjectBehavior
{
    function let(UuidIdentity $id)
    {
        $this->beConstructedThrough('add', [$id, 'Test quality']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Workly\Domain\Model\Quality\Quality');
    }

    function it_should_be_able_to_get_endorsed_by_a_user(User $user)
    {
        $this->endorse($user);

        $this->endorsedBy()->shouldHaveCount(1);
    }

    function it_should_not_endorse_if_already_endoresed_by_same_user(User $user)
    {
        $this->endorse($user);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('endorse', [$user]);
    }
}
