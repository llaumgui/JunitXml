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
class JunitXmlTestSuitesTest extends PhpUnitHelper
{
    /**
     * Test JunitXmlTestSuites generation.
     */
    public function testJunitXmlTestSuitesConstructor()
    {
        // Test empty call
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites time="' . DEFAULT_TIME_VALUE . '" />';
        $testSuites = new JunitXmlTestSuites();
        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, self::getTestableXmlOutput($actualXml), "XML generated for \"testsuites\" without parameter mismatch expected.");
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for \"testsuites\" without parameter.");

        // Test call with param
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites name="J Unit !" time="' . DEFAULT_TIME_VALUE . '" />';
        $testSuites = new JunitXmlTestSuites('J Unit !');
        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, self::getTestableXmlOutput($actualXml), "XML generated for \"testsuites\" with parameter mismatch expected.");
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for \"testsuites\" without parameter.");
    }


    /**
     * Test JunitXmlTestSuites manipulation.
     *
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::__construct
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::getXml
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::finish
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::incTests
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::incFailures
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::incErrors
     * @covers            \Llaumgui\JunitXml\JunitXmlTestSuites::incDisabled
     */
    public function testJunitXmlTestSuitesInc()
    {
        // Test call with param & increments
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites name="J Unit !" disabled="2" errors="3" failures="4" tests="5" time="' . DEFAULT_TIME_VALUE . '" />';
        $testSuites = new JunitXmlTestSuites('J Unit !');
        $testSuites->incTests(5);
        $testSuites->incFailures(4);
        $testSuites->incErrors(3);
        $testSuites->incDisabled(2);
        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, self::getTestableXmlOutput($actualXml), "XML generated for \"testsuites\" with datas mismatch expected.");
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for \"testsuites\" with datas.");

        // Test call with param & increments
        $expectedXml = '<?xml version="1.0"?>'
            . '<testsuites failures="1" tests="0" time="0" />';
        $testSuites = new JunitXmlTestSuites();
        $testSuites->incTests(0);
        $testSuites->incFailures();
        $actualXml = $testSuites->getXml();

        $this->assertXmlStringEqualsXmlString($expectedXml, self::getTestableXmlOutput($actualXml), "XML generated for \"testsuites\" with special datas mismatch expected.");
        $this->assertTrue(JunitXmlValidation::validateXsdFromString($actualXml), "Unvalide XML generated for \"testsuites\" with special datas.");
    }
}
