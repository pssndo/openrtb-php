<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Content;
use OpenRTB\Common\Resources\Producer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Content
 */
class ContentTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Content::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('episode', $schema);
        $this->assertEquals('int', $schema['episode']);
        $this->assertArrayHasKey('title', $schema);
        $this->assertEquals('string', $schema['title']);
        $this->assertArrayHasKey('series', $schema);
        $this->assertEquals('string', $schema['series']);
        $this->assertArrayHasKey('season', $schema);
        $this->assertEquals('string', $schema['season']);
        $this->assertArrayHasKey('producer', $schema);
        $this->assertEquals(Producer::class, $schema['producer']);
        $this->assertArrayHasKey('url', $schema);
        $this->assertEquals('string', $schema['url']);
        $this->assertArrayHasKey('contentrating', $schema);
        $this->assertEquals('string', $schema['contentrating']);
        $this->assertArrayHasKey('keywords', $schema);
        $this->assertEquals('string', $schema['keywords']);
    }

    public function testSetAndGetId(): void
    {
        $content = new Content();
        $content->setId('content-123');
        $this->assertEquals('content-123', $content->getId());
    }

    public function testSetAndGetEpisode(): void
    {
        $content = new Content();
        $content->setEpisode(5);
        $this->assertEquals(5, $content->getEpisode());
    }

    public function testSetAndGetTitle(): void
    {
        $content = new Content();
        $content->setTitle('Test Title');
        $this->assertEquals('Test Title', $content->getTitle());
    }

    public function testSetAndGetSeries(): void
    {
        $content = new Content();
        $content->setSeries('Test Series');
        $this->assertEquals('Test Series', $content->getSeries());
    }

    public function testSetAndGetSeason(): void
    {
        $content = new Content();
        $content->setSeason('Season 1');
        $this->assertEquals('Season 1', $content->getSeason());
    }

    public function testSetAndGetProducer(): void
    {
        $content = new Content();
        $producer = new Producer();
        $content->setProducer($producer);
        $this->assertSame($producer, $content->getProducer());
    }

    public function testSetAndGetUrl(): void
    {
        $content = new Content();
        $content->setUrl('https://example.com/video');
        $this->assertEquals('https://example.com/video', $content->getUrl());
    }

    public function testSetAndGetContentrating(): void
    {
        $content = new Content();
        $content->setContentrating('PG-13');
        $this->assertEquals('PG-13', $content->getContentrating());
    }

    public function testSetAndGetKeywords(): void
    {
        $content = new Content();
        $content->setKeywords('test,keywords,example');
        $this->assertEquals('test,keywords,example', $content->getKeywords());
    }

    public function testGetProducerReturnsNullByDefault(): void
    {
        $content = new Content();
        $this->assertNull($content->getProducer());
    }
}
