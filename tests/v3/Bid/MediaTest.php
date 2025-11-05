<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Media;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Bid\Media
 */
final class MediaTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Media::getSchema();

        $this->assertArrayHasKey('ad', $schema);
        $this->assertEquals(Ad::class, $schema['ad']);
    }

    public function testSetAd(): void
    {
        $media = new Media();
        $ad = new Ad();
        $media->setAd($ad);
        $this->assertSame($ad, $media->getAd());
    }

    public function testGetAd(): void
    {
        $media = new Media();
        $ad = new Ad();
        $media->setAd($ad);
        $this->assertSame($ad, $media->getAd());
    }
}
