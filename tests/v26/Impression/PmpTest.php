<?php

namespace OpenRTB\Tests\v26\Impression;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Impression\Deal;
use OpenRTB\v26\Impression\Pmp;
use PHPUnit\Framework\TestCase;

class PmpTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Pmp::getSchema();

        $this->assertArrayHasKey('deals', $schema);
        $this->assertEquals([Deal::class], $schema['deals']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }
}