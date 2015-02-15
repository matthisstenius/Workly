<?php

namespace spec\Workly\Domain\Model\Recommendation;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\Recommendation\Types\Positive;
use Workly\Domain\Model\User\User;

class RecommendationSpec extends ObjectBehavior
{
    function let(Positive $positive, User $user)
    {
        $this->beConstructedThrough('create', [$positive, $user]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Workly\Domain\Model\Recommendation\Recommendation');
    }

    function it_should_be_able_to_have_a_reason()
    {
        $reason = 'Test reason';

        $this->addReason($reason);
    }
}
