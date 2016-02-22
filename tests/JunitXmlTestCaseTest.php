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

use Llaumgui\JunitXml\JunitXmlTestSuites;

/**
 * The JunitXml class.
 */
class JunitXmlTestCaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test JunitXmlTestSuites generation.
     */
    public function testJunitXmlTestCaseGeneration()
    {
        $numberOfTestSuite = 3;
        $numberOfTestBySuite = 2;
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites name="Full tests !"'
            . '            tests="' . ($numberOfTestSuite * $numberOfTestBySuite) . '"'
            . '            failures="1"'
          //  . '            disabled="0"'
            . '            errors="1"'
            . '            time="' . DEFAULT_TIME_VALUE. '">'
            . '    <testsuite name="Test Suite #1" tests="' . $numberOfTestBySuite . '"'
            . '               skipped="0" failures="1" errors="0"'
            . '               time="' . DEFAULT_TIME_VALUE. '"'
            . '               timestamp="' . DEFAULT_TIMESTAMP_VALUE. '">'
            . '        <testcase assertions="1" name="Check if bla is bla on TS #1" time="0"/>'
            . '        <testcase assertions="2" status="Failed" name="Check if blabla is blabla on TS #1" time="0">'
            . '            <failure type="fatal fail">Fail</failure>'
            . '        </testcase>'
            . '    </testsuite>'
            . '    <testsuite name="Test Suite #2" tests="' . $numberOfTestBySuite . '"'
            . '               skipped="0" failures="0" errors="1"'
            . '               time="' . DEFAULT_TIME_VALUE. '"'
            . '               timestamp="' . DEFAULT_TIMESTAMP_VALUE. '">'
            . '        <testcase assertions="2" name="Check if bla is bla on TS #2" time="0"/>'
            . '        <testcase assertions="3" classname="JunitXmlTestCaseTest" name="Check if blabla is blabla on TS #2" time="0">'
            . '            <error type="fatal error">Error</error>'
            . '            <system-err>Error !</system-err>'
            . '        </testcase>'
            . '    </testsuite>'
            . '    <testsuite name="Test Suite #3" tests="' . $numberOfTestBySuite . '"'
            . '               skipped="1" failures="0" errors="0"'
            . '               time="' . DEFAULT_TIME_VALUE. '"'
            . '               timestamp="' . DEFAULT_TIMESTAMP_VALUE. '">'
            . '        <testcase assertions="3" name="Check if bla is bla on TS #3" time="0"/>'
            . '        <testcase assertions="4" name="Check if blabla is blabla on TS #3" time="0">'
            . '            <skipped>Skipped</skipped>'
            . '            <system-out>Output !</system-out>'
            . '        </testcase>'
            . '    </testsuite>'
            . '</testsuites>';

        $testSuites = new JunitXmlTestSuites('Full tests !');
        for ($i = 1; $i <= $numberOfTestSuite; $i++) {
            $testSuite = $testSuites->addTestSuite('Test Suite #' . $i);
            $test1 = $testSuite->addTest('Check if bla is bla on TS #' . $i);
            $test1->incAssertions($i);
            $test1->finish();

            $test2 = $testSuite->addTest('Check if blabla is blabla on TS #' . $i);
            $test2->incAssertions($i+1);
            switch ($i) {
                case 1:
                    $test2->addFailure('Fail', 'fatal fail');
                    $test2->setStatus('Failed');
                    break;
                case 2:
                    $test2->addError('Error', 'fatal error');
                    $test2->addStdErr('Error !');
                    $test2->setClassName('JunitXmlTestCaseTest');
                    break;
                case 3:
                    $test2->addSkipped('Skipped');
                    $test2->addStdOut('Output !');
                    break;
                default:
                    break;
            }
            $test2->finish();
            $testSuite->finish();
        }

        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, getTestableXmlOutput($actualXml), "XML generated for full mismatch expected.");
        $this->assertTrue(validateXsdFromString($actualXml), "Unvalide XML generated for full test.");
    }
}
