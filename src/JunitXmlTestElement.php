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
     * @param string $name
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
     * Set the optional string attributes.
     *
     * @param array $attributes List of optionnals attributes.
     */
    protected function setOptionalStringElementAttribute(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (!empty($this->$attribute)) {
                $this->setElementAttribute($attribute, $this->$attribute);
            }
        }
    }


    /**
     * Set the optional integer attributes.
     *
     * @param array $attributes List of optionnals attributes.
     */
    protected function setOptionalIntElementAttribute(array $attributes)
    {
        foreach ($attributes as $attribute) {
            if (is_int($this->$attribute)) {
                $this->setElementAttribute($attribute, $this->$attribute);
            }
        }
    }


    /**
     * Increment the optional integer attributes.
     *
     * @param \Llaumgui\JunitXml\JunitXmlTestElement $parent     Parent element.
     * @param array                                  $attributes List of optionnals attributes.
     */
    protected function incParentElementAttribute(JunitXmlTestElement $parent, array $attributes)
    {
        foreach ($attributes as $attribute) {
            // With "s" VS whitout "s" fix
            $parentAttribute = $attribute;
            if ($attribute == 'failure' or $attribute == 'error') {
                $parentAttribute = $attribute . 's';
            }
            if (is_int($this->$attribute)) {
                call_user_func(array($parent, 'inc' . ucfirst($parentAttribute)), $this->$attribute);
            }
        }
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
