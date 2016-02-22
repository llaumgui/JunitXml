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

/**
 * Remove time in XML output.
 *
 * @param string $xml XML output.
 * @return string Modified XML output.
 */
function getTestableXmlOutput($xml)
{
    $xmlDocument = new \DOMDocument();
    $xmlDocument->loadXML($xml);

    // Reset time
    foreach ($xmlDocument->getElementsByTagName('testsuites') as $testsuites) {
            $testsuites->setAttribute('time', DEFAULT_TIME_VALUE);
    }
    foreach ($xmlDocument->getElementsByTagName('testsuite') as $testsuite) {
        $testsuite->setAttribute('time', DEFAULT_TIME_VALUE);
        if ($testsuite->hasAttribute('timestamp')) {
            $testsuite->setAttribute('timestamp', DEFAULT_TIMESTAMP_VALUE);
        }
    }
    foreach ($xmlDocument->getElementsByTagName('testcase') as $testcase) {
        $testcase->setAttribute('time', DEFAULT_TIME_VALUE);
    }

    return $xmlDocument->saveXML();
}

/**
 * Validate XML string with JUnit XSD.
 *
 * @param string $xml XML output.
 * @return boolean Is valide ?
 */
function validateXsdFromString($xml)
{
    $xmlDocument = new \DOMDocument();
    $xmlDocument->loadXML($xml);

    return $xmlDocument->schemaValidate(\JUNIT4_XSD_PATH);
}
