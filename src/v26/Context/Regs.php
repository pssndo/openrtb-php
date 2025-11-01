<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=41
 */
class Regs implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'ext' => Ext::class,
    ];

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

    public function setUsPrivacy(string $usPrivacy): static
    {
        return $this->set('us_privacy', $usPrivacy);
    }

    public function getUsPrivacy(): ?string
    {
        return $this->get('us_privacy');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
