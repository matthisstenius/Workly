<?php namespace Workly\Domain\Model\User\Events;

use Workly\Domain\Model\User\Education;

class EducationWasAdded {
    /**
     * @var Education
     */
    public $education;

    public function __construct(Education $education)
    {

        $this->education = $education;
    }
}