<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Metric implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|float>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'value' => 'float',
            'vendor' => 'string',
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
    }

    public function setValue(float $value): static
    {
        return $this->set('value', $value);
    }

    public function getValue(): ?float
    {
        return $this->get('value');
    }

    public function setVendor(string $vendor): static
    {
        return $this->set('vendor', $vendor);
    }

    public function getVendor(): ?string
    {
        return $this->get('vendor');
    }
}
