<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Impression\MetricType;

class Metric extends BaseObject
{
    protected static array $schema = [
        'type' => MetricType::class,
    ];

    public function setType(MetricType $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?MetricType
    {
        return $this->get('type');
    }

    public function setValue(float $value): self
    {
        return $this->set('value', $value);
    }

    public function getValue(): ?float
    {
        return $this->get('value');
    }

    public function setVendor(string $vendor): self
    {
        return $this->set('vendor', $vendor);
    }

    public function getVendor(): ?string
    {
        return $this->get('vendor');
    }
}
