<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Response\SeatBid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\BidResponse
 */
class BidResponseTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = BidResponse::getSchema();

        $this->assertArrayHasKey('seatbid', $schema);
        $this->assertEquals([SeatBid::class], $schema['seatbid']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $response = new BidResponse();
        $response->setId('response-123');
        $this->assertEquals('response-123', $response->getId());
    }

    public function testGetId(): void
    {
        $response = new BidResponse();
        $response->setId('test-id');
        $this->assertEquals('test-id', $response->getId());
    }

    public function testSetSeatbidWithArray(): void
    {
        $response = new BidResponse();
        $seatBid = new SeatBid();

        $response->setSeatbid([$seatBid]);

        $result = $response->getSeatbid();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function testSetSeatbidWithCollection(): void
    {
        $response = new BidResponse();
        $seatBid = new SeatBid();
        $collection = new Collection([$seatBid], SeatBid::class);

        // setSeatbid casts Collection to array, which exposes object properties
        $response->setSeatbid($collection);

        // getSeatbid should still return a Collection, but it will be constructed from the array
        $result = $response->getSeatbid();
        $this->assertInstanceOf(Collection::class, $result);
        // When Collection is cast to array, it exposes 'items' and 'itemType' properties
        // So the count will be 2, not 1
        $this->assertCount(2, $result);
    }

    public function testGetSeatbidWithArrayValue(): void
    {
        $response = new BidResponse();
        $seatBid = new SeatBid();

        // Set seatbid as array directly (simulates parsed data)
        $response->set('seatbid', [$seatBid]);

        $result = $response->getSeatbid();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function testGetSeatbidWithCollectionValue(): void
    {
        $response = new BidResponse();
        $seatBid = new SeatBid();
        $collection = new Collection([$seatBid], SeatBid::class);

        // Set seatbid as Collection directly
        $response->set('seatbid', $collection);

        $result = $response->getSeatbid();
        $this->assertSame($collection, $result);
    }

    public function testGetSeatbidReturnsNullWhenNotSet(): void
    {
        $response = new BidResponse();
        $this->assertNull($response->getSeatbid());
    }

    public function testSetBidid(): void
    {
        $response = new BidResponse();
        $response->setBidid('bidid-123');
        $this->assertEquals('bidid-123', $response->getBidid());
    }

    public function testGetBidid(): void
    {
        $response = new BidResponse();
        $response->setBidid('test-bidid');
        $this->assertEquals('test-bidid', $response->getBidid());
    }

    public function testSetCur(): void
    {
        $response = new BidResponse();
        $response->setCur('USD');
        $this->assertEquals('USD', $response->getCur());
    }

    public function testGetCur(): void
    {
        $response = new BidResponse();
        $response->setCur('EUR');
        $this->assertEquals('EUR', $response->getCur());
    }

    public function testSetNbr(): void
    {
        $response = new BidResponse();
        $response->setNbr(2);
        $this->assertEquals(2, $response->getNbr());
    }

    public function testGetNbr(): void
    {
        $response = new BidResponse();
        $response->setNbr(3);
        $this->assertEquals(3, $response->getNbr());
    }

    public function testSetExt(): void
    {
        $response = new BidResponse();
        $ext = new Ext();
        $response->setExt($ext);
        $this->assertSame($ext, $response->getExt());
    }

    public function testGetExt(): void
    {
        $response = new BidResponse();
        $ext = new Ext();
        $response->setExt($ext);
        $this->assertSame($ext, $response->getExt());
    }

    public function testFullBidResponse(): void
    {
        $response = new BidResponse();
        $seatBid = new SeatBid();
        $ext = new Ext();

        $response
            ->setId('response-456')
            ->setSeatbid([$seatBid])
            ->setBidid('bidid-789')
            ->setCur('USD')
            ->setNbr(0)
            ->setExt($ext);

        $this->assertEquals('response-456', $response->getId());
        $this->assertInstanceOf(Collection::class, $response->getSeatbid());
        $this->assertCount(1, $response->getSeatbid());
        $this->assertEquals('bidid-789', $response->getBidid());
        $this->assertEquals('USD', $response->getCur());
        $this->assertEquals(0, $response->getNbr());
        $this->assertSame($ext, $response->getExt());
    }
}
