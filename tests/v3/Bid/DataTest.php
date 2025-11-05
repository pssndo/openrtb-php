<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use OpenRTB\v3\Bid\Data;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Data
 */
final class DataTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Data::getSchema();

        $this->assertArrayHasKey('value', $schema);
        $this->assertEquals('string', $schema['value']);
    }

    public function testSetValue(): void
    {
        $data = new Data();
        $value = 'test_value';
        $data->setValue($value);
        $this->assertEquals($value, $data->getValue());
    }

    public function testGetValue(): void
    {
        $data = new Data();
        $data->setValue('another_value');
        $this->assertEquals('another_value', $data->getValue());
    }

    public function testGetType(): void
    {
        $data = new Data();
        $this->assertNull($data->getType());
    }

    public function testSetType(): void
    {
        $data = new Data();
        $type = 1;
        $data->setType($type);
        $this->assertEquals($type, $data->getType());
    }

    public function testSchemaIncludesTypeField(): void
    {
        $schema = Data::getSchema();

        // Test that type field is in schema (REQUIRED field)
        $this->assertArrayHasKey('type', $schema);
        $this->assertEquals('int', $schema['type']);
    }
}
