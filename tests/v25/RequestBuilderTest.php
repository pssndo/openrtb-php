<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Context\App;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Regs;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Context\Source;
use OpenRTB\v25\Context\User;
use OpenRTB\v25\Enums\AuctionType;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Util\Parser;
use OpenRTB\v25\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Util\RequestBuilder
 * @covers \OpenRTB\v25\Util\Parser
 * @covers \OpenRTB\v25\BidRequest
 * @covers \OpenRTB\v25\Impression\Imp
 * @covers \OpenRTB\v25\Impression\Banner
 * @covers \OpenRTB\v25\Context\Site
 * @covers \OpenRTB\v25\Context\App
 * @covers \OpenRTB\v25\Context\Device
 * @covers \OpenRTB\v25\Context\User
 * @covers \OpenRTB\v25\Context\Regs
 * @covers \OpenRTB\v25\Context\Source
 */
class RequestBuilderTest extends TestCase
{
    public function testFullBuildAndSerialization(): void
    {
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $site = (new Site())->setId('site-1');
        $app = (new App())->setId('app-1');
        $device = (new Device())->setIp('127.0.0.1');
        $user = (new User())->setId('user-1');
        $regs = (new Regs())->setGdpr(1);
        $source = (new Source())->setTid('tid-1');
        $ext = new Ext();

        $builder = new RequestBuilder();

        $request = $builder
            ->setId('req-123')
            ->addImp($imp)
            ->setSite($site)
            ->setDevice($device)
            ->setUser($user)
            ->setAt(AuctionType::FIRST_PRICE)
            ->setTmax(200)
            ->setWseat(['seat-1'])
            ->setBseat(['seat-2'])
            ->setAllimps(1)
            ->setCur(['USD'])
            ->setWlang(['en'])
            ->setBcat(['IAB1'])
            ->setBadv(['bad.com'])
            ->setBapp(['bad.app'])
            ->setRegs($regs)
            ->setSource($source)
            ->setTest(true)
            ->setExt($ext)();

        $this->assertInstanceOf(BidRequest::class, $request);
        $this->assertEquals('req-123', $request->getId());

        $imp = $request->getImp();
        $this->assertNotNull($imp);
        $this->assertCount(1, $imp->toArray());

        $this->assertSame($device, $request->getDevice());
        $this->assertSame($user, $request->getUser());
        $this->assertEquals(AuctionType::FIRST_PRICE, $request->getAt());
        $this->assertEquals(200, $request->getTmax());

        $wseat = $request->getWseat();
        $this->assertNotNull($wseat);
        $this->assertEquals(['seat-1'], $wseat->toArray());
        $this->assertEquals(['seat-2'], $request->getBseat()?->toArray());
        $this->assertEquals(1, $request->getAllimps());
        $this->assertEquals(['USD'], $request->getCur()?->toArray());
        $this->assertEquals(['en'], $request->getWlang()?->toArray());
        $this->assertEquals(['IAB1'], $request->getBcat()?->toArray());
        $this->assertEquals(['bad.com'], $request->getBadv()?->toArray());
        $this->assertEquals(['bad.app'], $request->getBapp()?->toArray());
        $this->assertSame($regs, $request->getRegs());
        $this->assertSame($source, $request->getSource());
        $this->assertEquals(1, $request->getTest());
        $this->assertSame($ext, $request->getExt());
        $this->assertNotNull($request->getSite());

        // Now set the app and check that site is nullified
        $builder->setApp($app);
        $this->assertNotNull($request->getApp());
        $this->assertNull($request->getSite());

        $expectedArray = $request->toArray();

        $json = $request->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);

        $parser = new Parser();
        $parsedRequest = $parser->parseBidRequest($json);
        $this->assertEquals($expectedArray, $parsedRequest->toArray());
    }

    public function testBuilderWithMinimalRequest(): void
    {
        $builder = new RequestBuilder();
        $imp = (new Imp())->setId('imp-1')->setBanner(new Banner());

        $request = $builder
            ->setId('minimal-req')
            ->addImp($imp)();

        $this->assertInstanceOf(BidRequest::class, $request);
        $this->assertEquals('minimal-req', $request->getId());
        $imps = $request->getImp();
        $this->assertNotNull($imps);
        $this->assertCount(1, $imps);
    }

    public function testBuilderWithMultipleImpressions(): void
    {
        $builder = new RequestBuilder();
        $imp1 = (new Imp())->setId('imp-1')->setBanner(new Banner());
        $imp2 = (new Imp())->setId('imp-2')->setBanner(new Banner());
        $imp3 = (new Imp())->setId('imp-3')->setBanner(new Banner());

        $request = $builder
            ->setId('multi-imp-req')
            ->addImp($imp1)
            ->addImp($imp2)
            ->addImp($imp3)();

        $this->assertInstanceOf(BidRequest::class, $request);
        $imps = $request->getImp();
        $this->assertNotNull($imps);
        $this->assertCount(3, $imps);
    }

    public function testBuilderChaining(): void
    {
        $builder = new RequestBuilder();

        $result = $builder
            ->setId('chain-test')
            ->setTmax(100)
            ->setTest(false);

        // Builder should return itself for chaining
        $this->assertInstanceOf(RequestBuilder::class, $result);
    }
}
