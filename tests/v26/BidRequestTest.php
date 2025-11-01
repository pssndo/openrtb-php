<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\BidRequest
 */
class BidRequestTest extends TestCase
{
    public function testMinimalBidRequest(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-123');
        $request->addImp(new Imp());

        $this->assertEquals('test-req-123', $request->getId());
        $this->assertCount(1, $request->getImp());
    }

    public function testFullSerializationAndParsing(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-full');

        $imp = new Imp();
        $imp->setId('imp-1');
        $request->addImp($imp);

        $json = $request->toJson();
        $this->assertJson($json);

        $parser = new Parser();
        $parsedRequest = $parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());
    }
}