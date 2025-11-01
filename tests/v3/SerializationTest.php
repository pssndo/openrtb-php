<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Device;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Impression\Item;
use OpenRTB\v3\Impression\Spec;
use OpenRTB\v3\Placement\DisplayPlacement;
use OpenRTB\v3\Placement\Placement;
use OpenRTB\v3\Request;

/**
 * @covers \OpenRTB\v3\Request
 * @covers \OpenRTB\Common\BaseObject 
 */
class SerializationTest extends TestCase
{
    public function testToArraySerializesCorrectly(): void
    {
        // 1. Create a complex object graph
        $request = new Request();
        $request->setId('test-req');
        $request->setTest(1);
        $request->setAt(AuctionType::SECOND_PRICE);

        $item = new Item();
        $item->setId('item-1');

        $placement = new Placement();
        $display = new DisplayPlacement();
        $display->setPos(AdPosition::ABOVE_FOLD);
        $placement->setDisplay($display);

        $spec = new Spec();
        $spec->setPlacement($placement);
        $item->setSpec($spec);

        $context = new Context();
        $device = new Device();
        $device->setIp('127.0.0.1');
        $context->setDevice($device);

        $request->addItem($item);
        $request->setContext($context);

        // 2. Serialize the object to an array
        $result = $request->toArray();

        // 3. Assert the array structure and values

        // Assert top-level properties
        $this->assertEquals('test-req', $result['id']);
        $this->assertEquals(1, $result['test']);
        $this->assertEquals(2, $result['at']); // Check enum value

        // Assert nested item and placement
        $this->assertArrayHasKey('item', $result);
        $this->assertCount(1, $result['item']);
        $itemArray = $result['item'][0];
        $this->assertEquals('item-1', $itemArray['id']);
        $this->assertEquals(1, $itemArray['spec']['placement']['display']['pos']); // Check nested enum value

        // Assert nested context and device
        $this->assertArrayHasKey('context', $result);
        $this->assertEquals('127.0.0.1', $result['context']['device']['ip']);
    }

    public function testToJson(): void
    {
        $request = new Request();
        $request->setId('test-req-json');

        $json = $request->toJson();

        $this->assertIsString($json);
        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertArrayHasKey('id', $decoded);
        $this->assertEquals('test-req-json', $decoded['id']);
    }
}
