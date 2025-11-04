<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\HasData;
use PHPUnit\Framework\TestCase;
use stdClass;

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
}
