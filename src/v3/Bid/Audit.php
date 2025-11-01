<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Bid\AuditStatus;

class Audit implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'status' => AuditStatus::class,
        'feedback' => 'array',
        'init' => 'int',
        'lastmod' => 'int',
        'corr' => 'array',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setStatus(AuditStatus $status): self
    {
        return $this->set('status', $status);
    }

    public function getStatus(): ?AuditStatus
    {
        return $this->get('status');
    }

    /** @param list<string> $feedback */
    public function setFeedback(array $feedback): self
    {
        return $this->set('feedback', $feedback);
    }

    /** @return list<string>|null */
    public function getFeedback(): ?array
    {
        return $this->get('feedback');
    }

    public function setInit(int $init): self
    {
        return $this->set('init', $init);
    }

    public function getInit(): ?int
    {
        return $this->get('init');
    }

    public function setLastmod(int $lastmod): self
    {
        return $this->set('lastmod', $lastmod);
    }

    public function getLastmod(): ?int
    {
        return $this->get('lastmod');
    }

    /** @param array<string, string> $corr */
    public function setCorr(array $corr): self
    {
        return $this->set('corr', $corr);
    }

    /** @return array<string, string>|null */
    public function getCorr(): ?array
    {
        return $this->get('corr');
    }
}
