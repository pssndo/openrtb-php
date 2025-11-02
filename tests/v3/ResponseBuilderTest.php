<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Title;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\BidResponse as Response;
use OpenRTB\v3\Util\Parser;
use OpenRTB\v3\Util\ResponseBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Util\ResponseBuilder
 * @covers \OpenRTB\v3\Util\Parser
 * @covers \OpenRTB\v3\BidResponse
 */
class ResponseBuilderTest extends TestCase
{
    public function testNoBidResponseBuild(): void
    {
        $builder = new ResponseBuilder('req-123');

        $response = $builder
            ->setBidId('bid-456')
            ->setNoBidReason(NoBidReason::TECHNICAL_ERROR)
            ->setCurrency('USD')();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('req-123', $response->getId());
        $this->assertEquals('bid-456', $response->getBidid());
        $this->assertEquals(NoBidReason::TECHNICAL_ERROR, $response->getNbr());
        $this->assertEquals('USD', $response->getCur());
        // Removed redundant assertIsArray(Response::getSchema());
    }

    public function testFullResponseBuild(): void
    {
        $builder = new ResponseBuilder('req-abc');

        $title = (new Title())->setText('Native Ad Title');
        $link = (new Link())->setUrl('https://example.com');
        $asset = (new Asset())->setId(1)->setTitle($title)->setLink($link);
        $native = (new NativeAd())->setAsset([$asset])->setLink($link);
        $ad = (new Ad())->setNative($native);
        $media = (new Media())->setAd($ad);
        $bid = (new Bid())
            ->setId('bid-1')
            ->setPrice(1.50)
            ->setMedia($media);

        $seatbid = (new Seatbid())
            ->setSeat('seat-1')
            ->addBid($bid);

        $response = $builder
            ->setBidId('bid-xyz')
            ->setCurrency('EUR')
            ->setCdata('custom-data')
            ->addSeatbid($seatbid)();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('req-abc', $response->getId());
        $this->assertEquals('bid-xyz', $response->getBidid());
        $this->assertEquals('EUR', $response->getCur());
        $this->assertEquals('custom-data', $response->getCdata());

        $seatbids = $response->getSeatbid();
        $this->assertIsArray($seatbids);
        $this->assertCount(1, $seatbids);
        $this->assertEquals('seat-1', $seatbids[0]->getSeat());

        // Test serialization on the built object
        $json = $response->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);
        $decoded = json_decode($json, true);

        // Complete the cycle by parsing the response back.
        $parsedResponse = Parser::parseBidResponse($json);
        $this->assertInstanceOf(Response::class, $parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());
    }
}
