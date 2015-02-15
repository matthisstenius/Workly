<?php namespace Workly\Domain\Model\Company;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class Description implements ValueObject
{

    /**
     * @ORM\Column(type="string")
     */
    private $description;

    public function __construct($description)
    {
        Assertion::string($description);

        $this->description = $description;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->description == $other->description;
    }

    /**
     * Get string representation of Description
     *
     * @return string
     */
    public function __toString()
    {
        return $this->description;
    }
}