<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\Common\Resources\Bid as CommonBid;
use OpenRTB\Common\Collection;

/**
 * @covers \OpenRTB\v3\Bid\Seatbid
 */
final class SeatbidTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Seatbid::getSchema();

        // Assertions for properties from CommonSeatBid
        $this->assertArrayHasKey('seat', $schema);
        $this->assertEquals('string', $schema['seat']);
        $this->assertArrayHasKey('bid', $schema);
        $this->assertEquals([CommonBid::class], $schema['bid']);

        // Assertions for properties unique to v3 Seatbid
        $this->assertArrayHasKey('package', $schema);
        $this->assertEquals('int', $schema['package']);
    }

    public function testSetSeat(): void
    {
        $seatbid = new Seatbid();
        $seat = 'seat1';
        $seatbid->setSeat($seat);
        $this->assertEquals($seat, $seatbid->getSeat());
    }

    public function testGetSeat(): void
    {
        $seatbid = new Seatbid();
        $seatbid->setSeat('test_seat');
        $this->assertEquals('test_seat', $seatbid->getSeat());
    }

    public function testSetPackage(): void
    {
        $seatbid = new Seatbid();
        $package = 1;
        $seatbid->setPackage($package);
        $this->assertEquals($package, $seatbid->getPackage());
    }

    public function testGetPackage(): void
    {
        $seatbid = new Seatbid();
        $seatbid->setPackage(0);
        $this->assertEquals(0, $seatbid->getPackage());
    }

    public function testAddBid(): void
    {
        $seatbid = new Seatbid();
        $bid1 = new Bid();
        $bid2 = new Bid();
        $seatbid->addBid($bid1);
        $seatbid->addBid($bid2);
        $this->assertInstanceOf(Collection::class, $seatbid->getBid());
        $this->assertCount(2, $seatbid->getBid());
        $this->assertSame($bid1, $seatbid->getBid()->offsetGet(0));
        $this->assertSame($bid2, $seatbid->getBid()->offsetGet(1));
    }

    public function testGetBid(): void
    {
        $seatbid = new Seatbid();
        $bid = new Bid();
        $seatbid->addBid($bid);
        $this->assertInstanceOf(Collection::class, $seatbid->getBid());
        $this->assertCount(1, $seatbid->getBid());
        $this->assertSame($bid, $seatbid->getBid()[0]);
    }
}
