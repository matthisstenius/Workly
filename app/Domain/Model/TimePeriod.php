<?php namespace Workly\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class TimePeriod implements ValueObject
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    public function __construct($start, $end)
    {
        $this->assertValidDateFormat($start);
        $this->assertValidDateFormat($end);

        $this->assertRange($start, $end);

        $this->start = Carbon::createFromFormat('Y-m-d H:i:s', $start);
        $this->end = Carbon::createFromFormat('Y-m-d H:i:s', $end);
    }

    /**
     * Get start
     *
     * @return string
     */
    public function start()
    {
        return $this->start->toDateTimeString();
    }

    /**
     * Get end
     *
     * @return string
     */
    public function end()
    {
        return $this->end->toDateTimeString();
    }

    /**
     * Check equality against other Period
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->start->toDateTimeString() === $other->start() &&
            $this->end->toDateTimeString() === $other->end();
    }

    /**
     * Get string representation ValueObject
     *
     * @return string
     */
    public function __toString()
    {
        return $this->start . '-' . $this->end;
    }

    /**
     * Assert valid dateTime
     *
     * @param string $date
     */
    private function assertValidDateFormat($date)
    {
        try {
            Carbon::createFromFormat('Y-m-d H:i:s', $date);
        } catch (Exception $e) {
            throw new InvalidArgumentException("$date could not be parsed as date time! Expecting format Y-m-d H:i:s");
        }
    }

    /**
     * Assert start date is not greater then end date
     *
     * @param string $start
     * @param string $end
     */
    private function assertRange($start, $end)
    {
        if (Carbon::createFromFormat('Y-m-d H:i:s', $start) > Carbon::createFromFormat('Y-m-d H:i:s', $end)) {
            throw new InvalidArgumentException('Start date can not be greater then end date');
        }
    }
}