<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Audit;
use OpenRTB\v3\Bid\Data;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Image;
use OpenRTB\v3\Bid\Deal;
use OpenRTB\v3\Bid\Display;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Audio;
use OpenRTB\v3\Bid\Display\Native;
use OpenRTB\v3\Bid\Event;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Macro;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Title;
use OpenRTB\v3\Bid\Video;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\Bid\EventType;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Bid\AuditStatus;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\BaseObject 
 * @covers \OpenRTB\v3\Bid\Ad
 * @covers \OpenRTB\v3\Bid\Asset
 * @covers \OpenRTB\v3\Bid\Asset
 * @covers \OpenRTB\v3\Bid\Audit
 * @covers \OpenRTB\v3\Bid\Data
 * @covers \OpenRTB\v3\Bid\Bid
 * @covers \OpenRTB\v3\Bid\Deal
 * @covers \OpenRTB\v3\Bid\Display
 * @covers \OpenRTB\v3\Bid\Display\Banner
 * @covers \OpenRTB\v3\Bid\Display\Native
 * @covers \OpenRTB\v3\Bid\Event
 * @covers \OpenRTB\v3\Bid\Link
 * @covers \OpenRTB\v3\Bid\Image
 * @covers \OpenRTB\v3\Bid\Macro
 * @covers \OpenRTB\v3\Bid\Media
 * @covers \OpenRTB\v3\Bid\Seatbid
 * @covers \OpenRTB\v3\Bid\Seatbid
 * @covers \OpenRTB\v3\Bid\NativeAd
 * @covers \OpenRTB\v3\Bid\Title
 * @covers \OpenRTB\v3\Bid\Video
 * @covers \OpenRTB\v3\Bid\Audio
 */
class BidObjectsTest extends TestCase
{
    public function testFullBidObjectLifecycle(): void
    {
        $response = new Response();
        $response->setId('response-1');

        $seatbid = new Seatbid();
        $seatbid->setSeat('seat-1');

        $bid = new Bid();
        $bid->setId('bid-1');
        $bid->setPrice(1.50);
        $this->assertEquals('bid-1', $bid->getId());
        $this->assertEquals(1.50, $bid->getPrice());

        $media = new Media();
        $ad = new Ad();
        $ad->setId('ad-1');
        $ad->setBundle(['com.example.app']);
        $ad->setAdomain(['advertiser.com']);
        $ad->setCat(['IAB1']);
        $ad->setCattax(1);
        $ad->setLang('en');
        $ad->setAttr([CreativeAttribute::ONE_POOR]);
        $ad->setSecure(1);
        $ad->setInit(12345);
        $ad->setLastmod(12345);

        $this->assertEquals('ad-1', $ad->getId());
        $this->assertEquals(['com.example.app'], $ad->getBundle());
        $this->assertEquals(['advertiser.com'], $ad->getAdomain());
        $this->assertEquals(['IAB1'], $ad->getCat());
        $this->assertEquals(1, $ad->getCattax());
        $this->assertEquals('en', $ad->getLang());
        $this->assertEquals([CreativeAttribute::ONE_POOR], $ad->getAttr());
        $this->assertEquals(1, $ad->getSecure());
        $this->assertEquals(12345, $ad->getInit());
        $this->assertEquals(12345, $ad->getLastmod());

        $display = new Display();
        $link = (new Link())->setUrl('https://example.com/click');
        $banner = new Banner();
        $banner->setH(250)
            ->setW(300)
            ->setImg('https://example.com/banner.jpg')
            ->setLink($link);

        $native = new Native();
        $native->setLink($link);

        $display->setBanner($banner);
        $display->setNative($native);
        $ad->setDisplay($display);
        $this->assertSame($display, $ad->getDisplay());
        $this->assertEquals(250, $banner->getH());
        $this->assertEquals(300, $banner->getW());
        $this->assertEquals('https://example.com/banner.jpg', $banner->getImg());
        $this->assertSame($link, $banner->getLink());
        $this->assertIsArray(Banner::getSchema());

        $this->assertSame($banner, $display->getBanner());
        $this->assertSame($native, $display->getNative());

        $video = new Video();
        $video->setCtype('video/mp4');
        $video->setMime('video/mp4');
        $video->setDur(30);
        $video->setCurl('https://example.com/video.mp4');
        $video->setAdm('<VAST>...</VAST>');
        $video->setApi([ApiFramework::VPAID_2]);
        $ad->setVideo($video);
        $this->assertSame($video, $ad->getVideo());
        $this->assertEquals('video/mp4', $video->getCtype());
        $this->assertEquals('video/mp4', $video->getMime());
        $this->assertEquals(30, $video->getDur());
        $this->assertEquals('https://example.com/video.mp4', $video->getCurl());
        $this->assertEquals('<VAST>...</VAST>', $video->getAdm());
        $this->assertEquals([ApiFramework::VPAID_2], $video->getApi());

        $audio = new Audio();
        $audio->setAdm('<DAAST>...</DAAST>');
        $audio->setCurl('https://example.com/audio.xml');
        $audio->setApi([ApiFramework::VPAID_2]);
        $audio->setMime('audio/mp4');
        $audio->setDur(30);
        $ad->setAudio($audio);
        $this->assertSame($audio, $ad->getAudio());
        $this->assertEquals('<DAAST>...</DAAST>', $audio->getAdm());
        $this->assertEquals('https://example.com/audio.xml', $audio->getCurl());
        $this->assertEquals('audio/mp4', $audio->getMime());
        $this->assertEquals(30, $audio->getDur());
        $this->assertEquals([ApiFramework::VPAID_2], $audio->getApi());

        $nativeAd = new NativeAd();
        $nativeAd->setPrivacy('https://example.com/privacy');
        $ad->setNative($nativeAd);
        $this->assertSame($nativeAd, $ad->getNative());

        $audit = new Audit();
        $audit->setStatus(AuditStatus::PENDING);
        $audit->setFeedback(['feedback']);
        $audit->setInit(12345);
        $audit->setLastmod(12345);
        $audit->setCorr(['key' => 'value']);
        $ad->setAudit($audit);
        $this->assertSame($audit, $ad->getAudit());
        $this->assertEquals(AuditStatus::PENDING, $audit->getStatus());
        $this->assertEquals(['feedback'], $audit->getFeedback());
        $this->assertEquals(12345, $audit->getInit());
        $this->assertEquals(12345, $audit->getLastmod());
        $this->assertEquals(['key' => 'value'], $audit->getCorr());

        $media->setAd($ad);
        $this->assertSame($ad, $media->getAd());
        $bid->setMedia($media);
        $this->assertSame($media, $bid->getMedia());

        $deal = new Deal();
        $deal->setId('deal-1');
        $deal->setPrice(1.40);
        $deal->setWseat(['seat-2']);
        $deal->setWadomain(['advertiser.com']);
        $deal->setAt(2);
        $bid->setDeal($deal);
        $this->assertSame($deal, $bid->getDeal());
        $this->assertEquals('deal-1', $deal->getId());
        $this->assertEquals(1.40, $deal->getPrice());
        $this->assertEquals(['seat-2'], $deal->getWseat());
        $this->assertEquals(['advertiser.com'], $deal->getWadomain());
        $this->assertEquals(2, $deal->getAt());

        $macro = new Macro();
        $macro->setKey('key');
        $macro->setValue('value');
        $bid->setMacro([$macro]);
        $this->assertEquals('key', $macro->getKey());
        $this->assertEquals('value', $macro->getValue());
        $this->assertCount(1, $bid->getMacro());

        $seatbid->addBid($bid);
        $response->addSeatbid($seatbid);

        $json = $response->toJson();
        $this->assertIsString($json);

        $parsedResponse = Parser::parseResponse($json);
        $this->assertInstanceOf(Response::class, $parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());
    }

