<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Image;

/**
 * @covers \OpenRTB\v3\Bid\Image
 */
final class ImageTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Image::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('url', $schema);
        $this->assertEquals('string', $schema['url']);
        $this->assertArrayHasKey('w', $schema);
        $this->assertEquals('int', $schema['w']);
        $this->assertArrayHasKey('h', $schema);
        $this->assertEquals('int', $schema['h']);
    }

    public function testSetUrl(): void
    {
        $image = new Image();
        $url = 'http://example.com/image.png';
        $image->setUrl($url);
        $this->assertEquals($url, $image->getUrl());
    }

    public function testGetUrl(): void
    {
        $image = new Image();
        $image->setUrl('http://test.com/image.jpg');
        $this->assertEquals('http://test.com/image.jpg', $image->getUrl());
    }

    public function testSetW(): void
    {
        $image = new Image();
        $w = 300;
        $image->setW($w);
        $this->assertEquals($w, $image->getW());
    }

    public function testGetW(): void
    {
        $image = new Image();
        $image->setW(600);
        $this->assertEquals(600, $image->getW());
    }

    public function testSetH(): void
    {
        $image = new Image();
        $h = 250;
        $image->setH($h);
        $this->assertEquals($h, $image->getH());
    }

    public function testGetH(): void
    {
        $image = new Image();
        $image->setH(400);
        $this->assertEquals(400, $image->getH());
    }
}
