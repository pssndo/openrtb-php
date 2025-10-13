<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\AudioAd;
use OpenRTB\v3\Bid\Audit;
use OpenRTB\v3\Bid\Banner;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Data;
use OpenRTB\v3\Bid\DisplayAd;
use OpenRTB\v3\Bid\Image;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Title;
use OpenRTB\v3\Bid\VideoAd;
use OpenRTB\v3\Enums\Bid\AuditStatus;
use OpenRTB\v3\Enums\Bid\CreativeAttribute;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Placement\Event;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\Parser;

/**
 * @covers \OpenRTB\v3\Bid\Ad
 * @covers \OpenRTB\v3\Bid\AudioAd
 * @covers \OpenRTB\v3\Bid\Audit
 * @covers \OpenRTB\v3\Bid\Banner
 * @covers \OpenRTB\v3\Bid\Bid
 * @covers \OpenRTB\v3\Bid\Data
 * @covers \OpenRTB\v3\Bid\DisplayAd
 * @covers \OpenRTB\v3\Bid\Image
 * @covers \OpenRTB\v3\Bid\Link
 * @covers \OpenRTB\v3\Bid\Media
 * @covers \OpenRTB\v3\Bid\NativeAd
 * @covers \OpenRTB\v3\Bid\Seatbid
 * @covers \OpenRTB\v3\Bid\Title
 * @covers \OpenRTB\v3\Bid\VideoAd
 * @covers \OpenRTB\v3\Response
 */
