<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use PHPUnit\Framework\TestCase;
use OpenRTB\Common\Collection;

/**
 * @covers \OpenRTB\v26\Response\Bid
 * @covers \OpenRTB\v26\Response\SeatBid
 */
class ResponseObjectsTest extends TestCase
{
    public function testBidObject(): void
    {
        $ext = new Ext();
        $bid = (new Bid())
            ->setId('bid-1')
            ->setImpid('imp-1')
            ->setPrice(1.50)
            ->setAdid('ad-1')
            ->setNurl('nurl-val')
            ->setBurl('burl-val')
            ->setLurl('lurl-val')
            ->setAdm('adm-val')
            ->setAdomain(['example.com', 'advertiser.com'])
            ->setBundle('com.example.app')
            ->setIurl('https://example.com/image.jpg')
            ->setCid('campaign-123')
            ->setCrid('crid-val')
            ->setTactic('tactic-1')
            ->setCat(['IAB1', 'IAB2-1'])
            ->setAttr([1, 2, 3])
            ->setApi(5)
            ->setProtocol(2)
            ->setQagmediarating(1)
            ->setDealid('deal-1')
            ->setW(300)
            ->setH(250)
            ->setExp(3600)
            ->setExt($ext);

        $this->assertEquals('bid-1', $bid->getId());
        $this->assertEquals('imp-1', $bid->getImpid());
        $this->assertEquals(1.50, $bid->getPrice());
        $this->assertEquals('ad-1', $bid->getAdid());
        $this->assertEquals('nurl-val', $bid->getNurl());
        $this->assertEquals('burl-val', $bid->getBurl());
        $this->assertEquals('lurl-val', $bid->getLurl());
        $this->assertEquals('adm-val', $bid->getAdm());
        $this->assertEquals(['example.com', 'advertiser.com'], $bid->getAdomain());
        $this->assertEquals('com.example.app', $bid->getBundle());
        $this->assertEquals('https://example.com/image.jpg', $bid->getIurl());
        $this->assertEquals('campaign-123', $bid->getCid());
        $this->assertEquals('crid-val', $bid->getCrid());
        $this->assertEquals('tactic-1', $bid->getTactic());
        $this->assertEquals(['IAB1', 'IAB2-1'], $bid->getCat());
        $this->assertEquals([1, 2, 3], $bid->getAttr());
        $this->assertEquals(5, $bid->getApi());
        $this->assertEquals(2, $bid->getProtocol());
        $this->assertEquals(1, $bid->getQagmediarating());
        $this->assertEquals('deal-1', $bid->getDealid());
        $this->assertEquals(300, $bid->getW());
        $this->assertEquals(250, $bid->getH());
        $this->assertEquals(3600, $bid->getExp());
        $this->assertSame($ext, $bid->getExt());
    }

    public function testBidSerialization(): void
    {
        $bid = (new Bid())
            ->setId('bid-1')
            ->setImpid('imp-1')
            ->setPrice(1.50);

        $array = $bid->toArray();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($array);
        $this->assertEquals('bid-1', $array['id']);
        $this->assertEquals('imp-1', $array['impid']);
        $this->assertEquals(1.50, $array['price']);

        $json = $bid->toJson();
        $this->assertIsString($json);
        $this->assertJson($json);
    }

    public function testBidSchema(): void
    {
        $schema = Bid::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        // Test that schema is not empty and contains expected keys
        $this->assertNotEmpty($schema);
        $this->assertArrayHasKey('impid', $schema);
        $this->assertArrayHasKey('ext', $schema);
    }

    public function testSeatBidObject(): void
    {
        $bid = new Bid();
        $ext = new Ext();
        $seatBid = (new SeatBid())
            // @phpstan-ignore-next-line - Collection covariance in tests
            ->setBid(new Collection([$bid], Bid::class))
            ->setSeat('seat-1')
            ->setGroup(1)
            ->setExt($ext);

        $this->assertInstanceOf(Collection::class, $seatBid->getBid());
        $this->assertCount(1, $seatBid->getBid());
        $this->assertSame($bid, $seatBid->getBid()[0]);
        $this->assertEquals('seat-1', $seatBid->getSeat());
        $this->assertEquals(1, $seatBid->getGroup());
        $this->assertSame($ext, $seatBid->getExt());
    }
}
