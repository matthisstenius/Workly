<?php

namespace spec\Workly\Domain\Model;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Workly\Domain\Model\TimePeriod;

class TimePeriodSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('2015-01-24 13:00:00', '2015-01-25 13:00:00');
    }

    function it_should_only_accept_valid_datetime_strings()
    {
        $start = 'not a date';
        $end = 'not a date';

        $this->beConstructedWith($start, $end);
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', [$start, $end]);
    }

    function it_should_no_accept_a_end_date_that_is_before_a_start_date()
    {
        $start = '2014-01-01 12:00:00';
        $end = '2013-01-01 12:00:00';

        $this->beConstructedWith($start, $end);
        $this->shouldThrow('\InvalidArgumentException')->during('__construct', [$start, $end]);
    }

    function it_should_check_equality_with_other_time_period()
    {
        $this->beConstructedWith('2014-01-01 12:00:00', '2015-01-01 12:00:00');
        $otherTimePeriod = new TimePeriod('2014-01-01 12:00:00', '2015-01-01 12:00:00');

        $this->equals($otherTimePeriod)->shouldReturn(true);
    }
}
