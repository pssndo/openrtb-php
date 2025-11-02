<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Geo as CommonGeo;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=38
 */
class Geo extends CommonGeo
{
    /**
     * @return array<string, string|class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'type' => 'int',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonGeo::getBaseSchema(), static::getBaseSchema());
    }

    public function setType(int $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
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
