<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Request;
use OpenRTB\v3\Util\Parser;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Util\Parser
 */
class ParserTest extends TestCase
{
    public function testParseRequestWithEmptyJson(): void
    {
        $this->expectException(\JsonException::class);
        Parser::parseRequest('');
    }

    public function testParseRequestWithInvalidJson(): void
    {
        $this->expectException(\JsonException::class);
        Parser::parseRequest('{ "id": "123"');
    }

    public function testParseRequestWithValidJson(): void
    {
        $json = '{ "id": "123", "test": 1 }';
        $request = Parser::parseRequest($json);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('123', $request->getId());
        $this->assertEquals(1, $request->getTest());
    }

    public function testParseRequestWithFullJson(): void
    {
        $json = <<<JSON
{
  "id": "req-123",
  "test": 1,
  "at": 2,
  "cur": ["USD"],
  "context": {
    "site": {
      "id": "site-456",
      "domain": "example.com"
    },
    "device": {
      "ip": "1.2.3.4"
    }
  },
  "item": [
    {
      "id": "item-789",
      "qty": 1,
      "spec": {
        "placement": {
          "display": {
            "w": 300,
            "h": 250
          }
        }
      }
    }
  ]
}
JSON;

        $request = Parser::parseRequest($json);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req-123', $request->getId());

        $context = $request->getContext();
        $this->assertNotNull($context);
        $this->assertEquals('site-456', $context->getSite()->getId());
        $this->assertEquals('1.2.3.4', $context->getDevice()->getIp());

        $items = $request->getItem();
        $this->assertCount(1, $items);
        $this->assertEquals('item-789', $items[0]->getId());
        $this->assertEquals(300, $items[0]->getSpec()->getPlacement()->getDisplay()->getW());
    }

    public function testHydrateWithUnhandledTypes(): void
    {
        $json = <<<JSON
{
  "id": "req-unhandled",
  "item": [
    "not-an-object"
  ],
  "context": {
    "unhandled_array": [1, 2, 3]
  }
}
JSON;
        $request = Parser::parseRequest($json);

        // Assert that the parser correctly passed through the unhandled array value
        $this->assertEquals([1, 2, 3], $request->getContext()->get('unhandled_array'));

        // Assert that the parser passed through the scalar value where an array of objects was expected
        $this->assertEquals(['not-an-object'], $request->getItem());
    }

    public function testHydrateWithInvalidDataTypes(): void
    {
        $json = <<<JSON
{
  "id": "req-invalid-types",
  "context": {
    "site": "this-is-a-string-not-an-object"
  },
  "source": {
      "some_unhandled_object": { "key": "value" }
  }
}
JSON;
        $request = Parser::parseRequest($json);

        // This covers the `!is_array($value)` check.
        // The parser should return the raw string value.
        $this->assertEquals('this-is-a-string-not-an-object', $request->getContext()->get('site'));

        // This covers the final `return $value` by providing an object for a property
        // that is not a known ObjectInterface class in the schema.
        $this->assertEquals(['key' => 'value'], $request->getSource()->get('some_unhandled_object'));
    }

    public function testHydrateWithInvalidSchemaClass(): void
    {
        // Create a temporary request class with an invalid schema definition
        $requestWithInvalidSchema = new class extends Request {
            protected static array $schema = [
                'source' => InvalidSourceClassForTesting::class,
            ];
        };

        $json = <<<JSON
{
  "id": "req-invalid-schema",
  "source": { "key": "value" }
}
JSON;

        $data = json_decode($json, true);
        $parser = new Parser();

        // Use reflection to call the private hydrate method
        $result = $this->invokeMethod($parser, 'hydrate', [$data, get_class($requestWithInvalidSchema)]);

        // This covers the final `return $value` by providing an object for a property
        // whose class in the schema does not implement ObjectInterface.
        $this->assertEquals(['key' => 'value'], $result->get('source'));
    }

    private function invokeMethod(object $object, string $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }
}

// A dummy class that does NOT implement ObjectInterface, used to test the parser's edge case.
class InvalidSourceClassForTesting
{
}