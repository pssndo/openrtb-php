<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Impression;

use PHPUnit\Framework\TestCase;
use OpenRTB\v26\Impression\Deal;
use OpenRTB\v26\Ext;

/**
 * @covers \OpenRTB\v26\Impression\Deal
 */
final class DealTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Deal::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('bidfloor', $schema);
        $this->assertEquals('float', $schema['bidfloor']);
        $this->assertArrayHasKey('bidfloorcur', $schema);
        $this->assertEquals('string', $schema['bidfloorcur']);
        $this->assertArrayHasKey('at', $schema);
        $this->assertEquals('int', $schema['at']);
        $this->assertArrayHasKey('wseat', $schema);
        $this->assertEquals('array', $schema['wseat']);
        $this->assertArrayHasKey('wadv', $schema);
        $this->assertEquals('array', $schema['wadv']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $deal = new Deal();
        $id = 'deal123';
        $deal->setId($id);
        $this->assertEquals($id, $deal->getId());
    }

    public function testGetId(): void
    {
        $deal = new Deal();
        $deal->setId('test_id');
        $this->assertEquals('test_id', $deal->getId());
    }

    public function testSetBidfloor(): void
    {
        $deal = new Deal();
        $bidfloor = 1.23;
        $deal->setBidfloor($bidfloor);
        $this->assertEquals($bidfloor, $deal->getBidfloor());
    }

    public function testGetBidfloor(): void
    {
        $deal = new Deal();
        $deal->setBidfloor(4.56);
        $this->assertEquals(4.56, $deal->getBidfloor());
    }

    public function testSetBidfloorcur(): void
    {
        $deal = new Deal();
        $bidfloorcur = 'USD';
        $deal->setBidfloorcur($bidfloorcur);
        $this->assertEquals($bidfloorcur, $deal->getBidfloorcur());
    }

    public function testGetBidfloorcur(): void
    {
        $deal = new Deal();
        $deal->setBidfloorcur('EUR');
        $this->assertEquals('EUR', $deal->getBidfloorcur());
    }

    public function testSetAt(): void
    {
        $deal = new Deal();
        $at = 1;
        $deal->setAt($at);
        $this->assertEquals($at, $deal->getAt());
    }

    public function testGetAt(): void
    {
        $deal = new Deal();
        $deal->setAt(2);
        $this->assertEquals(2, $deal->getAt());
    }

    public function testSetWseat(): void
    {
        $deal = new Deal();
        $wseat = ['seat1', 'seat2'];
        $deal->setWseat($wseat);
        $this->assertEquals($wseat, $deal->getWseat());
    }

    public function testGetWseat(): void
    {
        $deal = new Deal();
        $deal->setWseat(['seat3']);
        $this->assertEquals(['seat3'], $deal->getWseat());
    }

    public function testSetWadv(): void
    {
        $deal = new Deal();
        $wadv = ['adv1', 'adv2'];
        $deal->setWadv($wadv);
        $this->assertEquals($wadv, $deal->getWadv());
    }

    public function testGetWadv(): void
    {
        $deal = new Deal();
        $deal->setWadv(['adv3']);
        $this->assertEquals(['adv3'], $deal->getWadv());
    }

    public function testSetExt(): void
    {
        $deal = new Deal();
        $ext = new Ext();
        $deal->setExt($ext);
        $this->assertSame($ext, $deal->getExt());
    }

    public function testGetExt(): void
    {
        $deal = new Deal();
        $ext = new Ext();
        $deal->setExt($ext);
        $this->assertSame($ext, $deal->getExt());
    }
}
