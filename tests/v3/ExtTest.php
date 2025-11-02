<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\v3\Ext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Ext
 */
class ExtTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $ext = new Ext();
        $this->assertInstanceOf(Ext::class, $ext);
    }

    public function testGetSchemaReturnsEmptyArray(): void
    {
        $schema = Ext::getSchema();
        $this->assertIsArray($schema);
        $this->assertEmpty($schema);
    }
}
