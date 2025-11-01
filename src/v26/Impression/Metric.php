<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=30
 */
class Metric implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(string $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?string
    {
        return $this->get('type');
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

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
