<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Data;
use OpenRTB\v3\Bid\Image;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Title;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\AssetFormat;
use OpenRTB\v3\Placement\DataFormat;
use OpenRTB\v3\Placement\ImageFormat;
use OpenRTB\v3\Placement\NativeFormat;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\TitleFormat;
use OpenRTB\v3\Request;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\Parser;

/**
 * @covers \OpenRTB\v3\Placement\NativeFormat
 * @covers \OpenRTB\v3\Placement\AssetFormat
 * @covers \OpenRTB\v3\Placement\TitleFormat
 * @covers \OpenRTB\v3\Placement\ImageFormat
 * @covers \OpenRTB\v3\Placement\DataFormat
 * @covers \OpenRTB\v3\Bid\NativeAd
 * @covers \OpenRTB\v3\Bid\Asset
 * @covers \OpenRTB\v3\Bid\Title
 * @covers \OpenRTB\v3\Bid\Image
 * @covers \OpenRTB\v3\Bid\Data
 * @covers \OpenRTB\v3\Bid\Link
 */
class NativeAdsTest extends TestCase
{
    public function testFullNativePlacementLifecycle(): void
    {
        $titleFormat = (new TitleFormat())->setLen(140);
        $this->assertEquals(140, $titleFormat->getLen());

        $imageFormat = (new ImageFormat())->setW(800)->setH(600);
        $this->assertEquals(800, $imageFormat->getW());
        $this->assertEquals(600, $imageFormat->getH());

        $dataFormat = (new DataFormat())->setType(1);
        $this->assertEquals(1, $dataFormat->getType());

        $assetFormat = (new AssetFormat())->setId(1)->setReq(1)->setTitle($titleFormat)->setImg($imageFormat)->setData($dataFormat);
        $this->assertEquals(1, $assetFormat->getId());
        $this->assertEquals(1, $assetFormat->getReq());
        $this->assertSame($titleFormat, $assetFormat->getTitle());
        $this->assertSame($imageFormat, $assetFormat->getImg());
        $this->assertSame($dataFormat, $assetFormat->getData());

        $nativeFormat = (new NativeFormat())->setAsset([$assetFormat]);
        $this->assertIsArray($nativeFormat->getAsset());
        $this->assertCount(1, $nativeFormat->getAsset());

        $placement = (new Placement())->setNativefmt($nativeFormat);
        $request = (new Request())->addItem((new Item())->setSpec((new Spec())->setPlacement($placement)));

        $json = $request->toJson();
        $this->assertIsString($json);
        $parsedRequest = Parser::parseRequest($json);

        $this->assertInstanceOf(Request::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());

        $items = $parsedRequest->getItem();
        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertInstanceOf(Item::class, $item);

        $spec = $item->getSpec();
        $this->assertInstanceOf(Spec::class, $spec);

        $parsedPlacement = $spec->getPlacement();
        $this->assertInstanceOf(Placement::class, $parsedPlacement);

        $parsedNativeFormat = $parsedPlacement->getNativefmt();
        $this->assertInstanceOf(NativeFormat::class, $parsedNativeFormat);

        $parsedAssets = $parsedNativeFormat->getAsset();
        $this->assertIsArray($parsedAssets);
        $this->assertCount(1, $parsedAssets);
        $parsedAsset = $parsedAssets[0];
        $this->assertInstanceOf(AssetFormat::class, $parsedAsset);

        $parsedTitle = $parsedAsset->getTitle();
        $this->assertInstanceOf(TitleFormat::class, $parsedTitle);
        $this->assertEquals(140, $parsedTitle->getLen());

        $parsedImg = $parsedAsset->getImg();
        $this->assertInstanceOf(ImageFormat::class, $parsedImg);
        $this->assertEquals(800, $parsedImg->getW());

        $parsedData = $parsedAsset->getData();
        $this->assertInstanceOf(DataFormat::class, $parsedData);
        $this->assertEquals(1, $parsedData->getType());
    }

