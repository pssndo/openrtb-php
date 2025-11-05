<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Publisher;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\EntityBase
 */
class EntityBaseTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Publisher::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array', $schema['cat']);
    }

    public function testSetAndGetId(): void
    {
        $entity = new Publisher();
        $entity->setId('pub-123');
        $this->assertEquals('pub-123', $entity->getId());
    }

    public function testSetAndGetName(): void
    {
        $entity = new Publisher();
        $entity->setName('Publisher Name');
        $this->assertEquals('Publisher Name', $entity->getName());
    }

    public function testSetAndGetDomain(): void
    {
        $entity = new Publisher();
        $entity->setDomain('example.com');
        $this->assertEquals('example.com', $entity->getDomain());
    }

    public function testSetAndGetCat(): void
    {
        $entity = new Publisher();
        $entity->setCat(['IAB1', 'IAB2']);
        $this->assertEquals(['IAB1', 'IAB2'], $entity->getCat());
    }

    public function testGetIdReturnsNullByDefault(): void
    {
        $entity = new Publisher();
        $this->assertNull($entity->getId());
    }

    public function testGetCatReturnsNullByDefault(): void
    {
        $entity = new Publisher();
        $this->assertNull($entity->getCat());
    }
}
