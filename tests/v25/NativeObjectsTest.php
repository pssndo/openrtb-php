<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v25;

use OpenRTB\v25\Impression\Native;
use OpenRTB\v25\Impression\Native\DataAsset;
use OpenRTB\v25\Impression\Native\ImageAsset;
use OpenRTB\v25\Impression\Native\NativeAsset;
use OpenRTB\v25\Impression\Native\NativeRequest;
use OpenRTB\v25\Impression\Native\TitleAsset;
use OpenRTB\v25\Impression\Native\VideoAsset;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v25\Impression\Native
 * @covers \OpenRTB\v25\Impression\Native\NativeRequest
 * @covers \OpenRTB\v25\Impression\Native\NativeAsset
 * @covers \OpenRTB\v25\Impression\Native\TitleAsset
 * @covers \OpenRTB\v25\Impression\Native\ImageAsset
 * @covers \OpenRTB\v25\Impression\Native\DataAsset
 * @covers \OpenRTB\v25\Impression\Native\VideoAsset
 */
final class NativeObjectsTest extends TestCase
{
    public function testNativeRequestObject(): void
    {
        $request = new NativeRequest();
        $request->setVer('1.2');
        $request->setContext(1);
        $request->setPlcmttype(1);

        $this->assertEquals('1.2', $request->getVer());
        $this->assertEquals(1, $request->getContext());
        $this->assertEquals(1, $request->getPlcmttype());
    }

    public function testNativeRequestWithAssets(): void
    {
        $request = new NativeRequest();

        $titleAsset = new TitleAsset(1, 90, true);
        $request->addAsset($titleAsset);

        $imageAsset = new ImageAsset(2, ImageAsset::TYPE_MAIN, 300, 250, true);
        $request->addAsset($imageAsset);

        $assets = $request->getAssets();
        $this->assertCount(2, $assets);
        $this->assertInstanceOf(TitleAsset::class, $assets[0]);
        $this->assertInstanceOf(ImageAsset::class, $assets[1]);
    }

    public function testNativeRequestToJson(): void
    {
        $request = new NativeRequest();
        $request->setVer('1.2');
        $request->setContext(1);
        $request->addAsset(new TitleAsset(1, 90, true));

        $json = $request->toJson();
        $this->assertJson($json);

        $data = json_decode($json, true);
        $this->assertEquals('1.2', $data['ver']);
        $this->assertEquals(1, $data['context']);
        $this->assertCount(1, $data['assets']);
    }

    public function testNativeRequestFromJson(): void
    {
        $json = json_encode([
            'ver' => '1.2',
            'context' => 1,
            'plcmttype' => 1,
            'assets' => [
                ['id' => 1, 'required' => 1, 'title' => ['len' => 90]]
            ]
        ]);

        $this->assertNotFalse($json);

        $request = NativeRequest::fromJson($json);

        $this->assertEquals('1.2', $request->getVer());
        $this->assertEquals(1, $request->getContext());
        $this->assertCount(1, $request->getAssets());
    }

    public function testTitleAsset(): void
    {
        $asset = new TitleAsset(1, 90, true);

        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(90, $asset->getLen());
        $this->assertTrue($asset->isRequired());

        $data = $asset->jsonSerialize();
        $this->assertEquals(1, $data['id']);
        $this->assertEquals(1, $data['required']);
        $this->assertEquals(90, $data['title']['len']);
    }

    public function testImageAsset(): void
    {
        $asset = new ImageAsset(2, ImageAsset::TYPE_MAIN, 300, 250, true);
        $asset->setMimes(['image/jpeg', 'image/png']);

        $this->assertEquals(2, $asset->getId());
        $this->assertEquals(ImageAsset::TYPE_MAIN, $asset->getType());
        $this->assertEquals(300, $asset->getWmin());
        $this->assertEquals(250, $asset->getHmin());
        $this->assertEquals(['image/jpeg', 'image/png'], $asset->getMimes());

        $data = $asset->jsonSerialize();
        $this->assertEquals(3, $data['img']['type']);
        $this->assertEquals(300, $data['img']['wmin']);
        $this->assertEquals(250, $data['img']['hmin']);
    }

