<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\App;
use OpenRTB\Common\Resources\Content;
use OpenRTB\Common\Resources\Publisher;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\App
 */
class AppTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = App::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);
        $this->assertArrayHasKey('storeurl', $schema);
        $this->assertEquals('string', $schema['storeurl']);
        $this->assertArrayHasKey('publisher', $schema);
        $this->assertEquals(Publisher::class, $schema['publisher']);
        $this->assertArrayHasKey('content', $schema);
        $this->assertEquals(Content::class, $schema['content']);
    }

    public function testSetAndGetId(): void
    {
        $app = new App();
        $app->setId('app-123');
        $this->assertEquals('app-123', $app->getId());
    }

    public function testSetAndGetName(): void
    {
        $app = new App();
        $app->setName('Test App');
        $this->assertEquals('Test App', $app->getName());
    }

    public function testSetAndGetBundle(): void
    {
        $app = new App();
        $app->setBundle('com.example.app');
        $this->assertEquals('com.example.app', $app->getBundle());
    }

    public function testSetAndGetDomain(): void
    {
        $app = new App();
        $app->setDomain('example.com');
        $this->assertEquals('example.com', $app->getDomain());
    }

    public function testSetAndGetStoreurl(): void
    {
        $app = new App();
        $app->setStoreurl('https://play.google.com/store/apps/details?id=com.example.app');
        $this->assertEquals('https://play.google.com/store/apps/details?id=com.example.app', $app->getStoreurl());
    }

    public function testSetAndGetPublisher(): void
    {
        $app = new App();
        $publisher = new Publisher();
        $app->setPublisher($publisher);
        $this->assertSame($publisher, $app->getPublisher());
    }

    public function testSetAndGetContent(): void
    {
        $app = new App();
        $content = new Content();
        $app->setContent($content);
        $this->assertSame($content, $app->getContent());
    }
}
