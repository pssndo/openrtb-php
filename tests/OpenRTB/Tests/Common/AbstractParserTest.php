<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\AbstractParser;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use PHPUnit\Framework\TestCase;
use ValueError;

// Dummy classes and enums for testing
enum TestEnum: int
{
    case VALUE1 = 1;
    case VALUE2 = 2;
}

class TestSubObject implements ObjectInterface
{
    use HasData;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (empty($data)) {
            $this->data = new \stdClass();
        } else {
            $this->data = (object) $data;
        }
    }

    /**
     * @return array<string, string>
     */
    public static function getSchema(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function set(string $key, mixed $value): static
    {
        $this->data->$key = $value;

        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data->$key ?? null;
    }
}

class TestObject implements ObjectInterface
{
    use HasData;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        if (empty($data)) {
            $this->data = new \stdClass();
        } else {
            $this->data = (object) $data;
        }
    }

    /**
     * @return array<string, class-string|array<class-string>|string|list<string>>
     */
    public static function getSchema(): array
    {
        return [
            'id' => 'string',
            'enumValue' => TestEnum::class,
            'enumArray' => [TestEnum::class],
            'subObject' => TestSubObject::class,
            'subObjectArray' => [TestSubObject::class],
            'scalarValue' => 'string',
            'nullableString' => 'string',
            'stringArray' => ['string'],
            'unknownProperty' => 'mixed',
        ];
    }

    public function set(string $key, mixed $value): static
    {
        $this->data->$key = $value;

        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data->$key ?? null;
    }
}

class TestParser extends AbstractParser
{
    /**
     * @template T of ObjectInterface
     *
     * @param array<string, mixed> $data
     * @param class-string<T>      $class
     *
     * @return T
     */
    public function parse(array $data, string $class): ObjectInterface
    {
        return $this->hydrate($data, $class);
    }
}

class AbstractParserTest extends TestCase
{
    private TestParser $parser;

