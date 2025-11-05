<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common\Resources;

use OpenRTB\Common\Resources\Regs;
use PHPUnit\Framework\TestCase;

/**
 * @covers \OpenRTB\Common\Resources\Regs
 */
class RegsTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Regs::getSchema();
        // @phpstan-ignore-next-line - Testing return type
        $this->assertIsArray($schema);
        $this->assertArrayHasKey('coppa', $schema);
        $this->assertEquals('int', $schema['coppa']);
        $this->assertArrayHasKey('gdpr', $schema);
        $this->assertEquals('int', $schema['gdpr']);
    }

    public function testSetAndGetCoppa(): void
    {
        $regs = new Regs();
        $regs->setCoppa(1);
        $this->assertEquals(1, $regs->getCoppa());
    }

    public function testSetAndGetGdpr(): void
    {
        $regs = new Regs();
        $regs->setGdpr(1);
        $this->assertEquals(1, $regs->getGdpr());
    }

    public function testGetCoppaReturnsNullByDefault(): void
    {
        $regs = new Regs();
        $this->assertNull($regs->getCoppa());
    }

    public function testGetGdprReturnsNullByDefault(): void
    {
        $regs = new Regs();
        $this->assertNull($regs->getGdpr());
    }
}
