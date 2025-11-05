<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use OpenRTB\Common\Resources\Bid as CommonBid;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Deal;
use OpenRTB\v3\Bid\Macro;
use OpenRTB\v3\Bid\Media;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Bid
 */
final class BidTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Bid::getSchema();

        // Assertions for properties from CommonBid
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('price', $schema);
        $this->assertEquals('float', $schema['price']);

        // Assertions for properties unique to v3 Bid
        $this->assertArrayHasKey('media', $schema);
        $this->assertEquals(Media::class, $schema['media']);
        $this->assertArrayHasKey('deal', $schema);
        $this->assertEquals('string', $schema['deal']);
        $this->assertArrayHasKey('cid', $schema);
        $this->assertEquals('string', $schema['cid']);
        $this->assertArrayHasKey('tactic', $schema);
        $this->assertEquals('string', $schema['tactic']);
        $this->assertArrayHasKey('dealobj', $schema);
        $this->assertEquals(Deal::class, $schema['dealobj']);
        $this->assertArrayHasKey('macro', $schema);
        $this->assertEquals([Macro::class], $schema['macro']);
    }

    public function testSetId(): void
    {
        $bid = new Bid();
        $id = 'bid123';
        $bid->setId($id);
        $this->assertEquals($id, $bid->getId());
    }

    public function testGetId(): void
    {
        $bid = new Bid();
        $bid->setId('test_id');
        $this->assertEquals('test_id', $bid->getId());
    }

    public function testSetPrice(): void
    {
        $bid = new Bid();
        $price = 1.23;
        $bid->setPrice($price);
        $this->assertEquals($price, $bid->getPrice());
    }

    public function testGetPrice(): void
    {
        $bid = new Bid();
        $bid->setPrice(4.56);
        $this->assertEquals(4.56, $bid->getPrice());
    }

    public function testSetMedia(): void
    {
        $bid = new Bid();
        $media = new Media();
        $bid->setMedia($media);
        $this->assertSame($media, $bid->getMedia());
    }

    public function testGetMedia(): void
    {
        $bid = new Bid();
        $media = new Media();
        $bid->setMedia($media);
        $this->assertSame($media, $bid->getMedia());
    }

    public function testSetDeal(): void
    {
        $bid = new Bid();
        $dealId = 'deal-123';
        $bid->setDeal($dealId);
        $this->assertSame($dealId, $bid->getDeal());
    }

    public function testGetDeal(): void
    {
        $bid = new Bid();
        $dealId = 'deal-456';
        $bid->setDeal($dealId);
        $this->assertSame($dealId, $bid->getDeal());
    }

    public function testSetItem(): void
    {
        $bid = new Bid();
        $itemId = 'item-123';
        $bid->setItem($itemId);
        $this->assertEquals($itemId, $bid->getItem());
    }

    public function testGetItem(): void
    {
        $bid = new Bid();
        $itemId = 'item-456';
        $bid->setItem($itemId);
        $this->assertEquals($itemId, $bid->getItem());
    }

    public function testSetCid(): void
    {
        $bid = new Bid();
        $cid = 'campaign-123';
        $bid->setCid($cid);
        $this->assertEquals($cid, $bid->getCid());
    }

    public function testGetCid(): void
    {
        $bid = new Bid();
        $cid = 'campaign-456';
        $bid->setCid($cid);
        $this->assertEquals($cid, $bid->getCid());
    }

    public function testSetTactic(): void
    {
        $bid = new Bid();
        $tactic = 'retargeting';
        $bid->setTactic($tactic);
        $this->assertEquals($tactic, $bid->getTactic());
    }

    public function testGetTactic(): void
    {
        $bid = new Bid();
        $tactic = 'prospecting';
        $bid->setTactic($tactic);
        $this->assertEquals($tactic, $bid->getTactic());
    }

    public function testSetDealobj(): void
    {
        $bid = new Bid();
        $deal = new Deal();
        $bid->setDealobj($deal);
        $this->assertSame($deal, $bid->getDealobj());
    }

    public function testGetDealobj(): void
    {
        $bid = new Bid();
        $deal = new Deal();
        $bid->setDealobj($deal);
        $this->assertSame($deal, $bid->getDealobj());
    }

    public function testSetMacro(): void
    {
        $bid = new Bid();
        $macro = [new Macro()];
        $bid->setMacro($macro);
        $this->assertEquals($macro, $bid->getMacro());
    }

    public function testGetMacro(): void
    {
        $bid = new Bid();
        $macro = [new Macro()];
        $bid->setMacro($macro);
        $this->assertEquals($macro, $bid->getMacro());
    }
}
