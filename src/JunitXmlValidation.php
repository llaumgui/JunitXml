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
 * The JunitXmlTestCase class.
 *
 * Build a JunitXmlTestCase object.
 */
class JunitXmlValidation
{
    /**
     * Validate XML string with JUnit XSD.
     *
     * @param string $xml XML output.
     * @return boolean Is valide ?
     */
    public static function validateXsdFromString($xml)
    {
        $xmlDocument = new \DOMDocument();
        $xmlDocument->loadXML($xml);

        return $xmlDocument->schemaValidate(__DIR__ . '/Resources/junit-4.xsd');
    }


    /**
     * Remove time in XML output.
     *
     * @param string $xml XML output.
     * @return string Modified XML output.
     */
    public static function getTestableXmlOutput($xml)
    {
        $xmlDocument = new \DOMDocument();
        $xmlDocument->loadXML($xml);

        // Reset time
        foreach ($xmlDocument->getElementsByTagName('testsuites') as $testsuites) {
                $testsuites->setAttribute('time', '0');
        }
        foreach ($xmlDocument->getElementsByTagName('testsuite') as $testsuite) {
            $testsuite->setAttribute('time', '0');
            if ($testsuite->hasAttribute('timestamp')) {
                $testsuite->setAttribute('timestamp', '2015-05-21T09:30:00+02:00');
            }
        }
        foreach ($xmlDocument->getElementsByTagName('testcase') as $testcase) {
            $testcase->setAttribute('time', '0');
        }

        return $xmlDocument->saveXML();
    }
}
