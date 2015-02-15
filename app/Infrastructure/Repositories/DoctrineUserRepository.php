<?php namespace Workly\Infrastructure\Repositories;

use Workly\Domain\Model\User\Email;
use Workly\Domain\Model\User\UserRepository;

class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository {
    /**
     * Get entity class name
     *
     * @return string
     */
    protected function getClassName()
    {
        return 'Workly\Domain\Model\User\Entities\User';
    }

    /**
     * Find user by email
     *
     * @param Email $email
     * @return User
     */
    public function findByEmail(Email $email)
    {
       return $this->getRepository()->findOneBy(['email.email' => $email->toString()]);
    }
}