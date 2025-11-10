<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\v25\BidRequest;
use OpenRTB\v25\BidResponse;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;
use OpenRTB\v25\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Util\Parser
 */
class ParserTest extends TestCase
{
    private Parser $parser;

    protected function setUp(): void
    {
        $this->parser = new Parser();
    }

    public function testParseBidRequest(): void
    {
        $request = new BidRequest();
        $request->setId('req-123');
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $request->addImp($imp);

        $json = $request->toJson();
        $parsed = $this->parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $parsed);
        $this->assertEquals('req-123', $parsed->getId());
    }

    public function testParseBidResponse(): void
    {
        $response = new BidResponse();
        $response->setId('resp-123');
        $response->setCur('USD');

        $json = $response->toJson();
        $parsed = $this->parser->parseBidResponse($json);

        $this->assertInstanceOf(BidResponse::class, $parsed);
        $this->assertEquals('resp-123', $parsed->getId());
        $this->assertEquals('USD', $parsed->getCur());
    }

    public function testParseBidRequestWithComplexData(): void
    {
        $request = new BidRequest();
        $request->setId('req-complex');
        $request->setTest(1);
        $request->setTmax(200);

        $imp = (new Imp())
            ->setId('imp-1')
            ->setBidfloor(1.50)
            ->setBidfloorcur('EUR')
            ->setSecure(1)
            ->setBanner((new Banner())->setW(300)->setH(250));

        $request->addImp($imp);

        $json = $request->toJson();
        $parsed = $this->parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $parsed);
        $this->assertEquals('req-complex', $parsed->getId());
        $this->assertEquals(1, $parsed->getTest());
        $this->assertEquals(200, $parsed->getTmax());

        $imps = $parsed->getImp();
        $this->assertNotNull($imps);
        $this->assertCount(1, $imps);
    }

    public function testParseBidResponseWithComplexData(): void
    {
        $response = new BidResponse();
        $response->setId('resp-complex');
        $response->setBidid('bid-id-123');
        $response->setCur('GBP');

        $bid = (new Bid())
            ->setId('bid-1')
            ->setImpid('imp-1')
            ->setPrice(2.50)
            ->setAdm('<creative>Ad</creative>')
            ->setCrid('creative-789')
            ->setW(300)
            ->setH(250);

        $seatBid = (new SeatBid())
            ->setSeat('seat-1')
            ->setBid([$bid])
            ->setGroup(0);

        $response->setSeatbid([$seatBid]);

        $json = $response->toJson();
        $parsed = $this->parser->parseBidResponse($json);

        $this->assertInstanceOf(BidResponse::class, $parsed);
        $this->assertEquals('resp-complex', $parsed->getId());
        $this->assertEquals('bid-id-123', $parsed->getBidid());
        $this->assertEquals('GBP', $parsed->getCur());

        $seatbids = $parsed->getSeatbid();
        $this->assertNotNull($seatbids);
        $this->assertCount(1, $seatbids);
    }

    public function testParseInvalidJson(): void
    {
        $this->expectException(\JsonException::class);
        $this->parser->parseBidRequest('invalid-json');
    }
}
