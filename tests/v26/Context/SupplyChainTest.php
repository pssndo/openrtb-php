<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use PHPUnit\Framework\TestCase;
use OpenRTB\v26\Context\SupplyChain;
use OpenRTB\v26\Context\SupplyChain\Node as SupplyChainNode;
use OpenRTB\v26\Ext;

/**
 * @covers \OpenRTB\v26\Context\SupplyChain
 */
final class SupplyChainTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = SupplyChain::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('complete', $schema);
        $this->assertEquals('int', $schema['complete']);
        $this->assertArrayHasKey('ver', $schema);
        $this->assertEquals('string', $schema['ver']);
        $this->assertArrayHasKey('nodes', $schema);
        $this->assertEquals([SupplyChainNode::class], $schema['nodes']);
        $this->assertArrayHasKey('ext', $schema);
        $this->assertEquals(Ext::class, $schema['ext']);
    }

    public function testSetComplete(): void
    {
        $supplyChain = new SupplyChain();
        $complete = 1;
        $supplyChain->setComplete($complete);
        $this->assertEquals($complete, $supplyChain->getComplete());
    }

    public function testGetComplete(): void
    {
        $supplyChain = new SupplyChain();
        $supplyChain->setComplete(0);
        $this->assertEquals(0, $supplyChain->getComplete());
    }

    public function testSetVer(): void
    {
        $supplyChain = new SupplyChain();
        $ver = '1.0';
        $supplyChain->setVer($ver);
        $this->assertEquals($ver, $supplyChain->getVer());
    }

    public function testGetVer(): void
    {
        $supplyChain = new SupplyChain();
        $supplyChain->setVer('1.1');
        $this->assertEquals('1.1', $supplyChain->getVer());
    }

    public function testSetNodes(): void
    {
        $supplyChain = new SupplyChain();
        $node = new SupplyChainNode();
        $nodes = [$node];
        $supplyChain->setNodes($nodes);
        $this->assertEquals($nodes, $supplyChain->getNodes());
    }

    public function testGetNodes(): void
    {
        $supplyChain = new SupplyChain();
        $node = new SupplyChainNode();
        $supplyChain->setNodes([$node]);
        $this->assertEquals([$node], $supplyChain->getNodes());
    }

    public function testSetExt(): void
    {
        $supplyChain = new SupplyChain();
        $ext = new Ext();
        $supplyChain->setExt($ext);
        $this->assertSame($ext, $supplyChain->getExt());
    }

    public function testGetExt(): void
    {
        $supplyChain = new SupplyChain();
        $ext = new Ext();
        $supplyChain->setExt($ext);
        $this->assertSame($ext, $supplyChain->getExt());
    }
}
