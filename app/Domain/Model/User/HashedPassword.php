<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Workly\Domain\Contracts\ValueObject;

/**
 * @ORM\Embeddable
 */
class HashedPassword implements ValueObject
{
    /**
     * @ORM\Column(type="string")
     */
    private $hashedPassword;

    public function __construct($hashedPassword)
    {
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * Get string representation of HashedPassword
     *
     * @return string
     */
    public function __toString()
    {
        return $this->hashedPassword;
    }

    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other)
    {
        return $this->hashedPassword === $other->hashedPassword;
    }
}