<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Workly\Domain\Contracts\Identity;
use Workly\Domain\EventRecorder;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\TimePeriod;
use Workly\Domain\Model\User\Events\EmploymentWasAdded;

/**
 * @ORM\Entity
 * @ORM\Table(name="employments")
 */
class Employment
{
    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="employments")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="Workly\Domain\Model\Company\Company", inversedBy="employees")
     */
    private $company;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\User\Position")
     */
    private $position;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\TimePeriod")
     */
    private $timePeriod;

    /**
     * @ORM\Column(type="boolean")
     */
    private $acceptingQuestions;

    public function __construct(Identity $id, User $user, Company $company, Position $position, TimePeriod $timePeriod)
    {
        $this->setId($id);
        $this->setUser($user);
        $this->setCompany($company);
        $this->setPosition($position);
        $this->setTimePeriod($timePeriod);

        $this->raise(new EmploymentWasAdded($this));
    }

    /**
     * @return Identity
     */
    public function id()
    {
        return Identity::fromString($this->id);
    }

    /**
     * @param Identity $id
     */
    private function setId(Identity $id)
    {
        $this->id = $id->toString();
    }

    /**
     * @return User
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return Company
     */
    public function company()
    {
        return $this->company;
    }

    /**
     * @param Company $company
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
    }

    /**
     * @return TimePeriod
     */
    public function timePeriod()
    {
        return $this->timePeriod;
    }

    /**
     * @param TimePeriod $from
     */
    public function setTimePeriod(TimePeriod $from)
    {
        $this->timePeriod = $from;
    }

    /**
     * @return Position
     */
    public function position()
    {
        return $this->position;
    }

    /**
     * @param Position $position
     */
    public function setPosition(Position $position)
    {
        $this->position = $position;
    }

    /**
     * Add a new employment
     *
     * @param Identity $id
     * @param User $user
     * @param Company $company
     * @param Position $position
     * @param TimePeriod $timePeriod
     *
     * @return Employment
     */
    public static function add(Identity $id, User $user, Company $company, Position $position, TimePeriod $timePeriod)
    {
        return new self($id, $user, $company, $position, $timePeriod);
    }

    /**
     * Accept questions about employment
     */
    public function acceptQuestions()
    {
        $this->acceptingQuestions = true;
    }

    /**
     * Deny questions about employment
     */
    public function denyQuestions()
    {
        $this->acceptingQuestions = false;
    }

    /**
     * Are questions accepted about employment
     *
     * @return bool
     */
    public function isAcceptingQuestions()
    {
        return $this->acceptingQuestions;
    }
} 