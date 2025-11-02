<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Util;

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\BidResponse;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\AbstractParser
 * @covers \OpenRTB\v26\Util\Parser
 */
final class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new Parser();
    }

    public function testParseBidRequest(): void
    {
        $json = '{"id":"12345","imp":[],"at":1}';
        $request = $this->parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $request);
        $this->assertEquals('12345', $request->getId());
    }

    public function testParseBidResponse(): void
    {
        $json = '{"id":"67890","seatbid":[]}';
        $response = $this->parser->parseBidResponse($json);

        $this->assertInstanceOf(BidResponse::class, $response);
        $this->assertEquals('67890', $response->getId());
    }

    public function testParseBidRequestWithComplexData(): void
    {
        $json = '{
            "id": "123",
            "imp": [
                {
                    "id": "1",
                    "banner": {"w":300, "h":250}
                }
            ],
            "site": {"id":"456", "name":"testsite"},
            "user": {"id":"789", "yob":1980},
            "at": 1
        }';
        $request = $this->parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $request);
        $this->assertEquals('123', $request->getId());

        $imp = $request->getImp();
        $this->assertNotNull($imp);
        $this->assertCount(1, $imp);
        $this->assertEquals('1', $imp[0]->getId());

        $banner = $imp[0]->getBanner();
        $this->assertNotNull($banner);
        $this->assertEquals(300, $banner->getW());

        $site = $request->getSite();
        $this->assertNotNull($site);
        $this->assertEquals('testsite', $site->getName());

        $user = $request->getUser();
        $this->assertNotNull($user);
        $this->assertEquals(1980, $user->getYob());

        $this->assertEquals(AuctionType::FIRST_PRICE, $request->getAt());
    }

    public function testParseBidResponseWithComplexData(): void
    {
        $json = '{
            "id": "response1",
            "seatbid": [
                {
                    "seat": "seat1",
                    "bid": [
                        {
                            "id": "bid1",
                            "impid": "1",
                            "price": 1.23
                        }
                    ]
                }
            ]
        }';
        $response = $this->parser->parseBidResponse($json);

        $this->assertInstanceOf(BidResponse::class, $response);
        $this->assertEquals('response1', $response->getId());

        $seatbid = $response->getSeatbid();
        $this->assertNotNull($seatbid);
        $this->assertCount(1, $seatbid);
        $this->assertEquals('seat1', $seatbid[0]->getSeat());

        $bid = $seatbid[0]->getBid();
        $this->assertNotNull($bid);
        $this->assertCount(1, $bid);
        $this->assertEquals('bid1', $bid[0]->getId());
        $this->assertEquals(1.23, $bid[0]->getPrice());
    }

    public function testHydrateScalarValue(): void
    {
        $json = '{"id":"scalar_test"}';
        $request = $this->parser->parseBidRequest($json);
        $this->assertNotNull($request);
        $this->assertEquals('scalar_test', $request->getId());
    }

    public function testHydrateArrayOfScalars(): void
    {
        $json = '{"id":"array_scalar_test","wseat":["seat1","seat2"]}';
        $request = $this->parser->parseBidRequest($json);
        $this->assertNotNull($request);
        $this->assertEquals(['seat1', 'seat2'], $request->getWseat()->toArray());
    }
}
