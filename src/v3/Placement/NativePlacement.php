<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\ContextType;
use OpenRTB\v3\Enums\Placement\NativeAdUnit;

class NativePlacement implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'context' => ContextType::class,
        'unit' => NativeAdUnit::class,
        'asset' => [AssetFormat::class],
        'event' => [EventSpec::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setContext(ContextType $context): self
    {
        return $this->set('context', $context);
    }

    public function setPlcmttype(int $plcmttype): self
    {
        return $this->set('plcmttype', $plcmttype);
    }

    public function setUnit(NativeAdUnit $unit): self
    {
        return $this->set('unit', $unit);
    }

    public function setAdunit(int $adunit): self
    {
        return $this->set('adunit', $adunit);
    }

    public function setVer(string $ver): self
    {
        return $this->set('ver', $ver);
    }

    public function setApi(array $api): self
    {
        return $this->set('api', $api);
    }

    public function setAsset(array $asset): self
    {
        return $this->set('asset', $asset);
    }

    public function setEvent(array $event): self
    {
        return $this->set('event', $event);
    }
}
