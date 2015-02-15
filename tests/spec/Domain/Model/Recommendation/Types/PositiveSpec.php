<?php

namespace spec\Workly\Domain\Model\Recommendation\Types;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PositiveSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Workly\Domain\Model\Recommendation\Types\RecommendationType');
        $this->shouldHaveType('Workly\Domain\Model\Recommendation\Types\Positive');
    }
}
