<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\HasData;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\HasData
 */
class HasDataTest extends TestCase
{
    private object $instance;

    protected function setUp(): void
    {
        $this->instance = new class {
            use HasData;
        };
    }

    public function testConstructorWithEmptyData(): void
    {
        $obj = new class([]) {
            use HasData;
        };

        // @phpstan-ignore-next-line - Testing return type of trait method
        $this->assertIsArray($obj->toArray());
        $this->assertEmpty($obj->toArray());
    }

    public function testConstructorWithData(): void
    {
        $data = ['key' => 'value', 'number' => 123];
        $obj = new class($data) {
            use HasData;
        };

        $this->assertEquals('value', $obj->get('key'));
        $this->assertEquals(123, $obj->get('number'));
    }

    public function testSetAndGet(): void
    {
        // @phpstan-ignore-next-line - Anonymous class with trait
        $this->instance->set('test', 'value');
        // @phpstan-ignore-next-line - Anonymous class with trait
        $this->assertEquals('value', $this->instance->get('test'));
    }

    public function testToArray(): void
    {
        // @phpstan-ignore-next-line - Anonymous class with trait
        $this->instance->set('field1', 'value1');
        // @phpstan-ignore-next-line - Anonymous class with trait
        $this->instance->set('field2', 123);

        // @phpstan-ignore-next-line - Anonymous class with trait
        $array = $this->instance->toArray();

        $this->assertIsArray($array);
        $this->assertEquals('value1', $array['field1']);
        $this->assertEquals(123, $array['field2']);
    }

    public function testToJson(): void
    {
        // @phpstan-ignore-next-line - Anonymous class with trait
        $this->instance->set('field', 'value');

        // @phpstan-ignore-next-line - Anonymous class with trait
        $json = $this->instance->toJson();

        $this->assertJson($json);
        $decoded = json_decode($json, true);
        $this->assertEquals('value', $decoded['field']);
    }

    public function testToArrayWithNestedObjects(): void
    {
        $nestedObj = (new \OpenRTB\v25\Response\Bid())
            ->setId('nested-id')
            ->setImpid('imp-1')
            ->setPrice(1.5);

        // @phpstan-ignore-next-line
        $this->instance->set('object', $nestedObj);
        // @phpstan-ignore-next-line
        $array = $this->instance->toArray();

        $this->assertIsArray($array['object']);
        $this->assertEquals('nested-id', $array['object']['id']);
        $this->assertEquals(1.5, $array['object']['price']);
    }

    public function testToArrayWithCollection(): void
    {
        $bid1 = (new \OpenRTB\v25\Response\Bid())->setId('bid-1')->setImpid('imp-1')->setPrice(1.0);
        $bid2 = (new \OpenRTB\v25\Response\Bid())->setId('bid-2')->setImpid('imp-2')->setPrice(2.0);

        $collection = new \OpenRTB\Common\Collection([$bid1, $bid2]);

        // @phpstan-ignore-next-line
        $this->instance->set('bids', $collection);
        // @phpstan-ignore-next-line
        $array = $this->instance->toArray();

        $this->assertIsArray($array['bids']);
        $this->assertCount(2, $array['bids']);
        $this->assertEquals('bid-1', $array['bids'][0]['id']);
        $this->assertEquals('bid-2', $array['bids'][1]['id']);
    }

    public function testToArrayWithBackedEnum(): void
    {
        $enum = \OpenRTB\v25\Enums\AuctionType::FIRST_PRICE;

        // @phpstan-ignore-next-line
        $this->instance->set('auctionType', $enum);
        // @phpstan-ignore-next-line
        $array = $this->instance->toArray();

        $this->assertEquals(1, $array['auctionType']);
    }

    public function testToArrayWithArrayOfObjects(): void
    {
        $bid1 = (new \OpenRTB\v25\Response\Bid())->setId('bid-1')->setImpid('imp-1')->setPrice(1.0);
        $bid2 = (new \OpenRTB\v25\Response\Bid())->setId('bid-2')->setImpid('imp-2')->setPrice(2.0);

        // @phpstan-ignore-next-line
        $this->instance->set('items', [$bid1, $bid2]);
        // @phpstan-ignore-next-line
        $array = $this->instance->toArray();

        $this->assertIsArray($array['items']);
        $this->assertCount(2, $array['items']);
        $this->assertEquals('bid-1', $array['items'][0]['id']);
        $this->assertEquals('bid-2', $array['items'][1]['id']);
    }

    public function testToArrayWithArrayOfEnums(): void
    {
        $enums = [
            \OpenRTB\v25\Enums\AuctionType::FIRST_PRICE,
            \OpenRTB\v25\Enums\AuctionType::SECOND_PRICE_PLUS,
        ];

        // @phpstan-ignore-next-line
        $this->instance->set('types', $enums);
        // @phpstan-ignore-next-line
        $array = $this->instance->toArray();

        $this->assertIsArray($array['types']);
        $this->assertEquals([1, 2], $array['types']);
    }

    public function testGetNonExistentKey(): void
    {
        // @phpstan-ignore-next-line
        $result = $this->instance->get('non_existent');

        $this->assertNull($result);
    }
}
