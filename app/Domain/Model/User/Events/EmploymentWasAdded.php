<?php namespace Workly\Domain\Model\User\Events;

use Workly\Domain\Model\User\Employment;

class EmploymentWasAdded
{
    /**
     * @var Employment
     */
    public $employment;

    public function __construct(Employment $employment)
    {
        $this->employment = $employment;
    }
} 