<?php

namespace spec\Workly\Domain\Model\User;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Workly\Domain\Model\User\Test');
    }
}
