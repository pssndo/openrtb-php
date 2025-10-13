<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Enums\Placement\Linearity;
use OpenRTB\v3\Enums\Placement\PlaybackMethod;
use OpenRTB\v3\Enums\Placement\VideoPlacementType;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Placement\VideoPlacement;
use OpenRTB\v3\Request;
use OpenRTB\v3\Util\Parser;

class VideoAdsTest extends TestCase
{
    public function testVideoRequestSerialization(): void
    {
        $request = new Request();
        $item = new Item();
        $spec = new Spec();
        $placement = new Placement();
        $video = new VideoPlacement();

        $video
            ->setPtype(VideoPlacementType::INSTREAM)
            ->setLinear(Linearity::LINEAR)
            ->setPlaymethod([PlaybackMethod::ON_CLICK_SOUND_ON]);

        $placement->setVideo($video);
        $spec->setPlacement($placement);
        $item->setSpec($spec);
        $request->addItem($item);

        $result = $request->toArray();

        $videoArray = $result['item'][0]['spec']['placement']['video'];
        $this->assertEquals(1, $videoArray['ptype']);
        $this->assertEquals(1, $videoArray['linear']);
        $this->assertEquals([3], $videoArray['playmethod']);
    }

    public function testVideoRequestDeserialization(): void
    {
        $json = <<<'JSON'
{
  "item": [
    {
      "spec": {
        "placement": {
          "video": {
            "ptype": 1,
            "linear": 1,
            "playmethod": [3]
          }
        }
      }
    }
  ]
}
JSON;

        $request = Parser::parseRequest($json);
        $this->assertInstanceOf(Request::class, $request);

        $items = $request->getItem();
        $this->assertIsArray($items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertInstanceOf(Item::class, $item);

        $spec = $item->getSpec();
        $this->assertInstanceOf(Spec::class, $spec);

        $placement = $spec->getPlacement();
        $this->assertInstanceOf(Placement::class, $placement);

        $video = $placement->getVideo();
        $this->assertInstanceOf(VideoPlacement::class, $video);

        $this->assertEquals(VideoPlacementType::INSTREAM, $video->getPtype());
        $this->assertEquals(Linearity::LINEAR, $video->getLinear());
        $this->assertIsArray($video->getPlaymethod());
        $this->assertEquals(PlaybackMethod::ON_CLICK_SOUND_ON, $video->getPlaymethod()[0]);
    }
}
