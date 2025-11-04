<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Content;
use OpenRTB\Common\Resources\Publisher;
use OpenRTB\Common\Resources\Site;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Site
 */
class SiteTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Site::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);
        $this->assertArrayHasKey('page', $schema);
        $this->assertEquals('string', $schema['page']);
        $this->assertArrayHasKey('ref', $schema);
        $this->assertEquals('string', $schema['ref']);
        $this->assertArrayHasKey('publisher', $schema);
        $this->assertEquals(Publisher::class, $schema['publisher']);
        $this->assertArrayHasKey('content', $schema);
        $this->assertEquals(Content::class, $schema['content']);
    }

    public function testSetAndGetId(): void
    {
        $site = new Site();
        $site->setId('site-123');
        $this->assertEquals('site-123', $site->getId());
    }

    public function testSetAndGetName(): void
    {
        $site = new Site();
        $site->setName('Test Site');
        $this->assertEquals('Test Site', $site->getName());
    }

    public function testSetAndGetDomain(): void
    {
        $site = new Site();
        $site->setDomain('example.com');
        $this->assertEquals('example.com', $site->getDomain());
    }

    public function testSetAndGetPage(): void
    {
        $site = new Site();
        $site->setPage('https://example.com/page');
        $this->assertEquals('https://example.com/page', $site->getPage());
    }

    public function testSetAndGetRef(): void
    {
        $site = new Site();
        $site->setRef('https://referrer.com');
        $this->assertEquals('https://referrer.com', $site->getRef());
    }

    public function testSetAndGetPublisher(): void
    {
        $site = new Site();
        $publisher = new Publisher();
        $site->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testSetAndGetContent(): void
    {
        $site = new Site();
        $content = new Content();
        $site->setContent($content);
        $this->assertSame($content, $site->getContent());
    }

    public function testGetPublisherReturnsNullByDefault(): void
    {
        $site = new Site();
        $this->assertNull($site->getPublisher());
    }

    public function testGetContentReturnsNullByDefault(): void
    {
        $site = new Site();
        $this->assertNull($site->getContent());
    }
}
