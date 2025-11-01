<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\BidRequest;
use OpenRTB\v26\Context\App;
use OpenRTB\v26\Context\Device;
use OpenRTB\v26\Context\Regs;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Source;
use OpenRTB\v26\Context\User;
use OpenRTB\v26\Enums\AuctionType;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Ext;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Util\RequestBuilder;
use OpenRTB\v26\Util\Parser;
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
            ->setExt($ext)
            ->build();

        $this->assertInstanceOf(BidRequest::class, $request);
        $this->assertEquals('req-123', $request->getId());
        $this->assertCount(1, $request->getImp());
        $this->assertSame($device, $request->getDevice());
        $this->assertSame($user, $request->getUser());
        $this->assertEquals(AuctionType::FIRST_PRICE, $request->getAt());
        $this->assertEquals(200, $request->getTmax());
        $this->assertEquals(['seat-1'], $request->getWseat());
        $this->assertEquals(['seat-2'], $request->getBseat());
        $this->assertEquals(1, $request->getAllimps());
        $this->assertEquals(['USD'], $request->getCur());
        $this->assertEquals(['en'], $request->getWlang());
        $this->assertEquals(['en-US'], $request->getWlangb());
        $this->assertEquals(['IAB1'], $request->getBcat());
        $this->assertEquals(['bad.com'], $request->getBadv());
        $this->assertEquals(['bad.app'], $request->getBapp());
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
        $this->assertJson($json);

        $parser = new Parser();
        $parsedRequest = $parser->parseBidRequest($json);
        $this->assertEquals($expectedArray, $parsedRequest->toArray());
    }
}