<?php namespace Workly\Domain\Model\User;

interface EmailSpecification
{
    /**
     * Check if Email is satisfied by specification
     *
     * @param Email $email
     * @return bool
     */
    public function isSatisfiedBy(Email $email);
} 