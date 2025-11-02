<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Context\Geo;
use PHPUnit\Framework\TestCase;
use OpenRTB\Common\Resources\Geo as CommonGeo;

/**
 * @covers \OpenRTB\v26\Context\Geo
 */
final class GeoTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Geo::getSchema();

        // Assertions for properties from CommonGeo
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

        // Assertions for properties unique to v26 Geo
        $this->assertArrayHasKey('type', $schema);
        $this->assertEquals('int', $schema['type']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetLat(): void
    {
        $geo = new Geo();
        $lat = 12.34;
        $geo->setLat($lat);
        $this->assertEquals($lat, $geo->getLat());
    }

    public function testGetLat(): void
    {
        $geo = new Geo();
        $geo->setLat(56.78);
        $this->assertEquals(56.78, $geo->getLat());
    }

    public function testSetLon(): void
    {
        $geo = new Geo();
        $lon = 98.76;
        $geo->setLon($lon);
        $this->assertEquals($lon, $geo->getLon());
    }

    public function testGetLon(): void
    {
        $geo = new Geo();
        $geo->setLon(54.32);
        $this->assertEquals(54.32, $geo->getLon());
    }

    public function testSetType(): void
    {
        $geo = new Geo();
        $type = 1;
        $geo->setType($type);
        $this->assertEquals($type, $geo->getType());
    }

    public function testGetType(): void
    {
        $geo = new Geo();
        $geo->setType(2);
        $this->assertEquals(2, $geo->getType());
    }

    public function testSetCountry(): void
    {
        $geo = new Geo();
        $country = 'USA';
        $geo->setCountry($country);
        $this->assertEquals($country, $geo->getCountry());
    }

    public function testGetCountry(): void
    {
        $geo = new Geo();
        $geo->setCountry('CAN');
        $this->assertEquals('CAN', $geo->getCountry());
    }

    public function testSetRegion(): void
    {
        $geo = new Geo();
        $region = 'NY';
        $geo->setRegion($region);
        $this->assertEquals($region, $geo->getRegion());
    }

    public function testGetRegion(): void
    {
        $geo = new Geo();
        $geo->setRegion('CA');
        $this->assertEquals('CA', $geo->getRegion());
    }

    public function testSetCity(): void
    {
        $geo = new Geo();
        $city = 'New York';
        $geo->setCity($city);
        $this->assertEquals($city, $geo->getCity());
    }

    public function testGetCity(): void
    {
        $geo = new Geo();
        $geo->setCity('Los Angeles');
        $this->assertEquals('Los Angeles', $geo->getCity());
    }

    public function testSetZip(): void
    {
        $geo = new Geo();
        $zip = '10001';
        $geo->setZip($zip);
        $this->assertEquals($zip, $geo->getZip());
    }

    public function testGetZip(): void
    {
        $geo = new Geo();
        $geo->setZip('90210');
        $this->assertEquals('90210', $geo->getZip());
    }

    public function testSetUtcoffset(): void
    {
        $geo = new Geo();
        $utcoffset = -5;
        $geo->setUtcoffset($utcoffset);
        $this->assertEquals($utcoffset, $geo->getUtcoffset());
    }

    public function testGetUtcoffset(): void
    {
        $geo = new Geo();
        $geo->setUtcoffset(-8);
        $this->assertEquals(-8, $geo->getUtcoffset());
    }

    public function testSetExt(): void
    {
        $geo = new Geo();
        $ext = new Ext();
        $geo->setExt($ext);
        $this->assertSame($ext, $geo->getExt());
    }

    public function testGetExt(): void
    {
        $geo = new Geo();
        $ext = new Ext();
        $geo->setExt($ext);
        $this->assertSame($ext, $geo->getExt());
    }
}
