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
        $imp = $request->getImp();
        $this->assertNotNull($imp);
        $this->assertCount(1, $imp);
    }

    public function testFullSerializationAndParsing(): void
    {
        $request = new BidRequest();
        $request->setId('test-req-full');

        $imp = new Imp();
        $imp->setId('imp-1');
        $request->addImp($imp);

        $json = $request->toJson();
        $this->assertIsString($json);

        $parser = new Parser();
        $parsedRequest = $parser->parseBidRequest($json);

        $this->assertInstanceOf(BidRequest::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());
    }

    public function testGetImpWithArrayValue(): void
    {
        $request = new BidRequest();
        $imp = new Imp();
        $imp->setId('imp-1');

        // Set imp as array directly (simulates parsed data)
        $request->set('imp', [$imp]);

        $result = $request->getImp();
        $this->assertNotNull($result);
        $this->assertCount(1, $result);
    }

    public function testGetWseatWithCollectionValue(): void
    {
        $request = new BidRequest();
        $collection = new \OpenRTB\Common\Collection(['seat-1', 'seat-2'], 'string');

        // Set wseat as Collection directly
        $request->set('wseat', $collection);

        $result = $request->getWseat();
        $this->assertSame($collection, $result);
    }

    public function testGetBseatWithCollectionValue(): void
    {
        $request = new BidRequest();
        $collection = new \OpenRTB\Common\Collection(['blocked-1', 'blocked-2'], 'string');

        // Set bseat as Collection directly
        $request->set('bseat', $collection);

        $result = $request->getBseat();
        $this->assertSame($collection, $result);
    }

    public function testGetCurReturnsNullWhenNotArray(): void
    {
        $request = new BidRequest();

        // Don't set cur, or set it to null
        $result = $request->getCur();
        $this->assertNull($result);
    }

    public function testAcatAndCattax(): void
    {
        $request = new BidRequest();
        $request->setAcat(['IAB1', 'IAB2-1', 'IAB3-5']);
        $request->setCattax(2);

        $acat = $request->getAcat();
        $this->assertNotNull($acat);
        $this->assertEquals(['IAB1', 'IAB2-1', 'IAB3-5'], $acat->toArray());
        $this->assertEquals(2, $request->getCattax());
    }

    public function testSetExt(): void
    {
        $request = new BidRequest();
        $ext = new \OpenRTB\Common\Resources\Ext();

        $request->setExt($ext);

        $this->assertSame($ext, $request->getExt());
    }
}
