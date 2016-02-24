<?php
/*
 * This file is part of the JunitXml package.
 *
 * Copyright (C) 2015-2016 Guillaume Kulakowski <guillaume@kulakowski.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Llaumgui\JunitXml;

use Tests\Llaumgui\JunitXml\PhpUnitHelper;
use Llaumgui\JunitXml\JunitXmlTestSuites;
use Llaumgui\JunitXml\JunitXmlValidation;

/**
 * The JunitXml class.
 */
class JunitXmlTestSuiteTest extends PhpUnitHelper
{
    /**
     * Test adding testsuite to a testsuites.
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
            self::getTestableXmlOutput($actualXml),
            "XML generated for simple \"testsuite\" mismatch expected."
        );
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for simple \"testsuite\".");


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

        $this->assertXmlStringEqualsXmlString($expectedXml, self::getTestableXmlOutput($actualXml), "XML generated for complexe \"testsuite\" mismatch expected.");
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for complexe \"testsuite\".");
    }
}
