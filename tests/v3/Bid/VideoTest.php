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

        $this->assertIsArray($schema);
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
}
