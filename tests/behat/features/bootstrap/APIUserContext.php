<?php
use Assert\InvalidArgumentException;
use Behat\Behat\Context\SnippetAcceptingContext;
use Illuminate\Contracts\Bus\Dispatcher;
use Workly\Domain\Exceptions\DuplicateException;
use Workly\Domain\Model\User\Education;
use Workly\Domain\Model\User\Email;
use Workly\Domain\Model\User\Employment;
use Workly\Domain\Model\User\Experience;
use Workly\Domain\Model\User\HashedPassword;
use Workly\Domain\Model\User\User;
use Workly\Domain\Model\Skill;
use Workly\Domain\Model\User\Password;
use Workly\Domain\Model\User\UserId;
use Workly\Domain\Model\UuidIdentity;
use Workly\Infrastructure\Commander\CommandBus;
use Workly\Infrastructure\Helpers\Hasher;

class APIUserContext extends PHPUnit_Framework_TestCase implements SnippetAcceptingContext {
    /**
     * @var InMemoryStorage
     */
    private $storage;

    public function __construct()
    {
        // Add guzzle
        $this->storage = InMemoryStorage::make();
    }

    /**
     * @Given There is a registered user named :arg1 with email :arg2
     */
    public function thereIsARegisteredUserNamedWithEmail($name, $email)
    {
        $id = UuidIdentity::generate();
        $email = new Email($email);
        $password = new HashedPassword('testing');
        $name = new \Workly\Domain\Model\User\Name($name, 'testersson');

        $user = User::register($id, $name, $email, $password);
        $this->storage->set('user', $user);
    }

    /**
     * @When I register with name :arg1 and surname :arg2 and email :arg3 and password :arg4
     */
    public function iRegisterWithNameAndSurnameAndEmailAndPassword($name, $surname, $email, $password)
    {
        $registerUser = new \Workly\Commands\RegisterUserCommand($name, $surname, $email, $password);

        $this->storage['user'] = $this->commandBus->execute($registerUser);

    }

