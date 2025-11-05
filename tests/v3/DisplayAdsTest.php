<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\Collection;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayFormat;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Placement\DisplayPlacement
 * @covers \OpenRTB\v3\Placement\DisplayFormat
 */
class DisplayAdsTest extends TestCase
{
    public function testDisplayRequestSerialization(): void
    {
        $request = new Request();
        $item = new Item();
        $spec = new Spec();
        $placement = new Placement();
        $display = new DisplayPlacement();

        $format = new DisplayFormat();
        $format->setW(300)->setH(250);

        $display
            ->setPos(AdPosition::ABOVE_FOLD)
            ->setApi([ApiFramework::MRAID_2])
            ->setDisplayfmt([$format]);

        $placement->setDisplay($display);
        $spec->setPlacement($placement);
        $item->setSpec($spec);
        $request->addItem($item);

        $result = $request->toArray();

        $displayArray = $result['item'][0]['spec']['placement']['display'];
        $this->assertEquals(1, $displayArray['pos']);
        $this->assertEquals([5], $displayArray['api']);
        $this->assertCount(1, $displayArray['displayfmt']);
        $this->assertEquals(300, $displayArray['displayfmt'][0]['w']);
    }

    public function testDisplayRequestDeserialization(): void
    {
        $json = <<<'JSON'
{
  "item": [
    {
      "spec": {
        "placement": {
          "display": {
            "pos": 1,
            "api": [5],
            "displayfmt": [
              {
                "w": 300,
                "h": 250
              }
            ]
          }
        }
      }
    }
  ]
}
JSON;

        $request = Parser::parseBidRequest($json);
        $this->assertInstanceOf(Request::class, $request);

        $items = $request->getItem();
        $this->assertInstanceOf(Collection::class, $items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertInstanceOf(Item::class, $item);

        $spec = $item->getSpec();
        $this->assertInstanceOf(Spec::class, $spec);

        $placement = $spec->getPlacement();
        $this->assertInstanceOf(Placement::class, $placement);

        $display = $placement->getDisplay();
        $this->assertInstanceOf(DisplayPlacement::class, $display);

        $this->assertEquals(AdPosition::ABOVE_FOLD, $display->getPos());
        $this->assertInstanceOf(Collection::class, $display->getApi());
        $this->assertEquals(ApiFramework::MRAID_2, $display->getApi()[0]);

        $displayFmts = $display->getDisplayfmt();
        $this->assertInstanceOf(Collection::class, $displayFmts);
        $this->assertCount(1, $displayFmts);
        $this->assertInstanceOf(DisplayFormat::class, $displayFmts[0]);
        $this->assertEquals(300, $displayFmts[0]->getW());
    }
}
