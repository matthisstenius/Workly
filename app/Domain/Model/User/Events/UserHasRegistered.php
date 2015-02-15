<?php namespace Workly\Domain\Model\User\Events;

use Workly\Domain\Model\User\User;

class UserHasRegistered {
    /**
     * @var User
     */
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
} 