<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Workly\Domain\Model\UuidIdentity;

class QualityContext extends PHPUnit_Framework_TestCase implements SnippetAcceptingContext
{
    /**
     * @var InMemoryStorage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = InMemoryStorage::make();
    }

    /**
     * @Given There is a quality called :arg1
     */
    public function thereIsAQualityCalled($quality)
    {
        $id = UuidIdentity::generate();

        $quality = new Workly\Domain\Model\Quality\Quality($id, $quality);
        $this->storage->set('quality', $quality);
    }
} 