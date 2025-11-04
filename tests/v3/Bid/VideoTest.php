<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Video;
use OpenRTB\v3\Enums\Placement\ApiFramework;

/**
 * @covers \OpenRTB\v3\Bid\Video
 */
final class VideoTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Video::getSchema();

        $this->assertArrayHasKey('adm', $schema);
        $this->assertEquals('string', $schema['adm']);
        $this->assertArrayHasKey('curl', $schema);
        $this->assertEquals('string', $schema['curl']);
        $this->assertArrayHasKey('api', $schema);
        $this->assertEquals([ApiFramework::class], $schema['api']);
        $this->assertArrayHasKey('ctype', $schema);
        $this->assertEquals('string', $schema['ctype']);
        $this->assertArrayHasKey('mime', $schema);
        $this->assertEquals('string', $schema['mime']);
        $this->assertArrayHasKey('dur', $schema);
        $this->assertEquals('int', $schema['dur']);
    }

    public function testGetAdm(): void
    {
        $video = new Video();
        $this->assertNull($video->getAdm());
    }

    public function testSetAdm(): void
    {
        $video = new Video();
        $adm = 'test_adm';
        $video->setAdm($adm);
        $this->assertEquals($adm, $video->getAdm());
    }

    public function testGetCurl(): void
    {
        $video = new Video();
        $this->assertNull($video->getCurl());
    }

    public function testSetCurl(): void
    {
        $video = new Video();
        $curl = 'http://example.com/video.mp4';
        $video->setCurl($curl);
        $this->assertEquals($curl, $video->getCurl());
    }

    public function testGetApi(): void
    {
        $video = new Video();
        $this->assertNull($video->getApi());
    }

    public function testSetApi(): void
    {
        $video = new Video();
        $api = [ApiFramework::VPAID_1];
        $video->setApi($api);
        $this->assertEquals($api, $video->getApi());
    }

    public function testGetCtype(): void
    {
        $video = new Video();
        $this->assertNull($video->getCtype());
    }

    public function testSetCtype(): void
    {
        $video = new Video();
        $ctype = 'video/mp4';
        $video->setCtype($ctype);
        $this->assertEquals($ctype, $video->getCtype());
    }

    public function testGetMime(): void
    {
        $video = new Video();
        $this->assertNull($video->getMime());
    }

    public function testSetMime(): void
    {
        $video = new Video();
        $mime = 'video/mp4';
        $video->setMime($mime);
        $this->assertEquals($mime, $video->getMime());
    }

    public function testGetDur(): void
    {
        $video = new Video();
        $this->assertNull($video->getDur());
    }

    public function testSetDur(): void
    {
        $video = new Video();
        $dur = 60;
        $video->setDur($dur);
        $this->assertEquals($dur, $video->getDur());
    }

    public function testGetW(): void
    {
        $video = new Video();
        $this->assertNull($video->getW());
    }

    public function testSetW(): void
    {
        $video = new Video();
        $w = 1920;
        $video->setW($w);
        $this->assertEquals($w, $video->getW());
    }

    public function testGetH(): void
    {
        $video = new Video();
        $this->assertNull($video->getH());
    }

    public function testSetH(): void
    {
        $video = new Video();
        $h = 1080;
        $video->setH($h);
        $this->assertEquals($h, $video->getH());
    }

    public function testGetWratio(): void
    {
        $video = new Video();
        $this->assertNull($video->getWratio());
    }

    public function testSetWratio(): void
    {
        $video = new Video();
        $wratio = 16;
        $video->setWratio($wratio);
        $this->assertEquals($wratio, $video->getWratio());
    }

    public function testGetHratio(): void
    {
        $video = new Video();
        $this->assertNull($video->getHratio());
    }

    public function testSetHratio(): void
    {
        $video = new Video();
        $hratio = 9;
        $video->setHratio($hratio);
        $this->assertEquals($hratio, $video->getHratio());
    }

    public function testGetPriv(): void
    {
        $video = new Video();
        $this->assertNull($video->getPriv());
    }

    public function testSetPriv(): void
    {
        $video = new Video();
        $priv = 'https://example.com/privacy';
        $video->setPriv($priv);
        $this->assertEquals($priv, $video->getPriv());
    }

    public function testGetEvent(): void
    {
        $video = new Video();
        $this->assertNull($video->getEvent());
    }

    public function testSetEvent(): void
    {
        $video = new Video();
        $event = new \OpenRTB\v3\Bid\Event();
        $video->setEvent([$event]);
        $this->assertEquals([$event], $video->getEvent());
    }

    public function testSchemaIncludesNewFields(): void
    {
        $schema = Video::getSchema();

        // Test new fields are in schema
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
        $this->assertArrayHasKey('event', $schema);
        $this->assertEquals([\OpenRTB\v3\Bid\Event::class], $schema['event']);
    }
}
