<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\ContextType;
use OpenRTB\v3\Enums\Placement\NativeAdUnit;

class NativePlacement implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>|array<int>|string>
     */
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

    public function setContext(ContextType $context): static
    {
        return $this->set('context', $context);
    }

    public function setPlcmttype(int $plcmttype): static
    {
        return $this->set('plcmttype', $plcmttype);
    }

    public function setUnit(NativeAdUnit $unit): static
    {
        return $this->set('unit', $unit);
    }

    public function setAdunit(int $adunit): static
    {
        return $this->set('adunit', $adunit);
    }

    public function setVer(string $ver): static
    {
        return $this->set('ver', $ver);
    }

    /** @param Collection<int>|array<int> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', $api);
    }

    /** @param Collection<AssetFormat>|array<AssetFormat> $asset */
    public function setAsset(Collection|array $asset): static
    {
        return $this->set('asset', $asset);
    }

    /** @param Collection<EventSpec>|array<EventSpec> $event */
    public function setEvent(Collection|array $event): static
    {
        return $this->set('event', $event);
    }
}
