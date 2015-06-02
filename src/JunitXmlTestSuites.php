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
 * The JunitXmlTestSuites class.
 *
 * Build a JunitXmlTestSuites object.
 */
class JunitXmlTestSuites extends JunitXmlTestElement
{
    /**
     * @var DOMDocument
     */
    private $xmlDocument;
    /**
     * @var int
     */
    protected $tests = false;
    /**
     * @var int
     */
    protected $failures = false;
    /**
     * @var int
     */
    protected $disabled = false;
    /**
     * @var int
     */
    protected $errors = false;


    /**
     * Constructor
     * Build emty testsuites DOMElement.
     *
     * @param string $name Name of the testsuites.
     */
    public function __construct($name = '')
    {
        $this->startTimer();
        $this->name = $name;

        $this->xmlDocument = new \DOMDocument();
        $this->domElement = new \DOMElement('testsuites');
        $this->xmlDocument->appendChild($this->domElement);
    }


    /**
     * Add a testsuite DOMElement to the testsuites
     *
     * @param string $name Name of the testsuite.
     * @return JunitXmlTestSuite Return a JunitXmlTestSuite object with testsuite DOMElement.
     */
    public function addTestSuite($name = '')
    {
        $ts = new JunitXmlTestSuite($this);
        $this->domElement->appendChild($ts->getXmlElement());
        $ts->setName($name);

        return $ts;
    }


    /**
     * Finish JunitXmlTestSuites and set attributes.
     */
    private function finish()
    {
        // Optional attributes
        $this->setOptionalStringElementAttribute(array('name'));
        $this->setOptionalIntElementAttribute(array('tests', 'disabled', 'errors', 'failures'));

        // Others attributes
        $this->setElementAttribute('time', $this->getExecTime());
    }


    /**
     * Get XML output
     *
     * @return string Output XML of the JunitXMLTestSuites.
     */
    public function getXml()
    {
        $this->finish();

        return $this->xmlDocument->saveXML();
    }


    /**
     * Increment test.
     *
     * @param int $inc Increment.
     */
    public function incTests($inc = 1)
    {
        $this->tests = (int) $this->tests + $inc;
    }


    /**
     * Increment disabled.
     *
     * @param int $inc Increment.
     */
    public function incDisabled($inc = 1)
    {
        $this->disabled = (int) $this->disabled + $inc;
    }


    /**
     * Increment errors.
     *
     * @param int $inc Increment.
     */
    public function incErrors($inc = 1)
    {
        $this->errors = (int) $this->errors + $inc;
    }


    /**
     * Increment failures.
     *
     * @param int $inc Increment.
     */
    public function incFailures($inc = 1)
    {
        $this->failures = (int) $this->failures + $inc;
    }
}
