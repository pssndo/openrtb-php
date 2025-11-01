<?php

declare(strict_types=1);

namespace OpenRTB\Tests\v3\Bid;

use PHPUnit\Framework\TestCase;
use OpenRTB\v3\Bid\Audit;
use OpenRTB\v3\Enums\Bid\AuditStatus;

/**
 * @covers \OpenRTB\v3\Bid\Audit
 */
final class AuditTest extends TestCase
{
    public function testGetSchema(): void
    {
        $schema = Audit::getSchema();

        $this->assertIsArray($schema);
        $this->assertArrayHasKey('status', $schema);
        $this->assertEquals(AuditStatus::class, $schema['status']);
        $this->assertArrayHasKey('feedback', $schema);
        $this->assertEquals('array', $schema['feedback']);
        $this->assertArrayHasKey('init', $schema);
        $this->assertEquals('int', $schema['init']);
        $this->assertArrayHasKey('lastmod', $schema);
        $this->assertEquals('int', $schema['lastmod']);
        $this->assertArrayHasKey('corr', $schema);
        $this->assertEquals('array', $schema['corr']);
    }

    public function testSetStatus(): void
    {
        $audit = new Audit();
        $status = AuditStatus::PENDING;
        $audit->setStatus($status);
        $this->assertEquals($status, $audit->getStatus());
    }

    public function testGetStatus(): void
    {
        $audit = new Audit();
        $audit->setStatus(AuditStatus::PRE_APPROVED);
        $this->assertEquals(AuditStatus::PRE_APPROVED, $audit->getStatus());
    }

    public function testSetFeedback(): void
    {
        $audit = new Audit();
        $feedback = ['reason1', 'reason2'];
        $audit->setFeedback($feedback);
        $this->assertEquals($feedback, $audit->getFeedback());
    }

    public function testGetFeedback(): void
    {
        $audit = new Audit();
        $audit->setFeedback(['reason3']);
        $this->assertEquals(['reason3'], $audit->getFeedback());
    }

    public function testSetInit(): void
    {
        $audit = new Audit();
        $init = 1;
        $audit->setInit($init);
        $this->assertEquals($init, $audit->getInit());
    }

    public function testGetInit(): void
    {
        $audit = new Audit();
        $audit->setInit(0);
        $this->assertEquals(0, $audit->getInit());
    }

    public function testSetLastmod(): void
    {
        $audit = new Audit();
        $lastmod = 123456789;
        $audit->setLastmod($lastmod);
        $this->assertEquals($lastmod, $audit->getLastmod());
    }

    public function testGetLastmod(): void
    {
        $audit = new Audit();
        $audit->setLastmod(987654321);
        $this->assertEquals(987654321, $audit->getLastmod());
    }

    public function testSetCorr(): void
    {
        $audit = new Audit();
        $corr = ['key' => 'value'];
        $audit->setCorr($corr);
        $this->assertEquals($corr, $audit->getCorr());
    }

    public function testGetCorr(): void
    {
        $audit = new Audit();
        $audit->setCorr(['key2' => 'value2']);
        $this->assertEquals(['key2' => 'value2'], $audit->getCorr());
    }
}
