<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use PHPUnit\Framework\TestCase;
use OpenRTB\v26\Context\Site;
use OpenRTB\v26\Context\Publisher;
use OpenRTB\v26\Context\Content;
use OpenRTB\v26\Ext;

/**
 * @covers \OpenRTB\v26\Context\Site
 */
final class SiteTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Site::getSchema();

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
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $site = new Site();
        $id = 'site123';
        $site->setId($id);
        $this->assertEquals($id, $site->getId());
    }

    public function testGetId(): void
    {
        $site = new Site();
        $site->setId('test_id');
        $this->assertEquals('test_id', $site->getId());
    }

    public function testSetName(): void
    {
        $site = new Site();
        $name = 'Test Site';
        $site->setName($name);
        $this->assertEquals($name, $site->getName());
    }

    public function testGetName(): void
    {
        $site = new Site();
        $site->setName('Another Site');
        $this->assertEquals('Another Site', $site->getName());
    }

    public function testSetDomain(): void
    {
        $site = new Site();
        $domain = 'example.com';
        $site->setDomain($domain);
        $this->assertEquals($domain, $site->getDomain());
    }

    public function testGetDomain(): void
    {
        $site = new Site();
        $site->setDomain('test.com');
        $this->assertEquals('test.com', $site->getDomain());
    }

    public function testSetPage(): void
    {
        $site = new Site();
        $page = 'https://example.com/page';
        $site->setPage($page);
        $this->assertEquals($page, $site->getPage());
    }

    public function testGetPage(): void
    {
        $site = new Site();
        $site->setPage('https://test.com/page');
        $this->assertEquals('https://test.com/page', $site->getPage());
    }

    public function testSetRef(): void
    {
        $site = new Site();
        $ref = 'https://referrer.com';
        $site->setRef($ref);
        $this->assertEquals($ref, $site->getRef());
    }

    public function testGetRef(): void
    {
        $site = new Site();
        $site->setRef('https://another-referrer.com');
        $this->assertEquals('https://another-referrer.com', $site->getRef());
    }

    public function testSetPublisher(): void
    {
        $site = new Site();
        $publisher = new Publisher();
        $site->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testGetPublisher(): void
    {
        $site = new Site();
        $publisher = new Publisher();
        $site->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testSetContent(): void
    {
        $site = new Site();
        $content = new Content();
        $site->setContent($content);
        $this->assertSame($content, $site->getContent());
    }

    public function testGetContent(): void
    {
        $site = new Site();
        $content = new Content();
        $site->setContent($content);
        $this->assertSame($content, $site->getContent());
    }

    public function testSetExt(): void
    {
        $site = new Site();
        $ext = new Ext();
        $site->setExt($ext);
        $this->assertSame($ext, $site->getExt());
    }

    public function testGetExt(): void
    {
        $site = new Site();
        $ext = new Ext();
        $site->setExt($ext);
        $this->assertSame($ext, $site->getExt());
    }
}
