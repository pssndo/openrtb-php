<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\Collection;
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

    /** @var array<string, class-string|array<class-string>|string|int> */
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

    /** @param Collection<string>|array<string> $ifrbust */
    public function setIfrbust(Collection|array $ifrbust): static
    {
        if (is_array($ifrbust)) {
            $ifrbust = new Collection($ifrbust);
        }

        return $this->set('ifrbust', $ifrbust);
    }

    /** @return Collection<string>|null */
    public function getIfrbust(): ?Collection
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

    /** @param Collection<string>|array<string> $mime */
    public function setMime(Collection|array $mime): static
    {
        if (is_array($mime)) {
            $mime = new Collection($mime);
        }

        return $this->set('mime', $mime);
    }

    /** @return Collection<string>|null */
    public function getMime(): ?Collection
    {
        return $this->get('mime');
    }

    /** @param Collection<ApiFramework>|array<ApiFramework> $api */
    public function setApi(Collection|array $api): static
    {
        if (is_array($api)) {
            $api = new Collection($api, ApiFramework::class);
        }

        return $this->set('api', $api);
    }

    /** @return Collection<ApiFramework>|null */
    public function getApi(): ?Collection
    {
        return $this->get('api');
    }

    /** @param Collection<CreativeType>|array<CreativeType> $ctype */
    public function setCtype(Collection|array $ctype): static
    {
        if (is_array($ctype)) {
            $ctype = new Collection($ctype, CreativeType::class);
        }

        return $this->set('ctype', $ctype);
    }

    /** @return Collection<CreativeType>|null */
    public function getCtype(): ?Collection
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

    /** @param Collection<DisplayFormat>|array<DisplayFormat> $displayfmt */
    public function setDisplayfmt(Collection|array $displayfmt): static
    {
        if (is_array($displayfmt)) {
            $displayfmt = new Collection($displayfmt, DisplayFormat::class);
        }

        return $this->set('displayfmt', $displayfmt);
    }

    /** @return Collection<DisplayFormat>|null */
    public function getDisplayfmt(): ?Collection
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

    /** @param Collection<Event>|array<Event> $event */
    public function setEvent(Collection|array $event): static
    {
        if (is_array($event)) {
            $event = new Collection($event, Event::class);
        }

        return $this->set('event', $event);
    }

    /** @return Collection<Event>|null */
    public function getEvent(): ?Collection
    {
        return $this->get('event');
    }
}
