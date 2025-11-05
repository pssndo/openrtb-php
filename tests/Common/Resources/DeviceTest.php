<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Device;
use OpenRTB\Common\Resources\Geo;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Device
 */
class DeviceTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Device::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('ua', $schema);
        $this->assertEquals('string', $schema['ua']);
        $this->assertArrayHasKey('geo', $schema);
        $this->assertEquals(Geo::class, $schema['geo']);
        $this->assertArrayHasKey('ip', $schema);
        $this->assertEquals('string', $schema['ip']);
        $this->assertArrayHasKey('make', $schema);
        $this->assertEquals('string', $schema['make']);
        $this->assertArrayHasKey('model', $schema);
        $this->assertEquals('string', $schema['model']);
        $this->assertArrayHasKey('os', $schema);
        $this->assertEquals('string', $schema['os']);
        $this->assertArrayHasKey('osv', $schema);
        $this->assertEquals('string', $schema['osv']);
        $this->assertArrayHasKey('hwv', $schema);
        $this->assertEquals('string', $schema['hwv']);
        $this->assertArrayHasKey('w', $schema);
        $this->assertEquals('int', $schema['w']);
        $this->assertArrayHasKey('h', $schema);
        $this->assertEquals('int', $schema['h']);
        $this->assertArrayHasKey('js', $schema);
        $this->assertEquals('int', $schema['js']);
    }

    public function testSetAndGetUa(): void
    {
        $device = new Device();
        $device->setUa('Mozilla/5.0');
        $this->assertEquals('Mozilla/5.0', $device->getUa());
    }

    public function testSetAndGetGeo(): void
    {
        $device = new Device();
        $geo = new Geo();
        $device->setGeo($geo);
        $this->assertSame($geo, $device->getGeo());
    }

    public function testSetAndGetIp(): void
    {
        $device = new Device();
        $device->setIp('192.168.1.1');
        $this->assertEquals('192.168.1.1', $device->getIp());
    }

    public function testSetAndGetMake(): void
    {
        $device = new Device();
        $device->setMake('Apple');
        $this->assertEquals('Apple', $device->getMake());
    }

    public function testSetAndGetModel(): void
    {
        $device = new Device();
        $device->setModel('iPhone 12');
        $this->assertEquals('iPhone 12', $device->getModel());
    }

    public function testSetAndGetOs(): void
    {
        $device = new Device();
        $device->setOs('iOS');
        $this->assertEquals('iOS', $device->getOs());
    }

    public function testSetAndGetOsv(): void
    {
        $device = new Device();
        $device->setOsv('14.5');
        $this->assertEquals('14.5', $device->getOsv());
    }

    public function testSetAndGetHwv(): void
    {
        $device = new Device();
        $device->setHwv('A14');
        $this->assertEquals('A14', $device->getHwv());
    }

    public function testSetAndGetW(): void
    {
        $device = new Device();
        $device->setW(1920);
        $this->assertEquals(1920, $device->getW());
    }

    public function testSetAndGetH(): void
    {
        $device = new Device();
        $device->setH(1080);
        $this->assertEquals(1080, $device->getH());
    }

    public function testSetAndGetJs(): void
    {
        $device = new Device();
        $device->setJs(1);
        $this->assertEquals(1, $device->getJs());
    }

    public function testGetGeoReturnsNullByDefault(): void
    {
        $device = new Device();
        $this->assertNull($device->getGeo());
    }
}
