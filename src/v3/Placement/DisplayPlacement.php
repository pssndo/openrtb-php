<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\ContextType;
use OpenRTB\v3\Enums\Placement\PlacementType;
use OpenRTB\v3\Enums\Placement\SizeUnit;

class DisplayPlacement implements ObjectInterface
{
    use HasData;

    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'pos' => AdPosition::class,
        'clktype' => ClickType::class,
        'ptype' => PlacementType::class,
        'context' => ContextType::class,
        'api' => [ApiFramework::class],
        'ctype' => [CreativeType::class],
        'unit' => SizeUnit::class,
        'displayfmt' => [DisplayFormat::class],
        'nativefmt' => NativeFormat::class,
        'event' => [Event::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setPos(AdPosition $pos): static
    {
        return $this->set('pos', $pos);
    }

    public function getPos(): ?AdPosition
    {
        return $this->get('pos');
    }

    public function setInstl(int $instl): static
    {
        return $this->set('instl', $instl);
    }

    public function getInstl(): ?int
    {
        return $this->get('instl');
    }

    public function setTopframe(int $topframe): static
    {
        return $this->set('topframe', $topframe);
    }

    public function getTopframe(): ?int
    {
        return $this->get('topframe');
    }

    /** @param list<string> $ifrbust */
    public function setIfrbust(array $ifrbust): static
    {
        return $this->set('ifrbust', $ifrbust);
    }

    /** @return list<string>|null */
    public function getIfrbust(): ?array
    {
        return $this->get('ifrbust');
    }

    public function setClktype(ClickType $clktype): static
    {
        return $this->set('clktype', $clktype);
    }

    public function getClktype(): ?ClickType
    {
        return $this->get('clktype');
    }

    public function setAmpren(int $ampren): static
    {
        return $this->set('ampren', $ampren);
    }

    public function getAmpren(): ?int
    {
        return $this->get('ampren');
    }

    public function setPtype(PlacementType $ptype): static
    {
        return $this->set('ptype', $ptype);
    }

    public function getPtype(): ?PlacementType
    {
        return $this->get('ptype');
    }

    public function setContext(ContextType $context): static
    {
        return $this->set('context', $context);
    }

    public function getContext(): ?ContextType
    {
        return $this->get('context');
    }

    /** @param list<string> $mime */
    public function setMime(array $mime): static
    {
        return $this->set('mime', $mime);
    }

    /** @return list<string>|null */
    public function getMime(): ?array
    {
        return $this->get('mime');
    }

    /** @param list<ApiFramework> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param list<CreativeType> $ctype */
    public function setCtype(array $ctype): static
    {
        return $this->set('ctype', $ctype);
    }

    /** @return list<CreativeType>|null */
    public function getCtype(): ?array
    {
        return $this->get('ctype');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setUnit(SizeUnit $unit): static
    {
        return $this->set('unit', $unit);
    }

    public function getUnit(): ?SizeUnit
    {
        return $this->get('unit');
    }

    public function setPriv(int $priv): static
    {
        return $this->set('priv', $priv);
    }

    public function getPriv(): ?int
    {
        return $this->get('priv');
    }

    /** @param list<DisplayFormat> $displayfmt */
    public function setDisplayfmt(array $displayfmt): static
    {
        return $this->set('displayfmt', $displayfmt);
    }

    /** @return list<DisplayFormat>|null */
    public function getDisplayfmt(): ?array
    {
        return $this->get('displayfmt');
    }

    public function setNativefmt(NativeFormat $nativefmt): static
    {
        return $this->set('nativefmt', $nativefmt);
    }

    public function getNativefmt(): ?NativeFormat
    {
        return $this->get('nativefmt');
    }

    /** @param list<Event> $event */
    public function setEvent(array $event): static
    {
        return $this->set('event', $event);
    }

    /** @return list<Event>|null */
    public function getEvent(): ?array
    {
        return $this->get('event');
    }
}
