<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\v26\Ext;
use OpenRTB\v26\Response\Bid;
use OpenRTB\v26\Response\SeatBid;
use PHPUnit\Framework\TestCase;

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
            ->setCrid('crid-val')
            ->setDealid('deal-1')
            ->setW(300)
            ->setH(250)
            ->setExt($ext);

        $this->assertEquals('bid-1', $bid->getId());
        $this->assertEquals('imp-1', $bid->getImpid());
        $this->assertEquals(1.50, $bid->getPrice());
        $this->assertEquals('ad-1', $bid->getAdid());
        $this->assertEquals('nurl-val', $bid->getNurl());
        $this->assertEquals('burl-val', $bid->getBurl());
        $this->assertEquals('lurl-val', $bid->getLurl());
        $this->assertEquals('adm-val', $bid->getAdm());
        $this->assertEquals('crid-val', $bid->getCrid());
        $this->assertEquals('deal-1', $bid->getDealid());
        $this->assertEquals(300, $bid->getW());
        $this->assertEquals(250, $bid->getH());
        $this->assertSame($ext, $bid->getExt());
        $this->assertIsArray(Bid::getSchema());
    }

    public function testSeatBidObject(): void
    {
        $bid = new Bid();
        $ext = new Ext();
        $seatBid = (new SeatBid())
            ->setBid([$bid])
            ->setSeat('seat-1')
            ->setGroup(1)
            ->setExt($ext);

        $this->assertEquals([$bid], $seatBid->getBid());
        $this->assertEquals('seat-1', $seatBid->getSeat());
        $this->assertEquals(1, $seatBid->getGroup());
        $this->assertSame($ext, $seatBid->getExt());
        $this->assertIsArray(SeatBid::getSchema());
    }
}