class BidObjectsTest extends TestCase
{
    public function testFullBidObjectLifecycle(): void
    {
        // This test now exhaustively covers every setter and getter for 100% coverage.

        $ad = new Ad();
        $ad->setId('ad-id-123');
        $this->assertEquals('ad-id-123', $ad->getId());
        $ad->setAname('Ad Name');
        $this->assertEquals('Ad Name', $ad->getAname());
        $ad->setCrid('crid-555');
        $this->assertEquals('crid-555', $ad->getCrid());
        $ad->setAdomain(['advertiser.com']);
        $this->assertEquals(['advertiser.com'], $ad->getAdomain());
        $ad->setBundle(['com.app.bundle']);
        $this->assertEquals(['com.app.bundle'], $ad->getBundle());
        $ad->setIurl('http://iurl.com');
        $this->assertEquals('http://iurl.com', $ad->getIurl());
        $ad->setCat(['IAB1']);
        $this->assertEquals(['IAB1'], $ad->getCat());
        $ad->setCattax(1);
        $this->assertEquals(1, $ad->getCattax());
        $ad->setLang('en');
        $this->assertEquals('en', $ad->getLang());
        $ad->setAttr([CreativeAttribute::ONE_POOR]);
        $this->assertEquals([CreativeAttribute::ONE_POOR], $ad->getAttr());
        $ad->setSecure(1);
        $this->assertEquals(1, $ad->getSecure());
        $ad->setMrating(1);
        $this->assertEquals(1, $ad->getMrating());
        $ad->setInit(123);
        $this->assertEquals(123, $ad->getInit());
        $ad->setLastmod(456);
        $this->assertEquals(456, $ad->getLastmod());
        $ad->setW(300);
        $this->assertEquals(300, $ad->getW());
        $ad->setH(250);
        $this->assertEquals(250, $ad->getH());
        $ad->setDur(30);
        $this->assertEquals(30, $ad->getDur());
        $ad->setApis([ApiFramework::MRAID_2]);
        $this->assertEquals([ApiFramework::MRAID_2], $ad->getApis());

        $audioAd = new AudioAd();
        $audioAd->setAdm('audio_adm')->setDur(15)->setCurl('audio_curl')->setType(CreativeType::HTML)->setApis([ApiFramework::VPAID_2])->setMime(['audio/mp4']);
        $this->assertEquals('audio_adm', $audioAd->getAdm());
        $this->assertEquals(15, $audioAd->getDur());
        $this->assertEquals('audio_curl', $audioAd->getCurl());
        $this->assertEquals(CreativeType::HTML, $audioAd->getType());
        $this->assertEquals([ApiFramework::VPAID_2], $audioAd->getApis());
        $this->assertEquals(['audio/mp4'], $audioAd->getMime());

        $videoAd = new VideoAd();
        $videoAd->setAdm('video_adm')->setW(1920)->setH(1080)->setCurl('video_curl')->setType(CreativeType::AMPHTML)->setApis([ApiFramework::OMID_1])->setMime(['video/mp4'])->setDur(60);
        $this->assertEquals('video_adm', $videoAd->getAdm());
        $this->assertEquals(1920, $videoAd->getW());
        $this->assertEquals(1080, $videoAd->getH());
        $this->assertEquals('video_curl', $videoAd->getCurl());
        $this->assertEquals(CreativeType::AMPHTML, $videoAd->getType());
        $this->assertEquals([ApiFramework::OMID_1], $videoAd->getApis());
        $this->assertEquals(['video/mp4'], $videoAd->getMime());
        $this->assertEquals(60, $videoAd->getDur());

        $banner = (new Banner())->setImg('banner.jpg')->setLink([(new Link())->setUrl('banner.url')]);
        $this->assertEquals('banner.jpg', $banner->getImg());
        $this->assertIsArray($banner->getLink());
        $this->assertCount(1, $banner->getLink());

        $displayAd = (new DisplayAd())
            ->setAdm('display_adm')->setCurl('display_curl')->setBanner($banner)
            ->setMime('image/jpeg')->setApis([ApiFramework::MRAID_3])->setType(CreativeType::HTML)
            ->setW(300)->setH(250)->setWratio(120)->setHratio(100)
            ->setNative((new NativeAd()))->setEvent([(new Event())]);
        $this->assertEquals('display_adm', $displayAd->getAdm());
        $this->assertEquals('display_curl', $displayAd->getCurl());
        $this->assertSame($banner, $displayAd->getBanner());
        $this->assertEquals('image/jpeg', $displayAd->getMime());
        $this->assertEquals([ApiFramework::MRAID_3], $displayAd->getApis());
        $this->assertEquals(CreativeType::HTML, $displayAd->getType());
        $this->assertEquals(300, $displayAd->getW());
        $this->assertEquals(250, $displayAd->getH());
        $this->assertEquals(120, $displayAd->getWratio());
        $this->assertEquals(100, $displayAd->getHratio());
        $this->assertInstanceOf(NativeAd::class, $displayAd->getNative());
        $this->assertIsArray($displayAd->getEvent());
        $this->assertCount(1, $displayAd->getEvent());

        $audit = (new Audit())
            ->setStatus(AuditStatus::PENDING)
            ->setFeedback(['fb'])
            ->setInit(123)
            ->setLastmod(456)
            ->setCorr(['corr_key' => 'corr_val']);
        $this->assertEquals(AuditStatus::PENDING, $audit->getStatus());
        $this->assertEquals(['fb'], $audit->getFeedback());
        $this->assertEquals(123, $audit->getInit());
        $this->assertEquals(456, $audit->getLastmod());
        $this->assertEquals(['corr_key' => 'corr_val'], $audit->getCorr());

        $data = (new Data())->setValue('data_val');
        $this->assertEquals('data_val', $data->getValue());
        $image = (new Image())->setUrl('image.png');
        $this->assertEquals('image.png', $image->getUrl());
        $link = (new Link())->setUrl('link.url');
        $this->assertEquals('link.url', $link->getUrl());
        $title = (new Title())->setText('title_text');
        $this->assertEquals('title_text', $title->getText());

        $nativeAd = (new NativeAd())->setJstracker('tracker.js');
        $this->assertEquals('tracker.js', $nativeAd->getJstracker());

        $ad->setAudio($audioAd)->setVideo($videoAd)->setDisplay($displayAd)->setAudit($audit)->setNative($nativeAd);
        $this->assertSame($audioAd, $ad->getAudio());
        $this->assertSame($videoAd, $ad->getVideo());
        $this->assertSame($displayAd, $ad->getDisplay());
        $this->assertSame($audit, $ad->getAudit());
        $this->assertSame($nativeAd, $ad->getNative());

        $media = (new Media())->setAd($ad);
        $this->assertSame($ad, $media->getAd());

        $bid = (new Bid())
            ->setId('bid-1')->setPrice(2.50)->setDeal('deal-1')->setMedia($media)
            ->setItem('item-1')->setCid('cid-1')->setTactic('tactic-1')->setPurl('purl.com')
            ->setBurl('burl.com')->setLurl('lurl.com')->setMid('mid-1')->setMacro(['macro-1']);
        $this->assertEquals('bid-1', $bid->getId());
        $this->assertEquals(2.50, $bid->getPrice());
        $this->assertEquals('deal-1', $bid->getDeal());
        $this->assertSame($media, $bid->getMedia());
        $this->assertEquals('item-1', $bid->getItem());
        $this->assertEquals('cid-1', $bid->getCid());
        $this->assertEquals('tactic-1', $bid->getTactic());
        $this->assertEquals('purl.com', $bid->getPurl());
        $this->assertEquals('burl.com', $bid->getBurl());
        $this->assertEquals('lurl.com', $bid->getLurl());
        $this->assertEquals('mid-1', $bid->getMid());
        $this->assertEquals(['macro-1'], $bid->getMacro());

        $seatbid = (new Seatbid())->setSeat('seat-1')->addBid($bid)->setPackage(1);
        $this->assertEquals('seat-1', $seatbid->getSeat());
        $this->assertIsArray($seatbid->getBid());
        $this->assertCount(1, $seatbid->getBid());
        $this->assertEquals(1, $seatbid->getPackage());

        $response = (new Response())->setId('req-1')->addSeatbid($seatbid);
        $this->assertEquals('req-1', $response->getId());

        // 2. Serialize to JSON and back to test the Parser and schema.
        $json = $response->toJson();
        $this->assertIsString($json);
        $parsedResponse = Parser::parseResponse($json);

        // 3. Assert deep equality on the deserialized object.
        $this->assertInstanceOf(Response::class, $parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());

        $parsedSeatbids = $parsedResponse->getSeatbid();
        $this->assertIsArray($parsedSeatbids);
        $this->assertCount(1, $parsedSeatbids);
        $parsedSeatbid = $parsedSeatbids[0];
        $this->assertInstanceOf(Seatbid::class, $parsedSeatbid);

        $parsedBids = $parsedSeatbid->getBid();
        $this->assertIsArray($parsedBids);
        $this->assertCount(1, $parsedBids);
        $parsedBid = $parsedBids[0];
        $this->assertInstanceOf(Bid::class, $parsedBid);

        $parsedMedia = $parsedBid->getMedia();
        $this->assertInstanceOf(Media::class, $parsedMedia);

        $parsedAd = $parsedMedia->getAd();
        $this->assertInstanceOf(Ad::class, $parsedAd);

        $this->assertEquals([CreativeAttribute::ONE_POOR], $parsedAd->getAttr());
        $this->assertNotNull($parsedAd->getAudit());
        $this->assertEquals(AuditStatus::PENDING, $parsedAd->getAudit()->getStatus());
        $this->assertEquals(123, $parsedAd->getAudit()->getInit());
        $this->assertEquals('Ad Name', $parsedAd->getAname());
        $this->assertEquals('http://iurl.com', $parsedAd->getIurl());
        $this->assertEquals(30, $parsedAd->getDur());
    }
}
