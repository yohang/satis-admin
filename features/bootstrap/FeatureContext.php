<?php

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Context\ClosuredContextInterface;
use Behat\Behat\Context\TranslatedContextInterface;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Exception\ResponseTextException;
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
        $elts = $this->getSession()->getPage()->findAll('named', array('field',  $this->fixStepArgument('"'.$arg1.'"')));
        if (0 === count($elts)) {
            throw new ResponseTextException("No '$arg1' field", $this->getSession());
        }
        $elts[count($elts) - 1]->fill($arg2);
    }

    /**
     * @When /^I follow the last remove repository link$/
     */
    public function iFollowTheLastRemoveRepositoryLink()
    {
        $elts = $this->getSession()->getPage()->findAll('css', '.repositories .repository .remove');
        if (0 === count($elts)) {
            throw new ResponseTextException("No remove repository link", $this->getSession());
        }
        $elts[count($elts) - 1]->click();
    }
}
