<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Illuminate\Foundation\Testing\ApplicationTrait;

/**
 * Defines application features from the specific context.
 */
class LaravelFeatureContext implements Context, SnippetAcceptingContext
{
    use ApplicationTrait;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @BeforeScenario
     */
    public function setUp()
    {
        if ( ! $this->app)
        {
            $this->refreshApplication();
        }
    }

    public function createApplication()
    {
        $unitTesting = true;

        $testEnvironment = 'testing';

        return require __DIR__.'/../../../../../bootstrap/start.php';
    }
}
