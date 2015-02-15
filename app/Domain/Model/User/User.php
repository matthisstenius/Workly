<?php namespace Workly\Domain\Model\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Workly\Domain\Contracts\Identity;
use Workly\Domain\EventRecorder;
use Workly\Domain\Exceptions\DuplicateException;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\Quality\Quality;
use Workly\Domain\Model\Skill;
use Workly\Domain\Model\User\Events\UserHasRegistered;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\User\Name")
     */
    private $name;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\User\Email")
     */
    private $email;

    /**
     * @ORM\Embedded(class="Workly\Domain\Model\User\HashedPassword")
     */
    private $password;

    /**
     * @ORM\ManyToMany(targetEntity="Education", inversedBy="students")
     */
    private $educations;

    private $skills;

    /**
     * @ORM\OneToMany(targetEntity="Workly\Domain\Model\Company\Company", mappedBy="interestedUsers")
     */
    private $interestedInCompanies;

    /**
     * @ORM\OneToMany(targetEntity="Employment", mappedBy="user")
     */
    private $employments;

    /**
     * @ORM\OneToMany(targetEntity="Workly\Domain\Model\Company\Company", mappedBy="interestedInUsers")
     */
    private $interestedCompanies;

    /**
     * @ORM\ManyToMany(targetEntity="Workly\Domain\Model\Quality\Quality")
     * @ORM\JoinTable(name="user_interested_qualities",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id"})
     *      inverseJoinColumn={@JoinColumn(name="quality_id", referencedColumnName="id", unique=true)}
     */
    private $interestedInQualities;

    public function __construct(Identity $id, Name $name, Email $email, HashedPassword $password)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setEmail($email);
        $this->setPassword($password);

        $this->experiences = new ArrayCollection();
        $this->educations = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->interestedInCompanies = new ArrayCollection();
        $this->interestedCompanies = new ArrayCollection;
        $this->employments = new ArrayCollection;
        $this->interestedInQualities = new ArrayCollection;

        $this->raise(new UserHasRegistered($this));
    }

    /**
     * @return UserId
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

    public function name()
    {
        return $this->name;
    }

    public function setName(Name $name)
    {
        $this->name = $name;
    }

    /**
     * @return Email
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @param Email $email
     */
    public function setEmail(Email $email)
    {
        $this->email = $email;
    }

    /**
     * @return HashedPassword
     */
    public function password()
    {
        return $this->password;
    }

    /**
     * @param HashedPassword $password
     */
    private function setPassword(HashedPassword $password)
    {
        $this->password = $password;
    }

    /**
     * Register new user
     *
     * @param Identity $id
     * @param string|Name $name
     * @param Email $email
     * @param HashedPassword $password
     * @internal param string $surname
     * @return static
     */
    public static function register(Identity $id, Name $name, Email $email, HashedPassword $password)
    {
        return new self($id, $name, $email, $password);
    }

    /**
     * Add education to educations
     *
     * @param Education $education
     * @throws DuplicateException
     */
    public function addEducation(Education $education)
    {
        if ($this->educations->contains($education)) {
            throw new DuplicateException('User already has education ' . $education->name());
        }
        $this->educations[] = $education;
    }

    /**
     * Get users educations
     *
     * @return array
     */
    public function educations()
    {
        return $this->educations;
    }

    /**
     * Add skill to skills
     *
     * @param Skill $skill
     * @throws DuplicateException
     */
    public function addSkill(Skill $skill)
    {
        if ($this->skills->contains($skill)) {
            throw new DuplicateException('User already has skill ' . $skill);
        }

        $this->skills[] = $skill;
    }

    /**
     * Get users skills
     *
     * @return array
     */
    public function skills()
    {
        return $this->skills;
    }

    /**
     * Add interest in a company
     *
     * @param Company $company
     * @throws DuplicateException
     */
    public function addInterestInCompany(Company $company)
    {
        if ($this->interestedInCompanies->contains($company)) {
            throw new DuplicateException('User already showed interest in company ' . $company->name());
        }

        $this->interestedInCompanies[] = $company;

        $company->addInterestByUser($this);
    }

    /**
     * @return ArrayCollection
     */
    public function interestedInCompanies()
    {
        return $this->interestedInCompanies;
    }

    /**
     * Add interest from Company
     *
     * @param Company $company
     * @throws DuplicateException
     */
    public function addInterestedCompany(Company $company)
    {
        if ($this->interestedCompanies->contains($company)) {
            throw new DuplicateException("Company {$company->name()} is already interested in user");
        }

        $this->interestedCompanies[] = $company;
    }

    /**
     * Get all interested companies
     *
     * @return ArrayCollection
     */
    public function interestedCompanies()
    {
        return $this->interestedCompanies;
    }

    /**
     * Add employment
     *
     * @param Employment $employment
     * @throws DuplicateException
     */
    public function addEmployment(Employment $employment)
    {
        if ($this->employments->contains($employment)) {
            throw new DuplicateException('User already has employment ' . $employment->position());
        }
        $this->employments[] = $employment;
        $employment->company()->addEmployee($this);
    }

    /**
     * Get current employment
     *
     * @return Employment
     */
    public function employments()
    {
        return $this->employments;
    }

    /**
     * Add quality to list of interesting qualities
     *
     * @param Quality $quality
     * @throws DuplicateException
     */
    public function addInterestInQuality(Quality $quality)
    {
        if ($this->interestedInQualities->contains($quality)) {
            throw new DuplicateException("User already has quality: {$quality->name()}");
        }

        $this->interestedInQualities[] = $quality;
    }

    /**
     * Get all interesting qualities
     *
     * @return ArrayCollection
     */
    public function interestedInQualities()
    {
        return $this->interestedInQualities;
    }
}
