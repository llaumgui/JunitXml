---
currentMenu: examples
---

# Example
* You can find an example in [JunitXmlTestCaseTest](https://github.com/llaumgui/JunitXml/blob/main/tests/JunitXmlTestCaseTest.php).
* You can also look at the [CheckToolsFramework](https://github.com/llaumgui/CheckToolsFramework) project for a full implementation of JunitXml:

```php
$checkTool = $this->getApplication()->getContainer()->get('ctf.checktool_bom');

// Init Junit log
$testSuites = new JunitXmlTestSuites('Check BOM.');
$testSuite = $testSuites->addTestSuite('Check BOM in files.');

// Find BOM in files in Finder
foreach ($this->getFinder() as $file) {
    $check = $checkTool->doCheck($file);

    // Create TestCase
    $testCase = $testSuite->addTest($check->getDescription());
    $testCase->setClassName($file->getRelativePathname());
    $testCase->incAssertions();

    if (!$check->getResult()) {
        $this->output->writeln($check->getDescription() . ': <error>Failed</error>');
        $testCase->addError($check->getMessage());
    } elseif ($check->getResult() && $this->output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
        $this->output->writeln($check->getDescription() . ': <info>Succeeded</info>');
    }
    $testCase->finish();
}
$testSuite->finish();

$this->writeOutput($testSuites->getXml());
```