    public function testImageAssetConstants(): void
    {
        $this->assertEquals(1, ImageAsset::TYPE_ICON);
        $this->assertEquals(2, ImageAsset::TYPE_LOGO);
        $this->assertEquals(3, ImageAsset::TYPE_MAIN);
    }

    public function testDataAsset(): void
    {
        $asset = new DataAsset(3, DataAsset::TYPE_DESC, 140, false);

        $this->assertEquals(3, $asset->getId());
        $this->assertEquals(DataAsset::TYPE_DESC, $asset->getType());
        $this->assertEquals(140, $asset->getLen());
        $this->assertFalse($asset->isRequired());

        $data = $asset->jsonSerialize();
        $this->assertEquals(2, $data['data']['type']);
        $this->assertEquals(140, $data['data']['len']);
    }

    public function testDataAssetConstants(): void
    {
        $this->assertEquals(1, DataAsset::TYPE_SPONSORED);
        $this->assertEquals(2, DataAsset::TYPE_DESC);
        $this->assertEquals(12, DataAsset::TYPE_CTATEXT);
    }

    public function testVideoAsset(): void
    {
        $asset = new VideoAsset(4, false);
        $asset->setMimes(['video/mp4']);
        $asset->setMinduration(5);
        $asset->setMaxduration(30);
        $asset->setProtocols([2, 3]);

        $this->assertEquals(4, $asset->getId());
        $this->assertEquals(['video/mp4'], $asset->getMimes());
        $this->assertEquals(5, $asset->getMinduration());
        $this->assertEquals(30, $asset->getMaxduration());

        $data = $asset->jsonSerialize();
        $this->assertEquals(['video/mp4'], $data['video']['mimes']);
        $this->assertEquals(5, $data['video']['minduration']);
    }

    public function testNativeAcceptsNativeRequest(): void
    {
        $nativeRequest = new NativeRequest();
        $nativeRequest->setVer('1.2');
        $nativeRequest->addAsset(new TitleAsset(1, 90, true));

        $native = new Native();
        $native->setRequest($nativeRequest);

        // Should auto-convert to JSON string
        $request = $native->getRequest();
        $this->assertIsString($request);
        $this->assertJson($request);

        $data = json_decode($request, true);
        $this->assertEquals('1.2', $data['ver']);
    }

    public function testNativeAcceptsString(): void
    {
        $json = json_encode(['ver' => '1.2', 'assets' => []]);
        $this->assertNotFalse($json);

        $native = new Native();
        $native->setRequest($json);

        $this->assertEquals($json, $native->getRequest());
    }

    public function testNativeGetRequestObject(): void
    {
        $nativeRequest = new NativeRequest();
        $nativeRequest->setVer('1.2');
        $nativeRequest->setContext(1);

        $native = new Native();
        $native->setRequest($nativeRequest);

        // Get back as object
        $retrieved = $native->getRequestObject();
        $this->assertInstanceOf(NativeRequest::class, $retrieved);
        $this->assertEquals('1.2', $retrieved->getVer());
        $this->assertEquals(1, $retrieved->getContext());
    }

    public function testNativeRequestFromArray(): void
    {
        $data = [
            'ver' => '1.2',
            'context' => 1,
            'plcmttype' => 1,
            'assets' => [
                ['id' => 1, 'required' => 1, 'title' => ['len' => 90]],
                ['id' => 2, 'required' => 1, 'img' => ['type' => 3, 'wmin' => 300, 'hmin' => 250]],
                ['id' => 3, 'required' => 0, 'data' => ['type' => 2, 'len' => 140]],
            ]
        ];

        $request = NativeRequest::fromArray($data);

        $this->assertEquals('1.2', $request->getVer());
        $this->assertEquals(1, $request->getContext());
        $this->assertCount(3, $request->getAssets());

        $assets = $request->getAssets();
        $this->assertInstanceOf(TitleAsset::class, $assets[0]);
        $this->assertInstanceOf(ImageAsset::class, $assets[1]);
        $this->assertInstanceOf(DataAsset::class, $assets[2]);
    }

    public function testAssetFromArray(): void
    {
        $titleData = ['id' => 1, 'required' => 1, 'title' => ['len' => 90]];
        $asset = TitleAsset::fromArray($titleData);

        $this->assertInstanceOf(TitleAsset::class, $asset);
        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(90, $asset->getLen());
    }

