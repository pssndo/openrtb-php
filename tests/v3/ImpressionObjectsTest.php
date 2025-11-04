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
        $wseat = $deal->getWseat();
        $this->assertNotNull($wseat);
        $this->assertEquals(['seat-1'], $wseat->toArray());
        $wadv = $deal->getWadv();
        $this->assertNotNull($wadv);
        $this->assertEquals(['adv-1'], $wadv->toArray());

        $spec = (new Spec())->setPlacement((new Placement())->setTagid('p1'));
        $placement = $spec->getPlacement();
        $this->assertNotNull($placement);
        $this->assertEquals('p1', $placement->getTagid());

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
        $metric = $item->getMetric();
        $this->assertNotNull($metric);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($metric->toArray());
        $this->assertCount(1, $metric);
        $dealColl = $item->getDeal();
        $this->assertNotNull($dealColl);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($dealColl->toArray());
        $this->assertCount(1, $dealColl);
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
        $this->assertNotNull($parsedItems);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($parsedItems->toArray());
        $this->assertCount(1, $parsedItems);
        $parsedItem = $parsedItems->offsetGet(0);
        $this->assertInstanceOf(Item::class, $parsedItem);

        $parsedMetrics = $parsedItem->getMetric();
        $this->assertNotNull($parsedMetrics);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($parsedMetrics->toArray());
        $this->assertCount(1, $parsedMetrics);
        $metricItem = $parsedMetrics->offsetGet(0);
        $this->assertNotNull($metricItem);
        $this->assertEquals(MetricType::CLICKS, $metricItem->getType());

        $parsedDeals = $parsedItem->getDeal();
        $this->assertNotNull($parsedDeals);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($parsedDeals->toArray());
        $this->assertCount(1, $parsedDeals);
        $dealItem = $parsedDeals->offsetGet(0);
        $this->assertNotNull($dealItem);
        $this->assertEquals(AuctionType::FIRST_PRICE, $dealItem->getAt());

        $parsedSpec = $parsedItem->getSpec();
        $this->assertInstanceOf(Spec::class, $parsedSpec);
        $parsedPlacement = $parsedSpec->getPlacement();
        $this->assertInstanceOf(Placement::class, $parsedPlacement);
        $this->assertEquals('p1', $parsedPlacement->getTagid());
    }
}
