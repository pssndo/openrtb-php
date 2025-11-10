<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\BidRequest;
use OpenRTB\v25\Context\Device;
use OpenRTB\v25\Context\Site;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\BidRequest
 */
class BidRequestTest extends TestCase
{
    public function testMinimalBidRequest(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-123');

        $imp = new Imp();
        $imp->setId('imp-1');
        $request->addImp($imp);

        $this->assertEquals('test-req-123', $request->getId());
        $imps = $request->getImp();
        $this->assertNotNull($imps);
        $this->assertCount(1, $imps);
    }

    public function testFullBidRequestWithSite(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-full');
        $request->setTest(0);
        $request->setTmax(200);

        $site = new Site();
        $site->setId('site-123');
        $site->setDomain('example.com');
        $request->setSite($site);

        $device = new Device();
        $device->setUa('Mozilla/5.0...');
        $device->setIp('192.168.1.1');
        $request->setDevice($device);

        $banner = new Banner();
        $banner->setW(300);
        $banner->setH(250);

        $imp = new Imp();
        $imp->setId('imp-1');
        $imp->setBanner($banner);
        $imp->setBidfloor(1.5);
        $request->addImp($imp);

        $this->assertEquals('test-req-full', $request->getId());
        $this->assertEquals(0, $request->getTest());
        $this->assertEquals(200, $request->getTmax());
        $this->assertNotNull($request->getSite());
        $this->assertNotNull($request->getDevice());
        $this->assertEquals('site-123', $request->getSite()->getId());
    }

    public function testSerializationAndParsing(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-parse');

        $imp = new Imp();
        $imp->setId('imp-1');
        $request->addImp($imp);

        $json = $request->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);

        $parser = new Parser();
        $parsedRequest = $parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $parsedRequest);
        $this->assertEquals('test-req-parse', $parsedRequest->getId());
    }

    public function testBlocklists(): void
    {
        $request = new BidRequest();
        $request->setId('test-blocklists');

        $request->setBcat(['IAB25', 'IAB26']);
        $request->setBadv(['badvertiser.com', 'spam.com']);
        $request->setBapp(['com.bad.app']);

        $bcat = $request->getBcat();
        $this->assertNotNull($bcat);
        $this->assertCount(2, $bcat);

        $badv = $request->getBadv();
        $this->assertNotNull($badv);
        $this->assertCount(2, $badv);

        $bapp = $request->getBapp();
        $this->assertNotNull($bapp);
        $this->assertCount(1, $bapp);
    }

    public function testCurrencies(): void
    {
        $request = new BidRequest();
        $request->setId('test-currencies');

        $request->setCur(['USD', 'EUR']);

        $cur = $request->getCur();
        $this->assertNotNull($cur);
        $this->assertCount(2, $cur);
    }

    public function testGetImpReturnsCollection(): void
    {
        $request = new BidRequest();
        $request->setId('test-imp-collection');

        $imp1 = new Imp();
        $imp1->setId('imp-1');
        $imp2 = new Imp();
        $imp2->setId('imp-2');

        $collection = new Collection([$imp1, $imp2], Imp::class);
        $request->setImp($collection);

        $result = $request->getImp();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
    }

    public function testGetWseatWhenNull(): void
    {
        $request = new BidRequest();
        $request->setId('test-wseat-null');

        $this->assertNull($request->getWseat());
    }

    public function testGetBseatWhenNull(): void
    {
        $request = new BidRequest();
        $request->setId('test-bseat-null');

        $this->assertNull($request->getBseat());
    }

    public function testGetCurWhenNull(): void
    {
        $request = new BidRequest();
        $request->setId('test-cur-null');

        $this->assertNull($request->getCur());
    }

    public function testSetExt(): void
    {
        $ext = new Ext();
        $request = new BidRequest();
        $request->setId('test-ext');
        $request->setExt($ext);

        $this->assertSame($ext, $request->getExt());
    }

    public function testGetImpConvertsArrayToCollection(): void
    {
        $request = new BidRequest();
        $request->setId('test-imp-array');

        $imp = new Imp();
        $imp->setId('imp-1');

        // Use reflection to set imp as raw array (simulating parsed JSON data)
        $reflection = new \ReflectionClass($request);
        $dataProperty = $reflection->getProperty('data');
        $data = $dataProperty->getValue($request);
        $data->imp = [$imp]; // Set as array, not Collection
        $dataProperty->setValue($request, $data);

        // getImp should convert array to Collection
        $result = $request->getImp();
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
    }
}
