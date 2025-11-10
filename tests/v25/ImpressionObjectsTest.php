<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\Impression\Audio;
use OpenRTB\v25\Impression\Banner;
use OpenRTB\v25\Impression\Deal;
use OpenRTB\v25\Impression\Format;
use OpenRTB\v25\Impression\Imp;
use OpenRTB\v25\Impression\Metric;
use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Impression\Pmp;
use OpenRTB\v25\Impression\Video;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Impression\Audio
 * @covers \OpenRTB\v25\Impression\Banner
 * @covers \OpenRTB\v25\Impression\Deal
 * @covers \OpenRTB\v25\Impression\Format
 * @covers \OpenRTB\v25\Impression\Imp
 * @covers \OpenRTB\v25\Impression\Metric
 * @covers \OpenRTB\v25\Impression\Native
 * @covers \OpenRTB\v25\Impression\Pmp
 * @covers \OpenRTB\v25\Impression\Video
 */
class ImpressionObjectsTest extends TestCase
{
    public function testImpGetSchema(): void
    {
        $schema = Imp::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testImpSetId(): void
    {
        $imp = (new Imp())->setId('imp-1');
        $this->assertEquals('imp-1', $imp->getId());
    }

    public function testImpSetBanner(): void
    {
        $banner = new Banner();
        $imp = (new Imp())->setBanner($banner);
        $this->assertSame($banner, $imp->getBanner());
    }

    public function testImpSetVideo(): void
    {
        $video = new Video();
        $imp = (new Imp())->setVideo($video);
        $this->assertSame($video, $imp->getVideo());
    }

    public function testImpSetAudio(): void
    {
        $audio = new Audio();
        $imp = (new Imp())->setAudio($audio);
        $this->assertSame($audio, $imp->getAudio());
    }

    public function testImpSetNative(): void
    {
        $native = new Native();
        $imp = (new Imp())->setNative($native);
        $this->assertSame($native, $imp->getNative());
    }

    public function testImpSetDisplaymanager(): void
    {
        $imp = (new Imp())->setDisplaymanager('sdk-1.0');
        $this->assertEquals('sdk-1.0', $imp->getDisplaymanager());
    }

    public function testImpSetDisplaymanagerver(): void
    {
        $imp = (new Imp())->setDisplaymanagerver('1.2.3');
        $this->assertEquals('1.2.3', $imp->getDisplaymanagerver());
    }

    public function testImpSetInstl(): void
    {
        $imp = (new Imp())->setInstl(1);
        $this->assertEquals(1, $imp->getInstl());
    }

    public function testImpSetTagid(): void
    {
        $imp = (new Imp())->setTagid('tag-123');
        $this->assertEquals('tag-123', $imp->getTagid());
    }

    public function testImpSetBidfloor(): void
    {
        $imp = (new Imp())->setBidfloor(2.50);
        $this->assertEquals(2.50, $imp->getBidfloor());
    }

    public function testImpSetBidfloorcur(): void
    {
        $imp = (new Imp())->setBidfloorcur('USD');
        $this->assertEquals('USD', $imp->getBidfloorcur());
    }

    public function testImpSetSecure(): void
    {
        $imp = (new Imp())->setSecure(1);
        $this->assertEquals(1, $imp->getSecure());
    }

    public function testImpSetPmp(): void
    {
        $pmp = new Pmp();
        $imp = (new Imp())->setPmp($pmp);
        $this->assertSame($pmp, $imp->getPmp());
    }

    public function testImpGetId(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getId());
    }

    public function testImpSetMetric(): void
    {
        $metric = new Metric();
        $imp = (new Imp())->setMetric([$metric]);
        $this->assertNotNull($imp->getMetric());
    }

