<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class Position implements ValueObject
{

    /**
     * @ORM\Column(type="string")
     */
    private $position;

    public function __construct($position)
    {
        Assertion::string($position);

        $this->position = $position;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this == $other;
    }

    /**
     * Get string representation of Position
     * @return string
     */
    public function __toString()
    {
        return $this->position;
    }
}