    public function testCompleteNativeWorkflow(): void
    {
        // Create request using objects
        $nativeRequest = new NativeRequest();
        $nativeRequest->setVer('1.2');
        $nativeRequest->setContext(1);
        $nativeRequest->setPlcmttype(1);

        $nativeRequest->addAsset(new TitleAsset(1, 90, true));
        $nativeRequest->addAsset(new ImageAsset(2, ImageAsset::TYPE_MAIN, 300, 250, true));
        $nativeRequest->addAsset(new DataAsset(3, DataAsset::TYPE_CTATEXT, 15, true));

        // Set on Native object
        $native = new Native();
        $native->setRequest($nativeRequest);
        $native->setVer('1.2');

        // Serialize to JSON (as would be sent in OpenRTB request)
        $json = $native->toJson();
        $this->assertNotFalse($json);
        $this->assertJson($json);

        // Parse back (as would be received by DSP)
        $receivedData = json_decode($json, true);
        $receivedRequestJson = $receivedData['request'];

        // Reconstruct native request from JSON
        $reconstructed = NativeRequest::fromJson($receivedRequestJson);

        // Verify it matches original
        $this->assertEquals('1.2', $reconstructed->getVer());
        $this->assertEquals(1, $reconstructed->getContext());
        $this->assertCount(3, $reconstructed->getAssets());
    }

    // ========================================================================
    // TitleAsset - Additional Coverage
    // ========================================================================

    public function testTitleAssetSetters(): void
    {
        $asset = new TitleAsset(1, 90, true);

        // Test setLen
        $asset->setLen(120);
        $this->assertEquals(120, $asset->getLen());

        // Test setId (inherited)
        $asset->setId(5);
        $this->assertEquals(5, $asset->getId());

        // Test setRequired (inherited)
        $asset->setRequired(false);
        $this->assertFalse($asset->isRequired());
    }

    public function testTitleAssetWithExt(): void
    {
        $asset = new TitleAsset(1, 90, true);
        $asset->setExt(['custom' => 'value']);

        $this->assertEquals(['custom' => 'value'], $asset->getExt());

        $data = $asset->jsonSerialize();
        $this->assertEquals(['custom' => 'value'], $data['ext']);
    }

    public function testTitleAssetFromArrayWithExt(): void
    {
        $data = [
            'id' => 1,
            'required' => 1,
            'title' => ['len' => 90],
            'ext' => ['custom' => 'value']
        ];

        $asset = TitleAsset::fromArray($data);

        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(90, $asset->getLen());
        $this->assertTrue($asset->isRequired());
        $this->assertEquals(['custom' => 'value'], $asset->getExt());
    }

    // ========================================================================
    // ImageAsset - Additional Coverage
    // ========================================================================

    public function testImageAssetAllSetters(): void
    {
        $asset = new ImageAsset(1, ImageAsset::TYPE_MAIN, 300, 250, true);

        // Test setType
        $asset->setType(ImageAsset::TYPE_ICON);
        $this->assertEquals(ImageAsset::TYPE_ICON, $asset->getType());

        // Test setW and setH
        $asset->setW(400);
        $asset->setH(300);
        $this->assertEquals(400, $asset->getW());
        $this->assertEquals(300, $asset->getH());

        // Test setWmin and setHmin
        $asset->setWmin(200);
        $asset->setHmin(150);
        $this->assertEquals(200, $asset->getWmin());
        $this->assertEquals(150, $asset->getHmin());

        // Test ratio fields
        $asset->setWratios(16);
        $asset->setHratios(9);
        $asset->setWratio(16);
        $asset->setHratio(9);

        $this->assertEquals(16, $asset->getWratios());
        $this->assertEquals(9, $asset->getHratios());
        $this->assertEquals(16, $asset->getWratio());
        $this->assertEquals(9, $asset->getHratio());
    }

