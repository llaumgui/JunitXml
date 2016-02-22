# JunitXml
[![Build Status branch master](https://travis-ci.org/llaumgui/JunitXml.svg?branch=master)](https://travis-ci.org/llaumgui/JunitXml) [![Code Climate](https://codeclimate.com/github/llaumgui/JunitXml/badges/gpa.svg)](https://codeclimate.com/github/llaumgui/JunitXml) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/ce42ebfd-027c-438e-bd0c-44ecf807d473/mini.png)](https://insight.sensiolabs.com/projects/ce42ebfd-027c-438e-bd0c-44ecf807d473) [![Test Coverage](https://codeclimate.com/github/llaumgui/JunitXml/badges/coverage.svg)](https://codeclimate.com/github/llaumgui/JunitXml/coverage) [![PHP version](https://badge.fury.io/ph/llaumgui%2Fjunit-xml.svg)](https://packagist.org/packages/llaumgui/junit-xml)

PHP library for generate XML document in JUnit format.


## Installation
~~~php
composer require 'llaumgui/junit-xml:dev-master'
~~~


## API documentation
See [JunitXml API Documentation](https://llaumgui.github.io/JunitXml/).


## Usage
* Create a new *TestSuites*:
~~~php
$testSuites = new JunitXmlTestSuites('My testsuites');
~~~
* Add a *TestSuite* to the *TestSuites*:
~~~php
$testSuite1 = $testSuites->addTestSuite('My testsuite #1');
~~~
* Add a *TestCase* to the *TestSuite*:
~~~php
$test1 = $testSuite1->addTest('Check if blabla is good');
~~~
* Increment the *assertion* number of the *TestCase*:
~~~php
$test1->incAssertions();
~~~
* Mark test as *skipped*:
~~~php
$test1->addSkipped('Skipped because blabla.');
~~~
* Mark test in error:
~~~php
$test1->addError('Error message', 'error_type');
~~~
* Mark test as fail:
~~~php
$test1->addFailure('Fail message', 'fail_type');
~~~
* Finish and close test:
~~~php
$test1->finish();
~~~
* Finish and close TestSuite:
~~~php
$testSuite->finish();
~~~
* Finish, close and get XML of the TestSuites:
~~~php
$testSuites->getXml();
~~~

* For full documentation: see [JunitXml API Documentation](https://llaumgui.github.io/JunitXml/)
* For full exemple: see  [tests/JunitXmlTestCaseTest.php](https://github.com/llaumgui/JunitXml/blob/master/tests/JunitXmlTestCaseTest.php)


## License
Released under the [MIT license](http://www.opensource.org/licenses/MIT).

