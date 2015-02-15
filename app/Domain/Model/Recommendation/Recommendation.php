<?php

namespace Workly\Domain\Model\Recommendation;

use Workly\Domain\Model\Recommendation\Types\RecommendationType;
use Workly\Domain\Model\User\User;

/**
 * @ORM\Entity(table="recommendations")
 */
class Recommendation
{
    /**
     * @ORM\column(type="string")
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity="Workly\Domain\Model\User\User")
     */
    private $by;

    /**
     * @ORM\column(type="string")
     */
    private $reason;

    public function __construct(RecommendationType $type, User $user)
    {
        $this->setType($type);
        $this->setBy($user);
    }

    /**
     * @param RecommendationType $type
     */
    private function setType(RecommendationType $type)
    {
        $this->type = $type->name();
    }

    /**
     * Get recommendation type
     *
     * @return RecommendationType
     */
    public function type()
    {
        return $this->type;
    }

    /**
     * Set recommended by
     *
     * @param User $user
     */
    public function setBy(User $user)
    {
        $this->by = $user;
    }

    /**
     * Get all who has recommended
     *
     * @return User
     */
    public function by()
    {
        return $this->by;
    }

    /**
     * Create new Recommendation
     *
     * @param RecommendationType $type
     * @param User $user
     *
     * @return Recommendation
     */
    public static function create(RecommendationType $type, User $user)
    {
        return new self($type, $user);
    }

    /**
     * Add a reason for the recommendation
     *
     * @param string $reason
     */
    public function addReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Get reason for recommendation
     *
     * @return string
     */
    public function reason()
    {
        return $this->reason;
    }
}
