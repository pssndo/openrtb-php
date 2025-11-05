<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Geo;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Geo
 */
class GeoTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Geo::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('lat', $schema);
        $this->assertEquals('float', $schema['lat']);
        $this->assertArrayHasKey('lon', $schema);
        $this->assertEquals('float', $schema['lon']);
        $this->assertArrayHasKey('country', $schema);
        $this->assertEquals('string', $schema['country']);
        $this->assertArrayHasKey('region', $schema);
        $this->assertEquals('string', $schema['region']);
        $this->assertArrayHasKey('city', $schema);
        $this->assertEquals('string', $schema['city']);
        $this->assertArrayHasKey('zip', $schema);
        $this->assertEquals('string', $schema['zip']);
        $this->assertArrayHasKey('utcoffset', $schema);
        $this->assertEquals('int', $schema['utcoffset']);
    }

    public function testSetAndGetLat(): void
    {
        $geo = new Geo();
        $geo->setLat(37.7749);
        $this->assertEquals(37.7749, $geo->getLat());
    }

    public function testSetAndGetLon(): void
    {
        $geo = new Geo();
        $geo->setLon(-122.4194);
        $this->assertEquals(-122.4194, $geo->getLon());
    }

    public function testSetAndGetCountry(): void
    {
        $geo = new Geo();
        $geo->setCountry('USA');
        $this->assertEquals('USA', $geo->getCountry());
    }

    public function testSetAndGetRegion(): void
    {
        $geo = new Geo();
        $geo->setRegion('CA');
        $this->assertEquals('CA', $geo->getRegion());
    }

    public function testSetAndGetCity(): void
    {
        $geo = new Geo();
        $geo->setCity('San Francisco');
        $this->assertEquals('San Francisco', $geo->getCity());
    }

    public function testSetAndGetZip(): void
    {
        $geo = new Geo();
        $geo->setZip('94102');
        $this->assertEquals('94102', $geo->getZip());
    }

    public function testSetAndGetUtcoffset(): void
    {
        $geo = new Geo();
        $geo->setUtcoffset(-480);
        $this->assertEquals(-480, $geo->getUtcoffset());
    }

    public function testGetLatReturnsNullByDefault(): void
    {
        $geo = new Geo();
        $this->assertNull($geo->getLat());
    }

    public function testGetLonReturnsNullByDefault(): void
    {
        $geo = new Geo();
        $this->assertNull($geo->getLon());
    }
}
