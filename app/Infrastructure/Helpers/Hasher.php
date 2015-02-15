<?php namespace Workly\Infrastructure\Helpers;

use Illuminate\Hashing\BcryptHasher;
use Workly\Domain\Model\User\HashedPassword;
use Workly\Domain\Model\User\Password;

class Hasher {
    /**
     * @var BcryptHasher
     */
    private $bcryptHasher;

    public function __construct(BcryptHasher $bcryptHasher)
    {
        $this->bcryptHasher = $bcryptHasher;
    }

    public function hash(Password $password)
    {
        return new HashedPassword($this->bcryptHasher->make($password));
    }
} 