<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Impression;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Impression\Metric;
use PHPUnit\Framework\TestCase;

class MetricTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Metric::getSchema();

        $this->assertArrayHasKey('type', $schema);
        $this->assertEquals('string', $schema['type']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }
}
