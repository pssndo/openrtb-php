<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Producer as CommonProducer;
use OpenRTB\v26\Context\Producer;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Context\Producer
 */
final class ProducerTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Producer::getSchema();

        // Assertions for properties from CommonProducer
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array', $schema['cat']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);

        // Assertions for properties unique to v26 Producer
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetId(): void
    {
        $producer = new Producer();
        $id = 'prod123';
        $producer->setId($id);
        $this->assertEquals($id, $producer->getId());
    }

    public function testGetId(): void
    {
        $producer = new Producer();
        $producer->setId('test_id');
        $this->assertEquals('test_id', $producer->getId());
    }

    public function testSetName(): void
    {
        $producer = new Producer();
        $name = 'Test Producer';
        $producer->setName($name);
        $this->assertEquals($name, $producer->getName());
    }

    public function testGetName(): void
    {
        $producer = new Producer();
        $producer->setName('Another Producer');
        $this->assertEquals('Another Producer', $producer->getName());
    }

    public function testSetCat(): void
    {
        $producer = new Producer();
        $cat = ['IAB1', 'IAB2'];
        $producer->setCat($cat);
        $this->assertEquals($cat, $producer->getCat());
    }

    public function testGetCat(): void
    {
        $producer = new Producer();
        $producer->setCat(['IAB3']);
        $this->assertEquals(['IAB3'], $producer->getCat());
    }

    public function testSetDomain(): void
    {
        $producer = new Producer();
        $domain = 'example.com';
        $producer->setDomain($domain);
        $this->assertEquals($domain, $producer->getDomain());
    }

    public function testGetDomain(): void
    {
        $producer = new Producer();
        $producer->setDomain('test.com');
        $this->assertEquals('test.com', $producer->getDomain());
    }

    public function testSetExt(): void
    {
        $producer = new Producer();
        $ext = new Ext();
        $producer->setExt($ext);
        $this->assertSame($ext, $producer->getExt());
    }

    public function testGetExt(): void
    {
        $producer = new Producer();
        $ext = new Ext();
        $producer->setExt($ext);
        $this->assertSame($ext, $producer->getExt());
    }
}
