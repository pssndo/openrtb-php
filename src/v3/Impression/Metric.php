<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\Common\Resources\Metric as CommonMetric;
use OpenRTB\v3\Enums\Impression\MetricType;

class Metric extends CommonMetric
{
    /**
     * @return array<string, class-string|string|float>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'type' => MetricType::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonMetric::getBaseSchema(), static::getBaseSchema());
    }

    public function setType(MetricType $type): static
    {
        return $this->set('type', $type->value);
    }

    public function getType(): ?MetricType
    {
        $type = $this->get('type');
        if ($type instanceof MetricType) {
            return $type;
        }

        return MetricType::tryFrom($type);
    }
}
