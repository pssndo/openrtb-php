<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\Regs as CommonRegs;
use OpenRTB\Common\Collection;

class Regs extends CommonRegs
{
    /**
     * @return array<string, string|array<string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'gpp' => 'string',
            'gpp_sid' => ['int'],
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setGpp(string $gpp): static
    {
        return $this->set('gpp', $gpp);
    }

    public function getGpp(): ?string
    {
        return $this->get('gpp');
    }

    /** @param Collection<int>|array<int> $gppSid */
    public function setGppSid(Collection|array $gppSid): static
    {
        return $this->set('gpp_sid', $gppSid);
    }

    /** @return list<int>|null */
    public function getGppSid(): ?array
    {
        return $this->get('gpp_sid');
    }
}
