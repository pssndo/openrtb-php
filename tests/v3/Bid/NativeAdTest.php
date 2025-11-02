<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Event;

/**
 * @covers \OpenRTB\v3\Bid\NativeAd
 */
final class NativeAdTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = NativeAd::getSchema();

        $this->assertArrayHasKey('link', $schema);
        $this->assertEquals(Link::class, $schema['link']);
        $this->assertArrayHasKey('asset', $schema);
        $this->assertEquals([Asset::class], $schema['asset']);
        $this->assertArrayHasKey('event', $schema);
        $this->assertEquals([Event::class], $schema['event']);
        $this->assertArrayHasKey('privacy', $schema);
        $this->assertEquals('string', $schema['privacy']);
    }

    public function testSetLink(): void
    {
        $nativeAd = new NativeAd();
        $link = new Link();
        $nativeAd->setLink($link);
        $this->assertSame($link, $nativeAd->getLink());
    }

    public function testGetLink(): void
    {
        $nativeAd = new NativeAd();
        $link = new Link();
        $nativeAd->setLink($link);
        $this->assertSame($link, $nativeAd->getLink());
    }

    public function testSetAsset(): void
    {
        $nativeAd = new NativeAd();
        $asset = [new Asset()];
        $nativeAd->setAsset($asset);
        $this->assertEquals($asset, $nativeAd->getAsset()->all());
    }

    public function testGetAsset(): void
    {
        $nativeAd = new NativeAd();
        $asset = [new Asset()];
        $nativeAd->setAsset($asset);
        $this->assertEquals($asset, $nativeAd->getAsset()->all());
    }

    public function testSetEvent(): void
    {
        $nativeAd = new NativeAd();
        $event = [new Event()];
        $nativeAd->setEvent($event);
        $this->assertEquals($event, $nativeAd->getEvent()->all());
    }

    public function testGetEvent(): void
    {
        $nativeAd = new NativeAd();
        $event = [new Event()];
        $nativeAd->setEvent($event);
        $this->assertEquals($event, $nativeAd->getEvent()->all());
    }

    public function testSetPrivacy(): void
    {
        $nativeAd = new NativeAd();
        $privacy = 'privacy_string';
        $nativeAd->setPrivacy($privacy);
        $this->assertEquals($privacy, $nativeAd->getPrivacy());
    }

    public function testGetPrivacy(): void
    {
        $nativeAd = new NativeAd();
        $nativeAd->setPrivacy('another_privacy_string');
        $this->assertEquals('another_privacy_string', $nativeAd->getPrivacy());
    }
}
