<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use OpenRTB\v26\Util\BidResponseBuilder;
use OpenRTB\v26\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Util\BidResponseBuilder
 * @covers \OpenRTB\v26\BidResponse
 * @covers \OpenRTB\v26\Util\Parser
 */
class ResponseBuilderTest extends TestCase
{
    public function testFullBuildAndSerialization(): void
    {
        $bid = (new Bid())->setId('bid-1');
        // @phpstan-ignore-next-line - Collection covariance in tests
        $seatBid = (new SeatBid())->setSeat('seat-1')->setBid(new Collection([$bid], Bid::class));
        $ext = new Ext();

        $builder = new BidResponseBuilder('req-123');
        $response = $builder
            ->setBidId('resp-456')
            ->setCur('USD')
            ->setNbr(2)
            ->setExt($ext)
            ->addSeatBid($seatBid)
            ->build();

        $this->assertInstanceOf(BidResponse::class, $response);
        $this->assertEquals('req-123', $response->getId());
        $this->assertEquals('resp-456', $response->getBidid());
        $this->assertEquals('USD', $response->getCur());
        $this->assertEquals(2, $response->getNbr());
        $this->assertNotNull($response->getSeatbid());
        $this->assertCount(1, $response->getSeatbid());
        $this->assertSame($seatBid, $response->getSeatbid()[0]);
        $this->assertSame($ext, $response->getExt());

        $json = $response->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);

        $parser = new Parser();
        $parsedResponse = $parser->parseBidResponse($json);
        $this->assertNotNull($parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());
    }
}
