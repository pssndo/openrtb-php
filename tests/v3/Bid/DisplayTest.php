<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Display\Native;

/**
 * @covers \OpenRTB\v3\Bid\Display
 */
final class DisplayTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Display::getSchema();

        $this->assertArrayHasKey('banner', $schema);
        $this->assertEquals(Banner::class, $schema['banner']);
        $this->assertArrayHasKey('native', $schema);
        $this->assertEquals(Native::class, $schema['native']);
    }

    public function testSetBanner(): void
    {
        $display = new Display();
        $banner = new Banner();
        $display->setBanner($banner);
        $this->assertSame($banner, $display->getBanner());
    }

    public function testGetBanner(): void
    {
        $display = new Display();
        $banner = new Banner();
        $display->setBanner($banner);
        $this->assertSame($banner, $display->getBanner());
    }

    public function testSetNative(): void
    {
        $display = new Display();
        $native = new Native();
        $display->setNative($native);
        $this->assertSame($native, $display->getNative());
    }

    public function testGetNative(): void
    {
        $display = new Display();
        $native = new Native();
        $display->setNative($native);
        $this->assertSame($native, $display->getNative());
    }

    public function testGetMime(): void
    {
        $display = new Display();
        $this->assertNull($display->getMime());
    }

    public function testSetMime(): void
    {
        $display = new Display();
        $mime = 'text/html';
        $display->setMime($mime);
        $this->assertEquals($mime, $display->getMime());
    }

    public function testGetApi(): void
    {
        $display = new Display();
        $this->assertNull($display->getApi());
    }

    public function testSetApi(): void
    {
        $display = new Display();
        $api = [\OpenRTB\v3\Enums\Placement\ApiFramework::VPAID_1];
        $display->setApi($api);
        $this->assertEquals($api, $display->getApi());
    }

    public function testGetCtype(): void
    {
        $display = new Display();
        $this->assertNull($display->getCtype());
    }

    public function testSetCtype(): void
    {
        $display = new Display();
        $ctype = 1;
        $display->setCtype($ctype);
        $this->assertEquals($ctype, $display->getCtype());
    }

    public function testGetW(): void
    {
        $display = new Display();
        $this->assertNull($display->getW());
    }

    public function testSetW(): void
    {
        $display = new Display();
        $w = 300;
        $display->setW($w);
        $this->assertEquals($w, $display->getW());
    }

    public function testGetH(): void
    {
        $display = new Display();
        $this->assertNull($display->getH());
    }

    public function testSetH(): void
    {
        $display = new Display();
        $h = 250;
        $display->setH($h);
        $this->assertEquals($h, $display->getH());
    }

    public function testGetWratio(): void
    {
        $display = new Display();
        $this->assertNull($display->getWratio());
    }

    public function testSetWratio(): void
    {
        $display = new Display();
        $wratio = 16;
        $display->setWratio($wratio);
        $this->assertEquals($wratio, $display->getWratio());
    }

    public function testGetHratio(): void
    {
        $display = new Display();
        $this->assertNull($display->getHratio());
    }

    public function testSetHratio(): void
    {
        $display = new Display();
        $hratio = 9;
        $display->setHratio($hratio);
        $this->assertEquals($hratio, $display->getHratio());
    }

    public function testGetPriv(): void
    {
        $display = new Display();
        $this->assertNull($display->getPriv());
    }

    public function testSetPriv(): void
    {
        $display = new Display();
        $priv = 'https://example.com/privacy';
        $display->setPriv($priv);
        $this->assertEquals($priv, $display->getPriv());
    }

    public function testGetAdm(): void
    {
        $display = new Display();
        $this->assertNull($display->getAdm());
    }

    public function testSetAdm(): void
    {
        $display = new Display();
        $adm = '<div>Ad markup</div>';
        $display->setAdm($adm);
        $this->assertEquals($adm, $display->getAdm());
    }

    public function testGetCurl(): void
    {
        $display = new Display();
        $this->assertNull($display->getCurl());
    }

    public function testSetCurl(): void
    {
        $display = new Display();
        $curl = 'https://example.com/creative';
        $display->setCurl($curl);
        $this->assertEquals($curl, $display->getCurl());
    }

    public function testGetEvent(): void
    {
        $display = new Display();
        $this->assertNull($display->getEvent());
    }

    public function testSetEvent(): void
    {
        $display = new Display();
        $event = new \OpenRTB\v3\Bid\Event();
        $display->setEvent([$event]);
        $this->assertEquals([$event], $display->getEvent());
    }

    public function testSchemaIncludesNewFields(): void
    {
        $schema = Display::getSchema();

        // Test new fields are in schema
        $this->assertArrayHasKey('mime', $schema);
        $this->assertEquals('string', $schema['mime']);
        $this->assertArrayHasKey('api', $schema);
        $this->assertEquals([\OpenRTB\v3\Enums\Placement\ApiFramework::class], $schema['api']);
        $this->assertArrayHasKey('ctype', $schema);
        $this->assertEquals('int', $schema['ctype']);
        $this->assertArrayHasKey('w', $schema);
        $this->assertEquals('int', $schema['w']);
        $this->assertArrayHasKey('h', $schema);
        $this->assertEquals('int', $schema['h']);
        $this->assertArrayHasKey('wratio', $schema);
        $this->assertEquals('int', $schema['wratio']);
        $this->assertArrayHasKey('hratio', $schema);
        $this->assertEquals('int', $schema['hratio']);
        $this->assertArrayHasKey('priv', $schema);
        $this->assertEquals('string', $schema['priv']);
        $this->assertArrayHasKey('adm', $schema);
        $this->assertEquals('string', $schema['adm']);
        $this->assertArrayHasKey('curl', $schema);
        $this->assertEquals('string', $schema['curl']);
        $this->assertArrayHasKey('event', $schema);
        $this->assertEquals([\OpenRTB\v3\Bid\Event::class], $schema['event']);
    }
}
