<?php
/*
 * This file is part of the JunitXml package.
 *
 * Copyright (C) 2015-2016 Guillaume Kulakowski <guillaume@kulakowski.fr>
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
    public $testSuite;
    /**
     * @var int
     */
    protected $assertions;
    /**
     * @var int
     */
    protected $error = 0;
    /**
     * @var int
     */
    protected $skipped = 0;
    /**
     * @var int
     */
    protected $failure = 0;
    /**
     * @var string
     */
    protected $classname;
    /**
     * @var string
     */
    protected $status;


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
        $this->incParentElementAttribute($this->testSuite, array('skipped', 'error', 'failure'));


        /*
         * Update JunitXmlTestCase
         */
        // Optional attributes
        $this->setOptionalStringElementAttribute(array('name', 'classname', 'status'));
        $this->setOptionalIntElementAttribute(array('assertions'));

        // Others attributes
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

        if (isset($this->$name)) {
            $this->$name++;
        }
    }


    /**
     * Set the status.
     *
     * @param string $status Status.
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * Set the class name.
     *
     * @param string $classname Class name.
     */
    public function setClassName($classname)
    {
        $this->classname = $classname;
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


    /**
     * Set system-out attribute.
     *
     * @param string $message the message.
     */
    public function addStdOut($message)
    {
        $this->addDomElement('system-out', $message);
    }

    /**
     * Set system-err attribute.
     *
     * @param string $message the message.
     */
    public function addStdErr($message)
    {
        $this->addDomElement('system-err', $message);
    }
}