    public function testImageAssetWithAllFields(): void
    {
        $asset = new ImageAsset(2, ImageAsset::TYPE_LOGO, 100, 100, false);
        $asset->setW(120);
        $asset->setH(120);
        $asset->setWratios(1);
        $asset->setHratios(1);
        $asset->setWratio(1);
        $asset->setHratio(1);
        $asset->setMimes(['image/png', 'image/gif']);
        $asset->setExt(['vendor' => 'data']);

        $data = $asset->jsonSerialize();

        $this->assertEquals(2, $data['id']);
        $this->assertEquals(0, $data['required']);
        $this->assertEquals(2, $data['img']['type']);
        $this->assertEquals(120, $data['img']['w']);
        $this->assertEquals(120, $data['img']['h']);
        $this->assertEquals(100, $data['img']['wmin']);
        $this->assertEquals(100, $data['img']['hmin']);
        $this->assertEquals(1, $data['img']['wratios']);
        $this->assertEquals(1, $data['img']['hratios']);
        $this->assertEquals(1, $data['img']['wratio']);
        $this->assertEquals(1, $data['img']['hratio']);
        $this->assertEquals(['image/png', 'image/gif'], $data['img']['mimes']);
        $this->assertEquals(['vendor' => 'data'], $data['ext']);
    }

    public function testImageAssetFromArrayWithAllFields(): void
    {
        $data = [
            'id' => 3,
            'required' => 0,
            'img' => [
                'type' => 3,
                'w' => 300,
                'h' => 250,
                'wmin' => 280,
                'hmin' => 230,
                'wratios' => 16,
                'hratios' => 9,
                'wratio' => 16,
                'hratio' => 9,
                'mimes' => ['image/jpeg', 'image/png']
            ],
            'ext' => ['custom' => 'field']
        ];

        $asset = ImageAsset::fromArray($data);

        $this->assertEquals(3, $asset->getId());
        $this->assertFalse($asset->isRequired());
        $this->assertEquals(ImageAsset::TYPE_MAIN, $asset->getType());
        $this->assertEquals(300, $asset->getW());
        $this->assertEquals(250, $asset->getH());
        $this->assertEquals(280, $asset->getWmin());
        $this->assertEquals(230, $asset->getHmin());
        $this->assertEquals(16, $asset->getWratios());
        $this->assertEquals(9, $asset->getHratios());
        $this->assertEquals(16, $asset->getWratio());
        $this->assertEquals(9, $asset->getHratio());
        $this->assertEquals(['image/jpeg', 'image/png'], $asset->getMimes());
        $this->assertEquals(['custom' => 'field'], $asset->getExt());
    }

    // ========================================================================
    // DataAsset - Additional Coverage
    // ========================================================================

    public function testDataAssetAllConstants(): void
    {
        $this->assertEquals(1, DataAsset::TYPE_SPONSORED);
        $this->assertEquals(2, DataAsset::TYPE_DESC);
        $this->assertEquals(3, DataAsset::TYPE_RATING);
        $this->assertEquals(4, DataAsset::TYPE_LIKES);
        $this->assertEquals(5, DataAsset::TYPE_DOWNLOADS);
        $this->assertEquals(6, DataAsset::TYPE_PRICE);
        $this->assertEquals(7, DataAsset::TYPE_SALEPRICE);
        $this->assertEquals(8, DataAsset::TYPE_PHONE);
        $this->assertEquals(9, DataAsset::TYPE_ADDRESS);
        $this->assertEquals(10, DataAsset::TYPE_DESC2);
        $this->assertEquals(11, DataAsset::TYPE_DISPLAYURL);
        $this->assertEquals(12, DataAsset::TYPE_CTATEXT);
    }

    public function testDataAssetSetters(): void
    {
        $asset = new DataAsset(1, DataAsset::TYPE_DESC, 140, false);

        // Test setType
        $asset->setType(DataAsset::TYPE_SPONSORED);
        $this->assertEquals(DataAsset::TYPE_SPONSORED, $asset->getType());

        // Test setLen
        $asset->setLen(200);
        $this->assertEquals(200, $asset->getLen());

        // Test inherited setters
        $asset->setId(10);
        $asset->setRequired(true);

        $this->assertEquals(10, $asset->getId());
        $this->assertTrue($asset->isRequired());
    }

    public function testDataAssetWithExt(): void
    {
        $asset = new DataAsset(1, DataAsset::TYPE_RATING, 10, false);
        $asset->setExt(['vendor_rating' => true]);

        $this->assertEquals(['vendor_rating' => true], $asset->getExt());

        $data = $asset->jsonSerialize();
        $this->assertEquals(['vendor_rating' => true], $data['ext']);
    }

