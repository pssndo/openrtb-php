<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid\Display;

use OpenRTB\v3\Bid\Display\Native;
use OpenRTB\v3\Bid\Link;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Display\Native
 */
final class NativeTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Native::getSchema();

        $this->assertArrayHasKey('link', $schema);
        $this->assertEquals(Link::class, $schema['link']);
        $this->assertArrayHasKey('asset', $schema);
        $this->assertEquals('array', $schema['asset']);
    }

    public function testSetLink(): void
    {
        $native = new Native();
        $link = new Link();
        $native->setLink($link);
        $this->assertSame($link, $native->getLink());
    }

    public function testGetLink(): void
    {
        $native = new Native();
        $link = new Link();
        $native->setLink($link);
        $this->assertSame($link, $native->getLink());
    }

    public function testSetAsset(): void
    {
        $native = new Native();
        $asset = ['asset1', 'asset2'];
        $native->setAsset($asset);
        $this->assertEquals($asset, $native->getAsset());
    }

    public function testGetAsset(): void
    {
        $native = new Native();
        $native->setAsset(['asset3']);
        $this->assertEquals(['asset3'], $native->getAsset());
    }
}
