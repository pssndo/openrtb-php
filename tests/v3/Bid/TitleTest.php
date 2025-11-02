<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Title;

/**
 * @covers \OpenRTB\v3\Bid\Title
 */
final class TitleTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Title::getSchema();

        $this->assertArrayHasKey('text', $schema);
        $this->assertEquals('string', $schema['text']);
    }

    public function testSetText(): void
    {
        $title = new Title();
        $text = 'Test Title';
        $title->setText($text);
        $this->assertEquals($text, $title->getText());
    }

    public function testGetText(): void
    {
        $title = new Title();
        $title->setText('Another Title');
        $this->assertEquals('Another Title', $title->getText());
    }
}
