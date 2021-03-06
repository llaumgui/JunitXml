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
 * The JunitXmlTestSuite class.
 *
 * Build a JunitXmlTestSuite object.
 */
class JunitXmlTestSuite extends JunitXmlTestElement
{
    /**
     * @var JunitXmlTestSuites
     */
    private $testSuites = null;
    /**
     * @var int
     */
    protected $tests = 0;
    /**
     * @var int
     */
    protected $failures;
    /**
     * @var int
     */
    protected $disabled;
    /**
     * @var int
     */
    protected $errors;
    /**
     * @var int
     */
    protected $skipped;
    /**
     * @var string
     */
    protected $timestamp;
    /**
     * @var string
     */
    protected $hostname;
    /**
     * @var string
     */
    protected $id;
    /**
     * @var string
     */
    protected $package;


    /**
     * Constructor.
     *
     * @param JunitXmlTestSuites The JunitXmlTestSuites.
     */
    public function __construct(JunitXmlTestSuites $testSuites)
    {
        $this->startTimer();
        $this->testSuites = $testSuites;
        $this->timestamp = date("c");

        $this->domElement = new \DOMElement('testsuite');
    }


    /**
     * Add testcase to testsuite.
     *
     * @param string $name Name of the testcase.
     * @return JunitXmlTestCase REturn the JunitXmlTestCase.
     */
    public function addTest($name = '')
    {
        $test = new JunitXmlTestCase($this);
        $this->domElement->appendChild($test->getXmlElement());
        $test->setName($name);

        return $test;
    }


    /**
     * Finish testsuite.
     */
    public function finish()
    {
        /*
         * Update JunitXmlTestSuites
         */
        $this->testSuites->incTests($this->tests);
        $this->incParentElementAttribute($this->testSuites, ['disabled', 'errors', 'failures']);

        /*
         * Update JunitXmlTestSuite
         */
        // Optional attributes
        $this->setOptionalStringElementAttribute(['timestamp', 'hostname', 'id', 'package']);
        $this->setOptionalIntElementAttribute(['disabled','errors','failures', 'skipped']);

        // Others attributes
        $this->setElementAttribute('name', $this->name);
        $this->setElementAttribute('tests', $this->tests);
        $this->setElementAttribute('time', $this->getExecTime());
    }


    /**
     * Increment tests.
     *
     * @param int $inc Increment.
     */
    public function incTests($inc = 1)
    {
        $this->tests += $inc;
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
     * Increment skipped.
     *
     * @param int $inc Increment.
     */
    public function incSkipped($inc = 1)
    {
        $this->skipped = (int) $this->skipped + $inc;
    }


    /**
     * Set testsuite id.
     *
     * @param string $id The testsuite id.
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Set package name.
     *
     * @param string $package The Package name.
     */
    public function setPackage($package)
    {
        $this->package = $package;
    }


    /**
     * Set hostname.
     *
     * @param string $hostname The hostname.
     */
    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
    }
}
