<?php namespace Workly\Infrastructure\Repositories;

use Doctrine\ORM\EntityManager;

abstract class DoctrineBaseRepository {
    /**
     * @var EntityManager
     */
    protected $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Get entity class name
     *
     * @return mixed
     */
    protected abstract function getClassName();

    /**
     * Get custom repository instance
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository()
    {
        return $this->em->getRepository($this->getClassName());
    }

    /**
     * Get next identity
     *
     * @return Identity
     */
    public function nextIdentity()
    {
        return UuidIdentity::generate();
    }
} 