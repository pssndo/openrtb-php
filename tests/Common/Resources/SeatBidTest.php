<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Bid;
use OpenRTB\Common\Resources\SeatBid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\SeatBid
 */
class SeatBidTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = SeatBid::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('seat', $schema);
        $this->assertEquals('string', $schema['seat']);
        $this->assertArrayHasKey('bid', $schema);
        $this->assertEquals([Bid::class], $schema['bid']);
    }

    public function testSetAndGetSeat(): void
    {
        $seatBid = new SeatBid();
        $seatBid->setSeat('seat-123');
        $this->assertEquals('seat-123', $seatBid->getSeat());
    }

    public function testSetAndGetBidWithArray(): void
    {
        $seatBid = new SeatBid();
        $bid1 = new Bid();
        $bid2 = new Bid();
        $seatBid->setBid([$bid1, $bid2]);

        $bids = $seatBid->getBid();
        $this->assertInstanceOf(Collection::class, $bids);
        $this->assertCount(2, $bids);
    }

    public function testSetAndGetBidWithCollection(): void
    {
        $seatBid = new SeatBid();
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);
        $seatBid->setBid($collection);

        $bids = $seatBid->getBid();
        $this->assertInstanceOf(Collection::class, $bids);
        $this->assertCount(2, $bids);
    }

    public function testGetBidReturnsNullByDefault(): void
    {
        $seatBid = new SeatBid();
        $this->assertNull($seatBid->getBid());
    }

    public function testGetBidReturnsCollectionWhenStoredAsArray(): void
    {
        $seatBid = new SeatBid();
        $bid = new Bid();

        // Manually set as array to test the array-to-collection conversion path
        $seatBid->set('bid', [$bid]);

        $bids = $seatBid->getBid();
        $this->assertInstanceOf(Collection::class, $bids);
        $this->assertCount(1, $bids);
    }

    public function testGetBidReturnsCollectionWhenStoredAsCollection(): void
    {
        $seatBid = new SeatBid();
        $bid = new Bid();
        $collection = new Collection([$bid], Bid::class);

        // Manually set as Collection
        $seatBid->set('bid', $collection);

        $bids = $seatBid->getBid();
        $this->assertInstanceOf(Collection::class, $bids);
        $this->assertSame($collection, $bids);
    }
}
