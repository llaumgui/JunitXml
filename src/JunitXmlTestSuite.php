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

/**
 * The JunitXmlTestSuite class.
 *
 * Build a JunitXmlTestSuite object.
 */
class JunitXmlTestSuite
{
    /**
    * @var DOMElement
    */
    private $xmlTestSuite;
    /**
     * @var string
     */
    private $name = '';
    /**
     * @var string
     */
    private $file = '';
    /**
     * @var int
     */
    private $tests = 0;
    /**
     * @var int
     */
    private $errors = 0;
    /**
     * @var int
     */
    private $failures = 0;
    /**
     * @var int
     */
    private $assertions = 0;
    /**
     * @var float
     */
    private $beginimeTime;
    /**
     * @var float
     */
    private $time;
    /**
     * @var JunitXmlTestSuites
     */
    private $mainTestSuite = null;


    /**
     * Constructor
     *
     * @param JunitXmlTestSuite $mainTestSuite
     */
    public function __construct(JunitXmlTestSuite $mainTestSuite = null)
    {
        if ($mainTestSuite instanceof JunitXmlTestSuite) {
            $this->mainTestSuite = $mainTestSuite;
        }
        $this->beginimeTime = \microtime(true);
        $this->xmlTestSuite = new \DOMElement('testsuite');
    }


    /**
     * Add a test suite on a main TestSuite
     */
    public function addTestSuite()
    {
        $ts = new JunitXmlTestSuite($this);
        $this->xmlTestSuite->appendChild($ts->getXmlTestSuite());

        return $ts;
    }


    /**
     * Add test
     */
    public function addTest()
    {
        $this->incTest();

        $test = new JunitXmlTestCase($this);
        $this->xmlTestSuite->appendChild($test->getXmlTestCase());

        return $test;
    }


    /**
     * Finish test suite
     */
    public function finish()
    {
        // For a testsuite children of a testsuite
        if ($this->mainTestSuite instanceof JunitXmlTestSuite) {
            $this->mainTestSuite->incTest($this->tests);
            $this->mainTestSuite->incError($this->errors);
            $this->mainTestSuite->incFailures($this->failures);
        }

        $this->time = \microtime(true) - $this->beginimeTime;

        $this->xmlTestSuite->setAttribute('tests', $this->tests);
        $this->xmlTestSuite->setAttribute('errors', $this->errors);
        $this->xmlTestSuite->setAttribute('failures', $this->failures);
        $this->xmlTestSuite->setAttribute('time', $this->time);
    }


    /**
     * Set Name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;

        $this->xmlTestSuite->setAttribute('name', $this->name);
    }


    /**
     * Set file
     *
     * @param string $file
     */
    public function setFile($file)
    {
        $this->file = $file;

        $this->xmlTestSuite->setAttribute('file', $this->file);
    }


    /**
     * Increment test
     *
     * @param int $inc
     */
    public function incTest($inc = 1)
    {
        $this->tests += $inc;
    }


    /**
     * Increment errors
     *
     * @param int $inc
     */
    public function incError($inc = 1)
    {
        $this->errors += $inc;
    }


    /**
     * Increment failures
     *
     * @param int $inc
     */
    public function incFailures($inc = 1)
    {
        $this->failures += $inc;
    }


    /**
     * Increment failures
     *
     * @param int $inc
     */
    public function incAssertions($inc = 1)
    {
        $this->assertions += $inc;
    }


    /**
     * Get $xmlTestSuite
     *
     * @return DOMElement
     */
    public function getXmlTestSuite()
    {
        return $this->xmlTestSuite;
    }
}
