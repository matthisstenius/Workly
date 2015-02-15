<?php namespace Workly\Handler\Command;

use Workly\Domain\Model\User\Email;
use Workly\Domain\Model\User\Name;
use Workly\Domain\Model\User\Password;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\User\UserRepository;
use Workly\Infrastructure\Commander\Contracts\CommandHandler;
use Workly\Infrastructure\Helpers\Hasher;

class RegisterUserHandler implements CommandHandler
{
    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var UserRepository
     */
    private $repository;

    public function __construct(Hasher $hasher, UserRepository $repository)
    {
        $this->hasher = $hasher;
        $this->repository = $repository;
    }

    public function handle($command)
    {
        $id = $this->repository->nextIdentity();

        $name = new Name($command->name, $command->surname);
        $email = new Email($command->email);
        $password = new Password($command->password);

        $hashedPassword = $this->hasher->hash($password);

        $user = User::register($id, $name, $email, $hashedPassword);

        $user->releaseEvents();

        return $user;
    }
}