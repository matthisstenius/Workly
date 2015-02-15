<?php namespace Workly\Domain\Model;

use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

class Skill implements ValueObject
{
    /**
     * @var string
     */
    private $skill;

    public function __construct($skill)
    {
        Assertion::string($skill);

        $this->skill = $skill;
    }

    public function equals(ValueObject $other)
    {
        return $this->skill == $other->skill;
    }

    /**
     * Get string representation of Skill
     *
     * @return string
     */
    public function toString()
    {
        return $this->skill;
    }

    /**
     * Get string representation of Skill
     *
     * @return string
     */
    public function __toString()
    {
        return $this->skill;
    }
}