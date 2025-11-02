<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\AbstractParser;
use OpenRTB\Interfaces\ObjectInterface;
use PHPUnit\Framework\TestCase;

// Dummy classes and enums for testing
enum TestEnum: int implements \BackedEnum
{
    case VALUE1 = 1;
    case VALUE2 = 2;
}

class TestSubObject implements ObjectInterface
{
    private array $data = [];

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

    public function set(string $property, mixed $value): void
    {
        $this->data[$property] = $value;
    }

    public function get(string $property): mixed
    {
        return $this->data[$property] ?? null;
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }
}

class TestObject implements ObjectInterface
{
    private array $data = [];

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
            'unknownProperty' => 'mixed', // Add this to schema to explicitly test unknown properties
        ];
    }

    public function set(string $property, mixed $value): void
    {
        $this->data[$property] = $value;
    }

    public function get(string $property): mixed
    {
        return $this->data[$property] ?? null;
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function getEnumValue(): mixed
    {
        return $this->get('enumValue');
    }

    public function getEnumArray(): array
    {
        return $this->get('enumArray') ?? [];
    }

    public function getSubObject(): mixed
    {
        return $this->get('subObject');
    }

    public function getSubObjectArray(): array
    {
        return $this->get('subObjectArray') ?? [];
    }

    public function getScalarValue(): mixed
    {
        return $this->get('scalarValue');
    }

    public function getNullableString(): ?string
    {
        return $this->get('nullableString');
    }

    public function getStringArray(): array
    {
        return $this->get('stringArray') ?? [];
    }

    public function getUnknownProperty(): mixed
    {
        return $this->get('unknownProperty');
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->parser = new TestParser();
    }

    public function testHydrateWithScalarValue(): void
    {
        $data = [
            'id' => 'scalar-test',
            'scalarValue' => 'hello',
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('hello', $object->getScalarValue());
    }

    public function testHydrateWithSingleEnum(): void
    {
        $data = [
            'id' => 'enum-test',
            'enumValue' => 1,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(TestEnum::VALUE1, $object->getEnumValue());
    }

    public function testHydrateWithArrayOfEnums(): void
    {
        $data = [
            'id' => 'enum-array-test',
            'enumArray' => [1, 2],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->getEnumArray());
        $this->assertEquals(TestEnum::VALUE1, $object->getEnumArray()[0]);
        $this->assertEquals(TestEnum::VALUE2, $object->getEnumArray()[1]);
    }

    public function testHydrateWithSingleObject(): void
    {
        $data = [
            'id' => 'sub-object-test',
            'subObject' => ['name' => 'sub1'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertInstanceOf(TestSubObject::class, $object->getSubObject());
        $this->assertEquals('sub1', $object->getSubObject()->getName());
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
        $this->assertCount(2, $object->getSubObjectArray());
        $this->assertInstanceOf(TestSubObject::class, $object->getSubObjectArray()[0]);
        $this->assertEquals('subA', $object->getSubObjectArray()[0]->getName());
        $this->assertInstanceOf(TestSubObject::class, $object->getSubObjectArray()[1]);
        $this->assertEquals('subB', $object->getSubObjectArray()[1]->getName());
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
        $this->assertEquals('test-id', $testObject->getId());
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
        $this->assertCount(2, $object->getSubObjectArray());
        $this->assertInstanceOf(TestSubObject::class, $object->getSubObjectArray()[0]);
        $this->assertEquals('subX', $object->getSubObjectArray()[0]->getName());
        $this->assertEquals('not-an-array', $object->getSubObjectArray()[1]);
    }

    public function testHydrateWithSingleObjectButScalarValue(): void
    {
        $data = [
            'id' => 'sub-object-scalar-test',
            'subObject' => 'not-an-object-data',
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals('not-an-object-data', $object->getSubObject());
    }

    public function testHydrateWithNullValueForOptionalProperty(): void
    {
        $data = [
            'id' => 'nullable-test',
            'nullableString' => null,
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertNull($object->getNullableString());
    }

    public function testHydrateWithSingleEnumButNonScalarValue(): void
    {
        $data = [
            'id' => 'enum-non-scalar-test',
            'enumValue' => ['not', 'a', 'scalar'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(['not', 'a', 'scalar'], $object->getEnumValue());
    }

    public function testHydrateWithArrayOfEnumsAndNonScalarItem(): void
    {
        $data = [
            'id' => 'enum-array-non-scalar-item-test',
            'enumArray' => [1, ['not', 'a', 'scalar']],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertCount(2, $object->getEnumArray());
        $this->assertEquals(TestEnum::VALUE1, $object->getEnumArray()[0]);
        // Expect an InvalidArgumentException from TestEnum::from() for the second item
        $this->expectException(\\InvalidArgumentException::class);
        // Accessing this will trigger the exception if not already triggered, ensuring line 41 is hit.
        $invalidEnum = $object->getEnumArray()[1];
    }

    public function testHydrateWithArrayOfScalarsInSchema(): void
    {
        $data = [
            'id' => 'string-array-test',
            'stringArray' => ['str1', 'str2', 'str3'],
        ];
        $object = $this->parser->parse($data, TestObject::class);
        $this->assertInstanceOf(TestObject::class, $object);
        $this->assertEquals(['str1', 'str2', 'str3'], $object->getStringArray());
    }
}
