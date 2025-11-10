<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\Response\Bid;
use OpenRTB\v25\Response\SeatBid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Response\Bid
 * @covers \OpenRTB\v25\Response\SeatBid
 */
class ResponseObjectsTest extends TestCase
{
    public function testBidGetSchema(): void
    {
        $schema = Bid::getSchema();
        /* @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testBidSetId(): void
    {
        $bid = (new Bid())->setId('bid-1');
        $this->assertEquals('bid-1', $bid->getId());
    }

    public function testBidSetImpid(): void
    {
        $bid = (new Bid())->setImpid('imp-1');
        $this->assertEquals('imp-1', $bid->getImpid());
    }

    public function testBidSetPrice(): void
    {
        $bid = (new Bid())->setPrice(2.50);
        $this->assertEquals(2.50, $bid->getPrice());
    }

    public function testBidSetAdid(): void
    {
        $bid = (new Bid())->setAdid('ad-123');
        $this->assertEquals('ad-123', $bid->getAdid());
    }

    public function testBidSetNurl(): void
    {
        $bid = (new Bid())->setNurl('http://win.url');
        $this->assertEquals('http://win.url', $bid->getNurl());
    }

    public function testBidSetBurl(): void
    {
        $bid = (new Bid())->setBurl('http://billing.url');
        $this->assertEquals('http://billing.url', $bid->getBurl());
    }

    public function testBidSetLurl(): void
    {
        $bid = (new Bid())->setLurl('http://loss.url');
        $this->assertEquals('http://loss.url', $bid->getLurl());
    }

    public function testBidSetAdm(): void
    {
        $bid = (new Bid())->setAdm('<creative>');
        $this->assertEquals('<creative>', $bid->getAdm());
    }

    public function testBidSetCrid(): void
    {
        $bid = (new Bid())->setCrid('creative-456');
        $this->assertEquals('creative-456', $bid->getCrid());
    }

    public function testBidSetDealid(): void
    {
        $bid = (new Bid())->setDealid('deal-789');
        $this->assertEquals('deal-789', $bid->getDealid());
    }

    public function testBidSetW(): void
    {
        $bid = (new Bid())->setW(300);
        $this->assertEquals(300, $bid->getW());
    }

    public function testBidSetH(): void
    {
        $bid = (new Bid())->setH(250);
        $this->assertEquals(250, $bid->getH());
    }

    public function testBidSetBundle(): void
    {
        $bid = (new Bid())->setBundle('com.app.bundle');
        $this->assertEquals('com.app.bundle', $bid->getBundle());
    }

    public function testBidSetIurl(): void
    {
        $bid = (new Bid())->setIurl('http://impression.url');
        $this->assertEquals('http://impression.url', $bid->getIurl());
    }

    public function testBidSetCid(): void
    {
        $bid = (new Bid())->setCid('campaign-111');
        $this->assertEquals('campaign-111', $bid->getCid());
    }

    public function testBidSetTactic(): void
    {
        $bid = (new Bid())->setTactic('tactic-222');
        $this->assertEquals('tactic-222', $bid->getTactic());
    }

    public function testBidSetApi(): void
    {
        $bid = (new Bid())->setApi(3);
        $this->assertEquals(3, $bid->getApi());
    }

    public function testBidSetProtocol(): void
    {
        $bid = (new Bid())->setProtocol(2);
        $this->assertEquals(2, $bid->getProtocol());
    }

    public function testBidSetQagmediarating(): void
    {
        $bid = (new Bid())->setQagmediarating(1);
        $this->assertEquals(1, $bid->getQagmediarating());
    }

    public function testBidSetAdomain(): void
    {
        $bid = (new Bid())->setAdomain(['advertiser.com']);
        $adomain = $bid->getAdomain();
        $this->assertEquals(['advertiser.com'], $adomain);
    }

    public function testBidSetCat(): void
    {
        $bid = (new Bid())->setCat(['IAB1', 'IAB2']);
        $cat = $bid->getCat();
        $this->assertEquals(['IAB1', 'IAB2'], $cat);
    }

    public function testBidSetExp(): void
    {
        $bid = (new Bid())->setExp(3600);
        $this->assertEquals(3600, $bid->getExp());
    }

    public function testBidSetExt(): void
    {
        $ext = new Ext();
        $bid = (new Bid())->setExt($ext);
        $this->assertSame($ext, $bid->getExt());
    }

    public function testBidSetAttr(): void
    {
        $bid = (new Bid())->setAttr([1, 2, 3]);
        $this->assertNotNull($bid->getAttr());
    }

    public function testBidGetAttr(): void
    {
        $bid = new Bid();
        $this->assertNull($bid->getAttr());
    }

    public function testSeatBidGetSchema(): void
    {
        $schema = SeatBid::getSchema();
        /* @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testSeatBidSetSeat(): void
    {
        $seatBid = (new SeatBid())->setSeat('seat-1');
        $this->assertEquals('seat-1', $seatBid->getSeat());
    }

    public function testSeatBidSetGroup(): void
    {
        $seatBid = (new SeatBid())->setGroup(1);
        $this->assertEquals(1, $seatBid->getGroup());
    }

    public function testSeatBidSetExt(): void
    {
        $ext = new Ext();
        $seatBid = (new SeatBid())->setExt($ext);
        $this->assertSame($ext, $seatBid->getExt());
    }
}
