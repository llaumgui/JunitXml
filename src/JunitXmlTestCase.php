<?php
/*
 * This file is part of the JunitXml package.
 *
 * (c) Guillaume Kulakowski <guillaume@kulakowski.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Llaumgui\JunitXml;

use Llaumgui\JunitXml\JunitXmlTestElement;

/**
 * The JunitXmlTestCase class.
 *
 * Build a JunitXmlTestCase object.
 */
class JunitXmlTestCase extends JunitXmlTestElement
{
    /**
     * @var JunitXmlTestSuite
     */
    private $testSuite;
    /**
     * @var int
     */
    private $assertions;
    /**
     * @var int
     */
    private $error;
    /**
     * @var int
     */
    private $skipped;
    /**
     * @var int
     */
    private $failure;
    /**
     * @var string
     */
    private $classname;
    /**
     * @var string
     */
    private $status;


    /**
     * Constructor.
     *
     * @param JunitXmlTestSuite $testSuite
     */
    public function __construct(JunitXmlTestSuite $testSuite)
    {
        $this->startTimer();

        $this->testSuite = $testSuite;
        $this->domElement = new \DOMElement('testcase');
    }


    /**
     * Finish test suite
     */
    public function finish()
    {
        /*
         * Update JunitXmlTestSuite
         */
        $this->testSuite->incTests();
        foreach (array('skipped', 'error', 'failure') as $attribute) {
            if (is_int($this->$attribute)) {
                call_user_func(array($this->testSuite, 'inc' . ucfirst($attribute) . 's'), $this->$attribute);
            }
        }
        // @TODO Add other increments.

        /*
         * Update JunitXmlTestCase
         */
        // Optional string elements
        foreach (array('name', 'classname', 'status') as $attribute) {
            if (!empty($this->$attribute)) {
                $this->setElementAttribute($attribute, $this->$attribute);
            }
        }
        // Optional int elements
        foreach (array('assertions', 'skipped', 'error', 'failure') as $attribute) {
            if (is_int($this->$attribute)) {
                $this->setElementAttribute($attribute, $this->$attribute);
            }
        }
        $this->setElementAttribute('time', $this->getExecTime());
    }


    /**
     * Add an domXmlElement.
     *
     * @param string $name    Name of the DOMElement.
     * @param string $message Message of the DOMElement.
     * @param string $type    Attribute type of the DOMElement.
     */
    public function addDomElement($name, $message, $type = false)
    {
        $element = new \DOMElement($name);
        $this->domElement->appendChild($element);
        if ($type !== false) {
            $element->setAttribute("type", $type);
        }
        $element->nodeValue = $message;

        $this->$name++;
    }


    /**
     * Add an error
     *
     * @param string $message
      * @param string $type
     */
    public function addError($message, $type = false)
    {
        $this->addDomElement('error', $message, $type);
    }

    /**
     * Add an skipped
     *
     * @param string $message
     */
    public function addSkipped($message)
    {
        $this->addDomElement('skipped', $message);
    }


    /**
     * Add an failures
     *
     * @param string $message
     * @param string $type
     */
    public function addFailure($message, $type = false)
    {
        $this->addDomElement('failure', $message, $type);
    }


    /**
     * Increment assertion.
     *
     * @param int $inc Increment.
     */
    public function incAssertions($inc = 1)
    {
        $this->assertions = $inc;
    }
}
