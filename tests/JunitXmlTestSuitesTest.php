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
 * The JunitXml class.
 */
class JunitXmlTestSuitesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test if the new JunitXmlTestSuites is good.
     *
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::__construct
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::getXml
     */
    public function testEmptyTestSuitesBuild()
    {
        $testSuites = new JunitXmlTestSuites();
        $resultXml = '<?xml version="1.0"?><testsuites/>';

        $this->assertXmlStringEqualsXmlString($testSuites->getXml(), $resultXml);
    }


    /**
     * Test if getXML return a string.
     *
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::__construct
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::getXml
     */
    public function testTestSuitesBuildXmlIsString()
    {
        $testSuites = new JunitXmlTestSuites();

        $this->assertTrue(is_string($testSuites->getXml()));
    }


    /**
     * Test if getXML return a string.
     *
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::__construct
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::getXml
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::addTestSuite
     */
    public function testSAddTestSuiteToTestSuites()
    {
        $testSuites = new JunitXmlTestSuites();
        $testSuites->addTestSuite();
        $testSuites->addTestSuite();

        $resultXml = '<?xml version="1.0"?><testsuites><testsuite/><testsuite/></testsuites>';

        $this->assertXmlStringEqualsXmlString($testSuites->getXml(), $resultXml);
    }
}
