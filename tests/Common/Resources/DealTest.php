<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Deal;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Deal
 */
class DealTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Deal::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('flr', $schema);
        $this->assertEquals('float', $schema['flr']);
        $this->assertArrayHasKey('flrcur', $schema);
        $this->assertEquals('string', $schema['flrcur']);
        $this->assertArrayHasKey('wseat', $schema);
        $this->assertEquals(['string'], $schema['wseat']);
        $this->assertArrayHasKey('wadv', $schema);
        $this->assertEquals(['string'], $schema['wadv']);
    }

    public function testSetAndGetId(): void
    {
        $deal = new Deal();
        $deal->setId('deal-123');
        $this->assertEquals('deal-123', $deal->getId());
    }

    public function testSetAndGetFlr(): void
    {
        $deal = new Deal();
        $deal->setFlr(2.5);
        $this->assertEquals(2.5, $deal->getFlr());
    }

    public function testSetAndGetFlrcur(): void
    {
        $deal = new Deal();
        $deal->setFlrcur('USD');
        $this->assertEquals('USD', $deal->getFlrcur());
    }

    public function testSetAndGetWseatWithArray(): void
    {
        $deal = new Deal();
        $deal->setWseat(['seat1', 'seat2']);

        $wseat = $deal->getWseat();
        $this->assertInstanceOf(Collection::class, $wseat);
        $this->assertCount(2, $wseat);
    }

    public function testSetAndGetWseatWithCollection(): void
    {
        $deal = new Deal();
        $collection = new Collection(['seat1', 'seat2'], 'string');
        $deal->setWseat($collection);

        $wseat = $deal->getWseat();
        $this->assertInstanceOf(Collection::class, $wseat);
        $this->assertCount(2, $wseat);
    }

    public function testSetAndGetWadvWithArray(): void
    {
        $deal = new Deal();
        $deal->setWadv(['adv1', 'adv2']);

        $wadv = $deal->getWadv();
        $this->assertInstanceOf(Collection::class, $wadv);
        $this->assertCount(2, $wadv);
    }

    public function testSetAndGetWadvWithCollection(): void
    {
        $deal = new Deal();
        $collection = new Collection(['adv1', 'adv2'], 'string');
        $deal->setWadv($collection);

        $wadv = $deal->getWadv();
        $this->assertInstanceOf(Collection::class, $wadv);
        $this->assertCount(2, $wadv);
    }

    public function testGetWseatReturnsEmptyCollectionByDefault(): void
    {
        $deal = new Deal();
        $wseat = $deal->getWseat();
        $this->assertInstanceOf(Collection::class, $wseat);
        $this->assertCount(0, $wseat);
    }

    public function testGetWadvReturnsEmptyCollectionByDefault(): void
    {
        $deal = new Deal();
        $wadv = $deal->getWadv();
        $this->assertInstanceOf(Collection::class, $wadv);
        $this->assertCount(0, $wadv);
    }
}
