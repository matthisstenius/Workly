<?php

namespace spec\Workly\Domain\Model\Company;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\Company\Name;
use Workly\Domain\Model\Quality\Quality;
use Workly\Domain\Model\Recommendation\Recommendation;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\UuidIdentity;

class CompanySpec extends ObjectBehavior
{
    function let(UuidIdentity $id, Name $name)
    {
        $this->beConstructedThrough('register', [$id, $name]);
        $this->shouldHaveType('Workly\Domain\Model\Company\Company');
    }

    function it_should_be_able_to_add_qualities(Quality $quality)
    {
        $this->addQuality($quality);

        $this->qualities()->shouldHaveCount(1);
    }

    function it_should_not_allow_same_quality_to_be_added_twice(Quality $quality)
    {
        $quality->name()->willReturn('Test quality');
        $this->addQuality($quality);

        $this->shouldThrow('Workly\Domain\Exceptions\DuplicateException')->during('addQuality', [$quality]);
    }

    function it_should_be_able_to_get_recommended(Recommendation $recommendation, User $user)
    {
        $recommendation->by()->willReturn($user);
        $this->addEmployee($user);
        $this->recommend($recommendation);
    }

    function it_should_be_able_to_get_recommended_against(Recommendation $recommendation, User $user)
    {
        $recommendation->by()->willReturn($user);
        $this->addEmployee($user);
        $this->recommendAgainst($recommendation);
    }

    function it_should_not_be_able_to_get_recommended_by_a_user_with_no_company_history(Recommendation $recommendation, User $user)
    {
        $user->id()->willReturn(1);

        $recommendation->by()->willReturn($user);
        $this->shouldThrow('Exception')->during('recommend', [$recommendation]);
    }

    function it_should_not_be_able_to_get_recommended_against_by_a_user_with_no_company_history(Recommendation $recommendation, User $user)
    {
        $user->id()->willReturn(1);

        $recommendation->by()->willReturn($user);
        $this->shouldThrow('Exception')->during('recommendAgainst', [$recommendation]);
    }
}
