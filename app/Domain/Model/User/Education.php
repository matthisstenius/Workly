<?php namespace Workly\Domain\Model\User;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Workly\Domain\Contracts\Identity;
use Workly\Domain\EventRecorder;
use Workly\Domain\Model\User\Events\EducationWasAdded;

/**
 * @ORM\Entity
 * @ORM\Table(name="educations")
 */
class Education
{
    use EventRecorder;

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string")
     */
    private $institute;

    /**
     * @ORM\ManyToMany(targetEntity="User", mappedBy="educations")
     */
    private $students;

    public function __construct(Identity $id, $name, $institute)
    {
        $this->setId($id);
        $this->setName($name);
        $this->setInstitute($institute);

        $this->students = new ArrayCollection;

        $this->raise(new EducationWasAdded($this));
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
     * @return string
     */
    public function institute()
    {
        return $this->institute;
    }

    /**
     * @param string $institute
     */
    public function setInstitute($institute)
    {
        $this->institute = $institute;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add new education
     *
     * @param Identity $id
     * @param string $name
     * @param string $institute
     *
     * @return Education
     */
    public static function add(Identity $id, $name, $institute)
    {
        return new self($id, $name, $institute);
    }

    /**
     * Get students
     *
     * @return ArrayCollection
     */
    public function students()
    {
        return $this->students;
    }

    /**
     * Add new student
     *
     * @param User $student
     */
    public function addStudent(User $student)
    {
        $this->students[] = $student;
        $student->addEducation($this);
    }
} 