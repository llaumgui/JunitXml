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
abstract class JunitXmlTestElement
{
    /**
     * @var DOMElement
     */
    protected $domElement;
    /**
     * @var float
     */
    protected $beginTime;
    /**
     * @var string
     */
    protected $name = '';
    /**
     * @var float
     */
    protected $time;


    /**
     * Start timer.
     */
    protected function startTimer()
    {
        $this->beginTime = \microtime(true);
    }


    /**
     * Get the TestElement execution time.
     *
     * @return string Execution timer.
     */
    protected function getExecTime()
    {
        return \microtime(true) - $this->beginTime;
    }


    /**
     * Set Name.
     *
     * @param string $name.
     */
    public function setName($name)
    {
        $this->name = $name;
    }


    /**
     * Set domElement attribute.
     *
     * @param string $attribute Name off the attribute.
     * @param string $value     Value of the attribute.
     */
    protected function setElementAttribute($attribute, $value)
    {
        $this->domElement->setAttribute($attribute, $value);
    }


    /**
     * Get $xmlTestSuite.
     *
     * @return DOMElement.
     */
    public function getXmlElement()
    {
        return $this->domElement;
    }
}
