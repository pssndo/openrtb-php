<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Data;
use OpenRTB\v3\Bid\Image;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Title;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Asset
 */
final class AssetTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Asset::getSchema();

        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('int', $schema['id']);
        $this->assertArrayHasKey('req', $schema);
        $this->assertEquals('int', $schema['req']);
        $this->assertArrayHasKey('title', $schema);
        $this->assertEquals(Title::class, $schema['title']);
        $this->assertArrayHasKey('img', $schema);
        $this->assertEquals(Image::class, $schema['img']);
        $this->assertArrayHasKey('data', $schema);
        $this->assertEquals(Data::class, $schema['data']);
        $this->assertArrayHasKey('link', $schema);
        $this->assertEquals(Link::class, $schema['link']);
    }

    public function testSetId(): void
    {
        $asset = new Asset();
        $id = 1;
        $asset->setId($id);
        $this->assertEquals($id, $asset->getId());
    }

    public function testGetId(): void
    {
        $asset = new Asset();
        $asset->setId(2);
        $this->assertEquals(2, $asset->getId());
    }

    public function testSetReq(): void
    {
        $asset = new Asset();
        $req = 1;
        $asset->setReq($req);
        $this->assertEquals($req, $asset->getReq());
    }

    public function testGetReq(): void
    {
        $asset = new Asset();
        $asset->setReq(0);
        $this->assertEquals(0, $asset->getReq());
    }

    public function testSetTitle(): void
    {
        $asset = new Asset();
        $title = new Title();
        $asset->setTitle($title);
        $this->assertSame($title, $asset->getTitle());
    }

    public function testGetTitle(): void
    {
        $asset = new Asset();
        $title = new Title();
        $asset->setTitle($title);
        $this->assertSame($title, $asset->getTitle());
    }

    public function testSetImg(): void
    {
        $asset = new Asset();
        $img = new Image();
        $asset->setImg($img);
        $this->assertSame($img, $asset->getImg());
    }

    public function testGetImg(): void
    {
        $asset = new Asset();
        $img = new Image();
        $asset->setImg($img);
        $this->assertSame($img, $asset->getImg());
    }

    public function testSetData(): void
    {
        $asset = new Asset();
        $data = new Data();
        $asset->setData($data);
        $this->assertSame($data, $asset->getData());
    }

    public function testGetData(): void
    {
        $asset = new Asset();
        $data = new Data();
        $asset->setData($data);
        $this->assertSame($data, $asset->getData());
    }

    public function testSetLink(): void
    {
        $asset = new Asset();
        $link = new Link();
        $asset->setLink($link);
        $this->assertSame($link, $asset->getLink());
    }

    public function testGetLink(): void
    {
        $asset = new Asset();
        $link = new Link();
        $asset->setLink($link);
        $this->assertSame($link, $asset->getLink());
    }
}
