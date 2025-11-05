<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Bid;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Bid
 */
class BidTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Bid::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('price', $schema);
        $this->assertEquals('float', $schema['price']);
    }

    public function testSetAndGetId(): void
    {
        $bid = new Bid();
        $bid->setId('bid-123');
        $this->assertEquals('bid-123', $bid->getId());
    }

    public function testSetAndGetPrice(): void
    {
        $bid = new Bid();
        $bid->setPrice(5.25);
        $this->assertEquals(5.25, $bid->getPrice());
    }

    public function testGetIdReturnsNullByDefault(): void
    {
        $bid = new Bid();
        $this->assertNull($bid->getId());
    }

    public function testGetPriceReturnsNullByDefault(): void
    {
        $bid = new Bid();
        $this->assertNull($bid->getPrice());
    }
}
