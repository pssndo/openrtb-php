<?php

declare(strict_types=1);

namespace OpenRTB\v25\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Producer as CommonProducer;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=35
 */
class Producer extends CommonProducer
{
    /**
     * @return array<string, class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonProducer::getBaseSchema(), static::getBaseSchema());
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
