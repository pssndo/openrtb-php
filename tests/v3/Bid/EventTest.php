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

    public function testGetType(): void
    {
        $event = new Event();
        $type = EventType::IMPRESSION;
        $event->setType($type);
        $this->assertEquals($type, $event->getType());
    }

    public function testGetMethod(): void
    {
        $event = new Event();
        $method = 1;
        $event->setMethod($method);
        $this->assertEquals($method, $event->getMethod());
    }

    public function testGetUrl(): void
    {
        $event = new Event();
        $url = 'https://example.com/track';
        $event->setUrl($url);
        $this->assertEquals($url, $event->getUrl());
    }

    public function testGetApi(): void
    {
        $event = new Event();
        $this->assertNull($event->getApi());
    }

    public function testSetApi(): void
    {
        $event = new Event();
        $api = [1, 2, 3];
        $event->setApi($api);
        $this->assertEquals($api, $event->getApi());
    }

    public function testGetWin(): void
    {
        $event = new Event();
        $this->assertNull($event->getWin());
    }

    public function testSetWin(): void
    {
        $event = new Event();
        $win = ['https://example.com/win1', 'https://example.com/win2'];
        $event->setWin($win);
        $this->assertEquals($win, $event->getWin());
    }

    public function testGetFurl(): void
    {
        $event = new Event();
        $this->assertNull($event->getFurl());
    }

    public function testSetFurl(): void
    {
        $event = new Event();
        $furl = ['https://example.com/fail1', 'https://example.com/fail2'];
        $event->setFurl($furl);
        $this->assertEquals($furl, $event->getFurl());
    }

    public function testSchemaIncludesNewFields(): void
    {
        $schema = Event::getSchema();

        // Test new fields are in schema
        $this->assertArrayHasKey('api', $schema);
        $this->assertEquals(['int'], $schema['api']);
        $this->assertArrayHasKey('win', $schema);
        $this->assertEquals(['string'], $schema['win']);
        $this->assertArrayHasKey('furl', $schema);
        $this->assertEquals(['string'], $schema['furl']);
    }
}
