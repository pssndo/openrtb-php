<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context\SupplyChain;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\v26\Context\SupplyChain\Node;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v26\Context\SupplyChain\Node
 */
final class NodeTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Node::getSchema();

        $this->assertArrayHasKey('asi', $schema);
        $this->assertEquals('string', $schema['asi']);
        $this->assertArrayHasKey('sid', $schema);
        $this->assertEquals('string', $schema['sid']);
        $this->assertArrayHasKey('hp', $schema);
        $this->assertEquals('int', $schema['hp']);
        $this->assertArrayHasKey('rid', $schema);
        $this->assertEquals('string', $schema['rid']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetAsi(): void
    {
        $node = new Node();
        $asi = 'asi_value';
        $node->setAsi($asi);
        $this->assertEquals($asi, $node->getAsi());
    }

    public function testGetAsi(): void
    {
        $node = new Node();
        $node->setAsi('test_asi');
        $this->assertEquals('test_asi', $node->getAsi());
    }

    public function testSetSid(): void
    {
        $node = new Node();
        $sid = 'sid_value';
        $node->setSid($sid);
        $this->assertEquals($sid, $node->getSid());
    }

    public function testGetSid(): void
    {
        $node = new Node();
        $node->setSid('test_sid');
        $this->assertEquals('test_sid', $node->getSid());
    }

    public function testSetHp(): void
    {
        $node = new Node();
        $hp = 1;
        $node->setHp($hp);
        $this->assertEquals($hp, $node->getHp());
    }

    public function testGetHp(): void
    {
        $node = new Node();
        $node->setHp(0);
        $this->assertEquals(0, $node->getHp());
    }

    public function testSetRid(): void
    {
        $node = new Node();
        $rid = 'rid_value';
        $node->setRid($rid);
        $this->assertEquals($rid, $node->getRid());
    }

    public function testGetRid(): void
    {
        $node = new Node();
        $node->setRid('test_rid');
        $this->assertEquals('test_rid', $node->getRid());
    }

    public function testSetName(): void
    {
        $node = new Node();
        $name = 'name_value';
        $node->setName($name);
        $this->assertEquals($name, $node->getName());
    }

    public function testGetName(): void
    {
        $node = new Node();
        $node->setName('test_name');
        $this->assertEquals('test_name', $node->getName());
    }

    public function testSetDomain(): void
    {
        $node = new Node();
        $domain = 'example.com';
        $node->setDomain($domain);
        $this->assertEquals($domain, $node->getDomain());
    }

    public function testGetDomain(): void
    {
        $node = new Node();
        $node->setDomain('test.com');
        $this->assertEquals('test.com', $node->getDomain());
    }

    public function testSetExt(): void
    {
        $node = new Node();
        $ext = new Ext();
        $node->setExt($ext);
        $this->assertSame($ext, $node->getExt());
    }

    public function testGetExt(): void
    {
        $node = new Node();
        $ext = new Ext();
        $node->setExt($ext);
        $this->assertSame($ext, $node->getExt());
    }
}
