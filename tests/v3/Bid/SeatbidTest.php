<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Bid;

/**
 * @covers \OpenRTB\v3\Bid\Seatbid
 */
final class SeatbidTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Seatbid::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('seat', $schema);
        $this->assertEquals('string', $schema['seat']);
        $this->assertArrayHasKey('package', $schema);
        $this->assertEquals('int', $schema['package']);
        $this->assertArrayHasKey('bid', $schema);
        $this->assertEquals([Bid::class], $schema['bid']);
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
        $this->assertEquals([$bid1, $bid2], $seatbid->getBid());
    }

    public function testGetBid(): void
    {
        $seatbid = new Seatbid();
        $bid = new Bid();
        $seatbid->addBid($bid);
        $this->assertEquals([$bid], $seatbid->getBid());
    }
}
