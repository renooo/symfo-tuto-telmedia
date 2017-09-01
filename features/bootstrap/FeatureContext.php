<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var MinkContext
     */
    private $minkContext;

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
    public function gatherContexts(BeforeScenarioScope $scope)
    {
        $environment = $scope->getEnvironment();
        $this->minkContext = $environment->getContext('Behat\MinkExtension\Context\MinkContext');
        $this->minkContext->getSession()->maximizeWindow();
    }

    /**
     * @Then /^(?:|I )should see "(?P<text>[^"]*)" as the (?P<index>\d+)(?:st|nd|rd|th) artist$/
     */
    public function iShouldSeeAsStArtist($text, $index)
    {
        $page = $this->minkContext->getSession()->getPage();
        $artistNames = $page->findAll('css', '.row .col-md-3:nth-child(2)');

        if (!isset($artistNames[$index - 1])) {
            throw new \Behat\Mink\Exception\ElementNotFoundException($this->minkContext->getSession()->getDriver());
        }

        if ($text !== $artistNames[$index - 1]->getText()) {
            throw new \Behat\Mink\Exception\ElementTextException(
                'Artist name does not match '.$text,
                $this->minkContext->getSession()->getDriver(),
                $artistNames[$index - 1]
            );
        }
    }
}
