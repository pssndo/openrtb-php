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
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Ext;

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
            ->setExt($ext)
        ();


        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req-123', $request->getId());
        $this->assertEquals(1, $request->getTest());
        $this->assertEquals(200, $request->getTmax());
        $this->assertEquals(AuctionType::SECOND_PRICE, $request->getAt());
        $this->assertEquals(['USD'], $request->getCur());
        $this->assertEquals(['seat-1'], $request->getBseat());
        $this->assertEquals(['seat-w-1'], $request->getWseat());
        $this->assertEquals(['badv1', 'badv2'], $request->getBadv());
        $this->assertEquals(['bapp1', 'bapp2'], $request->getBapp());
        $this->assertEquals(['bcat1', 'bcat2'], $request->getBcat());
        $this->assertEquals('cdata-val', $request->getCdata());
        $this->assertSame($source, $request->getSource());
        $this->assertSame($context, $request->getContext());
        $this->assertCount(1, $request->getItem());
        $this->assertSame($item, $request->getItem()[0]);
        $this->assertSame($ext, $request->getExt());

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