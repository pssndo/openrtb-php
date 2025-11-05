<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Context;

use OpenRTB\Common\Resources\Source as CommonSource;
use OpenRTB\v3\Context\Source;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Context\Source
 */
final class SourceTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Source::getSchema();

        // Assertions for properties from CommonSource
        $this->assertArrayHasKey('tid', $schema);
        $this->assertEquals('string', $schema['tid']);

        // Assertions for properties unique to v3 Source
        $this->assertArrayHasKey('ts', $schema);
        $this->assertEquals('int', $schema['ts']);
        $this->assertArrayHasKey('ds', $schema);
        $this->assertEquals('string', $schema['ds']);
        $this->assertArrayHasKey('dsmap', $schema);
        $this->assertEquals('string', $schema['dsmap']);
    }

    public function testSetTid(): void
    {
        $source = new Source();
        $tid = 'test_tid';
        $source->setTid($tid);
        $this->assertEquals($tid, $source->getTid());
    }

    public function testGetTid(): void
    {
        $source = new Source();
        $source->setTid('test_tid');
        $this->assertEquals('test_tid', $source->getTid());
    }

    public function testSetTs(): void
    {
        $source = new Source();
        $ts = 123456789;
        $source->setTs($ts);
        $this->assertEquals($ts, $source->getTs());
    }

    public function testGetTs(): void
    {
        $source = new Source();
        $source->setTs(987654321);
        $this->assertEquals(987654321, $source->getTs());
    }

    public function testSetDs(): void
    {
        $source = new Source();
        $ds = 'test_ds';
        $source->setDs($ds);
        $this->assertEquals($ds, $source->getDs());
    }

    public function testGetDs(): void
    {
        $source = new Source();
        $source->setDs('another_ds');
        $this->assertEquals('another_ds', $source->getDs());
    }

    public function testSetDsmap(): void
    {
        $source = new Source();
        $dsmap = 'test_dsmap';
        $source->setDsmap($dsmap);
        $this->assertEquals($dsmap, $source->getDsmap());
    }

    public function testGetDsmap(): void
    {
        $source = new Source();
        $source->setDsmap('another_dsmap');
        $this->assertEquals('another_dsmap', $source->getDsmap());
    }
}
