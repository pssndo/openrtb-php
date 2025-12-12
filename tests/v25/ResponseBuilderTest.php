<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;
use OpenRTB\v25\Util\BidResponseBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Util\BidResponseBuilder
 */
class ResponseBuilderTest extends TestCase
{
    public function testBuildMinimalResponse(): void
    {
        $builder = new BidResponseBuilder('req-123');
        $response = $builder();

        $this->assertInstanceOf(BidResponse::class, $response);
        $this->assertEquals('req-123', $response->getId());
    }

    public function testBuildResponseWithBidid(): void
    {
        $builder = new BidResponseBuilder('req-456');
        $response = $builder
            ->setBidid('bid-789')();

        /** @var BidResponse $response */
        $this->assertEquals('req-456', $response->getId());
        $this->assertEquals('bid-789', $response->getBidid());
    }

    public function testBuildResponseWithCurrency(): void
    {
        $builder = new BidResponseBuilder('req-111');
        $response = $builder
            ->setCur('EUR')();

        /** @var BidResponse $response */
        $this->assertEquals('EUR', $response->getCur());
    }

    public function testBuildResponseWithNoBidReason(): void
    {
        $builder = new BidResponseBuilder('req-222');
        $response = $builder
            ->setNbr(2)();

        /** @var BidResponse $response */
        $this->assertEquals(2, $response->getNbr());
    }

    public function testBuildResponseWithSeatBid(): void
    {
        $bid = (new Bid())
            ->setId('bid-1')
            ->setImpid('imp-1')
            ->setPrice(2.50);

        $seatBid = (new SeatBid())
            ->setSeat('seat-1')
            ->setBid([$bid]);

        $builder = new BidResponseBuilder('req-333');
        $response = $builder
            ->addSeatBid($seatBid)();

        /** @var BidResponse $response */
        $seatbids = $response->getSeatbid();
        $this->assertNotNull($seatbids);
        $this->assertCount(1, $seatbids);
    }

    public function testBuildResponseWithMultipleSeatBids(): void
    {
        $bid1 = (new Bid())->setId('bid-1')->setImpid('imp-1')->setPrice(1.0);
        $bid2 = (new Bid())->setId('bid-2')->setImpid('imp-2')->setPrice(2.0);

        $seatBid1 = (new SeatBid())->setSeat('seat-1')->setBid([$bid1]);
        $seatBid2 = (new SeatBid())->setSeat('seat-2')->setBid([$bid2]);

        $builder = new BidResponseBuilder('req-444');
        $response = $builder
            ->addSeatBid($seatBid1)
            ->addSeatBid($seatBid2)();

        /** @var BidResponse $response */
        $seatbids = $response->getSeatbid();
        $this->assertNotNull($seatbids);
        $this->assertCount(2, $seatbids);
    }

    public function testBuildCompleteResponse(): void
    {
        $bid = (new Bid())
            ->setId('bid-full')
            ->setImpid('imp-full')
            ->setPrice(3.50)
            ->setAdm('<creative>Full Ad</creative>')
            ->setCrid('creative-999')
            ->setW(300)
            ->setH(250);

        $seatBid = (new SeatBid())
            ->setSeat('seat-full')
            ->setBid([$bid])
            ->setGroup(0);

        $builder = new BidResponseBuilder('req-full');
        $response = $builder
            ->setBidid('bidid-full')
            ->setCur('USD')
            ->addSeatBid($seatBid)();

        /** @var BidResponse $response */
        $this->assertEquals('req-full', $response->getId());
        $this->assertEquals('bidid-full', $response->getBidid());
        $this->assertEquals('USD', $response->getCur());

        $seatbids = $response->getSeatbid();
        $this->assertNotNull($seatbids);
        $this->assertCount(1, $seatbids);
    }

    public function testBuildResponseWithExt(): void
    {
        $ext = new Ext();
        $builder = new BidResponseBuilder('req-555');
        $response = $builder
            ->setExt($ext)();

        /** @var BidResponse $response */
        $this->assertEquals('req-555', $response->getId());
        $this->assertSame($ext, $response->getExt());
    }
}
