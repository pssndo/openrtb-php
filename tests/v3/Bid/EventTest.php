<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Event;
use OpenRTB\v3\Enums\EventType;

/**
 * @covers \OpenRTB\v3\Bid\Event
 */
final class EventTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Event::getSchema();

        $this->assertArrayHasKey('type', $schema);
        $this->assertEquals(EventType::class, $schema['type']);
        $this->assertArrayHasKey('method', $schema);
        $this->assertEquals('int', $schema['method']);
        $this->assertArrayHasKey('url', $schema);
        $this->assertEquals('string', $schema['url']);
    }

    public function testSetType(): void
    {
        $event = new Event();
        $type = EventType::IMPRESSION;
        $event->setType($type);
        $this->assertEquals($type, $event->get('type'));
    }

    public function testSetMethod(): void
    {
        $event = new Event();
        $method = 1;
        $event->setMethod($method);
        $this->assertEquals($method, $event->get('method'));
    }

    public function testSetUrl(): void
    {
        $event = new Event();
        $url = 'https://example.com';
        $event->setUrl($url);
        $this->assertEquals($url, $event->get('url'));
    }
}
