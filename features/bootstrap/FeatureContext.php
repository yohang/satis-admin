<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\MinkExtension\Context\MinkDictionary;

require_once __DIR__.'/../../vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

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
    }

    /**
     * @Then /^The following repositories are visible:$/
     */
    public function theFollowingRepositoriesAreVisible(TableNode $table)
    {
        $tableHash = $table->getHash();
        assertCount(count($tableHash), $this->getSession()->getPage()->findAll('css', '.repositories .repository'));

        foreach ($tableHash as $row) {
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

    /**
     * @Given /^I fill the last "([^"]*)" field with "([^"]*)"$/
     */
    public function iFillTheLastFieldWith($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When /^I follow the last "([^"]*)" link$/
     */
    public function iFollowTheLastLink($arg1)
    {
        throw new PendingException();
    }
}
