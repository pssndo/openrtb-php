<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Impression\DeliveryMethod;
use OpenRTB\v3\Enums\Placement\ContextType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\BoxingAllowed;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\CompanionType;
use OpenRTB\v3\Enums\EventType;
use OpenRTB\v3\Enums\Placement\FeedType;
use OpenRTB\v3\Enums\Placement\Linearity;
use OpenRTB\v3\Enums\Placement\PlacementType;
use OpenRTB\v3\Enums\Placement\PlaybackCessationMode;
use OpenRTB\v3\Enums\Placement\PlaybackMethod;
use OpenRTB\v3\Enums\Placement\SizeUnit;
use OpenRTB\v3\Enums\Placement\VideoPlacementType;
use OpenRTB\v3\Enums\Placement\VolumeNormalizationMode;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\AssetFormat;
use OpenRTB\v3\Placement\AudioPlacement;
use OpenRTB\v3\Placement\DataFormat;
use OpenRTB\v3\Placement\DisplayFormat;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Event;
use OpenRTB\v3\Placement\ImageFormat;
use OpenRTB\v3\Placement\NativeFormat;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\TitleFormat;
use OpenRTB\v3\Placement\VideoPlacement;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Util\Parser;
use OpenRTB\Common\Collection;

/**
 * @covers \OpenRTB\v3\Placement\Placement
 * @covers \OpenRTB\v3\Placement\DisplayPlacement
 * @covers \OpenRTB\v3\Placement\VideoPlacement
 * @covers \OpenRTB\v3\Placement\AudioPlacement
 * @covers \OpenRTB\v3\Placement\NativeFormat
 * @covers \OpenRTB\v3\Placement\AssetFormat
 * @covers \OpenRTB\v3\Placement\TitleFormat
 * @covers \OpenRTB\v3\Placement\ImageFormat
 * @covers \OpenRTB\v3\Placement\DataFormat
 * @covers \OpenRTB\v3\Placement\DisplayFormat
 * @covers \OpenRTB\v3\Placement\Event
 */
