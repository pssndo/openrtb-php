<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid\Display;

use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Link;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Display\Banner
 */
final class BannerTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Banner::getSchema();

        $this->assertArrayHasKey('img', $schema);
        $this->assertEquals('string', $schema['img']);
        $this->assertArrayHasKey('w', $schema);
        $this->assertEquals('int', $schema['w']);
        $this->assertArrayHasKey('h', $schema);
        $this->assertEquals('int', $schema['h']);
        $this->assertArrayHasKey('link', $schema);
        $this->assertEquals(Link::class, $schema['link']);
    }

    public function testSetImg(): void
    {
        $banner = new Banner();
        $img = 'http://example.com/image.png';
        $banner->setImg($img);
        $this->assertEquals($img, $banner->getImg());
    }

    public function testGetImg(): void
    {
        $banner = new Banner();
        $banner->setImg('http://test.com/image.jpg');
        $this->assertEquals('http://test.com/image.jpg', $banner->getImg());
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
        $banner->setW(600);
        $this->assertEquals(600, $banner->getW());
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
        $banner->setH(400);
        $this->assertEquals(400, $banner->getH());
    }

    public function testSetLink(): void
    {
        $banner = new Banner();
        $link = new Link();
        $banner->setLink($link);
        $this->assertSame($link, $banner->getLink());
    }

    public function testGetLink(): void
    {
        $banner = new Banner();
        $link = new Link();
        $banner->setLink($link);
        $this->assertSame($link, $banner->getLink());
    }
}
