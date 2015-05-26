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
 * The JunitXmlTestSuites class.
 *
 * Build a JunitXmlTestSuites object.
 */
class JunitXmlTestSuites
{
    /**
     * instance for singleton
     * @var spwUserProfile $instance
     */
    static private $instance = null;

    /**
     * @var DOMDocument
     */
    private $xml;
    /**
     * @var DOMElement
     */
    private $xmlTestSuites;

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        $this->xml = new \DOMDocument();
        $this->xmlTestSuites = new \DOMElement('testsuites');
        $this->xml->appendChild($this->xmlTestSuites);
    }


    /**
     * Add a test suite
     *
     */
    public function addTestSuite()
    {
        $ts = new JunitXmlTestSuite();
        $this->xmlTestSuites->appendChild($ts->getXmlTestSuite());

        return $ts;
    }


    /**
     * Get XML output
     *
     */
    public function getXml()
    {
        return $this->xml->saveXML();
    }
}