class PlacementObjectsTest extends TestCase
{
    public function testFullPlacementObjectLifecycle(): void
    {
        // 1. Create and exhaustively test every object in the Placement namespace.
        $displayFormat = (new DisplayFormat())->setW(300)->setH(250)->setWratio(120)->setHratio(100)->setExpdir([1]);
        $this->assertEquals(300, $displayFormat->getW());
        $this->assertEquals(250, $displayFormat->getH());
        $this->assertEquals(120, $displayFormat->getWratio());
        $this->assertEquals(100, $displayFormat->getHratio());
        $this->assertEquals([1], $displayFormat->getExpdir());

        $event = (new Event())->setType(EventType::VIEWABLE_MRC50)->setMethod(1)->setUrl('event.url')->setCdata(['key' => 'val']);
        $this->assertEquals(EventType::VIEWABLE_MRC50, $event->getType());
        $this->assertEquals(1, $event->getMethod());
        $this->assertEquals('event.url', $event->getUrl());
        $this->assertEquals(['key' => 'val'], $event->getCdata());

        $titleFormat = (new TitleFormat())->setLen(140);
        $this->assertEquals(140, $titleFormat->getLen());

        $imageFormat = (new ImageFormat())->setW(800)->setH(600)->setWmin(700)->setHmin(500)->setMimes(['image/jpeg'])->setType(1);
        $this->assertEquals(800, $imageFormat->getW());
        $this->assertEquals(600, $imageFormat->getH());
        $this->assertEquals(700, $imageFormat->getWmin());
        $this->assertEquals(500, $imageFormat->getHmin());
        $this->assertEquals(['image/jpeg'], $imageFormat->getMimes());
        $this->assertEquals(1, $imageFormat->getType());

        $dataFormat = (new DataFormat())->setType(1)->setLen(50);
        $this->assertEquals(1, $dataFormat->getType());
        $this->assertEquals(50, $dataFormat->getLen());

        $assetFormat = (new AssetFormat())->setId(1)->setReq(1)->setTitle($titleFormat)->setImg($imageFormat)->setData($dataFormat);
        $this->assertEquals(1, $assetFormat->getId());
        $this->assertEquals(1, $assetFormat->getReq());
        $this->assertSame($titleFormat, $assetFormat->getTitle());
        $this->assertSame($imageFormat, $assetFormat->getImg());
        $this->assertSame($dataFormat, $assetFormat->getData());

        $nativeFormat = (new NativeFormat())->setAsset([$assetFormat])->setPriv(1);
        $this->assertInstanceOf(Collection::class, $nativeFormat->getAsset());
        $this->assertCount(1, $nativeFormat->getAsset());
        $this->assertEquals(1, $nativeFormat->getPriv());

        $displayPlacement = (new DisplayPlacement())
            ->setPos(AdPosition::ABOVE_FOLD)->setClktype(ClickType::CLICKABLE)->setPtype(PlacementType::IN_ATOMIC_UNIT)
            ->setContext(ContextType::CONTENT)->setApi([ApiFramework::MRAID_2])->setCtype([CreativeType::HTML])
            ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)->setDisplayfmt([$displayFormat])->setEvent([$event])->setNativefmt($nativeFormat)
            ->setInstl(1)->setTopframe(1)->setIfrbust(['ifrbust'])->setAmpren(1)->setW(300)->setH(250)->setPriv(1)->setMime(['image/png']);
        $this->assertEquals(AdPosition::ABOVE_FOLD, $displayPlacement->getPos());
        $this->assertEquals(ClickType::CLICKABLE, $displayPlacement->getClktype());
        $this->assertEquals(PlacementType::IN_ATOMIC_UNIT, $displayPlacement->getPtype());
        $this->assertEquals(ContextType::CONTENT, $displayPlacement->getContext());
        $this->assertEquals([ApiFramework::MRAID_2], $displayPlacement->getApi()->toArray());
        $this->assertEquals([CreativeType::HTML], $displayPlacement->getCtype()->toArray());
        $this->assertEquals(SizeUnit::DENSITY_INDEPENDENT_PIXELS, $displayPlacement->getUnit());
        $this->assertInstanceOf(Collection::class, $displayPlacement->getDisplayfmt());
        $this->assertCount(1, $displayPlacement->getDisplayfmt());
        $this->assertInstanceOf(Collection::class, $displayPlacement->getEvent());
        $this->assertCount(1, $displayPlacement->getEvent());
        $this->assertSame($nativeFormat, $displayPlacement->getNativefmt());
        $this->assertEquals(1, $displayPlacement->getInstl());
        $this->assertEquals(1, $displayPlacement->getTopframe());
        $this->assertEquals(['ifrbust'], $displayPlacement->getIfrbust()->toArray());
        $this->assertEquals(1, $displayPlacement->getAmpren());
        $this->assertEquals(300, $displayPlacement->getW());
        $this->assertEquals(250, $displayPlacement->getH());
        $this->assertEquals(1, $displayPlacement->getPriv());
        $this->assertEquals(['image/png'], $displayPlacement->getMime()->toArray());

