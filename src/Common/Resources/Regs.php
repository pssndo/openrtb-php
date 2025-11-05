<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Regs implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|int|array<string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'coppa' => 'int',
            'gdpr' => 'int',
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
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
}
