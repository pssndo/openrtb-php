<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Metric;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Metric
 */
class MetricTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Metric::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('value', $schema);
        $this->assertEquals('float', $schema['value']);
        $this->assertArrayHasKey('vendor', $schema);
        $this->assertEquals('string', $schema['vendor']);
    }

    public function testSetAndGetValue(): void
    {
        $metric = new Metric();
        $metric->setValue(1.5);
        $this->assertEquals(1.5, $metric->getValue());
    }

    public function testSetAndGetVendor(): void
    {
        $metric = new Metric();
        $metric->setVendor('vendor-123');
        $this->assertEquals('vendor-123', $metric->getVendor());
    }

    public function testGetValueReturnsNullByDefault(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getValue());
    }

    public function testGetVendorReturnsNullByDefault(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getVendor());
    }
}