    /**
     * @Then There should be a registered user with name :name and surname :surname and email :email
     */
    public function thereShouldBeARegisteredUserWithEmail($name, $surname, $email)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->email(), $email);
        $this->assertEquals($user->name()->firstName(), $name);
        $this->assertEquals($user->name()->surname(), $surname);
    }

    /**
     * @Then There should not be a registered user
     */
    public function thereShouldNotBeAUserWithEmail()
    {
        $this->setExpectedException('InvalidArgumentException');

        $this->storage->get('user');
    }

    /**
     * @Given There is a registered user named :arg1
     */
    public function thereIsARegisteredUserNamed($name)
    {
        $id = UuidIdentity::generate();
        $name = new \Workly\Domain\Model\User\Name($name, 'testersson');
        $email = new Email('test@test.com');
        $password = new HashedPassword('testing');

        $user = User::register($id, $name, $email, $password);

        $this->storage->set('user', $user);
    }

    /**
     * @Given There is an education with name :arg1 and institute :arg2
     */
    public function thereIsAnEducationWithNameAndInstitute($name, $institute)
    {
        $id = UuidIdentity::generate();
        $education = Education::add($id, $name, $institute);

        $this->storage->set('education', $education);
    }

    /**
     * @When I add education named :arg1 to my list of educations
     */
    public function iAddEducationNamedToMyListOfEducations($name)
    {
        $user = $this->storage->get('user');
        $education = $this->storage->get('education');

        $user->addEducation($education);
    }

    /**
     * @Then There should be an education named :arg1 with institute :arg2 in my list of educations
     */
    public function thereShouldBeAnEducationNamedWithInstituteInMyListOfEducations($name, $institute)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->educations()[0]->name(), $name);
        $this->assertEquals($user->educations()[0]->institute(), $institute);
    }

    /**
     * @Given There is a skill named :arg1
     */
    public function thereIsASkillNamed($skillName)
    {
        $skill = new Skill($skillName);

        $this->storage->set('skill', $skill);
    }

    /**
     * @When I add skill :arg1 to my list of skills
     */
    public function iAddSkillToMyListOfSkills($skill)
    {
        $user = $this->storage->get('user');

        $skill = $this->storage->get('skill');

        $user->addSkill($skill);
    }

    /**
     * @Then There should be a skill named :arg1 in my list of skills
     */
    public function thereShouldBeASkillNamedInMyListOfSkills($skill)
    {
        $user = $this->storage->get('user');
        $skill = new Skill($skill);

        $this->assertTrue($user->skills()[0]->equals($skill));
    }

    /**
     * @When I show interest in company :arg1
     */
    public function iShowInterestInCompany($companyName)
    {
        $company = $this->storage->get('company');
        $user = $this->storage->get('user');

        $user->addInterestInCompany($company);
    }

    /**
     * @Then I should be able to find company :arg1 in my interested by companies list
     */
    public function iShouldBeAbleToFindCompanyInMyInterestedInCompanies($companyName)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->interestedInCompanies()[0]->name(), $companyName);
    }

    /**
     * @Given User :arg1 is employed at company :arg2
     */
    public function userIsEmployedAtCompany($arg1, $companyName)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');
        $id = UuidIdentity::generate();

        $position = new Workly\Domain\Model\User\Position('Position');

        $timePeriod = new Workly\Domain\Model\TimePeriod('2014-03-04 00:00:00', '2014-05-04 00:00:00');

        $employment = Employment::add($id, $user, $company, $position, $timePeriod);

        $user->addEmployment($employment);
    }

    /**
     * @When I add company :arg1 as my current employer with position :arg2 and period :arg3 to :arg4
     */
    public function iAddCompanyAsMyCurrentEmployerWithPosition($companyName, $positionName, $from, $to)
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
     * @Then company :arg1 should be my current employer with position :arg2
     */
    public function companyShouldBeMyCurrentEmployer($companyName, $positionName)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->employments()[0]->company()->name(), $companyName);
        $this->assertEquals($user->employments()[0]->position(), $positionName);
    }

    /**
     * @When I add quality :arg1 to my list of qualities that i'm interested in
     */
    public function iAddQualityToMyListOfQualitiesThatIMInterestedIn($arg1)
    {
        $quality = $this->storage->get('quality');
        $user = $this->storage->get('user');

        try {
            $user->addInterestInQuality($quality);
        } catch (DuplicateException $e) {

        }
    }

    /**
     * @Then Quality :arg1 should be in my list of qualities that i'm interested in
     */
    public function qualityShouldBeInMyListOfQualitiesThatIMInterestedIn($quality)
    {
        $user = $this->storage->get('user');

        $this->assertEquals($user->interestedInQualities()[0]->name(), $quality);
    }

    /**
     * @Given User :arg1 is interested in quality :arg2
     */
    public function userIsInterestedInQuality($arg1, $quality)
    {
        $user = $this->storage->get('user');
        $quality = $this->storage->get('quality');

        $user->addInterestInQuality($quality);
    }

    /**
     * @Then Quality :arg1 should not be in my list of qualities that i'm interested in
     */
    public function qualityShouldNotBeInMyListOfQualitiesThatIMInterestedIn($arg1)
    {
        $user = $this->storage->get('user');

        $this->assertCount(1, $user->interestedInQualities());
    }

    /**
     * @Given User :arg1 accepts questions for company :arg2
     * @When User :arg1 adds flag for accepting questions about company :arg2
     */
    public function userAddsFlagForAcceptingQuestionsAboutCompany($arg1, $companyName)
    {
        $user = $this->storage->get('user');

        $user->employments()[0]->acceptQuestions();
    }

    /**
     * @Then User :arg1 should be flagged for accepting questions about company :arg2
     */
    public function userShouldBeFlaggedForAcceptingQuestionsAboutCompany($arg1, $companyName)
    {
        $user = $this->storage->get('user');

        $this->assertTrue($user->employments()[0]->isAcceptingQuestions());
    }

    /**
     * @When User :arg1 removes flag for accepting questions about company :arg2
     */
    public function userRemovesFlagForAcceptingQuestionsAboutCompany($arg1, $companyName)
    {
        $user = $this->storage->get('user');

        $user->employments()[0]->denyQuestions();
    }

    /**
     * @Then User :arg1 should be flagged to not accept questions about company :arg2
     */
    public function userShouldBeFlaggedToNotAcceptQuestionsAboutCompany($arg1, $companyName)
    {
        $user = $this->storage->get('user');

        $this->assertFalse($user->employments()[0]->isAcceptingQuestions());
    }


} 