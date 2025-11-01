<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Link;

/**
 * @covers \OpenRTB\v3\Bid\Link
 */
final class LinkTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Link::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('url', $schema);
        $this->assertEquals('string', $schema['url']);
        $this->assertArrayHasKey('trkr', $schema);
        $this->assertEquals('array', $schema['trkr']);
        $this->assertArrayHasKey('fallback', $schema);
        $this->assertEquals('string', $schema['fallback']);
    }

    public function testSetUrl(): void
    {
        $link = new Link();
        $url = 'http://example.com';
        $link->setUrl($url);
        $this->assertEquals($url, $link->getUrl());
    }

    public function testGetUrl(): void
    {
        $link = new Link();
        $link->setUrl('http://test.com');
        $this->assertEquals('http://test.com', $link->getUrl());
    }

    public function testSetTrkr(): void
    {
        $link = new Link();
        $trkr = ['tracker1', 'tracker2'];
        $link->setTrkr($trkr);
        $this->assertEquals($trkr, $link->getTrkr());
    }

    public function testGetTrkr(): void
    {
        $link = new Link();
        $link->setTrkr(['tracker3']);
        $this->assertEquals(['tracker3'], $link->getTrkr());
    }

    public function testSetFallback(): void
    {
        $link = new Link();
        $fallback = 'http://fallback.com';
        $link->setFallback($fallback);
        $this->assertEquals($fallback, $link->getFallback());
    }

    public function testGetFallback(): void
    {
        $link = new Link();
        $link->setFallback('http://another-fallback.com');
        $this->assertEquals('http://another-fallback.com', $link->getFallback());
    }
}
