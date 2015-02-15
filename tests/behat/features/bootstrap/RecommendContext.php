<?php
use Behat\Behat\Context\SnippetAcceptingContext;

class RecommendContext  extends PHPUnit_Framework_TestCase implements SnippetAcceptingContext
{
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::make();
    }

    /**
     * @When User :arg1 recommends company :arg2
     */
    public function userRecommendsCompany($arg1, $arg2)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');

        $recommendationType = new Workly\Domain\Model\Recommendation\Types\Positive();

        $recommendation = Workly\Domain\Model\Recommendation\Recommendation::create($recommendationType, $user);

        $this->storage->set('recommendation', $recommendation);

        try {
            $company->recommend($recommendation);
        } catch (Exception $e) {

        }
    }

    /**
     * @Then Company :arg1 should have a recommendation from user :arg2
     */
    public function companyShouldHaveARecommendationFromUser($arg1, $username)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->recommendations()[0]->by()->name()->firstName(), $username);
    }

    /**
     * @When User :arg1 recommends company :arg2 with reason :arg3
     */
    public function userRecommendsCompanyWithReason($arg1, $arg2, $reason)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');

        $recommendationType = new Workly\Domain\Model\Recommendation\Types\Positive();

        $recommendation = Workly\Domain\Model\Recommendation\Recommendation::create($recommendationType, $user);
        $recommendation->addReason($reason);

        $this->storage->set('recommendation', $recommendation);

        try {
            $company->recommend($recommendation);
        } catch (Exception $e) {

        }
    }

    /**
     * @Then Company :arg1 should have a recommendation from user :arg2 with reason :arg3
     */
    public function companyShouldHaveARecommendationFromUserWithReason($arg1, $username, $reason)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->recommendations()[0]->by()->name()->firstName(), $username);
        $this->assertEquals($company->recommendations()[0]->reason(), $reason);
    }


    /**
     * @When User :arg1 recommends against company :arg2
     */
    public function userRecommendsAgainstCompany($arg1, $arg2)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');

        $recommendationType = new Workly\Domain\Model\Recommendation\Types\Negative();

        $recommendation = Workly\Domain\Model\Recommendation\Recommendation::create($recommendationType, $user);

        $this->storage->set('recommendation', $recommendation);

        try {
            $company->recommendAgainst($recommendation);
        } catch (Exception $e) {

        }
    }

    /**
     * @Then Company :arg1 should have a recommendation by user :arg2 and type :arg3
     */
    public function companyShouldHaveARecommendationByUserAndType($arg1, $username, $type)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->recommendations()[0]->by()->name()->firstName(), $username);
        $this->assertEquals($company->recommendations()[0]->type(), $type);
    }

    /**
     * @When User :arg1 recommends against company :arg2 with reason :arg3
     */
    public function userRecommendsAgainstCompanyWithReason($arg1, $arg2, $reason)
    {
        $user = $this->storage->get('user');
        $company = $this->storage->get('company');

        $recommendationType = new Workly\Domain\Model\Recommendation\Types\Negative();

        $recommendation = Workly\Domain\Model\Recommendation\Recommendation::create($recommendationType, $user);
        $recommendation->addReason($reason);

        $this->storage->set('recommendation', $recommendation);

        try {
            $company->recommendAgainst($recommendation);
        } catch (Exception $e) {

        }
    }

    /**
     * @Then Company :arg1 should have a recommendation by user :arg2 and type :arg3 and reason :arg4
     */
    public function companyShouldHaveARecommendationByUserAndTypeAndReason($arg1, $username, $type, $reason)
    {
        $company = $this->storage->get('company');

        $this->assertEquals($company->recommendations()[0]->by()->name()->firstName(), $username);
        $this->assertEquals($company->recommendations()[0]->type(), $type);
        $this->assertEquals($company->recommendations()[0]->reason(), $reason);
    }

    /**
     * @Then Company :arg1 should not have a recommendation from user :arg2
     */
    public function companyShouldNotHaveARecommendationFromUser($arg1, $arg2)
    {
        $company = $this->storage->get('company');

        $this->assertCount(0, $company->recommendations());
    }
} 