<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Request;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\Parser;

/**
 * @covers \OpenRTB\v3\Util\Parser
 * @covers \OpenRTB\v3\Enums\HydrationType
 */
class ParserTest extends TestCase
{
    public function testParseRequest(): void
    {
        $json = <<<'JSON'
{
  "id": "test-request-123",
  "at": 2,
  "tmax": 150,
  "item": [
    {
      "id": "item-1"
    }
  ],
  "context": {
    "device": {
      "ip": "127.0.0.1"
    }
  }
}
JSON;

        $request = Parser::parseRequest($json);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('test-request-123', $request->getId());
        $this->assertEquals(AuctionType::SECOND_PRICE, $request->getAt());
        $this->assertEquals(150, $request->getTmax());

        $items = $request->getItem();
        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $this->assertEquals('item-1', $items[0]->getId());

        $this->assertNotNull($request->getContext());
        $this->assertNotNull($request->getContext()->getDevice());
        $this->assertEquals('127.0.0.1', $request->getContext()->getDevice()->getIp());
    }

    public function testParseInvalidRequestJson(): void
    {
        $json = '{"id": "test-request-123", "at": 2,}'; // Invalid JSON with trailing comma
        $request = Parser::parseRequest($json);
        $this->assertNull($request);
    }

    public function testParseResponse(): void
    {
        $json = <<<'JSON'
{
  "id": "req-123",
  "bidid": "resp-abc",
  "nbr": 2,
  "seatbid": []
}
JSON;

        $response = Parser::parseResponse($json);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('req-123', $response->getId());
        $this->assertEquals('resp-abc', $response->getBidid());
        $this->assertEquals(NoBidReason::INVALID_REQUEST, $response->getNbr());
        $this->assertIsArray($response->getSeatbid());
    }

    public function testParseInvalidResponseJson(): void
    {
        $json = '{"id": "req-123",,}'; // Invalid JSON
        $response = Parser::parseResponse($json);
        $this->assertNull($response);
    }
}
