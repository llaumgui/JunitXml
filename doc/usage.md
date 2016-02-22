---
currentMenu: usage
---

# Usage
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