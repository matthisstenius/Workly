<?php namespace Workly\Domain\Contracts;

interface Identity
{
    /**
     * Generate new Identity
     *
     * @return Identity
     */
    public static function generate();

    /**
     * Check equality with other ValueObject
     *
     * @param Identity $other
     * @return bool
     */
    public function equals(Identity $other);

    /**
     * Create Identity from string
     *
     * @param $string
     * @return Identity
     */
    public static function fromString($string);

    /**
     * Get string representation Identity
     *
     * @return string
     */
    public function toString();

    /**
     * Get string representation Identity
     *
     * @return string
     */
    public function __toString();

} 