<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\BidRequest as Request;
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
        Parser::parseBidRequest('');
    }

    public function testParseRequestWithInvalidJson(): void
    {
        $this->expectException(\JsonException::class);
        Parser::parseBidRequest('{ "id": "123"');
    }

    public function testParseRequestWithValidJson(): void
    {
        $json = '{ "id": "123", "test": 1 }';
        $request = Parser::parseBidRequest($json);

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

        $request = Parser::parseBidRequest($json);

        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals('req-123', $request->getId());

        $context = $request->getContext();
        $this->assertNotNull($context);
        $site = $context->getSite();
        $this->assertNotNull($site);
        $this->assertEquals('site-456', $site->getId());

        $items = $request->getItem();
        $this->assertNotNull($items);
        $this->assertCount(1, $items);
        $item = $items[0];
        $this->assertNotNull($item);
        $this->assertEquals('item-789', $item->getId());
        $spec = $item->getSpec();
        $this->assertNotNull($spec);
        $placement = $spec->getPlacement();
        $this->assertNotNull($placement);
        $display = $placement->getDisplay();
        $this->assertNotNull($display);
        $this->assertEquals(300, $display->getW());
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
        $request = Parser::parseBidRequest($json);

        // Assert that the parser correctly passed through the unhandled array value
        $context = $request->getContext();
        $this->assertNotNull($context);
        $this->assertEquals([1, 2, 3], $context->get('unhandled_array'));

        // Assert that the parser passed through the scalar value where an array of objects was expected
        // It should now return a Collection with null for the unhandled item.
        $this->assertEquals([null], $request->getItem()?->toArray());
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
        $request = Parser::parseBidRequest($json);

        // This covers the `!is_array($value)` check.
        // The parser should return the raw string value.
        $context = $request->getContext();
        $this->assertNotNull($context);
        $this->assertEquals('this-is-a-string-not-an-object', $context->get('site'));

        // This covers the final `return $value` by providing an object for a property
        // that is not a known ObjectInterface class in the schema.
        $source = $request->getSource();
        $this->assertNotNull($source);
        $this->assertEquals(['key' => 'value'], $source->get('some_unhandled_object'));
    }

    public function testHydrateWithInvalidSchemaClass(): void
    {
        // Create a temporary request class with an invalid schema definition
        $requestWithInvalidSchema = new class () extends Request {
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

    public function testGetItemWithArrayValue(): void
    {
        $request = new Request();
        $item = new \OpenRTB\v3\Impression\Item();
        $item->setId('item-1');

        // Set item as array directly (simulates parsed data)
        $request->set('item', [$item]);

        $result = $request->getItem();
        $this->assertNotNull($result);
        $this->assertCount(1, $result);
        $resultItem = $result[0];
        $this->assertNotNull($resultItem);
        $this->assertEquals('item-1', $resultItem->getId());
    }

    /**
     * @param array<mixed> $parameters
     */
    private function invokeMethod(object $object, string $methodName, array $parameters = []): mixed
    {
        $reflection = new \ReflectionClass(get_class($object));

        return $reflection->getMethod($methodName)->invokeArgs($object, $parameters);
    }
}

// A dummy class that does NOT implement ObjectInterface, used to test the parser's edge case.
class InvalidSourceClassForTesting
{
}
