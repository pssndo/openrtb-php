<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\ResponseBuilder;

/**
 * @covers \OpenRTB\v3\Util\ResponseBuilder
 * @covers \OpenRTB\v3\Response
 */
class ResponseBuilderTest extends TestCase
{
    public function testFullResponseBuild(): void
    {
        $builder = new ResponseBuilder('req-123');

        $seatbid = new Seatbid();
        $seatbid->setSeat('test-seat');

        $bid = new Bid();
        $bid->setId('bid-456');
        $bid->setPrice(1.50);

        $media = new Media();
        $ad = new Ad();
        $ad->setId('ad-789');
        $media->setAd($ad);
        $bid->setMedia($media);

        $seatbid->addBid($bid);

        $builder
            ->setBidId('resp-abc')
            ->setCurrency('USD')
            ->setCdata('cdata-string')
            ->addSeatbid($seatbid);

        $response = $builder->build();

        // Assert that the returned object is a Response instance
        $this->assertInstanceOf(Response::class, $response);

        // Assert top-level properties
        $this->assertEquals('req-123', $response->getId());
        $this->assertEquals('resp-abc', $response->getBidid());
        $this->assertEquals('USD', $response->getCur());
        $this->assertEquals('cdata-string', $response->getCdata());

        // Assert nested seatbid and bid
        $responseSeatbids = $response->getSeatbid();
        $this->assertIsArray($responseSeatbids);
        $this->assertCount(1, $responseSeatbids);
        $responseSeatbid = $responseSeatbids[0];
        $this->assertEquals('test-seat', $responseSeatbid->getSeat());

        $responseBids = $responseSeatbid->getBid();
        $this->assertIsArray($responseBids);
        $this->assertCount(1, $responseBids);
        $responseBid = $responseBids[0];
        $this->assertEquals('bid-456', $responseBid->getId());
        $this->assertEquals(1.50, $responseBid->getPrice());

        $responseMedia = $responseBid->getMedia();
        $this->assertInstanceOf(Media::class, $responseMedia);
        $responseAd = $responseMedia->getAd();
        $this->assertInstanceOf(Ad::class, $responseAd);
        $this->assertEquals('ad-789', $responseAd->getId());

        // Assert builder proxy methods
        $json = $builder->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);
        $this->assertEquals($response->toArray(), $builder->toArray());
    }

    public function testBuildsNoBidResponseCorrectly(): void
    {
        $builder = new ResponseBuilder('req-123');

        $response = $builder
            ->setNoBidReason(NoBidReason::INVALID_REQUEST)
            ->build();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('req-123', $response->getId());
        $this->assertEquals(NoBidReason::INVALID_REQUEST, $response->getNbr());
        $this->assertNull($response->getSeatbid());
    }
}
