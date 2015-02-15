<?php namespace Workly\Domain\Model\Quality;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Assert\Assertion;
use Workly\Domain\Exceptions\DuplicateException;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\UuidIdentity;

/**
 * @ORM\Entity
 */
class Quality
{
    /**
     * @var UuidIdentity
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="Workly\Domain\Model\User\User")
     * @ORM\JoinTable(name="quality_endorsements",
     *      joinColumns={@JoinColumn(name="quality_id", referencedColumnName="id"})
     *      inverseJoinColumn={@JoinColumn(name="user_id", referencedColumnName="id", unique=true)}
     */
    private $endorsedBy;

    public function __construct(UuidIdentity $id, $name)
    {
        Assertion::string($name);

        $this->setId($id);
        $this->setName($name);

        $this->endorsedBy = new ArrayCollection;
    }

    /**
     * @return UuidIdentity
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param UuidIdentity $id
     */
    public function setId(UuidIdentity $id)
    {
        $this->id = $id->toString();
    }

    /**
     * @return mixed
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Add new quality
     *
     * @param UuidIdentity $id
     * @param string $name
     * @return Quality
     */
    public static function add(UuidIdentity $id, $name)
    {
        return new self($id, $name);
    }

    /**
     * Add endorsement by user
     *
     * @param User $user
     * @throws DuplicateException
     */
    public function endorse(User $user)
    {
        if ($this->endorsedBy->contains($user)) {
            throw new DuplicateException('Quality is already endorsed by user ' . $user->name());
        }

        $this->endorsedBy[] = $user;
    }

    /**
     * Get all endorsements
     *
     * @return ArrayCollection
     */
    public function endorsedBy()
    {
        return $this->endorsedBy;
    }
}
