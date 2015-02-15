<?php namespace Workly\Commands;

use Workly\Gettable;

class RegisterUserCommand
{
    use Gettable;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

	public function __construct($name, $surname, $email, $password)
	{
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->password = $password;
    }
}
