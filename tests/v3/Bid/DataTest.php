<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Data;

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
}
