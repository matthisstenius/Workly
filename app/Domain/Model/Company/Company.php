<?php namespace Workly\Domain\Model\Company;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use Workly\Domain\Contracts\Identity;
use Workly\Domain\Exceptions\DuplicateException;
use Workly\Domain\Model\Quality\Quality;
use Workly\Domain\Model\Recommendation\Recommendation;
use Workly\Domain\Model\Skill;
use Workly\Domain\Model\User\User;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies")
 */
class Company
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\Company\Name")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Workly\Domain\Model\User\User", mappedBy="interestedInCompanies")
     */
    private $interestedUsers;

    /**
     * @ORM\OneToMany(targetEntity="Workly\Domain\Model\User\Employment", mappedBy="company")
     */
    private $employees;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\Company\Description")
     */
    private $description;

    private $wantedSkills;

    /**
     * @ORM\OneToMany(targetEntity="Workly\Domain\Model\User\User", mappedBy="interestedCompanies")
     */
    private $interestedInUsers;

    /**
     * @ORM\ManyToMany(targetEntity="Workly\Domain\Model\Quality\Quality")
     * @ORM\JoinTable(name="company_qualities",
     *      joinColumns={@JoinColumn(name="company_id", referencedColumnName="id"})
     *      inverseJoinColumn={@JoinColumn(name="quality_id", referencedColumnName="id", unique=true)}
     */
    private $qualities;

    /**
     * @ORM\ManyToMany(targetEntity="Workly\Domain\Model\Recommendation\Recommendation")
     * @ORM\JoinTable(name="company_recommendations",
     *      joinColumns={@JoinColumn(name="company_id", referencedColumnName="id"})
     *      inverseJoinColumn={@JoinColumn(name="recommendation_id", referencedColumnName="id", unique=true)}
     */
    private $recommendations;

    public function __construct(Identity $id, Name $name)
    {
        $this->setId($id);
        $this->setName($name);

        $this->interestedUsers = new ArrayCollection;
        $this->employees = new ArrayCollection;
        $this->wantedSkills = new ArrayCollection;
        $this->interestedInUsers = new ArrayCollection;
        $this->qualities = new ArrayCollection;
        $this->recommendations = new ArrayCollection;
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
    public function setId(Identity $id)
    {
        $this->id = $id->toString();
    }

    /**
     * @return Name
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param Name $name
     */
    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * Get company description
     *
     * @return Description
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Set company description
     *
     * @param Description $description
     */
    public function setDescription(Description $description)
    {
        $this->description = $description;
    }

    /**
     * Add a new company
     *
     * @param Identity $id
     * @param Name $name
     * @return Company
     */
    public static function register(Identity $id, Name $name)
    {
        return new self($id, $name);
    }

    /**
     * Add User as interested in Company
     *
     * @param User $user
     */
    public function addInterestByUser(User $user)
    {
        $this->interestedUsers[] = $user;
    }

    /**
     * @return ArrayCollection
     */
    public function interestedUsers()
    {
        return $this->interestedUsers;
    }

    /**
     * Add new employee
     *
     * @param User $user
     */
    public function addEmployee(User $user)
    {
        $this->employees[] = $user;
    }

    /**
     * Get all employees
     *
     * @return ArrayCollection
     */
    public function employees()
    {
        return $this->employees;
    }

    /**
     * Add wanted skill
     *
     * @param Skill $skill
     */
    public function addWantedSkill(Skill $skill)
    {
        $this->wantedSkills[] = $skill;
    }

    public function wantedSkills()
    {
        return $this->wantedSkills;
    }

    /**
     * Add interest in user
     *
     * @param User $user
     */
    public function addInterestInUser(User $user)
    {
        $this->interestedInUsers[] = $user;

        $user->addInterestedCompany($this);
    }

    /**
     * Get users Company is interested in
     *
     * @return mixed
     */
    public function interestedInUsers()
    {
        return $this->interestedInUsers;
    }

    /**
     * Add quality
     *
     * @param Quality $quality
     * @throws DuplicateException
     */
    public function addQuality(Quality $quality)
    {
        if ($this->qualities->contains($quality)) {
            throw new DuplicateException("Company already has quality {$quality->name()}");
        }

        $this->qualities[] = $quality;
    }

    /**
     * Get all qualities
     *
     * @return ArrayCollection
     */
    public function qualities()
    {
        return $this->qualities;
    }

    /**
     * Recommend Company
     *
     * @param Recommendation $recommendation
     * @throws Exception
     */
    public function recommend(Recommendation $recommendation)
    {
        if ( ! $this->employees->contains($recommendation->by())) {
            throw new Exception('User is/has not been an employee at the company');
        }

        $this->recommendations[] = $recommendation;
    }

    /**
     * Recommend against Company
     *
     * @param Recommendation $recommendation
     * @throws Exception
     */
    public function recommendAgainst(Recommendation $recommendation)
    {
        if ( ! $this->employees->contains($recommendation->by())) {
            throw new Exception('User is/has not been an employee at the company');
        }

        $this->recommendations[] = $recommendation;
    }

    /**
     * Get all recommendations
     *
     * @return ArrayCollection
     */
    public function recommendations()
    {
        return $this->recommendations;
    }
}
