<?php namespace Workly\Domain\Model\User;

class UniqueEmail implements EmailSpecification
{
    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Check if Email is satisfied by specification
     *
     * @param Email $email
     * @return bool
     */
    public function isSatisfiedBy(Email $email)
    {
        if ($this->repository->findByEmail($email)) {
            return false;
        }

        return true;
    }
}