<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Source;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Source
 */
class SourceTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Source::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('tid', $schema);
        $this->assertEquals('string', $schema['tid']);
    }

    public function testSetAndGetTid(): void
    {
        $source = new Source();
        $source->setTid('transaction-123');
        $this->assertEquals('transaction-123', $source->getTid());
    }

    public function testGetTidReturnsNullByDefault(): void
    {
        $source = new Source();
        $this->assertNull($source->getTid());
    }
}
