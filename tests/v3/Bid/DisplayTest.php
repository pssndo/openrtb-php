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
}