    public function testImpGetMetric(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getMetric());
    }

    public function testImpGetBanner(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getBanner());
    }

    public function testImpGetVideo(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getVideo());
    }

    public function testImpGetAudio(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getAudio());
    }

    public function testImpGetNative(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getNative());
    }

    public function testImpGetPmp(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getPmp());
    }

    public function testImpGetDisplaymanager(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getDisplaymanager());
    }

    public function testImpGetDisplaymanagerver(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getDisplaymanagerver());
    }

    public function testImpGetInstl(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getInstl());
    }

    public function testImpGetTagid(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getTagid());
    }

    public function testImpGetBidfloor(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getBidfloor());
    }

    public function testImpGetBidfloorcur(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getBidfloorcur());
    }

    public function testImpSetClickbrowser(): void
    {
        $imp = (new Imp())->setClickbrowser(1);
        $this->assertEquals(1, $imp->getClickbrowser());
    }

    public function testImpGetClickbrowser(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getClickbrowser());
    }

    public function testImpGetSecure(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getSecure());
    }

    public function testImpSetIframebuster(): void
    {
        $imp = (new Imp())->setIframebuster(['buster1', 'buster2']);
        $this->assertNotNull($imp->getIframebuster());
    }

    public function testImpGetIframebuster(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getIframebuster());
    }

    public function testImpSetRwdd(): void
    {
        $imp = (new Imp())->setRwdd(1);
        $this->assertEquals(1, $imp->getRwdd());
    }

    public function testImpGetRwdd(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getRwdd());
    }

    public function testImpSetSsai(): void
    {
        $imp = (new Imp())->setSsai(1);
        $this->assertEquals(1, $imp->getSsai());
    }

    public function testImpGetSsai(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getSsai());
    }

    public function testImpSetExp(): void
    {
        $imp = (new Imp())->setExp(3600);
        $this->assertEquals(3600, $imp->getExp());
    }

    public function testImpGetExp(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getExp());
    }

    public function testImpSetDt(): void
    {
        $imp = (new Imp())->setDt(1.5);
        $this->assertEquals(1.5, $imp->getDt());
    }

    public function testImpGetDt(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getDt());
    }

    public function testImpSetExt(): void
    {
        $ext = new Ext();
        $imp = (new Imp())->setExt($ext);
        $this->assertSame($ext, $imp->getExt());
    }

    public function testImpGetExt(): void
    {
        $imp = new Imp();
        $this->assertNull($imp->getExt());
    }

    public function testBannerGetSchema(): void
    {
        $schema = Banner::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testBannerSetW(): void
    {
        $banner = (new Banner())->setW(300);
        $this->assertEquals(300, $banner->getW());
    }

    public function testBannerSetH(): void
    {
        $banner = (new Banner())->setH(250);
        $this->assertEquals(250, $banner->getH());
    }

    public function testBannerSetId(): void
    {
        $banner = (new Banner())->setId('banner-1');
        $this->assertEquals('banner-1', $banner->getId());
    }

    public function testBannerSetPos(): void
    {
        $banner = (new Banner())->setPos(1);
        $this->assertEquals(1, $banner->getPos());
    }

    public function testBannerSetTopframe(): void
    {
        $banner = (new Banner())->setTopframe(1);
        $this->assertEquals(1, $banner->getTopframe());
    }

    public function testBannerSetVcm(): void
    {
        $banner = (new Banner())->setVcm(1);
        $this->assertEquals(1, $banner->getVcm());
    }

    public function testBannerGetW(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getW());
    }

    public function testBannerGetH(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getH());
    }

    public function testBannerGetId(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getId());
    }

    public function testBannerGetPos(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getPos());
    }

    public function testBannerGetTopframe(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getTopframe());
    }

    public function testBannerGetVcm(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getVcm());
    }

    public function testBannerSetFormat(): void
    {
        $format = new Format();
        $banner = (new Banner())->setFormat([$format]);
        $this->assertNotNull($banner->getFormat());
    }

    public function testBannerGetFormat(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getFormat());
    }

    public function testBannerSetBtype(): void
    {
        $banner = (new Banner())->setBtype([1, 2]);
        $this->assertNotNull($banner->getBtype());
    }

    public function testBannerGetBtype(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getBtype());
    }

    public function testBannerSetBattr(): void
    {
        $banner = (new Banner())->setBattr([1, 2]);
        $this->assertNotNull($banner->getBattr());
    }

    public function testBannerGetBattr(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getBattr());
    }

    public function testBannerSetApi(): void
    {
        $banner = (new Banner())->setApi([1, 2]);
        $this->assertNotNull($banner->getApi());
    }

    public function testBannerGetApi(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getApi());
    }

    public function testBannerSetMimes(): void
    {
        $banner = (new Banner())->setMimes(['image/jpeg', 'image/png']);
        $this->assertNotNull($banner->getMimes());
    }

    public function testBannerGetMimes(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getMimes());
    }

    public function testBannerSetExpdir(): void
    {
        $banner = (new Banner())->setExpdir([1, 2, 3]);
        $this->assertNotNull($banner->getExpdir());
    }

    public function testBannerGetExpdir(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getExpdir());
    }

    public function testBannerSetExt(): void
    {
        $ext = new Ext();
        $banner = (new Banner())->setExt($ext);
        $this->assertSame($ext, $banner->getExt());
    }

    public function testBannerGetExt(): void
    {
        $banner = new Banner();
        $this->assertNull($banner->getExt());
    }

    public function testFormatGetSchema(): void
    {
        $schema = Format::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testFormatSetW(): void
    {
        $format = (new Format())->setW(300);
        $this->assertEquals(300, $format->getW());
    }

    public function testFormatSetH(): void
    {
        $format = (new Format())->setH(250);
        $this->assertEquals(250, $format->getH());
    }

    public function testVideoGetSchema(): void
    {
        $schema = Video::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testVideoSetMinduration(): void
    {
        $video = (new Video())->setMinduration(5);
        $this->assertEquals(5, $video->getMinduration());
    }

    public function testVideoSetMaxduration(): void
    {
        $video = (new Video())->setMaxduration(30);
        $this->assertEquals(30, $video->getMaxduration());
    }

    public function testVideoSetW(): void
    {
        $video = (new Video())->setW(640);
        $this->assertEquals(640, $video->getW());
    }

    public function testVideoSetH(): void
    {
        $video = (new Video())->setH(480);
        $this->assertEquals(480, $video->getH());
    }

    public function testVideoSetStartdelay(): void
    {
        $video = (new Video())->setStartdelay(0);
        $this->assertEquals(0, $video->getStartdelay());
    }

    public function testVideoSetPlacement(): void
    {
        $video = (new Video())->setPlacement(1);
        $this->assertEquals(1, $video->getPlacement());
    }

    public function testVideoSetLinearity(): void
    {
        $video = (new Video())->setLinearity(1);
        $this->assertEquals(1, $video->getLinearity());
    }

    public function testVideoSetSkip(): void
    {
        $video = (new Video())->setSkip(1);
        $this->assertEquals(1, $video->getSkip());
    }

    public function testVideoSetSkipmin(): void
    {
        $video = (new Video())->setSkipmin(5);
        $this->assertEquals(5, $video->getSkipmin());
    }

    public function testVideoSetSkipafter(): void
    {
        $video = (new Video())->setSkipafter(5);
        $this->assertEquals(5, $video->getSkipafter());
    }

    public function testVideoSetProtocols(): void
    {
        $video = (new Video())->setProtocols([1, 2]);
        $protocols = $video->getProtocols();
        $this->assertNotNull($protocols);
    }

    public function testVideoSetPos(): void
    {
        $video = (new Video())->setPos(1);
        $this->assertEquals(1, $video->getPos());
    }

    public function testVideoSetMimes(): void
    {
        $video = (new Video())->setMimes(['video/mp4', 'video/webm']);
        $this->assertNotNull($video->getMimes());
    }

    public function testVideoGetMimes(): void
    {
        $video = new Video();
        $this->assertNull($video->getMimes());
    }

    public function testVideoSetApi(): void
    {
        $video = (new Video())->setApi([1, 2]);
        $this->assertNotNull($video->getApi());
    }

    public function testVideoGetApi(): void
    {
        $video = new Video();
        $this->assertNull($video->getApi());
    }

    public function testVideoSetExt(): void
    {
        $ext = new Ext();
        $video = (new Video())->setExt($ext);
        $this->assertSame($ext, $video->getExt());
    }

    public function testVideoGetExt(): void
    {
        $video = new Video();
        $this->assertNull($video->getExt());
    }

    public function testAudioGetSchema(): void
    {
        $schema = Audio::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testAudioSetMinduration(): void
    {
        $audio = (new Audio())->setMinduration(5);
        $this->assertEquals(5, $audio->getMinduration());
    }

    public function testAudioSetMaxduration(): void
    {
        $audio = (new Audio())->setMaxduration(30);
        $this->assertEquals(30, $audio->getMaxduration());
    }

    public function testAudioSetApi(): void
    {
        $audio = new Audio();
        $result = $audio->setApi([1, 2]);
        $this->assertSame($audio, $result);
    }

    public function testAudioSetMimes(): void
    {
        $audio = (new Audio())->setMimes(['audio/mp4', 'audio/mpeg']);
        $this->assertNotNull($audio->getMimes());
    }

    public function testAudioGetMimes(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getMimes());
    }

    public function testAudioGetMinduration(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getMinduration());
    }

    public function testAudioGetMaxduration(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getMaxduration());
    }

    public function testAudioSetProtocols(): void
    {
        $audio = (new Audio())->setProtocols([1, 2, 3]);
        $this->assertNotNull($audio->getProtocols());
    }

    public function testAudioGetProtocols(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getProtocols());
    }

    public function testAudioSetMaxseq(): void
    {
        $audio = (new Audio())->setMaxseq(10);
        $this->assertEquals(10, $audio->getMaxseq());
    }

    public function testAudioGetMaxseq(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getMaxseq());
    }

    public function testAudioGetApi(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getApi());
    }

    public function testAudioSetExt(): void
    {
        $ext = new Ext();
        $audio = (new Audio())->setExt($ext);
        $this->assertSame($ext, $audio->getExt());
    }

    public function testAudioGetExt(): void
    {
        $audio = new Audio();
        $this->assertNull($audio->getExt());
    }

    public function testNativeGetSchema(): void
    {
        $schema = Native::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testNativeSetRequest(): void
    {
        $native = (new Native())->setRequest('{"native":{}}');
        $this->assertEquals('{"native":{}}', $native->getRequest());
    }

    public function testNativeSetVer(): void
    {
        $native = (new Native())->setVer('1.2');
        $this->assertEquals('1.2', $native->getVer());
    }

    public function testNativeGetRequest(): void
    {
        $native = new Native();
        $this->assertNull($native->getRequest());
    }

    public function testNativeGetVer(): void
    {
        $native = new Native();
        $this->assertNull($native->getVer());
    }

    public function testNativeSetApi(): void
    {
        $native = (new Native())->setApi([1, 2]);
        $this->assertNotNull($native->getApi());
    }

    public function testNativeGetApi(): void
    {
        $native = new Native();
        $this->assertNull($native->getApi());
    }

    public function testNativeSetBattr(): void
    {
        $native = (new Native())->setBattr([1, 2]);
        $this->assertNotNull($native->getBattr());
    }

    public function testNativeGetBattr(): void
    {
        $native = new Native();
        $this->assertNull($native->getBattr());
    }

    public function testNativeSetExt(): void
    {
        $ext = new Ext();
        $native = (new Native())->setExt($ext);
        $this->assertSame($ext, $native->getExt());
    }

    public function testNativeGetExt(): void
    {
        $native = new Native();
        $this->assertNull($native->getExt());
    }

    public function testDealGetSchema(): void
    {
        $schema = Deal::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testDealSetId(): void
    {
        $deal = (new Deal())->setId('deal-1');
        $this->assertEquals('deal-1', $deal->getId());
    }

    public function testDealSetBidfloor(): void
    {
        $deal = (new Deal())->setBidfloor(2.50);
        $this->assertEquals(2.50, $deal->getBidfloor());
    }

    public function testDealSetBidfloorcur(): void
    {
        $deal = (new Deal())->setBidfloorcur('USD');
        $this->assertEquals('USD', $deal->getBidfloorcur());
    }

    public function testDealSetExt(): void
    {
        $ext = new Ext();
        $deal = (new Deal())->setExt($ext);
        $this->assertSame($ext, $deal->getExt());
    }

    public function testDealGetId(): void
    {
        $deal = new Deal();
        $this->assertNull($deal->getId());
    }

    public function testDealGetBidfloor(): void
    {
        $deal = new Deal();
        $this->assertNull($deal->getBidfloor());
    }

    public function testDealGetBidfloorcur(): void
    {
        $deal = new Deal();
        $this->assertNull($deal->getBidfloorcur());
    }

    public function testDealSetAt(): void
    {
        $deal = (new Deal())->setAt(2);
        $at = $deal->getAt();
        $this->assertNotNull($at);
        $this->assertInstanceOf(\OpenRTB\v25\Enums\AuctionType::class, $at);
        $this->assertEquals(2, $at->value);
    }

    public function testDealGetAt(): void
    {
        $deal = new Deal();
        $this->assertNull($deal->getAt());
    }

    public function testDealGetAtReturnsAuctionTypeInstance(): void
    {
        $deal = new Deal();

        // Use reflection to set at as AuctionType instance directly
        $auctionType = \OpenRTB\v25\Enums\AuctionType::FIRST_PRICE;
        $reflection = new \ReflectionClass($deal);
        $dataProperty = $reflection->getProperty('data');
        $data = $dataProperty->getValue($deal);
        $data->at = $auctionType;
        $dataProperty->setValue($deal, $data);

        $result = $deal->getAt();
        $this->assertSame($auctionType, $result);
    }

    public function testDealGetExt(): void
    {
        $deal = new Deal();
        $this->assertNull($deal->getExt());
    }

    public function testDealSetWseat(): void
    {
        $deal = (new Deal())->setWseat(['seat1', 'seat2']);
        $this->assertNotNull($deal->getWseat());
    }

    public function testDealSetWadv(): void
    {
        $deal = (new Deal())->setWadv(['adv1', 'adv2']);
        $this->assertNotNull($deal->getWadv());
    }

    public function testPmpGetSchema(): void
    {
        $schema = Pmp::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testPmpSetPrivateAuction(): void
    {
        $pmp = (new Pmp())->setPrivateAuction(1);
        $this->assertEquals(1, $pmp->getPrivateAuction());
    }

    public function testPmpGetPrivateAuction(): void
    {
        $pmp = new Pmp();
        $this->assertNull($pmp->getPrivateAuction());
    }

    public function testPmpSetDeals(): void
    {
        $deal = new Deal();
        $pmp = (new Pmp())->setDeals([$deal]);
        $this->assertNotNull($pmp->getDeals());
    }

    public function testPmpGetDeals(): void
    {
        $pmp = new Pmp();
        $this->assertNull($pmp->getDeals());
    }

    public function testPmpSetExt(): void
    {
        $ext = new Ext();
        $pmp = (new Pmp())->setExt($ext);
        $this->assertSame($ext, $pmp->getExt());
    }

    public function testPmpGetExt(): void
    {
        $pmp = new Pmp();
        $this->assertNull($pmp->getExt());
    }

    public function testMetricGetSchema(): void
    {
        $schema = Metric::getSchema();
        /** @phpstan-ignore-next-line method.alreadyNarrowedType */
        $this->assertIsArray($schema);
    }

    public function testMetricSetType(): void
    {
        $metric = (new Metric())->setType('viewability');
        $this->assertEquals('viewability', $metric->getType());
    }

    public function testMetricSetValue(): void
    {
        $metric = (new Metric())->setValue(0.85);
        $this->assertEquals(0.85, $metric->getValue());
    }

    public function testMetricSetVendor(): void
    {
        $metric = (new Metric())->setVendor('moat');
        $this->assertEquals('moat', $metric->getVendor());
    }

    public function testMetricGetType(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getType());
    }

    public function testMetricGetValue(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getValue());
    }

    public function testMetricGetVendor(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getVendor());
    }

    public function testMetricSetExt(): void
    {
        $ext = new Ext();
        $metric = (new Metric())->setExt($ext);
        $this->assertSame($ext, $metric->getExt());
    }

    public function testMetricGetExt(): void
    {
        $metric = new Metric();
        $this->assertNull($metric->getExt());
    }
}
