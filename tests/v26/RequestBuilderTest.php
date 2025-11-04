<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Util\Parser;
use OpenRTB\v26\Util\RequestBuilder;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Util\RequestBuilder
 * @covers \OpenRTB\v26\Util\Parser
 * @covers \OpenRTB\v26\BidRequest
 * @covers \OpenRTB\v26\Impression\Imp
 * @covers \OpenRTB\v26\Impression\Banner
 * @covers \OpenRTB\v26\Context\Site
 * @covers \OpenRTB\v26\Context\App
 * @covers \OpenRTB\v26\Context\Device
 * @covers \OpenRTB\v26\Context\User
 * @covers \OpenRTB\v26\Context\Regs
 * @covers \OpenRTB\v26\Context\Source
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
            ->setSite($site) // Add site
            ->setDevice($device)
            ->setUser($user)
            ->setAt(AuctionType::FIRST_PRICE)
            ->setTmax(200)
            ->setWseat(['seat-1'])
            ->setBseat(['seat-2'])
            ->setAllimps(1)
            ->setCur(['USD'])
            ->setWlang(['en'])
            ->setWlangb(['en-US'])
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
        $this->assertEquals(['en-US'], $request->getWlangb()?->toArray());
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
        $this->assertNotNull($parsedRequest);
        $this->assertEquals($expectedArray, $parsedRequest->toArray());
    }
}
