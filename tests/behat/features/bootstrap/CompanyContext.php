<?php
use Behat\Behat\Context\SnippetAcceptingContext;
use Workly\Domain\Model\Company\Company;
use Workly\Domain\Model\Company\Name as CompanyName;
use Workly\Domain\Model\User\Name as UserName;
use Workly\Domain\Model\Skill;
use Workly\Domain\Model\User\Email;
use Workly\Domain\Model\User\Employment;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\User\HashedPassword;
use Workly\Domain\Model\UuidIdentity;

class CompanyContext extends PHPUnit_Framework_TestCase implements SnippetAcceptingContext {
    /**
     * @var InMemoryStorage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::make();
    }

    /**
     * @Given There is a registered user named :arg1 with employer :arg2
     */
    public function thereIsARegisteredUserNamedWithEmployee($userName, $companyName)
    {
        $companyId = UuidIdentity::generate();
        $userId = UuidIdentity::generate();

        $name = new UserName($userName, 'tester');
        $email = new Email('test@tester.com');
        $password = new HashedPassword('password1234');

        $user = User::register($userId, $name, $email, $password);

        $company = Company::register($companyId, new CompanyName($companyName));

        $this->storage->set('user', $user);
        $this->storage->set('company', $company);
    }

    /**
     * @When User :arg1 adds company :arg2 as my current employer with position :arg3 and period :arg4 to :arg5
     */
    public function userAddsCompanyAsMyCurrentEmployerWithPositionAndPeriodTo($user, $companyName, $positionName, $from, $to)
    {
        $user = $this->storage->get('user');

        $id = UuidIdentity::generate();
        $company = $this->storage->get('company');
        $position = new Workly\Domain\Model\User\Position($positionName);

        $timePeriod = new Workly\Domain\Model\TimePeriod($from, $to);

        $employment = Employment::add($id, $user, $company, $position, $timePeriod);

        $user->addEmployment($employment);
    }

    /**
     * @Then User :arg1 should be an employee in company :arg2
     */
    public function userShouldBeAnEmployeeInCompany($userName, $companyName)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->employees()[0]->name()->firstName(), $userName);
    }

    /**
     * @Given There is a company named :arg1
     */
    public function thereIsACompanyNamed($companyName)
    {
        $companyId = UuidIdentity::generate();

        $company = Company::register($companyId, new CompanyName($companyName));

        $this->storage->set('company', $company);
    }

    /**
     * @When Skill :arg1 is added to company :arg2
     */
    public function skillIsAddedToCompany($skill, $companyName)
    {
        $company = $this->storage->get('company');

        $skill = new Skill($skill);

        $company->addWantedSkill($skill);
    }

    /**
     * @Then Skill :arg1 should be in company :arg2 wanted skills
     */
    public function skillShouldBeInCompanyWantedSkills($skill, $companyName)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->wantedSkills()[0], $skill);
    }

    /**
     * @When Company :arg1 shows interest in user :arg2
     */
    public function companyShowsInterestInUser($companyName, $userName)
    {
        $company = $this->storage->get('company');

        $userId = UuidIdentity::generate();
        $name = new UserName($userName, 'tester');
        $email = new Email('test@tester.com');
        $password = new HashedPassword('password1234');

        $user = User::register($userId, $name, $email, $password);

        $company->addInterestInUser($user);

        $this->storage->set('user', $user);
    }

    /**
     * @Then Company :arg1 should be able to find user :arg2 in their interested by users list
     */
    public function companyShouldBeAbleToFindUserInTheirInterestedByUsersList($companyName, $userName)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->interestedInUsers()[0]->name()->firstName(), $userName);
    }

    /**
     * @Then User should be able to find company :arg1 as an interested company
     */
    public function userShouldBeAbleToFindCompanyAsAnInterestedCompany($companyName)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->interestedCompanies()[0]->name(), $companyName);
    }

    /**
     * @When Quality :arg1 is added to company :arg2
     */
    public function qualityIsAddedToCompany($companyName, $qualityName)
    {
        $company = $this->storage->get('company');
        $quality = $this->storage->get('quality');

        $company->addQuality($quality);
    }

    /**
     * @Then Company :arg1 should have quality :arg2
     */
    public function companyShouldHaveQuality($companyName, $arg2)
    {
        $company = $this->storage->get('company');
        $quality = $this->storage->get('quality');

        $this->assertContains($quality, $company->qualities());
    }

    /**
     * @Given Company :arg1 has quality :arg2
     */
    public function companyHasQuality($companyName, $arg2)
    {
        $company = $this->storage->get('company');
        $quality = $this->storage->get('quality');

        $company->addQuality($quality);
    }

    /**
     * @When I endorse company :arg1 for quality :arg2
     */
    public function iEndorseCompanyForQuality($arg1, $arg2)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');

        $quality = $company->qualities()[0];

        $quality->endorse($user);
    }

    /**
     * @Then Company :arg1 should have an endorsement for quality :arg2 by user :arg3
     */
    public function companyShouldHaveAnEndorsementForQualityMe($arg1, $arg2, $username)
    {
        $company = $this->storage->get('company');

        $endorsedQuality = $company->qualities()[0];

        $this->assertEquals($endorsedQuality->endorsedBy()[0]->name()->firstName(), $username);
    }
} 