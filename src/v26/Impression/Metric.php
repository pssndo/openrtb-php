<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Metric as CommonMetric;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=30
 */
class Metric extends CommonMetric
{
    /**
     * @return array<string, mixed>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'type' => 'string',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonMetric::getBaseSchema(), static::getBaseSchema());
    }

    public function setType(string $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?string
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
