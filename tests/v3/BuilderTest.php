<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Context\App;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Context\Regs;
use OpenRTB\v3\Context\Restrictions;
use OpenRTB\v3\Context\Site;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Context\User;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Util\Parser;
use OpenRTB\v3\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Util\RequestBuilder
 * @covers \OpenRTB\Common\AbstractRequestBuilder
 * @covers \OpenRTB\v3\BidRequest
 */
class BuilderTest extends TestCase
{
    public function testMinimalRequestBuild(): void
    {
        $request = (new RequestBuilder())();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertNotNull($request->getId());
    }

    public function testSetTestWithInvalidValue(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value for test. Must be 0 or 1.');
        $builder = new RequestBuilder();
        $builder->setTest(2);
    }

    public function testFullRequestBuild(): void
    {
        $builder = new RequestBuilder();

        $context = (new Context())
            ->setSite(new Site())
            ->setApp(new App())
            ->setDevice(new Device())
            ->setUser(new User())
            ->setRegs(new Regs())
            ->setRestrictions(new Restrictions());

        $source = new Source();
        $item = new Item();
        $ext = new Ext();

        $request = $builder
            ->setId('req-123')
            ->setTest(1)
            ->setTmax(200)
            ->setAt(AuctionType::SECOND_PRICE)
            ->setCur(['USD'])
            ->setBseat(['seat-1'])
            ->setWseat(['seat-w-1'])
            ->setBadv(['badv1', 'badv2'])
            ->setBapp(['bapp1', 'bapp2'])
            ->setBcat(['bcat1', 'bcat2'])
            ->setCdata('cdata-val')
            ->setSource($source)
            ->setContext($context)
            ->addItem($item)
            ->setExt($ext)();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req-123', $request->getId());
        $this->assertEquals(1, $request->getTest());
        $this->assertEquals(200, $request->getTmax());
        $this->assertEquals(AuctionType::SECOND_PRICE, $request->getAt());
        $this->assertEquals(['USD'], $request->getCur()?->toArray());
        $this->assertEquals(['seat-1'], $request->getBseat()?->toArray());
        $this->assertEquals(['seat-w-1'], $request->getWseat()?->toArray());
        $this->assertEquals(['badv1', 'badv2'], $request->getBadv()?->toArray());
        $this->assertEquals(['bapp1', 'bapp2'], $request->getBapp()?->toArray());
        $this->assertEquals(['bcat1', 'bcat2'], $request->getBcat()?->toArray());
        $this->assertEquals('cdata-val', $request->getCdata());
        $this->assertSame($source, $request->getSource());
        $this->assertSame($context, $request->getContext());
        $this->assertNotNull($request->getItem());
        $this->assertCount(1, $request->getItem());
        $this->assertSame($item, $request->getItem()[0]);
        $this->assertSame($ext, $request->getExt());

        // Fix: Call toJson() on the built object, not the builder
        $json = $request->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);

        $decoded = json_decode($json, true);
        $this->assertIsArray($decoded);
        $this->assertEquals('req-123', $decoded['id']);
        $this->assertEquals(2, $decoded['at']); // Check enum value

        // Parse the request back to trigger lazy-loading getters
        $parsedRequest = Parser::parseBidRequest($json);
        $this->assertInstanceOf(Request::class, $parsedRequest);

        // These assertions will trigger the previously uncovered `is_array()` branches
        $this->assertInstanceOf(Collection::class, $parsedRequest->getWseat());
        $this->assertInstanceOf(Collection::class, $parsedRequest->getBseat());
        $this->assertInstanceOf(Collection::class, $parsedRequest->getBadv());
        $this->assertInstanceOf(Collection::class, $parsedRequest->getBapp());
        $this->assertInstanceOf(Collection::class, $parsedRequest->getBcat());
        $this->assertInstanceOf(Collection::class, $parsedRequest->getCur());
    }

    public function testSetWseatWithCollection(): void
    {
        // Test BidRequest directly (not through builder) to hit the Collection branch
        $request = new Request();
        $collection = new Collection(['seat1', 'seat2'], 'string');

        $request->setWseat($collection);

        $this->assertEquals(['seat1', 'seat2'], $request->getWseat()?->toArray());
    }

    public function testGetItemWithArrayValue(): void
    {
        // Test getItem when item is stored as a raw array
        $request = new Request();
        $item = new Item();

        // Set item as array directly (simulates parsed data)
        $request->set('item', [$item]);

        $result = $request->getItem();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }

    public function testGetItemReturnsNullWhenNotSet(): void
    {
        // Test getItem when item is not set
        $request = new Request();

        $result = $request->getItem();
        $this->assertNull($result);
    }
}
