<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Audio;
use OpenRTB\v3\Enums\Placement\ApiFramework;

/**
 * @covers \OpenRTB\v3\Bid\Audio
 */
final class AudioTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Audio::getSchema();

        $this->assertArrayHasKey('adm', $schema);
        $this->assertEquals('string', $schema['adm']);
        $this->assertArrayHasKey('curl', $schema);
        $this->assertEquals('string', $schema['curl']);
        $this->assertArrayHasKey('api', $schema);
        $this->assertEquals([ApiFramework::class], $schema['api']);
        $this->assertArrayHasKey('mime', $schema);
        $this->assertEquals('string', $schema['mime']);
        $this->assertArrayHasKey('dur', $schema);
        $this->assertEquals('int', $schema['dur']);
    }

    public function testGetAdm(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getAdm());
    }

    public function testSetAdm(): void
    {
        $audio = new Audio();
        $adm = 'test_adm';
        $audio->setAdm($adm);
        $this->assertEquals($adm, $audio->getAdm());
    }

    public function testGetCurl(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getCurl());
    }

    public function testSetCurl(): void
    {
        $audio = new Audio();
        $curl = 'http://example.com/audio.mp3';
        $audio->setCurl($curl);
        $this->assertEquals($curl, $audio->getCurl());
    }

    public function testGetApi(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getApi());
    }

    public function testSetApi(): void
    {
        $audio = new Audio();
        $api = [ApiFramework::VPAID_1];
        $audio->setApi($api);
        $this->assertEquals($api, $audio->getApi());
    }

    public function testGetMime(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getMime());
    }

    public function testSetMime(): void
    {
        $audio = new Audio();
        $mime = 'audio/mp3';
        $audio->setMime($mime);
        $this->assertEquals($mime, $audio->getMime());
    }

    public function testGetDur(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getDur());
    }

    public function testSetDur(): void
    {
        $audio = new Audio();
        $dur = 30;
        $audio->setDur($dur);
        $this->assertEquals($dur, $audio->getDur());
    }
}
