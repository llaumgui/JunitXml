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

/**
 * The JunitXml class.
 */
class JunitXmlTestSuiteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test adding testsuite to a testsuites.
     *
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::addTestSuite
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::__construct
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::setName
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::incTests
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::incErrors
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::incFailures
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::incDisabled
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::incSkipped
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::setId
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::setPackage
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::setHostname
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuite::finish
     */
    public function testJunitXmlTestSuiteGeneration()
    {
        // Test simple call
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites tests="0" time="0">'
            . '    <testsuite name="My simple testsuite test" tests="0" time="' . DEFAULT_TIME_VALUE . '" timestamp="' . DEFAULT_TIMESTAMP_VALUE . '"/>'
            . '</testsuites>';
        $testSuites = new JunitXmlTestSuites();
        $ts = $testSuites->addTestSuite('My simple testsuite test');
        $ts->finish();
        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString(
            $expectedXml,
            getTestableXmlOutput($actualXml),
            "XML generated for simple \"testsuite\" mismatch expected."
        );
        $this->assertTrue(validateXsdFromString($actualXml), "Unvalide XML generated for simple \"testsuite\".");


        // Test complexe call
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites tests="10" errors="9" failures="8" disabled="7" time="' . DEFAULT_TIME_VALUE . '">'
            . '    <testsuite name="My complexe testsuite test" hostname="' . gethostname() .'" tests="10"'
            . '        errors="9" failures="8" disabled="7" skipped="6" id="testsuiteid" package="packagename"'
            . '        time="' . DEFAULT_TIME_VALUE . '" timestamp="' . DEFAULT_TIMESTAMP_VALUE . '"/>'
            . '</testsuites>';
        $testSuites = new JunitXmlTestSuites();
        $ts = $testSuites->addTestSuite();
        $ts->setName('My complexe testsuite test');
        $ts->incTests(10);
        $ts->incErrors(9);
        $ts->incFailures(8);
        $ts->incDisabled(7);
        $ts->incSkipped(6);
        $ts->setId('testsuiteid');
        $ts->setPackage('packagename');
        $ts->setHostname(gethostname());
        $ts->finish();

        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, getTestableXmlOutput($actualXml), "XML generated for complexe \"testsuite\" mismatch expected.");
        $this->assertTrue(validateXsdFromString($actualXml), "Unvalide XML generated for complexe \"testsuite\".");
    }
}
