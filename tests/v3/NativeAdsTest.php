<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\Bid\Ad;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Bid;
use OpenRTB\v3\Bid\Link;
use OpenRTB\v3\Bid\Media;
use OpenRTB\v3\Bid\NativeAd;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Bid\Title;
use OpenRTB\v3\Enums\Placement\ContextType;
use OpenRTB\v3\Enums\Placement\EventType;
use OpenRTB\v3\Enums\Placement\NativeAdUnit;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\AssetFormat;
use OpenRTB\v3\Placement\DataFormat;
use OpenRTB\v3\Placement\EventSpec;
use OpenRTB\v3\Placement\ImageFormat;
use OpenRTB\v3\Placement\NativePlacement;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\TitleFormat;
use OpenRTB\v3\Placement\VideoPlacement;
use OpenRTB\v3\Request;
use OpenRTB\v3\Response;
use OpenRTB\v3\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Placement\Placement
 * @covers \OpenRTB\v3\Placement\NativePlacement
 * @covers \OpenRTB\v3\Placement\AssetFormat
 * @covers \OpenRTB\v3\Placement\EventSpec
 * @covers \OpenRTB\v3\Placement\ImageFormat
 * @covers \OpenRTB\v3\Bid\NativeAd
 */
class NativeAdsTest extends TestCase
{
    /**
     * @covers \OpenRTB\v3\Placement\NativePlacement
     */
    public function testFullNativePlacementLifecycle(): void
    {
        $request = new Request();
        $item = new Item();
        $spec = new Spec();
        $placement = new Placement();
        $native = new NativePlacement();

        $asset = new AssetFormat();
        $asset->setId(1);
        $asset->setReq(1);

        $title = new TitleFormat();
        $title->setLen(140);
        $asset->setTitle($title);

        $image = new ImageFormat();
        $image->setH(627);
        $image->setW(1200);
        $asset->setImg($image);

        $video = new VideoPlacement();
        $asset->setVideo($video);
        $this->assertSame($video, $asset->getVideo());

        $data = new DataFormat();
        $data->setType(1);
        $data->setLen(50);
        $asset->setData($data);

        $event = new EventSpec();
        $event->setType(EventType::IMPRESSION);
        $event->setMethod([1, 2]);
        $this->assertEquals(EventType::IMPRESSION, $event->getType());
        $this->assertEquals([1, 2], $event->getMethod());
        $this->assertIsArray(EventSpec::getSchema());

        $native
            ->setContext(ContextType::SOCIAL_CENTRIC_FEED)
            ->setPlcmttype(1)
            ->setUnit(NativeAdUnit::AD_UNIT_ID_PAID_SEARCH_UNITS)
            ->setAdunit(1)
            ->setVer('1.2')
            ->setApi([3, 5])
            ->setAsset([$asset])
            ->setEvent([$event]);

        $placement->setNative($native);
        $this->assertSame($native, $placement->getNative());
        $spec->setPlacement($placement);
        $item->setSpec($spec);
        $request->addItem($item);

        $json = $request->toJson();
        $this->assertIsString($json);

        $parsedRequest = Parser::parseRequest($json);
        $this->assertInstanceOf(Request::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());
    }

    public function testFullNativeResponseLifecycle(): void
    {
        $response = new Response();
        $response->setId('response-1');

        $seatbid = new Seatbid();
        $seatbid->setSeat('seat-1');

        $bid = new Bid();
        $bid->setId('bid-1');
        $bid->setPrice(1.50);

        $media = new Media();
        $ad = new Ad();
        $nativeAd = new NativeAd();

        $link = new Link();
        $link->setUrl('https://example.com');
        $nativeAd->setLink($link);

        $asset = new Asset();
        $asset->setId(1);
        $title = new Title();
        $title->setText('Native Title');
        $asset->setTitle($title);
        $nativeAd->setAsset([$asset]);

        $ad->setNative($nativeAd);
        $media->setAd($ad);
        $bid->setMedia($media);
        $seatbid->addBid($bid);
        $response->addSeatbid($seatbid);

        $json = $response->toJson();
        $this->assertIsString($json);

        $parsedResponse = Parser::parseResponse($json);
        $this->assertInstanceOf(Response::class, $parsedResponse);
        $this->assertEquals($response->toArray(), $parsedResponse->toArray());

        $this->assertIsArray(NativeAd::getSchema());
    }
}
