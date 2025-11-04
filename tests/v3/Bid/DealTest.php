<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Deal;

/**
 * @covers \OpenRTB\v3\Bid\Deal
 */
final class DealTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Deal::getSchema();

        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('price', $schema);
        $this->assertEquals('float', $schema['price']);
        $this->assertArrayHasKey('wseat', $schema);
        $this->assertEquals('array', $schema['wseat']);
        $this->assertArrayHasKey('wadomain', $schema);
        $this->assertEquals('array', $schema['wadomain']);
        $this->assertArrayHasKey('at', $schema);
        $this->assertEquals('int', $schema['at']);
    }

    public function testSetId(): void
    {
        $deal = new Deal();
        $id = 'deal123';
        $deal->setId($id);
        $this->assertEquals($id, $deal->getId());
    }

    public function testGetId(): void
    {
        $deal = new Deal();
        $deal->setId('test_id');
        $this->assertEquals('test_id', $deal->getId());
    }

    public function testSetPrice(): void
    {
        $deal = new Deal();
        $price = 1.23;
        $deal->setPrice($price);
        $this->assertEquals($price, $deal->getPrice());
    }

    public function testGetPrice(): void
    {
        $deal = new Deal();
        $deal->setPrice(4.56);
        $this->assertEquals(4.56, $deal->getPrice());
    }

    public function testSetWseat(): void
    {
        $deal = new Deal();
        $wseat = ['seat1', 'seat2'];
        $deal->setWseat($wseat);
        $this->assertEquals($wseat, $deal->getWseat()?->toArray());
    }

    public function testGetWseat(): void
    {
        $deal = new Deal();
        $deal->setWseat(['seat3']);
        $this->assertEquals(['seat3'], $deal->getWseat()?->toArray());
    }

    public function testSetWadomain(): void
    {
        $deal = new Deal();
        $wadomain = ['domain1', 'domain2'];
        $deal->setWadomain($wadomain);
        $this->assertEquals($wadomain, $deal->getWadomain()?->toArray());
    }

    public function testGetWadomain(): void
    {
        $deal = new Deal();
        $deal->setWadomain(['domain3']);
        $this->assertEquals(['domain3'], $deal->getWadomain()?->toArray());
    }

    public function testSetAt(): void
    {
        $deal = new Deal();
        $at = 1;
        $deal->setAt($at);
        $at = $deal->getAt();
        $this->assertNotNull($at);
        $this->assertEquals(1, $at->value);
    }

    public function testGetAt(): void
    {
        $deal = new Deal();
        $deal->setAt(2);
        $at = $deal->getAt();
        $this->assertNotNull($at);
        $this->assertEquals(2, $at->value);
    }

    public function testGetAtWithEnumValue(): void
    {
        $deal = new Deal();
        // Directly set an AuctionType enum instance
        $deal->set('at', \OpenRTB\v3\Enums\AuctionType::FIRST_PRICE);
        $this->assertEquals(\OpenRTB\v3\Enums\AuctionType::FIRST_PRICE, $deal->getAt());
    }
}
