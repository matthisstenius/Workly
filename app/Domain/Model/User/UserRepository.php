<?php namespace Workly\Domain\Model\User;

Interface UserRepository
{
    /**
     * Get next identity
     *
     * @return Identity
     */
    public function nextIdentity();
} 