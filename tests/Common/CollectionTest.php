<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Bid;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

/**
 * @covers \OpenRTB\Common\Collection
 */
class CollectionTest extends TestCase
{
    public function testConstructorWithEmptyArray(): void
    {
        $collection = new Collection([], Bid::class);
        $this->assertCount(0, $collection);
    }

    public function testConstructorWithItems(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $this->assertCount(2, $collection);
    }

    public function testConstructorWithCollection(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection1 = new Collection([$bid1, $bid2], Bid::class);
        $collection2 = new Collection($collection1);

        $this->assertCount(2, $collection2);
    }

    public function testConstructorWithInvalidItemsAddsNull(): void
    {
        // When constructor receives invalid items, it adds null instead
        // This tests line 43 - the catch block
        $collection = new Collection(['invalid', new Bid()], Bid::class);

        // Should have 2 items (one null, one valid)
        $this->assertCount(2, $collection);
    }

    public function testAdd(): void
    {
        $collection = new Collection([], Bid::class);
        $bid = new Bid();
        $collection->add($bid);

        $this->assertCount(1, $collection);
    }

    public function testAddWithInvalidTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Collection expects items of type');

        $collection = new Collection([], Bid::class);
        $collection->add('invalid');
    }

    public function testAddWithScalarType(): void
    {
        $collection = new Collection([], 'string');
        $collection->add('test');

        $this->assertCount(1, $collection);
        $this->assertEquals('test', $collection[0]);
    }

    public function testAddWithNullWhenTypeIsSet(): void
    {
        $collection = new Collection([], Bid::class);
        $collection->add(null);

        $this->assertCount(1, $collection);
        // @phpstan-ignore-next-line - Testing null handling
        $this->assertNull($collection[0]);
    }

    public function testCount(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $this->assertEquals(2, $collection->count());
    }

    // ArrayAccess Interface Tests

    public function testOffsetExists(): void
    {
        $bid = new Bid();
        $collection = new Collection([$bid], Bid::class);

        $this->assertTrue(isset($collection[0]));
        $this->assertFalse(isset($collection[999]));
    }

    public function testOffsetGet(): void
    {
        $bid = new Bid();
        $collection = new Collection([$bid], Bid::class);

        $this->assertSame($bid, $collection[0]);
        $this->assertNull($collection[999]);
    }

    public function testOffsetSetWithNullOffset(): void
    {
        $collection = new Collection([], Bid::class);
        $bid = new Bid();

        // @phpstan-ignore-next-line - Testing ArrayAccess implementation
        $collection[] = $bid;

        $this->assertCount(1, $collection);
        $this->assertSame($bid, $collection[0]);
    }

    public function testOffsetSetWithSpecificOffset(): void
    {
        $collection = new Collection([], Bid::class);
        $bid = new Bid();

        // @phpstan-ignore-next-line - Testing ArrayAccess implementation
        $collection[5] = $bid;

        // @phpstan-ignore-next-line - Testing specific offset
        $this->assertTrue(isset($collection[5]));
        $this->assertSame($bid, $collection[5]);
    }

    public function testOffsetSetWithInvalidTypeThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Collection expects items of type');

        $collection = new Collection([], Bid::class);
        // @phpstan-ignore-next-line - Testing error handling for invalid type
        $collection[0] = 'invalid';
    }

    public function testOffsetUnset(): void
    {
        $bid = new Bid();
        $collection = new Collection([$bid], Bid::class);

        $this->assertTrue(isset($collection[0]));

        unset($collection[0]);

        $this->assertFalse(isset($collection[0]));
    }

    // Iterator Interface Tests

    public function testGetIterator(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $items = [];
        foreach ($collection as $key => $item) {
            $items[$key] = $item;
        }

        $this->assertCount(2, $items);
        $this->assertSame($bid1, $items[0]);
        $this->assertSame($bid2, $items[1]);
    }

    public function testGetIteratorWithEmptyCollection(): void
    {
        $collection = new Collection([], Bid::class);

        $count = 0;
        foreach ($collection as $item) {
            $count++;
        }

        $this->assertEquals(0, $count);
    }

    // all() method test

    public function testAll(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $all = $collection->all();

        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($all);
        $this->assertCount(2, $all);
        $this->assertSame($bid1, $all[0]);
        $this->assertSame($bid2, $all[1]);
    }

    public function testAllReturnsRawObjects(): void
    {
        $bid = new Bid();
        $bid->setId('test-id');
        $collection = new Collection([$bid], Bid::class);

        $all = $collection->all();

        // all() returns objects, not arrays
        $this->assertInstanceOf(Bid::class, $all[0]);
        $this->assertEquals('test-id', $all[0]->getId());
    }

    // toArray() method test

    public function testToArray(): void
    {
        $bid = new Bid();
        $bid->setId('test-id');
        $bid->setPrice(5.0);
        $collection = new Collection([$bid], Bid::class);

        $array = $collection->toArray();

        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($array);
        $this->assertCount(1, $array);
        $this->assertIsArray($array[0]); // toArray converts objects to arrays
    }

    public function testToArrayWithScalars(): void
    {
        $collection = new Collection(['string1', 'string2'], 'string');

        $array = $collection->toArray();

        $this->assertEquals(['string1', 'string2'], $array);
    }

    // Serialization tests

    public function testSerialize(): void
    {
        $bid1 = new Bid();
        $bid1->setId('bid-1');
        $bid2 = new Bid();
        $bid2->setId('bid-2');
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $serialized = serialize($collection);
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsString($serialized);
    }

    public function testUnserialize(): void
    {
        $bid1 = new Bid();
        $bid1->setId('bid-1');
        $bid2 = new Bid();
        $bid2->setId('bid-2');
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $serialized = serialize($collection);
        $unserialized = unserialize($serialized);

        $this->assertInstanceOf(Collection::class, $unserialized);
        $this->assertCount(2, $unserialized);
        $this->assertEquals('bid-1', $unserialized[0]->getId());
        $this->assertEquals('bid-2', $unserialized[1]->getId());
    }

    // __debugInfo test

    public function testDebugInfo(): void
    {
        $bid1 = new Bid();
        $bid2 = new Bid();
        $collection = new Collection([$bid1, $bid2], Bid::class);

        $debugInfo = $collection->__debugInfo();

        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($debugInfo);
        $this->assertCount(2, $debugInfo);
        $this->assertSame($bid1, $debugInfo[0]);
        $this->assertSame($bid2, $debugInfo[1]);
    }

    // getTypeName test (error path)

    public function testGetTypeNameInErrorMessage(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/Collection expects items of type .*, .* given/');

        $collection = new Collection([], Bid::class);
        $collection->add(new \stdClass());
    }

    public function testValidateItemWithNullItemType(): void
    {
        // When itemType is null, any item is valid
        $collection = new Collection();
        $collection->add('string');
        $collection->add(123);
        $collection->add(new Bid());

        $this->assertCount(3, $collection);
    }

    public function testConstructorInheritsItemTypeFromCollection(): void
    {
        $collection1 = new Collection([], Bid::class);
        $collection2 = new Collection($collection1);

        // Add item to collection2 - should validate against Bid::class
        $bid = new Bid();
        $collection2->add($bid);

        $this->assertCount(1, $collection2);
    }

    public function testConstructorCanOverrideItemType(): void
    {
        $collection1 = new Collection(['string'], 'string');
        // Pass a specific itemType that overrides the source collection's type
        $collection2 = new Collection($collection1, 'int');

        // This creates a new collection, but the constructor tries to add items
        // Since 'string' doesn't match 'int', it will add null (line 43)
        $this->assertCount(1, $collection2);
    }
}