    public function testDataAssetFromArrayWithExt(): void
    {
        $data = [
            'id' => 5,
            'required' => 1,
            'data' => [
                'type' => 6,
                'len' => 20
            ],
            'ext' => ['price_format' => 'USD']
        ];

        $asset = DataAsset::fromArray($data);

        $this->assertEquals(5, $asset->getId());
        $this->assertTrue($asset->isRequired());
        $this->assertEquals(DataAsset::TYPE_PRICE, $asset->getType());
        $this->assertEquals(20, $asset->getLen());
        $this->assertEquals(['price_format' => 'USD'], $asset->getExt());
    }

    public function testDataAssetWithoutLen(): void
    {
        $asset = new DataAsset(1, DataAsset::TYPE_LIKES);

        $this->assertNull($asset->getLen());

        $data = $asset->jsonSerialize();
        $this->assertArrayNotHasKey('len', $data['data']);
    }

    // ========================================================================
    // VideoAsset - Additional Coverage
    // ========================================================================

    public function testVideoAssetAllSetters(): void
    {
        $asset = new VideoAsset(1, true);

        $asset->setMimes(['video/mp4', 'video/webm']);
        $asset->setMinduration(10);
        $asset->setMaxduration(60);
        $asset->setProtocols([2, 3, 5]);

        $this->assertEquals(['video/mp4', 'video/webm'], $asset->getMimes());
        $this->assertEquals(10, $asset->getMinduration());
        $this->assertEquals(60, $asset->getMaxduration());
        $this->assertEquals([2, 3, 5], $asset->getProtocols());
    }

    public function testVideoAssetWithExt(): void
    {
        $asset = new VideoAsset(1, false);
        $asset->setExt(['playback' => 'autoplay']);

        $this->assertEquals(['playback' => 'autoplay'], $asset->getExt());

        $data = $asset->jsonSerialize();
        $this->assertEquals(['playback' => 'autoplay'], $data['ext']);
    }

    public function testVideoAssetFromArray(): void
    {
        $data = [
            'id' => 10,
            'required' => 1,
            'video' => [
                'mimes' => ['video/mp4'],
                'minduration' => 5,
                'maxduration' => 30,
                'protocols' => [2, 3]
            ],
            'ext' => ['vendor' => 'test']
        ];

        $asset = VideoAsset::fromArray($data);

        $this->assertEquals(10, $asset->getId());
        $this->assertTrue($asset->isRequired());
        $this->assertEquals(['video/mp4'], $asset->getMimes());
        $this->assertEquals(5, $asset->getMinduration());
        $this->assertEquals(30, $asset->getMaxduration());
        $this->assertEquals([2, 3], $asset->getProtocols());
        $this->assertEquals(['vendor' => 'test'], $asset->getExt());
    }

    public function testVideoAssetJsonSerializeComplete(): void
    {
        $asset = new VideoAsset(5, true);
        $asset->setMimes(['video/mp4', 'video/webm', 'video/ogg']);
        $asset->setMinduration(15);
        $asset->setMaxduration(45);
        $asset->setProtocols([1, 2, 3, 4, 5]);
        $asset->setExt(['bitrate' => 'high']);

        $data = $asset->jsonSerialize();

        $this->assertEquals(5, $data['id']);
        $this->assertEquals(1, $data['required']);
        $this->assertEquals(['video/mp4', 'video/webm', 'video/ogg'], $data['video']['mimes']);
        $this->assertEquals(15, $data['video']['minduration']);
        $this->assertEquals(45, $data['video']['maxduration']);
        $this->assertEquals([1, 2, 3, 4, 5], $data['video']['protocols']);
        $this->assertEquals(['bitrate' => 'high'], $data['ext']);
    }

    // ========================================================================
    // NativeRequest - Additional Coverage
    // ========================================================================

