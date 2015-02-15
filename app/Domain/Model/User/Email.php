<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class Email implements ValueObject
{
    /**
     * @ORM\Column(type="string")
     */
    private $email;

    public function __construct($email)
    {
        Assertion::email($email);

        $this->email = $email;
    }

    /**
     * Get string representation of email
     *
     * @return string
     */
    public function toString()
    {
        return $this->email;
    }

    /**
     * Get string representation of email
     *
     * @return string
     */
    public function __toString()
    {
        return $this->email;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->email === $other->email;
    }
}