<?php namespace Workly\Domain\Contracts;

interface ValueObject
{
    /**
     * Check equality with other ValueObject
     *
     * @param ValueObject $other
     * @return bool
     */
    public function equals(ValueObject $other);

    /**
     * Get string representation ValueObject
     *
     * @return string
     */
    public function __toString();
} 