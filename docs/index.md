# JunitXml

[![PHP CI/CD](https://github.com/llaumgui/JunitXml/workflows/PHP%20CI/CD/badge.svg?branch=main)](https://github.com/llaumgui/JunitXml/actions?query=workflow%3A"PHP+CI%2FCD") [![GitHub license](https://img.shields.io/github/license/llaumgui/JunitXml.svg)](https://github.com/llaumgui/JunitXml/blob/main/LICENSE) [![PHP version](https://badge.fury.io/ph/llaumgui%2Fjunit-xml.svg)](https://packagist.org/packages/llaumgui/junit-xml)

PHP library for generate XML document in JUnit format.

## Installation

### Requirements

JunitXml requires PHP 5.5.9 or above on your machine.

### With Composer

With [composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx), you can add JunitXml as a dependency for a project with:

```bash
php composer.phar require llaumgui/junit-xml
```

## Usage

* Create a new *TestSuites*:

```php
$testSuites = new JunitXmlTestSuites('My testsuites');
```

* Add a *TestSuite* to the *TestSuites*:

```php
$testSuite1 = $testSuites->addTestSuite('My testsuite #1');
```

* Add a *TestCase* to the *TestSuite*:

```php
$test1 = $testSuite1->addTest('Check if blabla is good');
```

* Increment the *assertion* number of the *TestCase*:

```php
$test1->incAssertions();
```

* Mark test as *skipped*:

```php
$test1->addSkipped('Skipped because blabla.');
```

* Mark test in error:

```php
$test1->addError('Error message', 'error_type');
```

* Mark test as fail:

```php
$test1->addFailure('Fail message', 'fail_type');
```

* Finish and close test:

```php
$test1->finish();
```

* Finish and close TestSuite:

```php
$testSuite->finish();
```

* Finish, close and get XML of the TestSuites:

```php
$testSuites->getXml();
```

## Testing

JUnitXML provides the [JunitXml\JunitXmlValidation](http://llaumgui.github.io/JunitXml/apigen/class-Llaumgui.JunitXml.JunitXmlValidation.html) class. This class provides statics methods for:

* __validateXsdFromString:__ Validate a XML string with the Junit v4 XSD.
* __getTestableXmlOutput:__ Normalize the variants: time and timestamp.

### Example

```php
// Test file output format
$this->assertTrue(JunitXmlValidation::validateXsdFromString(
    file_get_content('junit.xml')
));

// Test file output content
$this->assertXmlStringEqualsXmlString(
    file_get_content('good_junit.xml'),
    JunitXmlValidation::getTestableXmlOutput(file_get_content('junit.xml')
);
```
