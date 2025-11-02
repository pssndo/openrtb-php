<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3;

use OpenRTB\Common\Resources\Ext;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Ext
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
        $this->assertEmpty($schema);
    }
}