    public function testNativeAdObject(): void
    {
        $nativeAd = new NativeAd();
        $link = (new Link())
            ->setUrl('https://example.com')
            ->setTrkr(['https://tracker.com'])
            ->setFallback('https://fallback.com');
        $this->assertEquals('https://example.com', $link->getUrl());
        $this->assertEquals(['https://tracker.com'], $link->getTrkr());
        $this->assertEquals('https://fallback.com', $link->getFallback());

        $asset = new Asset();
        $asset->setId(1);
        $asset->setReq(1);

        $title = new Title();
        $title->setText('Native Title');
        $asset->setTitle($title);
        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(1, $asset->getReq());
        $this->assertSame($title, $asset->getTitle());
        $this->assertEquals('Native Title', $title->getText());
        $this->assertIsArray($title::getSchema());
        $this->assertIsArray(Title::getSchema());

        $image = new Image();
        $image->setUrl('https://example.com/image.png')->setW(1200)->setH(627);
        $asset->setImg($image);
        $this->assertSame($image, $asset->getImg());
        $this->assertEquals('https://example.com/image.png', $image->getUrl());
        $this->assertEquals(1200, $image->getW());
        $this->assertEquals(627, $image->getH());
        $this->assertIsArray(Image::getSchema());

        $data = new Data();
        $data->setValue('asset-data-value');
        $asset->setData($data);
        $this->assertSame($data, $asset->getData());

        $this->assertIsArray($asset::getSchema());

        $asset->setLink($link);
        $this->assertSame($link, $asset->getLink());

        $event = new Event();
        $event->setType(EventType::IMPRESSION);
        $event->setMethod(1);
        $event->setUrl('https://example.com/impression');

        $nativeAd->setLink($link);
        $nativeAd->setAsset([$asset]);
        $nativeAd->setEvent([$event]);
        $nativeAd->setPrivacy('https://example.com/privacy');

        $this->assertSame($link, $nativeAd->getLink());
        $this->assertCount(1, $nativeAd->getAsset());
        $this->assertSame($asset, $nativeAd->getAsset()[0]);
        $this->assertCount(1, $nativeAd->getEvent());
        $this->assertSame($event, $nativeAd->getEvent()[0]);
        $this->assertEquals('https://example.com/privacy', $nativeAd->getPrivacy());
    }

    public function testDisplayNativeObject(): void
    {
        $native = new Native();
        $link = new Link();
        $link->setUrl('https://example.com');
        $native->setLink($link);
        $native->setAsset(['asset']);

        $this->assertSame($link, $native->getLink());
        $this->assertEquals(['asset'], $native->getAsset());
    }

    public function testSeatbidObject(): void
    {
        $seatbid = new Seatbid();
        $seatbid->setSeat('seat-1')->setPackage(1);
        $bid = new Bid();
        $bid->setId('bid-1');
        $seatbid->addBid($bid);

        $this->assertEquals('seat-1', $seatbid->getSeat());
        $this->assertEquals(1, $seatbid->getPackage());
        $this->assertCount(1, $seatbid->getBid());
        $this->assertSame($bid, $seatbid->getBid()[0]);
    }

    public function testDataObject(): void
    {
        $data = new Data();
        $data->setValue('some-data-value');

        $this->assertEquals('some-data-value', $data->getValue());
    }
}
