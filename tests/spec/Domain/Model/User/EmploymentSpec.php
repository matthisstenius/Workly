<?php

namespace spec\Workly\Domain\Model\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\TimePeriod;
use Workly\Domain\Model\User\Events\EmploymentWasAdded;
use Workly\Domain\Model\User\Position;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\UuidIdentity;

class EmploymentSpec extends ObjectBehavior
{
    function let(UuidIdentity $id, User $user, Company $company, Position $position, TimePeriod $timePeriod)
    {
        $this->beConstructedThrough('add', [$id, $user, $company, $position, $timePeriod]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Workly\Domain\Model\User\Employment');
    }

    function it_should_accept_questions()
    {
        $this->acceptQuestions();
        $this->isAcceptingQuestions()->shouldReturn(true);
    }

    function it_should_deny_questions()
    {
        $this->denyQuestions();
        $this->isAcceptingQuestions()->shouldReturn(false);
    }

    function it_should_raise_an_education_was_added_event()
    {
        $this->releaseEvents()[0]->shouldHaveType('Workly\Domain\Model\User\Events\EmploymentWasAdded');
    }
}
