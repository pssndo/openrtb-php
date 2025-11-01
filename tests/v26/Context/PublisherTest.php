<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use PHPUnit\Framework\TestCase;
use OpenRTB\v26\Context\Publisher;
use OpenRTB\v26\Ext;

/**
 * @covers \OpenRTB\v26\Context\Publisher
 */
final class PublisherTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Publisher::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array', $schema['cat']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $publisher = new Publisher();
        $id = 'pub123';
        $publisher->setId($id);
        $this->assertEquals($id, $publisher->getId());
    }

    public function testGetId(): void
    {
        $publisher = new Publisher();
        $publisher->setId('test_id');
        $this->assertEquals('test_id', $publisher->getId());
    }

    public function testSetName(): void
    {
        $publisher = new Publisher();
        $name = 'Test Publisher';
        $publisher->setName($name);
        $this->assertEquals($name, $publisher->getName());
    }

    public function testGetName(): void
    {
        $publisher = new Publisher();
        $publisher->setName('Another Publisher');
        $this->assertEquals('Another Publisher', $publisher->getName());
    }

    public function testSetCat(): void
    {
        $publisher = new Publisher();
        $cat = ['IAB1', 'IAB2'];
        $publisher->setCat($cat);
        $this->assertEquals($cat, $publisher->getCat());
    }

    public function testGetCat(): void
    {
        $publisher = new Publisher();
        $publisher->setCat(['IAB3']);
        $this->assertEquals(['IAB3'], $publisher->getCat());
    }

    public function testSetDomain(): void
    {
        $publisher = new Publisher();
        $domain = 'example.com';
        $publisher->setDomain($domain);
        $this->assertEquals($domain, $publisher->getDomain());
    }

    public function testGetDomain(): void
    {
        $publisher = new Publisher();
        $publisher->setDomain('test.com');
        $this->assertEquals('test.com', $publisher->getDomain());
    }

    public function testSetExt(): void
    {
        $publisher = new Publisher();
        $ext = new Ext();
        $publisher->setExt($ext);
        $this->assertSame($ext, $publisher->getExt());
    }

    public function testGetExt(): void
    {
        $publisher = new Publisher();
        $ext = new Ext();
        $publisher->setExt($ext);
        $this->assertSame($ext, $publisher->getExt());
    }
}
