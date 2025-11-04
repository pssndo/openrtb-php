<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Impression\Audio;
use OpenRTB\v26\Impression\Banner;
use OpenRTB\v26\Impression\Deal;
use OpenRTB\v26\Impression\Format;
use OpenRTB\v26\Impression\Imp;
use OpenRTB\v26\Impression\Metric;
use OpenRTB\v26\Impression\Native;
use OpenRTB\v26\Impression\Pmp;
use OpenRTB\v26\Impression\Video;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Impression\Audio
 * @covers \OpenRTB\v26\Impression\Banner
 * @covers \OpenRTB\v26\Impression\Deal
 * @covers \OpenRTB\v26\Impression\Format
 * @covers \OpenRTB\v26\Impression\Imp
 * @covers \OpenRTB\v26\Impression\Metric
 * @covers \OpenRTB\v26\Impression\Native
 * @covers \OpenRTB\v26\Impression\Pmp
 * @covers \OpenRTB\v26\Impression\Video
 */
class ImpressionObjectsTest extends TestCase
{
    public function testImpObject(): void
    {
        $banner = new Banner();
        $video = new Video();
        $audio = new Audio();
        $native = new Native();
        $pmp = new Pmp();
        $metric = new Metric();
        $ext = new Ext();

        $imp = (new Imp())
            ->setId('imp-1')
            ->setMetric([$metric])
            ->setBanner($banner)
            ->setVideo($video)
            ->setAudio($audio)
            ->setNative($native)
            ->setPmp($pmp)
            ->setInstl(1)
            ->setClickbrowser(1)
            ->setSecure(1)
            ->setExp(30)
            ->setExt($ext);

        $this->assertEquals('imp-1', $imp->getId());
        $this->assertEquals([$metric], $imp->getMetric());
        $this->assertSame($banner, $imp->getBanner());
        $this->assertSame($video, $imp->getVideo());
        $this->assertSame($audio, $imp->getAudio());
        $this->assertSame($native, $imp->getNative());
        $this->assertSame($pmp, $imp->getPmp());
        $this->assertEquals(1, $imp->getInstl());
        $this->assertEquals(1, $imp->getClickbrowser());
        $this->assertEquals(1, $imp->getSecure());
        $this->assertEquals(30, $imp->getExp());
        $this->assertSame($ext, $imp->getExt());
    }

    public function testAudioObject(): void
    {
        $ext = new Ext();
        $audio = (new Audio())
            ->setMimes(['audio/mp4'])
            ->setMinduration(5)
            ->setMaxduration(30)
            ->setProtocols([1, 2])
            ->setMaxseq(2)
            ->setApi([3, 5])
            ->setExt($ext);

        $this->assertEquals(['audio/mp4'], $audio->getMimes());
        $this->assertEquals(5, $audio->getMinduration());
        $this->assertEquals(30, $audio->getMaxduration());
        $this->assertEquals([1, 2], $audio->getProtocols());
        $this->assertEquals(2, $audio->getMaxseq());
        $this->assertEquals([3, 5], $audio->getApi());
        $this->assertSame($ext, $audio->getExt());
    }

    public function testAudioSchema(): void
    {
        $schema = Audio::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('ext', $schema);
    }

    public function testBannerObject(): void
    {
        $format = new Format();
        $ext = new Ext();
        $banner = (new Banner())
            ->setFormat([$format])
            ->setW(300)
            ->setH(250)
            ->setPos(1)
            ->setApi([3])
            ->setVcm(1)
            ->setExt($ext);

        $this->assertEquals([$format], $banner->getFormat());
        $this->assertEquals(300, $banner->getW());
        $this->assertEquals(250, $banner->getH());
        $this->assertEquals(1, $banner->getPos());
        $this->assertEquals([3], $banner->getApi());
        $this->assertEquals(1, $banner->getVcm());
        $this->assertSame($ext, $banner->getExt());
    }

    public function testDealObject(): void
    {
        $ext = new Ext();
        $deal = (new Deal())
            ->setId('deal-1')
            ->setBidfloor(1.5)
            ->setBidfloorcur('USD')
            ->setAt(2)
            ->setWseat(['seat-1'])
            ->setExt($ext);

        $this->assertEquals('deal-1', $deal->getId());
        $this->assertEquals(1.5, $deal->getBidfloor());
        $this->assertEquals('USD', $deal->getBidfloorcur());
        $at = $deal->getAt();
        $this->assertNotNull($at);
        $this->assertEquals(2, $at->value);
        $wseat = $deal->getWseat();
        $this->assertNotNull($wseat);
        $this->assertEquals(['seat-1'], $wseat->toArray());
        $this->assertSame($ext, $deal->getExt());
    }

    public function testDealSchema(): void
    {
        $schema = Deal::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('ext', $schema);
    }

    public function testFormatObject(): void
    {
        $format = (new Format())->setW(300)->setH(250);
        $this->assertEquals(300, $format->getW());
        $this->assertEquals(250, $format->getH());

        $schema = Format::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('w', $schema);
        $this->assertArrayHasKey('h', $schema);
    }

    public function testMetricObject(): void
    {
        $ext = new Ext();
        $metric = (new Metric())
            ->setType('viewability')
            ->setValue(0.8)
            ->setVendor('MOAT')
            ->setExt($ext);

        $this->assertEquals('viewability', $metric->getType());
        $this->assertEquals(0.8, $metric->getValue());
        $this->assertEquals('MOAT', $metric->getVendor());
        $this->assertSame($ext, $metric->getExt());
    }

    public function testNativeObject(): void
    {
        $ext = new Ext();
        $native = (new Native())
            ->setRequest('native-request-string')
            ->setVer('1.2')
            ->setApi([3, 5])
            ->setBattr([1, 2])
            ->setExt($ext);

        $this->assertEquals('native-request-string', $native->getRequest());
        $this->assertEquals('1.2', $native->getVer());
        $this->assertEquals([3, 5], $native->getApi());
        $this->assertEquals([1, 2], $native->getBattr());
        $this->assertSame($ext, $native->getExt());
    }

    public function testNativeSchema(): void
    {
        $schema = Native::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('ext', $schema);
    }

    public function testPmpObject(): void
    {
        $deal = new Deal();
        $ext = new Ext();
        $pmp = (new Pmp())
            ->setPrivateAuction(1)
            ->setDeals([$deal])
            ->setExt($ext);

        $this->assertEquals(1, $pmp->getPrivateAuction());
        $this->assertEquals([$deal], $pmp->getDeals());
        $this->assertSame($ext, $pmp->getExt());
    }

    public function testVideoObject(): void
    {
        $ext = new Ext();
        $video = (new Video())
            ->setMimes(['video/mp4'])
            ->setMinduration(5)
            ->setMaxduration(30)
            ->setProtocols([2, 3])
            ->setW(1920)
            ->setH(1080)
            ->setLinearity(1)
            ->setPlacement(1)
            ->setApi([3, 5])
            ->setExt($ext);

        $this->assertEquals(['video/mp4'], $video->getMimes());
        $this->assertEquals(5, $video->getMinduration());
        $this->assertEquals(30, $video->getMaxduration());
        $this->assertEquals([2, 3], $video->getProtocols());
        $this->assertEquals(1920, $video->getW());
        $this->assertEquals(1080, $video->getH());
        $this->assertEquals(1, $video->getLinearity());
        $this->assertEquals(1, $video->getPlacement());
        $this->assertEquals([3, 5], $video->getApi());
        $this->assertSame($ext, $video->getExt());
    }

    public function testVideoSchema(): void
    {
        $schema = Video::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('ext', $schema);
    }
}
