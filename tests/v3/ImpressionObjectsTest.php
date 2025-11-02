<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Impression\DeliveryMethod;
use OpenRTB\v3\Enums\Impression\MetricType;
use OpenRTB\v3\Impression\Deal;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Metric;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Util\Parser;

/**
 * @covers \OpenRTB\v3\Impression\Deal
 * @covers \OpenRTB\v3\Impression\Item
 * @covers \OpenRTB\v3\Impression\Metric
 * @covers \OpenRTB\v3\Impression\Spec
 */
class ImpressionObjectsTest extends TestCase
{
    public function testFullImpressionObjectLifecycle(): void
    {
        // 1. Create and exhaustively test every object in the Impression namespace.
        $metric = (new Metric())->setType(MetricType::CLICKS)->setValue(0.95)->setVendor('test-vendor');
        $this->assertEquals(MetricType::CLICKS, $metric->getType());
        $this->assertEquals(0.95, $metric->getValue());
        $this->assertEquals('test-vendor', $metric->getVendor());

        $deal = (new Deal())
            ->setId('deal-123')
            ->setAt(AuctionType::FIRST_PRICE)
            ->setFlr(2.50)
            ->setFlrcur('USD')
            ->setWseat(['seat-1'])
            ->setWadv(['adv-1']);
        $this->assertEquals('deal-123', $deal->getId());
        $this->assertEquals(AuctionType::FIRST_PRICE, $deal->getAt());
        $this->assertEquals(2.50, $deal->getFlr());
        $this->assertEquals('USD', $deal->getFlrcur());
        $this->assertEquals(['seat-1'], $deal->getWseat());
        $this->assertEquals(['adv-1'], $deal->getWadv());

        $spec = (new Spec())->setPlacement((new Placement())->setTagid('p1'));
        $this->assertNotNull($spec->getPlacement());
        $this->assertEquals('p1', $spec->getPlacement()->getTagid());

        $item = (new Item())
            ->setId('item-123')
            ->setQty(2)
            ->setSeq(1)
            ->setFlr(1.99)
            ->setFlrcur('EUR')
            ->setExp(300)
            ->setDt(12345)
            ->setDlvy(DeliveryMethod::TAG)
            ->setMetric([$metric])
            ->setDeal([$deal])
            ->setPrivate(1)
            ->setSpec($spec);
        $this->assertEquals('item-123', $item->getId());
        $this->assertEquals(2, $item->getQty());
        $this->assertEquals(1, $item->getSeq());
        $this->assertEquals(1.99, $item->getFlr());
        $this->assertEquals('EUR', $item->getFlrcur());
        $this->assertEquals(300, $item->getExp());
        $this->assertEquals(12345, $item->getDt());
        $this->assertEquals(DeliveryMethod::TAG, $item->getDlvy());
        $this->assertIsArray($item->getMetric());
        $this->assertCount(1, $item->getMetric());
        $this->assertIsArray($item->getDeal());
        $this->assertCount(1, $item->getDeal());
        $this->assertEquals(1, $item->getPrivate());
        $this->assertSame($spec, $item->getSpec());

        $request = (new Request())->addItem($item);

        // 2. Serialize to JSON and back to test the Parser and schema.
        $json = $request->toJson();
        $this->assertIsString($json);
        $parsedRequest = Parser::parseBidRequest($json);

        // 3. Assert deep equality on the deserialized object.
        $this->assertInstanceOf(Request::class, $parsedRequest);
        $this->assertEquals($request->toArray(), $parsedRequest->toArray());

        $parsedItems = $parsedRequest->getItem();
        $this->assertIsArray($parsedItems);
        $this->assertCount(1, $parsedItems);
        $parsedItem = $parsedItems[0];
        $this->assertInstanceOf(Item::class, $parsedItem);

        $parsedMetrics = $parsedItem->getMetric();
        $this->assertIsArray($parsedMetrics);
        $this->assertCount(1, $parsedMetrics);
        $this->assertEquals(MetricType::CLICKS, $parsedMetrics[0]->getType());

        $parsedDeals = $parsedItem->getDeal();
        $this->assertIsArray($parsedDeals);
        $this->assertCount(1, $parsedDeals);
        $this->assertEquals(AuctionType::FIRST_PRICE, $parsedDeals[0]->getAt());

        $parsedSpec = $parsedItem->getSpec();
        $this->assertInstanceOf(Spec::class, $parsedSpec);
        $parsedPlacement = $parsedSpec->getPlacement();
        $this->assertInstanceOf(Placement::class, $parsedPlacement);
        $this->assertEquals('p1', $parsedPlacement->getTagid());
    }
}
