<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Bid\AuditStatus;

class Audit extends BaseObject
{
    /** @var array<string, class-string> */
    protected static array $schema = [
        'status' => AuditStatus::class,
    ];

    public function setStatus(AuditStatus $status): static
    {
        return $this->set('status', $status);
    }

    public function getStatus(): ?AuditStatus
    {
        return $this->get('status');
    }

    /** @param list<string> $feedback */
    public function setFeedback(array $feedback): static
    {
        return $this->set('feedback', $feedback);
    }

    /** @return list<string>|null */
    public function getFeedback(): ?array
    {
        return $this->get('feedback');
    }

    public function setInit(int $init): static
    {
        return $this->set('init', $init);
    }

    public function getInit(): ?int
    {
        return $this->get('init');
    }

    public function setLastmod(int $lastmod): static
    {
        return $this->set('lastmod', $lastmod);
    }

    public function getLastmod(): ?int
    {
        return $this->get('lastmod');
    }

    /** @param array<string, string> $corr */
    public function setCorr(array $corr): static
    {
        return $this->set('corr', $corr);
    }

    /** @return array<string, string>|null */
    public function getCorr(): ?array
    {
        return $this->get('corr');
    }
}
