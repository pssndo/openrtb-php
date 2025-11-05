<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v26\Context;

use OpenRTB\v26\Context\Source;
use PHPUnit\Framework\TestCase;

final class SourceTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Source::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        self::assertIsArray($schema);
        self::assertArrayHasKey('fd', $schema);
        self::assertArrayHasKey('tid', $schema);
        self::assertArrayHasKey('pchain', $schema);
        self::assertArrayHasKey('ext', $schema);
    }
}
