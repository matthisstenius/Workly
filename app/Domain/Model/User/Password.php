<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Contracts\ValueObject;

/**
 * @Embeddable
 */
class Password implements ValueObject
{
    /**
     * @var string
     */
    private $password;

    public function __construct($password)
    {
        Assertion::minLength($password, 7);

        $this->password = $password;
    }

    /**
     * Get string representation of Password
     *
     * @return string
     */
    public function __toString()
    {
        return $this->password;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->password === $other->password;
    }
}