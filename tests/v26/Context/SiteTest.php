<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use OpenRTB\Common\Resources\Content as CommonContent;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Publisher as CommonPublisher;
use OpenRTB\v26\Context\Content as V26Content;
use OpenRTB\v26\Context\Site;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Context\Site
 */
final class SiteTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Site::getSchema();

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
        $this->assertEquals(CommonPublisher::class, $schema['publisher']);
        $this->assertArrayHasKey('content', $schema);
        $this->assertEquals(CommonContent::class, $schema['content']);
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
        $publisher = new CommonPublisher();
        $site->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testGetPublisher(): void
    {
        $site = new Site();
        $publisher = new CommonPublisher();
        $site->setPublisher($publisher);
        $this->assertSame($publisher, $site->getPublisher());
    }

    public function testSetContent(): void
    {
        $site = new Site();
        $content = new V26Content();
        $site->setContent($content);
        $this->assertSame($content, $site->getContent());
    }

    public function testGetContent(): void
    {
        $site = new Site();
        $content = new V26Content();
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

    public function testSetSectioncat(): void
    {
        $site = new Site();
        $sectioncat = ['IAB1', 'IAB12'];
        $site->setSectioncat($sectioncat);
        $this->assertEquals($sectioncat, $site->getSectioncat());
    }

    public function testGetSectioncat(): void
    {
        $site = new Site();
        $this->assertNull($site->getSectioncat());
        $site->setSectioncat(['IAB1']);
        $this->assertEquals(['IAB1'], $site->getSectioncat());
    }

    public function testSetPagecat(): void
    {
        $site = new Site();
        $pagecat = ['IAB1-1', 'IAB12-2'];
        $site->setPagecat($pagecat);
        $this->assertEquals($pagecat, $site->getPagecat());
    }

    public function testGetPagecat(): void
    {
        $site = new Site();
        $this->assertNull($site->getPagecat());
        $site->setPagecat(['IAB1-1']);
        $this->assertEquals(['IAB1-1'], $site->getPagecat());
    }

    public function testSetPrivacypolicy(): void
    {
        $site = new Site();
        $site->setPrivacypolicy(1);
        $this->assertEquals(1, $site->getPrivacypolicy());
    }

    public function testGetPrivacypolicy(): void
    {
        $site = new Site();
        $this->assertNull($site->getPrivacypolicy());
        $site->setPrivacypolicy(0);
        $this->assertEquals(0, $site->getPrivacypolicy());
    }

    public function testSetKeywords(): void
    {
        $site = new Site();
        $keywords = 'news, politics, technology';
        $site->setKeywords($keywords);
        $this->assertEquals($keywords, $site->getKeywords());
    }

    public function testGetKeywords(): void
    {
        $site = new Site();
        $this->assertNull($site->getKeywords());
        $site->setKeywords('test keywords');
        $this->assertEquals('test keywords', $site->getKeywords());
    }

    public function testSetSearch(): void
    {
        $site = new Site();
        $search = 'election 2024';
        $site->setSearch($search);
        $this->assertEquals($search, $site->getSearch());
    }

    public function testGetSearch(): void
    {
        $site = new Site();
        $this->assertNull($site->getSearch());
        $site->setSearch('test search');
        $this->assertEquals('test search', $site->getSearch());
    }

    public function testSetMobile(): void
    {
        $site = new Site();
        $site->setMobile(1);
        $this->assertEquals(1, $site->getMobile());
    }

    public function testGetMobile(): void
    {
        $site = new Site();
        $this->assertNull($site->getMobile());
        $site->setMobile(0);
        $this->assertEquals(0, $site->getMobile());
    }
}