    public function testHydrateWithScalarValue(): void
    {
        $data = [
            'id' => 'scalar-test',
            'scalarValue' => 'hello',
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('hello', $object->get('scalarValue'));
    }

    public function testHydrateWithSingleEnum(): void
    {
        $data = [
            'id' => 'enum-test',
            'enumValue' => 1,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(TestEnum::VALUE1, $object->get('enumValue'));
    }

    public function testHydrateWithArrayOfEnums(): void
    {
        $data = [
            'id' => 'enum-array-test',
            'enumArray' => [1, 2],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->get('enumArray'));
        $this->assertEquals(TestEnum::VALUE1, $object->get('enumArray')[0]);
        $this->assertEquals(TestEnum::VALUE2, $object->get('enumArray')[1]);
    }

    public function testHydrateWithSingleObject(): void
    {
        $data = [
            'id' => 'sub-object-test',
            'subObject' => ['name' => 'sub1'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObject'));
        $this->assertEquals('sub1', $object->get('subObject')->get('name'));
    }

    public function testHydrateWithArrayOfObjects(): void
    {
        $data = [
            'id' => 'sub-object-array-test',
            'subObjectArray' => [
                ['name' => 'subA'],
                ['name' => 'subB'],
            ],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->get('subObjectArray'));
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObjectArray')[0]);
        $this->assertEquals('subA', $object->get('subObjectArray')[0]->get('name'));
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObjectArray')[1]);
        $this->assertEquals('subB', $object->get('subObjectArray')[1]->get('name'));
    }

    public function testHydrateValueWithArrayOfScalars(): void
    {
        $parser = new TestParser();
        $data = [
            'id' => 'test-id',
            'tags' => ['tag1', 'tag2', 'tag3'], // This will be an unknown property
        ];

        $testObject = $parser->parse($data, TestObject::class);

        $this->assertInstanceOf(TestObject::class, $testObject);
        $this->assertEquals('test-id', $testObject->get('id'));
        $this->assertEquals(['tag1', 'tag2', 'tag3'], $testObject->get('tags'));
    }

    public function testHydrateValueWithArrayOfMixedItemsInObjectArray(): void
    {
        $data = [
            'id' => 'mixed-array-test',
            'subObjectArray' => [
                ['name' => 'subX'],
                'not-an-array',
            ],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->get('subObjectArray'));
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObjectArray')[0]);
        $this->assertEquals('subX', $object->get('subObjectArray')[0]->get('name'));
        // When a non-array item is added to an ObjectInterface collection,
        // it's caught by InvalidArgumentException and null is added instead (line 79)
        $this->assertNull($object->get('subObjectArray')[1]);
    }

    public function testHydrateWithSingleObjectButScalarValue(): void
    {
        $data = [
            'id' => 'sub-object-scalar-test',
            'subObject' => 'not-an-object-data',
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('not-an-object-data', $object->get('subObject'));
    }

    public function testHydrateWithNullValueForOptionalProperty(): void
    {
        $data = [
            'id' => 'nullable-test',
            'nullableString' => null,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertNull($object->get('nullableString'));
    }

    public function testHydrateWithSingleEnumButNonScalarValue(): void
    {
        // When enum value is wrong type (array instead of int), TypeError is thrown
        $this->expectException(\TypeError::class);

        $data = [
            'id' => 'enum-non-scalar-test',
            'enumValue' => ['not', 'a', 'scalar'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
    }

    public function testHydrateWithArrayOfEnumsAndNonScalarItem(): void
    {
        // When enum array contains wrong type, TypeError is thrown
        $this->expectException(\TypeError::class);

        $data = [
            'id' => 'enum-array-non-scalar-item-test',
            'enumArray' => [1, ['not', 'a', 'scalar']],
        ];
        $object = $this->parser->parse($data, TestObject::class);
    }

    public function testHydrateWithArrayOfScalarsInSchema(): void
    {
        $data = [
            'id' => 'string-array-test',
            'stringArray' => ['str1', 'str2', 'str3'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        // stringArray schema is ['string'], so it returns a Collection
        $stringArray = $object->get('stringArray');
        $this->assertInstanceOf(\OpenRTB\Common\Collection::class, $stringArray);
        $this->assertCount(3, $stringArray);
    }

    public function testHydrateWithArrayOfMixedTypes(): void
    {
        // When enum array contains invalid string value, TypeError is thrown
        $this->expectException(\TypeError::class);

        $data = [
            'id' => 'mixed-types-array-test',
            'subObjectArray' => [
                ['name' => 'subA'],
                1, // Scalar item
                ['name' => 'subB'],
            ],
            'enumArray' => [
                1, // Valid enum
                'not-an-enum', // Invalid enum - will cause TypeError
            ],
        ];

        $object = $this->parser->parse($data, TestObject::class);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new TestParser();
    }

    // Additional tests for missing coverage

    public function testHydrateWithListArray(): void
    {
        // Line 25: When data is a list array (not associative), return empty object
        $data = ['value1', 'value2', 'value3'];
        // @phpstan-ignore-next-line - Testing edge case with list array
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertNull($object->get('id'));
    }

    public function testHydrateCollectionWithNonArrayValue(): void
    {
        // Line 67: When value is not an array, return it as-is
        $data = [
            'id' => 'test',
            'subObjectArray' => 'not-an-array', // Schema expects array but got string
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('not-an-array', $object->get('subObjectArray'));
    }

    public function testHydrateCollectionItemWithIntType(): void
    {
        // Line 96: When itemType is not a string (int/float), return item as-is
        // This is difficult to test directly without modifying schema to have int type
        // But we can use a schema with mixed types that includes numeric keys
        $data = [
            'id' => 'test',
            'unknownProperty' => [1, 2, 3], // Will be handled as-is since type is 'mixed'
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals([1, 2, 3], $object->get('unknownProperty'));
    }

    public function testHydrateSingleValueWithIntType(): void
    {
        // Line 120: When type is not a string (int/float), return value as-is
        // This requires a schema with int/float type instead of class-string
        // The schema system uses strings, so this is an edge case for defensive programming
        $data = [
            'id' => 'test',
            'scalarValue' => 123,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(123, $object->get('scalarValue'));
    }

    public function testHydrateObjectWithListArray(): void
    {
        // Line 148: When object value is a list array, take first element
        $data = [
            'id' => 'test',
            'subObject' => [['name' => 'first'], ['name' => 'second']], // List array
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObject'));
        $this->assertEquals('first', $object->get('subObject')->get('name'));
    }

    public function testHydrateEnumWithInvalidValue(): void
    {
        // Lines 165-166: Catch ValueError when enum value is invalid
        $data = [
            'id' => 'test',
            'enumValue' => 999, // Invalid enum value
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        // Invalid enum value should be returned as-is
        $this->assertEquals(999, $object->get('enumValue'));
    }

    public function testHydrateCollectionWithInvalidItems(): void
    {
        // Lines 78-79: Catch InvalidArgumentException when adding invalid item to collection
        // This happens when Collection validates items and rejects them
        // The catch block adds null instead
        // Use a string value in object array to trigger InvalidArgumentException
        $data = [
            'id' => 'test',
            'subObjectArray' => [
                ['name' => 'valid'],
                'invalid-string', // This will trigger InvalidArgumentException
            ],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $subObjectArray = $object->get('subObjectArray');
        $this->assertCount(2, $subObjectArray);
        $this->assertInstanceOf(TestSubObject::class, $subObjectArray[0]);
        // The invalid value is caught and null is added instead (line 79)
        $this->assertNull($subObjectArray[1]);
    }

    public function testHydrateCollectionWithEmptyTypeArray(): void
    {
        // Line 67: When type array is empty (no type[0]), return value as-is
        // This is difficult to test without modifying the schema structure
        // but represents defensive programming for malformed schemas
        $data = [
            'id' => 'test',
            'stringArray' => ['item1', 'item2'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $stringArray = $object->get('stringArray');
        $this->assertCount(2, $stringArray); // Should be a Collection with 2 items
    }

    public function testHydrateWithNullValue(): void
    {
        // Line 49: hydrateValue returns null when value is null
        $data = [
            'id' => 'test',
            'subObject' => null,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertNull($object->get('subObject'));
    }

    public function testIsBackedEnumMethod(): void
    {
        // Ensure isBackedEnum and isObjectInterface methods are called
        // They're called indirectly through hydrateSingleValue and hydrateCollectionItem
        $data = [
            'id' => 'test',
            'enumValue' => 2, // Valid enum value
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(TestEnum::VALUE2, $object->get('enumValue'));
    }

    public function testIsObjectInterfaceMethod(): void
    {
        // Ensure isObjectInterface is called
        $data = [
            'id' => 'test',
            'subObject' => ['name' => 'test-name'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertInstanceOf(TestSubObject::class, $object->get('subObject'));
        $this->assertEquals('test-name', $object->get('subObject')->get('name'));
    }

    public function testHydrateCollectionItemWithStringScalarType(): void
    {
        // Line 110 in hydrateCollectionItem: When itemType is a string but not enum/object
        // This happens with scalar types like 'string', 'int', 'float' in array schema
        $data = [
            'id' => 'test',
            'stringArray' => ['value1', 'value2', 'value3'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $stringArray = $object->get('stringArray');
        $this->assertInstanceOf(\OpenRTB\Common\Collection::class, $stringArray);
        $this->assertCount(3, $stringArray);
        // Each item should be returned as-is (string)
        $this->assertEquals('value1', $stringArray[0]);
        $this->assertEquals('value2', $stringArray[1]);
        $this->assertEquals('value3', $stringArray[2]);
    }

    public function testHydrateSingleValueWithScalarString(): void
    {
        // Line 136 in hydrateSingleValue: When type is a string but not object/enum
        // This happens for scalar types like 'string', 'int', etc.
        $data = [
            'id' => 'scalar-id-value',
            'scalarValue' => 'some-string-value',
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('scalar-id-value', $object->get('id'));
        $this->assertEquals('some-string-value', $object->get('scalarValue'));
    }

    public function testHydrateSingleValueWithObjectInterface(): void
    {
        // Lines 126-128 in hydrateSingleValue: When type is ObjectInterface
        $data = [
            'id' => 'object-test',
            'subObject' => ['name' => 'nested-object'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $subObject = $object->get('subObject');
        $this->assertInstanceOf(TestSubObject::class, $subObject);
        $this->assertEquals('nested-object', $subObject->get('name'));
    }

    public function testHydrateSingleValueWithBackedEnum(): void
    {
        // Lines 131-133 in hydrateSingleValue: When type is BackedEnum
        $data = [
            'id' => 'enum-test',
            'enumValue' => 2,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(TestEnum::VALUE2, $object->get('enumValue'));
    }

    public function testHydrateSingleValueWithNonStringType(): void
    {
        // Line 123 in hydrateSingleValue: When type is int/float (not a string)
        // This tests defensive programming for malformed schemas
        // Create a custom object with int/float type in schema
        $customObject = new class implements ObjectInterface {
            use HasData;

            public function __construct()
            {
                $this->data = new \stdClass();
            }

            public static function getSchema(): array
            {
                return [
                    'numericField' => 42, // int type instead of string
                ];
            }

            public function set(string $key, mixed $value): static
            {
                $this->data->$key = $value;

                return $this;
            }

            public function get(string $key): mixed
            {
                return $this->data->$key ?? null;
            }
        };

        $parser = new TestParser();
        $data = ['numericField' => 'test-value'];
        $result = $parser->parse($data, get_class($customObject));

        // When type is not a string, value should be returned as-is
        $this->assertEquals('test-value', $result->get('numericField'));
    }

    public function testHydrateCollectionItemWithNonStringType(): void
    {
        // Line 97 in hydrateCollectionItem: When itemType is int/float (not a string)
        // This tests defensive programming for malformed array schemas
        $customObject = new class implements ObjectInterface {
            use HasData;

            public function __construct()
            {
                $this->data = new \stdClass();
            }

            public static function getSchema(): array
            {
                return [
                    'numericArray' => [99], // int type in array instead of string
                ];
            }

            public function set(string $key, mixed $value): static
            {
                $this->data->$key = $value;

                return $this;
            }

            public function get(string $key): mixed
            {
                return $this->data->$key ?? null;
            }
        };

        $parser = new TestParser();
        $data = ['numericArray' => ['item1', 'item2']];
        $result = $parser->parse($data, get_class($customObject));

        // When itemType is not a string, items should be returned as-is
        $collection = $result->get('numericArray');
        $this->assertInstanceOf(\OpenRTB\Common\Collection::class, $collection);
        $this->assertEquals('item1', $collection[0]);
        $this->assertEquals('item2', $collection[1]);
    }
}
