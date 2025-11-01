<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Regs implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setCoppa(int $coppa): static
    {
        return $this->set('coppa', $coppa);
    }

    public function getCoppa(): ?int
    {
        return $this->get('coppa');
    }

    public function setGdpr(int $gdpr): static
    {
        return $this->set('gdpr', $gdpr);
    }

    public function getGdpr(): ?int
    {
        return $this->get('gdpr');
    }

    public function setGpp(string $gpp): static
    {
        return $this->set('gpp', $gpp);
    }

    public function getGpp(): ?string
    {
        return $this->get('gpp');
    }

    /** @param list<int> $gppSid */
    public function setGppSid(array $gppSid): static
    {
        return $this->set('gpp_sid', $gppSid);
    }

    /** @return list<int>|null */
    public function getGppSid(): ?array
    {
        return $this->get('gpp_sid');
    }
}
