<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\Device as CommonDevice;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=36
 */
class Device extends CommonDevice
{
    /**
     * @return array<string, string|class-string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'devicetype' => 'int',
            'language' => 'string',
            'connectiontype' => 'int',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setDeviceType(int $devicetype): static
    {
        return $this->set('devicetype', $devicetype);
    }

    public function getDeviceType(): ?int
    {
        return $this->get('devicetype');
    }

    public function setLanguage(string $language): static
    {
        return $this->set('language', $language);
    }

    public function getLanguage(): ?string
    {
        return $this->get('language');
    }

    public function setConnectionType(int $connectiontype): static
    {
        return $this->set('connectiontype', $connectiontype);
    }

    public function getConnectionType(): ?int
    {
        return $this->get('connectiontype');
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
