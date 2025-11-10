<?php

declare(strict_types=1);

namespace OpenRTB\v25\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Regs as CommonRegs;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=41
 */
class Regs extends CommonRegs
{
    /**
     * @return array<string, class-string|string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'us_privacy' => 'string',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonRegs::getBaseSchema(), static::getBaseSchema());
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
