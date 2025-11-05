<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Context;

use OpenRTB\v3\Context\App;
use OpenRTB\v3\Enums\Context\ContentTaxonomy;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\v3\Context\App
 */
final class AppTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = App::getSchema();

        // Assertions for parent schema properties
        $this->assertArrayHasKey('id', $schema);
        $this->assertEquals('string', $schema['id']);
        $this->assertArrayHasKey('name', $schema);
        $this->assertEquals('string', $schema['name']);
        $this->assertArrayHasKey('domain', $schema);
        $this->assertEquals('string', $schema['domain']);

        // Assertions for App specific schema properties
        $this->assertArrayHasKey('storeid', $schema);
        $this->assertEquals('string', $schema['storeid']);
        $this->assertArrayHasKey('cat', $schema);
        $this->assertEquals('array<string>', $schema['cat']);
        $this->assertArrayHasKey('sectioncat', $schema);
        $this->assertEquals('array<string>', $schema['sectioncat']);
        $this->assertArrayHasKey('pagecat', $schema);
        $this->assertEquals('array<string>', $schema['pagecat']);
        $this->assertArrayHasKey('cattax', $schema);
        $this->assertEquals(ContentTaxonomy::class, $schema['cattax']);
        $this->assertArrayHasKey('ver', $schema);
        $this->assertEquals('string', $schema['ver']);
        $this->assertArrayHasKey('privacypolicy', $schema);
        $this->assertEquals('int', $schema['privacypolicy']);
        $this->assertArrayHasKey('paid', $schema);
        $this->assertEquals('int', $schema['paid']);
        $this->assertArrayHasKey('keywords', $schema);
        $this->assertEquals('string', $schema['keywords']);
        $this->assertArrayHasKey('kwarray', $schema);
        $this->assertEquals('array<string>', $schema['kwarray']);
    }
}
