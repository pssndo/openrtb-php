<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Bid;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Producer;
use OpenRTB\v26\Context\Content;
use OpenRTB\v26\Impression\Deal;
use OpenRTB\v26\Impression\Format;
use OpenRTB\v26\Impression\Metric;
use OpenRTB\v26\Impression\Pmp;
use OpenRTB\v26\Response\SeatBid;
use OpenRTB\v3\Bid\Asset;
use OpenRTB\v3\Bid\Event;
use OpenRTB\v3\Bid\NativeAd;
use PHPUnit\Framework\TestCase;

/**
 * Batch test file to cover remaining uncovered lines across multiple classes.
 */
class CoveragePatchTest extends TestCase
{
    // v26/Impression/Deal - Line 64: tryFrom branch
    public function testDealGetAtWithIntValue(): void
    {
        $deal = new Deal();
        $deal->set('at', 1); // Set as int, not AuctionType

        $at = $deal->getAt();
        $this->assertNotNull($at);
    }

    // v3/Bid/NativeAd - Lines 60, 80: Collection branch
    public function testNativeAdGetAssetWhenAlreadyCollection(): void
    {
        $nativeAd = new NativeAd();
        $collection = new Collection([new Asset()], Asset::class);
        $nativeAd->set('asset', $collection);

        $result = $nativeAd->getAsset();
        $this->assertSame($collection, $result);
    }

    public function testNativeAdGetEventWhenAlreadyCollection(): void
    {
        $nativeAd = new NativeAd();
        $collection = new Collection([new Event()], Event::class);
        $nativeAd->set('event', $collection);

        $result = $nativeAd->getEvent();
        $this->assertSame($collection, $result);
    }

    // v26/Impression/Pmp - likely getPrivateAuction
    public function testPmpGetPrivateAuction(): void
    {
        $pmp = new Pmp();
        $pmp->setPrivateAuction(1);

        $this->assertEquals(1, $pmp->getPrivateAuction());
    }

    // v26/Impression/Format - get methods
    public function testFormatGetH(): void
    {
        $format = new Format();
        $format->setH(600);

        $this->assertEquals(600, $format->getH());
    }

    // v26/Impression/Metric - missing lines
    public function testMetricGetVendor(): void
    {
        $metric = new Metric();
        $metric->setVendor('vendor-123');

        $this->assertEquals('vendor-123', $metric->getVendor());
    }

    public function testMetricGetValue(): void
    {
        $metric = new Metric();
        $metric->setValue(1.5);

        $this->assertEquals(1.5, $metric->getValue());
    }

    public function testMetricSetType(): void
    {
        $metric = new Metric();
        $metric->setType('viewable');

        $this->assertEquals('viewable', $metric->getType());
    }

    // v26/Response/SeatBid - missing schema methods
    public function testSeatBidGetSchema(): void
    {
        $schema = SeatBid::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('bid', $schema);
    }

    public function testSeatBidGetGroup(): void
    {
        $seatBid = new SeatBid();
        $seatBid->setGroup(1);

        $this->assertEquals(1, $seatBid->getGroup());
    }

    public function testSeatBidGetBidAsArray(): void
    {
        $seatBid = new SeatBid();
        $bid = new Bid();
        $seatBid->set('bid', [$bid]); // Set as array

        $bids = $seatBid->getBid();
        $this->assertInstanceOf(Collection::class, $bids);
    }

    // v26/Context/Content - missing methods
    public function testContentGetSchema(): void
    {
        $schema = Content::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
    }

    public function testContentGetProducer(): void
    {
        $content = new Content();
        $producer = new Producer();
        $content->setProducer($producer);

        $this->assertSame($producer, $content->getProducer());
    }

    // Common/AbstractRequestBuilder - test with bool
    public function testRequestBuilderSetTestWithBoolTrue(): void
    {
        $builder = new \OpenRTB\v26\Util\RequestBuilder();
        $builder->setTest(true);

        /** @var \OpenRTB\v26\BidRequest $request */
        $request = $builder();
        $this->assertEquals(1, $request->getTest());
    }

    public function testRequestBuilderSetTestWithBoolFalse(): void
    {
        $builder = new \OpenRTB\v26\Util\RequestBuilder();
        $builder->setTest(false);

        /** @var \OpenRTB\v26\BidRequest $request */
        $request = $builder();
        $this->assertEquals(0, $request->getTest());
    }

    public function testRequestBuilderSetExt(): void
    {
        $builder = new \OpenRTB\v26\Util\RequestBuilder();
        $ext = new Ext();
        $builder->setExt($ext);

        /** @var \OpenRTB\v26\BidRequest $request */
        $request = $builder();
        $this->assertSame($ext, $request->getExt());
    }

    // v26/Util/Validator - missing error paths
    public function testValidatorWithInvalidImpInCollection(): void
    {
        $validator = new \OpenRTB\v26\Util\Validator();
        $request = new \OpenRTB\v26\BidRequest();
        $request->setId('test-request');

        // Add an invalid object to the impressions collection
        $request->set('imp', ['not-an-imp-object']);

        $isValid = $validator->validateBidRequest($request);
        $this->assertFalse($isValid);
        $this->assertTrue($validator->hasErrors());
    }

    public function testValidatorWithImpMissingMediaType(): void
    {
        $validator = new \OpenRTB\v26\Util\Validator();
        $request = new \OpenRTB\v26\BidRequest();
        $request->setId('test-request');

        $imp = new \OpenRTB\v26\Impression\Imp();
        $imp->setId('imp-1');
        // Don't set any media type (banner, video, audio, native)

        $request->addImp($imp);

        $isValid = $validator->validateBidRequest($request);
        $this->assertFalse($isValid);
        $error = $validator->getFirstError();
        $this->assertNotNull($error);
        $this->assertStringContainsString('must contain at least one', $error);
    }
}
