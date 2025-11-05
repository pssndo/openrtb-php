<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Impression;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Format;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Impression\Banner
 */
final class BannerTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Banner::getSchema();

        // Removed redundant assertIsArray($schema);
        $this->assertArrayHasKey('format', $schema);
        $this->assertEquals([Format::class], $schema['format']);
        $this->assertArrayHasKey('w', $schema);
        $this->assertEquals('int', $schema['w']);
        $this->assertArrayHasKey('h', $schema);
        $this->assertEquals('int', $schema['h']);
        $this->assertArrayHasKey('pos', $schema);
        $this->assertEquals('int', $schema['pos']);
        $this->assertArrayHasKey('btype', $schema);
        $this->assertEquals('array', $schema['btype']);
        $this->assertArrayHasKey('battr', $schema);
        $this->assertEquals('array', $schema['battr']);
        $this->assertArrayHasKey('api', $schema);
        $this->assertEquals('array', $schema['api']);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('vcm', $schema);
        $this->assertEquals('int', $schema['vcm']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetFormat(): void
    {
        $banner = new Banner();
        $format = [new Format()];
        $banner->setFormat($format);
        $this->assertEquals($format, $banner->getFormat());
    }

    public function testGetFormat(): void
    {
        $banner = new Banner();
        $format = [new Format()];
        $banner->setFormat($format);
        $this->assertEquals($format, $banner->getFormat());
    }

    public function testSetW(): void
    {
        $banner = new Banner();
        $w = 300;
        $banner->setW($w);
        $this->assertEquals($w, $banner->getW());
    }

    public function testGetW(): void
    {
        $banner = new Banner();
        $banner->setW(320);
        $this->assertEquals(320, $banner->getW());
    }

    public function testSetH(): void
    {
        $banner = new Banner();
        $h = 250;
        $banner->setH($h);
        $this->assertEquals($h, $banner->getH());
    }

    public function testGetH(): void
    {
        $banner = new Banner();
        $banner->setH(50);
        $this->assertEquals(50, $banner->getH());
    }

    public function testSetPos(): void
    {
        $banner = new Banner();
        $pos = 1;
        $banner->setPos($pos);
        $this->assertEquals($pos, $banner->getPos());
    }

    public function testGetPos(): void
    {
        $banner = new Banner();
        $banner->setPos(7);
        $this->assertEquals(7, $banner->getPos());
    }

    public function testSetBtype(): void
    {
        $banner = new Banner();
        $btype = [1, 2];
        $banner->setBtype($btype);
        $this->assertEquals($btype, $banner->getBtype());
    }

    public function testGetBtype(): void
    {
        $banner = new Banner();
        $banner->setBtype([3]);
        $this->assertEquals([3], $banner->getBtype());
    }

    public function testSetBattr(): void
    {
        $banner = new Banner();
        $battr = [4, 5];
        $banner->setBattr($battr);
        $this->assertEquals($battr, $banner->getBattr());
    }

    public function testGetBattr(): void
    {
        $banner = new Banner();
        $banner->setBattr([6]);
        $this->assertEquals([6], $banner->getBattr());
    }

    public function testSetApi(): void
    {
        $banner = new Banner();
        $api = [1, 2];
        $banner->setApi($api);
        $this->assertEquals($api, $banner->getApi());
    }

    public function testGetApi(): void
    {
        $banner = new Banner();
        $banner->setApi([3]);
        $this->assertEquals([3], $banner->getApi());
    }

    public function testSetId(): void
    {
        $banner = new Banner();
        $id = 'banner1';
        $banner->setId($id);
        $this->assertEquals($id, $banner->getId());
    }

    public function testGetId(): void
    {
        $banner = new Banner();
        $banner->setId('banner2');
        $this->assertEquals('banner2', $banner->getId());
    }

    public function testSetVcm(): void
    {
        $banner = new Banner();
        $vcm = 1;
        $banner->setVcm($vcm);
        $this->assertEquals($vcm, $banner->getVcm());
    }

    public function testGetVcm(): void
    {
        $banner = new Banner();
        $banner->setVcm(0);
        $this->assertEquals(0, $banner->getVcm());
    }

    public function testSetExt(): void
    {
        $banner = new Banner();
        $ext = new Ext();
        $banner->setExt($ext);
        $this->assertSame($ext, $banner->getExt());
    }

    public function testGetExt(): void
    {
        $banner = new Banner();
        $ext = new Ext();
        $banner->setExt($ext);
        $this->assertSame($ext, $banner->getExt());
    }
}
