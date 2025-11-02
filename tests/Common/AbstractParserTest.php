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

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public static function getSchema(): array
    {
        return [
            'name' => 'string',
        ];
    }

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }
}

class TestObject implements ObjectInterface
{
    use HasData;

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

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

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }
}

class TestParser extends AbstractParser
{
    /**
     * @template T of ObjectInterface
     * @param array<string, mixed> $data
     * @param class-string<T> $class
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
        $this->assertEquals('not-an-array', $object->get('subObjectArray')[1]);
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
        $data = [
            'id' => 'enum-non-scalar-test',
            'enumValue' => ['not', 'a', 'scalar'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(['not', 'a', 'scalar'], $object->get('enumValue'));
    }

    public function testHydrateWithArrayOfEnumsAndNonScalarItem(): void
    {
        $data = [
            'id' => 'enum-array-non-scalar-item-test',
            'enumArray' => [1, ['not', 'a', 'scalar']],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->get('enumArray'));
        $this->assertEquals(TestEnum::VALUE1, $object->get('enumArray')[0]);
        // Expect an InvalidArgumentException from TestEnum::from() for the second item
        $this->expectException(ValueError::class);
        // Accessing this will trigger the exception if not already triggered, ensuring line 41 is hit.
        $invalidEnum = $object->get('enumArray')[1];
    }

    public function testHydrateWithArrayOfScalarsInSchema(): void
    {
        $data = [
            'id' => 'string-array-test',
            'stringArray' => ['str1', 'str2', 'str3'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(['str1', 'str2', 'str3'], $object->get('stringArray'));
    }

    public function testHydrateWithArrayOfMixedTypes(): void
    {
        $data = [
            'id' => 'mixed-types-array-test',
            'subObjectArray' => [
                ['name' => 'subA'],
                1, // Scalar item
                ['name' => 'subB'],
            ],
            'enumArray' => [
                1, // Valid enum
                'not-an-enum', // Invalid enum
            ]
        ];

        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);

        // Test subObjectArray
        $subObjectArray = $object->get('subObjectArray');
        $this->assertCount(3, $subObjectArray);
        $this->assertInstanceOf(TestSubObject::class, $subObjectArray[0]);
        $this->assertEquals('subA', $subObjectArray[0]->get('name'));
        $this->assertEquals(1, $subObjectArray[1]); // Should hit return $itemData;
        $this->assertInstanceOf(TestSubObject::class, $subObjectArray[2]);
        $this->assertEquals('subB', $subObjectArray[2]->get('name'));

        // Test enumArray
        $enumArray = $object->get('enumArray');
        $this->assertCount(2, $enumArray);
        $this->assertEquals(TestEnum::VALUE1, $enumArray[0]);
        $this->expectException(ValueError::class); // BackedEnum::from() throws ValueError for invalid value
        $invalidEnum = $enumArray[1]; // Accessing this will trigger the exception
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new TestParser();
    }
}