    public function testNativeRequestAllOptionalFields(): void
    {
        $request = new NativeRequest();
        $request->setVer('1.2');
        $request->setContext(1);
        $request->setPlcmttype(1);
        $request->setContextsubtype(10);
        $request->setPlcmtcnt(3);
        $request->setSeq(1);
        $request->setAurlsupport(1);
        $request->setDurlsupport(1);
        $request->setEventtrackers([1, 2]);
        $request->setPrivacy(1);
        $request->setExt(['vendor' => 'custom']);

        $this->assertEquals('1.2', $request->getVer());
        $this->assertEquals(1, $request->getContext());
        $this->assertEquals(1, $request->getPlcmttype());
        $this->assertEquals(10, $request->getContextsubtype());
        $this->assertEquals(3, $request->getPlcmtcnt());
        $this->assertEquals(1, $request->getSeq());
        $this->assertEquals(1, $request->getAurlsupport());
        $this->assertEquals(1, $request->getDurlsupport());
        $this->assertEquals([1, 2], $request->getEventtrackers());
        $this->assertEquals(1, $request->getPrivacy());
        $this->assertEquals(['vendor' => 'custom'], $request->getExt());
    }

    public function testNativeRequestSetAssets(): void
    {
        $request = new NativeRequest();

        $assets = [
            new TitleAsset(1, 90, true),
            new ImageAsset(2, ImageAsset::TYPE_MAIN, 300, 250, true),
            new DataAsset(3, DataAsset::TYPE_CTATEXT, 15, true)
        ];

        $request->setAssets($assets);

        $this->assertCount(3, $request->getAssets());
        $this->assertSame($assets, $request->getAssets());
    }

    public function testNativeRequestJsonSerializeWithAllFields(): void
    {
        $request = new NativeRequest();
        $request->setVer('1.2');
        $request->setContext(2);
        $request->setPlcmttype(4);
        $request->setContextsubtype(20);
        $request->setPlcmtcnt(5);
        $request->setSeq(2);
        $request->setAurlsupport(1);
        $request->setDurlsupport(1);
        $request->setEventtrackers([1, 2, 3]);
        $request->setPrivacy(1);
        $request->setExt(['test' => 'data']);
        $request->addAsset(new TitleAsset(1, 90, true));

        $data = $request->jsonSerialize();

        $this->assertEquals('1.2', $data['ver']);
        $this->assertEquals(2, $data['context']);
        $this->assertEquals(4, $data['plcmttype']);
        $this->assertEquals(20, $data['contextsubtype']);
        $this->assertEquals(5, $data['plcmtcnt']);
        $this->assertEquals(2, $data['seq']);
        $this->assertEquals(1, $data['aurlsupport']);
        $this->assertEquals(1, $data['durlsupport']);
        $this->assertEquals([1, 2, 3], $data['eventtrackers']);
        $this->assertEquals(1, $data['privacy']);
        $this->assertEquals(['test' => 'data'], $data['ext']);
        $this->assertCount(1, $data['assets']);
    }

    public function testNativeRequestFromArrayWithAllFields(): void
    {
        $data = [
            'ver' => '1.2',
            'context' => 3,
            'plcmttype' => 2,
            'contextsubtype' => 15,
            'plcmtcnt' => 2,
            'seq' => 1,
            'aurlsupport' => 1,
            'durlsupport' => 1,
            'eventtrackers' => [1, 2],
            'privacy' => 1,
            'ext' => ['custom' => 'value'],
            'assets' => [
                ['id' => 1, 'required' => 1, 'title' => ['len' => 90]]
            ]
        ];

        $request = NativeRequest::fromArray($data);

        $this->assertEquals('1.2', $request->getVer());
        $this->assertEquals(3, $request->getContext());
        $this->assertEquals(2, $request->getPlcmttype());
        $this->assertEquals(15, $request->getContextsubtype());
        $this->assertEquals(2, $request->getPlcmtcnt());
        $this->assertEquals(1, $request->getSeq());
        $this->assertEquals(1, $request->getAurlsupport());
        $this->assertEquals(1, $request->getDurlsupport());
        $this->assertEquals([1, 2], $request->getEventtrackers());
        $this->assertEquals(1, $request->getPrivacy());
        $this->assertEquals(['custom' => 'value'], $request->getExt());
        $this->assertCount(1, $request->getAssets());
    }

    // ========================================================================
    // Native - Additional Coverage
    // ========================================================================

    public function testNativeGetRequestObjectReturnsNull(): void
    {
        $native = new Native();

        $this->assertNull($native->getRequestObject());
    }

