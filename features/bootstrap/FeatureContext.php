<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Mink;
use Behat\Mink\Session;
use Behat\MinkExtension\Context\MinkDictionary;
use Symfony\Component\HttpKernel\Client;
//   require_once 'PHPUnit/Framework/Assert/Functions.php';

/**
 * Features context.
 */
class FeatureContext extends BehatContext
{
    use MinkDictionary;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        static $app;
        if (null === $app) {
            $app = require_once __DIR__.'/../../src/app_test.php';
        }

        $this->setMink(new Mink(array('silex' => new Session(new BrowserKitDriver(new Client($app))))));
        $this->getMink()->setDefaultSessionName('silex');
    }

    /**
     * @Then /^The following repositories are visible:$/
     */
    public function theFollowingRepositoriesAreVisible(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->assertPageContainsText($row['type']);
            $this->assertPageContainsText($row['url']);
        }
    }

    /**
     * @When /^I fill the form with$/
     */
    public function iFillTheFormWith(TableNode $table)
    {
        foreach ($table->getHash() as $row) {
            $this->getSession()->getPage()->fillField($row['field'], $row['value']);
        }
    }
}
