<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\BidResponse
 */
class BidResponseTest extends TestCase
{
    public function testMinimalBidResponse(): void
    {
        $response = new BidResponse();
        $response->setId('test-resp-123');

        $this->assertEquals('test-resp-123', $response->getId());
    }

    public function testBidResponseWithBids(): void
    {
        $response = new BidResponse();
        $response->setId('test-resp-full');
        $response->setCur('USD');

        $bid = new Bid();
        $bid->setId('bid-1');
        $bid->setImpid('imp-1');
        $bid->setPrice(2.5);
        $bid->setAdm('<div>Ad markup</div>');
        $bid->setAdomain(['advertiser.com']);

        $seatBid = new SeatBid();
        $seatBid->setBid([$bid]);
        $seatBid->setSeat('seat-123');

        $response->setSeatbid([$seatBid]);

        $this->assertEquals('test-resp-full', $response->getId());
        $this->assertEquals('USD', $response->getCur());

        $seatBids = $response->getSeatbid();
        $this->assertNotNull($seatBids);
        $this->assertCount(1, $seatBids);
    }

    public function testNoBidResponse(): void
    {
        $response = new BidResponse();
        $response->setId('test-no-bid');
        $response->setNbr(1); // Technical error

        $this->assertEquals('test-no-bid', $response->getId());
        $this->assertEquals(1, $response->getNbr());
    }

    public function testSerialization(): void
    {
        $response = new BidResponse();
        $response->setId('test-serialize');
        $response->setCur('EUR');
        $response->setBidid('bidid-123');

        $json = $response->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);

        $decoded = json_decode($json, true);
        $this->assertEquals('test-serialize', $decoded['id']);
        $this->assertEquals('EUR', $decoded['cur']);
        $this->assertEquals('bidid-123', $decoded['bidid']);
    }

    public function testGetSchema(): void
    {
        $schema = BidResponse::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testGetBidid(): void
    {
        $response = new BidResponse();
        $response->setId('test-resp');
        $response->setBidid('bidid-456');

        $this->assertEquals('bidid-456', $response->getBidid());
    }

    public function testSetExt(): void
    {
        $ext = new Ext();
        $response = new BidResponse();
        $response->setId('test-resp');
        $response->setExt($ext);

        $this->assertSame($ext, $response->getExt());
    }

    public function testGetExt(): void
    {
        $response = new BidResponse();
        $this->assertNull($response->getExt());
    }

    public function testGetSeatbidWhenNull(): void
    {
        $response = new BidResponse();
        $response->setId('test-resp');

        $this->assertNull($response->getSeatbid());
    }
}
