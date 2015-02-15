<?php namespace Workly\Domain\Model;

use Doctrine\ORM\Mapping as ORM;
use Rhumsaa\Uuid\Uuid;
use Workly\Domain\Contracts\Identity;

/**
 * @ORM\Embeddable
 */
class UuidIdentity implements Identity
{
    /**
     * @ORM\Column(type="string")
     */
    private $id;

    public function __construct(Uuid $id)
    {
        $this->id = $id;
    }

    /**
     * Generate new Identity
     *
     * @return Identity
     */
    public static function generate()
    {
        return new self(Uuid::uuid4());
    }

    /**
     * Check equality with other ValueObject
     *
     * @param Identity $other
     * @return bool
     */
    public function equals(Identity $other)
    {
        return $this->id == $other->id;
    }

    /**
     * Create Identity from string
     *
     * @param $string
     * @return Identity
     */
    public static function fromString($string)
    {
        return new static(Uuid::fromString($string));
    }

    /**
     * Get string representation Identity
     *
     * @return string
     */
    public function toString()
    {
        return $this->id->toString();
    }

    /**
     * Get string representation Identity
     *
     * @return string
     */
    public function __toString()
    {
        return $this->id->toString();
    }
}