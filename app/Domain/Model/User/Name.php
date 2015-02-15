<?php namespace Workly\Domain\Model\User;

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
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $surname;

    public function __construct($firstName, $surname)
    {
        Assertion::string($firstName);
        Assertion::string($surname);

        $this->firstName = $firstName;
        $this->surname = $surname;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->toString() == $other->toString();
    }

    /**
     * Get String representation of Name
     *
     * @return string
     */
    public function toString()
    {
        return $this->firstName . ' ' . $this->surname;
    }

    /**
     * Get string representation of Name
     *
     * @return string
     */
    public function __toString()
    {
        return $this->firstName . ' ' . $this->surname;
    }

    /**
     * Get first name
     *
     * @return string
     */
    public function firstName()
    {
        return $this->firstName;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function surname()
    {
        return $this->surname;
    }
}