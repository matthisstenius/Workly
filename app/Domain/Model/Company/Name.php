<?php namespace Workly\Domain\Model\Company;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class Name implements ValueObject
{
    /**
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct($name)
    {
        Assertion::string($name);

        $this->name = $name;
    }

    /**
     * Get string representation of Name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->name == $other->name;
    }
}