    public function testFullNativeResponseLifecycle(): void
    {
        $title = (new Title())->setText('Test Title');
        $this->assertEquals('Test Title', $title->getText());

        $image = (new Image())->setUrl('img.jpg')->setW(100)->setH(100);
        $this->assertEquals('img.jpg', $image->getUrl());
        $this->assertEquals(100, $image->getW());
        $this->assertEquals(100, $image->getH());

        $data = (new Data())->setValue('data-val');
        $this->assertEquals('data-val', $data->getValue());

        $link = (new Link())->setUrl('link.url')->setFallback('fallback.url')->setTrkr(['tracker.url']);
        $this->assertEquals('link.url', $link->getUrl());
        $this->assertEquals('fallback.url', $link->getFallback());
        $this->assertEquals(['tracker.url'], $link->getTrkr());

        $asset = (new Asset())->setId(1)->setReq(1)->setTitle($title)->setImg($image)->setData($data)->setLink($link);
        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(1, $asset->getReq());
        $this->assertSame($title, $asset->getTitle());
        $this->assertSame($image, $asset->getImg());
        $this->assertSame($data, $asset->getData());
        $this->assertSame($link, $asset->getLink());

        $nativeAd = (new NativeAd())
            ->setAsset([$asset])
            ->setLink($link)
            ->setJstracker('native-tracker.js')
            ->setVer('1.2')
            ->setImptrackers(['imp.tracker.url']);
        $this->assertIsArray($nativeAd->getAsset());
        $this->assertCount(1, $nativeAd->getAsset());
        $this->assertSame($link, $nativeAd->getLink());
        $this->assertEquals('native-tracker.js', $nativeAd->getJstracker());
        $this->assertEquals('1.2', $nativeAd->getVer());
        $this->assertEquals(['imp.tracker.url'], $nativeAd->getImptrackers());

        $response = (new Response())->addSeatbid((new Seatbid())->addBid((new Bid())->setMedia((new Media())->setAd((new Ad())->setNative($nativeAd)))));

        $json = $response->toJson();
        $this->assertIsString($json);
        $parsedResponse = Parser::parseResponse($json);

        $this->assertInstanceOf(Response::class, $parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());

        $seatbids = $parsedResponse->getSeatbid();
        $this->assertIsArray($seatbids);
        $this->assertCount(1, $seatbids);
        $seatbid = $seatbids[0];
        $this->assertInstanceOf(Seatbid::class, $seatbid);

        $bids = $seatbid->getBid();
        $this->assertIsArray($bids);
        $this->assertCount(1, $bids);
        $bid = $bids[0];
        $this->assertInstanceOf(Bid::class, $bid);

        $media = $bid->getMedia();
        $this->assertInstanceOf(Media::class, $media);

        $ad = $media->getAd();
        $this->assertInstanceOf(Ad::class, $ad);

        $parsedNativeAd = $ad->getNative();
        $this->assertInstanceOf(NativeAd::class, $parsedNativeAd);
        $this->assertEquals(['imp.tracker.url'], $parsedNativeAd->getImptrackers());

        $parsedAssets = $parsedNativeAd->getAsset();
        $this->assertIsArray($parsedAssets);
        $this->assertCount(1, $parsedAssets);
        $parsedAsset = $parsedAssets[0];
        $this->assertInstanceOf(Asset::class, $parsedAsset);

        $parsedTitle = $parsedAsset->getTitle();
        $this->assertInstanceOf(Title::class, $parsedTitle);
        $this->assertEquals('Test Title', $parsedTitle->getText());

        $parsedImg = $parsedAsset->getImg();
        $this->assertInstanceOf(Image::class, $parsedImg);
        $this->assertEquals('img.jpg', $parsedImg->getUrl());

        $parsedData = $parsedAsset->getData();
        $this->assertInstanceOf(Data::class, $parsedData);
        $this->assertEquals('data-val', $parsedData->getValue());

        $parsedLink = $parsedAsset->getLink();
        $this->assertInstanceOf(Link::class, $parsedLink);
        $this->assertEquals('link.url', $parsedLink->getUrl());
    }
}
