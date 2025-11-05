<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\Collection;
use OpenRTB\v3\BidRequest as Request;
use OpenRTB\v3\Enums\Placement\FeedType;
use OpenRTB\v3\Enums\Placement\VolumeNormalizationMode;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\AudioPlacement;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Placement\AudioPlacement
 */
class AudioAdsTest extends TestCase
{
    public function testAudioRequestSerialization(): void
    {
        $request = new Request();
        $item = new Item();
        $spec = new Spec();
        $placement = new Placement();
        $audio = new AudioPlacement();

        $audio
            ->setFeed(FeedType::PODCAST)
            ->setNvol(VolumeNormalizationMode::AD_LOUDNESS);

        $placement->setAudio($audio);
        $spec->setPlacement($placement);
        $item->setSpec($spec);
        $request->addItem($item);

        $result = $request->toArray();

        $audioArray = $result['item'][0]['spec']['placement']['audio'];
        $this->assertEquals(3, $audioArray['feed']);
        $this->assertEquals(3, $audioArray['nvol']);
    }

    public function testAudioRequestDeserialization(): void
    {
        $json = <<<'JSON'
{
  "item": [
    {
      "spec": {
        "placement": {
          "audio": {
            "feed": 3,
            "nvol": 3
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

        $audio = $placement->getAudio();
        $this->assertInstanceOf(AudioPlacement::class, $audio);

        $this->assertEquals(FeedType::PODCAST, $audio->getFeed());
        $this->assertEquals(VolumeNormalizationMode::AD_LOUDNESS, $audio->getNvol());
    }
}