    public function testNativeGetRequestObjectWithInvalidJson(): void
    {
        $native = new Native();
        $native->setRequest('invalid json {');

        // Should return null for invalid JSON
        $this->assertNull($native->getRequestObject());
    }

    // ========================================================================
    // Edge Cases and Error Handling
    // ========================================================================

    public function testNativeRequestFromJsonWithInvalidJson(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        NativeRequest::fromJson('invalid json');
    }

    public function testAssetFromArrayWithVideoType(): void
    {
        $data = [
            'id' => 1,
            'required' => 1,
            'video' => [
                'mimes' => ['video/mp4'],
                'minduration' => 5,
                'maxduration' => 30
            ]
        ];

        $asset = VideoAsset::fromArray($data);

        $this->assertInstanceOf(VideoAsset::class, $asset);
        $this->assertEquals(1, $asset->getId());
        $this->assertTrue($asset->isRequired());
    }

    // ========================================================================
    // NativeAsset - Factory Method Coverage
    // ========================================================================

    public function testNativeAssetFromArrayWithTitleType(): void
    {
        $data = [
            'id' => 1,
            'required' => 1,
            'title' => ['len' => 90]
        ];

        $asset = NativeAsset::fromArray($data);

        $this->assertInstanceOf(TitleAsset::class, $asset);
        $this->assertEquals(1, $asset->getId());
        $this->assertEquals(90, $asset->getLen());
    }

    public function testNativeAssetFromArrayWithImageType(): void
    {
        $data = [
            'id' => 2,
            'required' => 1,
            'img' => [
                'type' => 3,
                'wmin' => 300,
                'hmin' => 250
            ]
        ];

        $asset = NativeAsset::fromArray($data);

        $this->assertInstanceOf(ImageAsset::class, $asset);
        $this->assertEquals(2, $asset->getId());
        $this->assertEquals(ImageAsset::TYPE_MAIN, $asset->getType());
    }

    public function testNativeAssetFromArrayWithDataType(): void
    {
        $data = [
            'id' => 3,
            'required' => 0,
            'data' => [
                'type' => 2,
                'len' => 140
            ]
        ];

        $asset = NativeAsset::fromArray($data);

        $this->assertInstanceOf(DataAsset::class, $asset);
        $this->assertEquals(3, $asset->getId());
        $this->assertEquals(DataAsset::TYPE_DESC, $asset->getType());
    }

    public function testNativeAssetFromArrayWithVideoType(): void
    {
        $data = [
            'id' => 4,
            'required' => 1,
            'video' => [
                'mimes' => ['video/mp4'],
                'minduration' => 5
            ]
        ];

        $asset = NativeAsset::fromArray($data);

        $this->assertInstanceOf(VideoAsset::class, $asset);
        $this->assertEquals(4, $asset->getId());
        $this->assertTrue($asset->isRequired());
    }

    public function testNativeAssetFromArrayWithUnknownType(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Unknown asset type in data');

        $data = [
            'id' => 1,
            'required' => 1,
            // No title, img, data, or video key
        ];

        NativeAsset::fromArray($data);
    }

    public function testNativeAssetGetBaseDataWithExt(): void
    {
        $asset = new TitleAsset(1, 90, true);
        $asset->setExt(['custom' => 'value']);

        $serialized = $asset->jsonSerialize();

        // Verify ext is included in base data
        $this->assertArrayHasKey('ext', $serialized);
        $this->assertEquals(['custom' => 'value'], $serialized['ext']);
    }

    public function testNativeAssetGetBaseDataWithoutExt(): void
    {
        $asset = new TitleAsset(1, 90, false);

        $serialized = $asset->jsonSerialize();

        // Verify ext is not included when null
        $this->assertArrayNotHasKey('ext', $serialized);
        $this->assertEquals(0, $serialized['required']); // required false = 0
    }

    public function testNativeAssetRequiredFieldConversion(): void
    {
        // Test required = true -> 1
        $assetTrue = new TitleAsset(1, 90, true);
        $dataTrue = $assetTrue->jsonSerialize();
        $this->assertEquals(1, $dataTrue['required']);

        // Test required = false -> 0
        $assetFalse = new TitleAsset(2, 90, false);
        $dataFalse = $assetFalse->jsonSerialize();
        $this->assertEquals(0, $dataFalse['required']);
    }
}
