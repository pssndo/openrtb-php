<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

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
use OpenRTB\v3\Request;
use OpenRTB\v3\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Util\RequestBuilder
 * @covers \OpenRTB\Common\AbstractRequestBuilder
 * @covers \OpenRTB\v3\Request
 */
class BuilderTest extends TestCase
{
    public function testMinimalRequestBuild(): void
    {
        $builder = new RequestBuilder();
        $request = $builder->build();

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

        $request = $builder
            ->setId('req-123')
            ->setTest(1)
            ->setTmax(200)
            ->setAt(AuctionType::SECOND_PRICE)
            ->setCur(['USD'])
            ->setSeat(['seat-1'])
            ->setWseat(1)
            ->setCdata('cdata-val')
            ->setSource($source)
            ->setContext($context)
            ->addItem($item)
            ->build();

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req-123', $request->getId());
        $this->assertEquals(1, $request->getTest());
        $this->assertEquals(200, $request->getTmax());
        $this->assertEquals(AuctionType::SECOND_PRICE, $request->getAt());
        $this->assertEquals(['USD'], $request->getCur());
        $this->assertEquals(['seat-1'], $request->getSeat());
        $this->assertEquals(1, $request->getWseat());
        $this->assertEquals('cdata-val', $request->getCdata());
        $this->assertSame($source, $request->getSource());
        $this->assertSame($context, $request->getContext());
        $this->assertCount(1, $request->getItem());
        $this->assertSame($item, $request->getItem()[0]);

        // Fix: Call toJson() on the built object, not the builder
        $json = $request->toJson();
        $this->assertJson($json);

        $decoded = json_decode($json, true);
        $this->assertEquals('req-123', $decoded['id']);
        $this->assertEquals(2, $decoded['at']); // Check enum value

        // Cover the static schema method
        $this->assertIsArray(Request::getSchema());
    }
}