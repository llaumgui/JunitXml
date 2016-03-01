---
currentMenu: testing
---

# Testing
JUnitXML provides the [JunitXml\JunitXmlValidation](http://llaumgui.github.io/JunitXml/apigen/class-Llaumgui.JunitXml.JunitXmlValidation.html) class. This class provides statics methods for:

* __validateXsdFromString:__ Validate a XML string with the Junit v4 XSD.
* __getTestableXmlOutput:__ Normalize the variants: time and timestamp.

## Example

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