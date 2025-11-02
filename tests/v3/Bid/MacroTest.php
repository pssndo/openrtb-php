<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Macro;

/**
 * @covers \OpenRTB\v3\Bid\Macro
 */
final class MacroTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Macro::getSchema();

        $this->assertArrayHasKey('key', $schema);
        $this->assertEquals('string', $schema['key']);
        $this->assertArrayHasKey('value', $schema);
        $this->assertEquals('string', $schema['value']);
    }

    public function testSetKey(): void
    {
        $macro = new Macro();
        $key = 'MACRO_KEY';
        $macro->setKey($key);
        $this->assertEquals($key, $macro->getKey());
    }

    public function testSetValue(): void
    {
        $macro = new Macro();
        $value = 'MACRO_VALUE';
        $macro->setValue($value);
        $this->assertEquals($value, $macro->getValue());
    }

    public function testGetKey(): void
    {
        $macro = new Macro();
        $macro->setKey('TEST_KEY');
        $this->assertEquals('TEST_KEY', $macro->getKey());
    }

    public function testGetValue(): void
    {
        $macro = new Macro();
        $macro->setValue('TEST_VALUE');
        $this->assertEquals('TEST_VALUE', $macro->getValue());
    }
}