        $videoPlacement = (new VideoPlacement())
            ->setPtype(VideoPlacementType::INSTREAM)->setLinear(Linearity::LINEAR)->setPlaymethod([PlaybackMethod::ON_CLICK_SOUND_ON])
            ->setPlayend(PlaybackCessationMode::ON_VIDEO_COMPLETION)->setBoxing(BoxingAllowed::ALLOWED)->setDelivery([DeliveryMethod::TAG])
            ->setComptype([CompanionType::HTML_RESOURCE])->setPos(AdPosition::HEADER)->setDelay(10)->setSkip(1)->setSkipmin(5)
            ->setSkipafter(15)->setClktype(ClickType::NON_CLICKABLE)->setMime(['video/mp4'])->setApi([ApiFramework::VPAID_2])
            ->setCtype([CreativeType::AMPHTML])->setW(1920)->setH(1080)->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)->setMindur(5)->setMaxdur(30)
            ->setMaxext(60)->setMinbitr(320)->setMaxbitr(1024)->setMaxseq(2)->setComp([$displayPlacement]);
        $this->assertEquals(VideoPlacementType::INSTREAM, $videoPlacement->getPtype());
        $this->assertEquals(Linearity::LINEAR, $videoPlacement->getLinear());
        $this->assertEquals([PlaybackMethod::ON_CLICK_SOUND_ON], $videoPlacement->getPlaymethod()->toArray());
        $this->assertEquals(PlaybackCessationMode::ON_VIDEO_COMPLETION, $videoPlacement->getPlayend());
        $this->assertEquals(BoxingAllowed::ALLOWED, $videoPlacement->getBoxing());
        $this->assertEquals([DeliveryMethod::TAG], $videoPlacement->getDelivery()->toArray());
        $this->assertEquals([CompanionType::HTML_RESOURCE], $videoPlacement->getComptype()->toArray());
        $this->assertEquals(AdPosition::HEADER, $videoPlacement->getPos());
        $this->assertEquals(10, $videoPlacement->getDelay());
        $this->assertEquals(1, $videoPlacement->getSkip());
        $this->assertEquals(5, $videoPlacement->getSkipmin());
        $this->assertEquals(15, $videoPlacement->getSkipafter());
        $this->assertEquals(ClickType::NON_CLICKABLE, $videoPlacement->getClktype());
        $this->assertEquals(['video/mp4'], $videoPlacement->getMime()->toArray());
        $this->assertEquals([ApiFramework::VPAID_2], $videoPlacement->getApi()->toArray());
        $this->assertEquals([CreativeType::AMPHTML], $videoPlacement->getCtype()->toArray());
        $this->assertEquals(1920, $videoPlacement->getW());
        $this->assertEquals(1080, $videoPlacement->getH());
        $this->assertEquals(SizeUnit::DENSITY_INDEPENDENT_PIXELS, $videoPlacement->getUnit());
        $this->assertEquals(5, $videoPlacement->getMindur());
        $this->assertEquals(30, $videoPlacement->getMaxdur());
        $this->assertEquals(60, $videoPlacement->getMaxext());
        $this->assertEquals(320, $videoPlacement->getMinbitr());
        $this->assertEquals(1024, $videoPlacement->getMaxbitr());
        $this->assertEquals(2, $videoPlacement->getMaxseq());
        $this->assertInstanceOf(Collection::class, $videoPlacement->getComp());
        $this->assertCount(1, $videoPlacement->getComp());

        $audioPlacement = (new AudioPlacement())
            ->setFeed(FeedType::PODCAST)->setNvol(VolumeNormalizationMode::AD_LOUDNESS)->setDelay(15)->setSkip(1)
            ->setSkipmin(5)->setSkipafter(10)->setPlaymethod([PlaybackMethod::ON_PAGE_LOAD_SOUND_ON])
            ->setPlayend(PlaybackCessationMode::ON_LEAVING_VIEWPORT)->setMime(['audio/mp4'])->setApi([ApiFramework::VPAID_2])
            ->setCtype([CreativeType::HTML])->setMindur(5)->setMaxdur(30)->setMaxext(60)->setMinbitr(320)
            ->setMaxbitr(1024)->setDelivery([DeliveryMethod::PROGRAMMATIC])->setMaxseq(2)->setComp([$displayPlacement])
            ->setComptype([CompanionType::STATIC_RESOURCE]);
        $this->assertEquals(FeedType::PODCAST, $audioPlacement->getFeed());
        $this->assertEquals(VolumeNormalizationMode::AD_LOUDNESS, $audioPlacement->getNvol());
        $this->assertEquals(15, $audioPlacement->getDelay());
        $this->assertEquals(1, $audioPlacement->getSkip());
        $this->assertEquals(5, $audioPlacement->getSkipmin());
        $this->assertEquals(10, $audioPlacement->getSkipafter());
        $this->assertEquals([PlaybackMethod::ON_PAGE_LOAD_SOUND_ON], $audioPlacement->getPlaymethod()->toArray());
        $this->assertEquals(PlaybackCessationMode::ON_LEAVING_VIEWPORT, $audioPlacement->getPlayend());
        $this->assertEquals(['audio/mp4'], $audioPlacement->getMime()->toArray());
        $this->assertEquals([ApiFramework::VPAID_2], $audioPlacement->getApi()->toArray());
        $this->assertEquals([CreativeType::HTML], $audioPlacement->getCtype()->toArray());
        $this->assertEquals(5, $audioPlacement->getMindur());
        $this->assertEquals(30, $audioPlacement->getMaxdur());
        $this->assertEquals(60, $audioPlacement->getMaxext());
        $this->assertEquals(320, $audioPlacement->getMinbitr());
        $this->assertEquals(1024, $audioPlacement->getMaxbitr());
        $this->assertEquals([DeliveryMethod::PROGRAMMATIC], $audioPlacement->getDelivery()->toArray());
        $this->assertEquals(2, $audioPlacement->getMaxseq());
        $this->assertInstanceOf(Collection::class, $audioPlacement->getComp());
        $this->assertCount(1, $audioPlacement->getComp());
        $this->assertEquals([CompanionType::STATIC_RESOURCE], $audioPlacement->getComptype()->toArray());

        $placement = (new Placement())
            ->setTagid('placement-1')->setW(800)->setH(600)->setReward(1)->setSsai(1)->setSdk('sdk')->setSdkver('1.0')
            ->setUnit(SizeUnit::DENSITY_INDEPENDENT_PIXELS)->setPriv(1)
            ->setDisplay($displayPlacement)->setVideo($videoPlacement)->setAudio($audioPlacement)
            ->setDisplayfmt([$displayFormat])->setEvent([$event])->setNativefmt($nativeFormat);
        $this->assertEquals('placement-1', $placement->getTagid());
        $this->assertEquals(800, $placement->getW());
        $this->assertEquals(600, $placement->getH());
        $this->assertEquals(1, $placement->getReward());
        $this->assertEquals(1, $placement->getSsai());
        $this->assertEquals('sdk', $placement->getSdk());
        $this->assertEquals('1.0', $placement->getSdkver());
        $this->assertEquals(SizeUnit::DENSITY_INDEPENDENT_PIXELS, $placement->getUnit());
        $this->assertEquals(1, $placement->getPriv());
        $this->assertSame($displayPlacement, $placement->getDisplay());
        $this->assertSame($videoPlacement, $placement->getVideo());
        $this->assertSame($audioPlacement, $placement->getAudio());
        $this->assertInstanceOf(Collection::class, $placement->getDisplayfmt());
        $this->assertCount(1, $placement->getDisplayfmt());
        $this->assertInstanceOf(Collection::class, $placement->getEvent());
        $this->assertCount(1, $placement->getEvent());
        $this->assertSame($nativeFormat, $placement->getNativefmt());

        $request = (new Request())->addItem((new Item())->setSpec((new Spec())->setPlacement($placement)));

        // 2. Serialize to JSON and back to test the Parser and schema.
        $json = $request->toJson();
        $this->assertIsString($json);
        $parsedRequest = Parser::parseBidRequest($json);

        // 3. Assert deep equality on the deserialized object.
        $this->assertInstanceOf(Request::class, $parsedRequest);

        // Get the parsed item to test its getters
        $parsedItem = $parsedRequest->getItem()->offsetGet(0);
        $this->assertInstanceOf(Item::class, $parsedItem);
        $parsedPlacement = $parsedItem->getSpec()->getPlacement();
        $this->assertInstanceOf(Placement::class, $parsedPlacement);
        $parsedAudio = $parsedPlacement->getAudio();
        $this->assertInstanceOf(AudioPlacement::class, $parsedAudio);

        // These assertions will trigger the previously uncovered `is_array()` branches in the getters
        $this->assertInstanceOf(Collection::class, $parsedAudio->getPlaymethod());
        $this->assertInstanceOf(Collection::class, $parsedAudio->getMime());
        $this->assertInstanceOf(Collection::class, $parsedAudio->getApi());
        $this->assertInstanceOf(Collection::class, $parsedAudio->getCtype());
        $this->assertInstanceOf(Collection::class, $parsedAudio->getDelivery());
        $this->assertInstanceOf(Collection::class, $parsedAudio->getComp(), 'Failed to get Comp collection');
        $this->assertInstanceOf(Collection::class, $parsedAudio->getComptype(), 'Failed to get CompType collection');

        // Trigger the is_array() branch in NativeFormat's getter
        $parsedNativeFmt = $parsedPlacement->getNativefmt();
        $this->assertInstanceOf(NativeFormat::class, $parsedNativeFmt);
        $this->assertInstanceOf(Collection::class, $parsedNativeFmt->getAsset());

        // Trigger the is_array() branches in Placement's getters
        $this->assertInstanceOf(Collection::class, $parsedPlacement->getDisplayfmt());
        $this->assertInstanceOf(Collection::class, $parsedPlacement->getEvent());

        // Trigger the is_array() branches in VideoPlacement's getters
        $parsedVideo = $parsedPlacement->getVideo();
        $this->assertInstanceOf(VideoPlacement::class, $parsedVideo);
        $this->assertInstanceOf(Collection::class, $parsedVideo->getMime());
        $this->assertInstanceOf(Collection::class, $parsedVideo->getApi());
        $this->assertInstanceOf(Collection::class, $parsedVideo->getCtype());
        $this->assertInstanceOf(Collection::class, $parsedVideo->getDelivery());
        $this->assertInstanceOf(Collection::class, $parsedVideo->getComp());
        $this->assertInstanceOf(Collection::class, $parsedVideo->getComptype());

        $this->assertEquals($request->toArray(), $parsedRequest->toArray(), "The re-serialized object should match the original");
    }
}
