<?php

namespace Application\Refactor\ReferenceBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext
//MinkContext if you want to test web                   implements KernelAwareInterface
{

    private $kernel;

    private $parameters;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;

    }//end __construct()

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;

    }//end setKernel()

    //
    // Place your definition and hook methods here:
    //
    //    /**
    //     * @Given /^I have done something with "([^"]*)"$/
    //     */
    //    public function iHaveDoneSomethingWith($argument)
    //    {
    //        $container = $this->kernel->getContainer();
    //        $container->get('some_service')->doSomethingWith($argument);
    //    }
    //



    /**
     * @Given /^que je suis à "([^"]*)"$/
     */
    public function queJeSuisA($arg1)
    {
        $this->visit($arg1);

    }//end queJeSuisA()

    /**
     * @Given /^je vais à "([^"]*)"$/
     */
    public function jeVaisA($arg1)
    {
        $this->visit($arg1);

    }//end jeVaisA()


    /**
     * @Given /^je dois voir "([^"]*)"$/
     */
    public function jeDoisVoir($arg1)
    {
        $this->assertResponseContains($arg1);

    }//end jeDoisVoir()
}//end class
