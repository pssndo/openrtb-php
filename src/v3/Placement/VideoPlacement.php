<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Impression\DeliveryMethod;
use OpenRTB\v3\Enums\Placement\AdPosition;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Enums\Placement\BoxingAllowed;
use OpenRTB\v3\Enums\Placement\ClickType;
use OpenRTB\v3\Enums\Placement\CompanionType;
use OpenRTB\v3\Enums\Placement\Linearity;
use OpenRTB\v3\Enums\Placement\PlaybackCessationMode;
use OpenRTB\v3\Enums\Placement\PlaybackMethod;
use OpenRTB\v3\Enums\Placement\SizeUnit;
use OpenRTB\v3\Enums\Placement\VideoPlacementType;

class VideoPlacement extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'ptype' => VideoPlacementType::class,
        'pos' => AdPosition::class,
        'playmethod' => [PlaybackMethod::class],
        'playend' => PlaybackCessationMode::class,
        'clktype' => ClickType::class,
        'api' => [ApiFramework::class],
        'ctype' => [CreativeType::class],
        'unit' => SizeUnit::class,
        'delivery' => [DeliveryMethod::class],
        'linear' => Linearity::class,
        'boxing' => BoxingAllowed::class,
        'comp' => [DisplayPlacement::class],
        'comptype' => [CompanionType::class],
    ];

    public function setPtype(VideoPlacementType $ptype): static
    {
        return $this->set('ptype', $ptype);
    }

    public function getPtype(): ?VideoPlacementType
    {
        return $this->get('ptype');
    }

    public function setPos(AdPosition $pos): static
    {
        return $this->set('pos', $pos);
    }

    public function getPos(): ?AdPosition
    {
        return $this->get('pos');
    }

    public function setDelay(int $delay): static
    {
        return $this->set('delay', $delay);
    }

    public function getDelay(): ?int
    {
        return $this->get('delay');
    }

    public function setSkip(int $skip): static
    {
        return $this->set('skip', $skip);
    }

    public function getSkip(): ?int
    {
        return $this->get('skip');
    }

    public function setSkipmin(int $skipmin): static
    {
        return $this->set('skipmin', $skipmin);
    }

    public function getSkipmin(): ?int
    {
        return $this->get('skipmin');
    }

    public function setSkipafter(int $skipafter): static
    {
        return $this->set('skipafter', $skipafter);
    }

    public function getSkipafter(): ?int
    {
        return $this->get('skipafter');
    }

    /** @param list<PlaybackMethod> $playmethod */
    public function setPlaymethod(array $playmethod): static
    {
        return $this->set('playmethod', $playmethod);
    }

    /** @return list<PlaybackMethod>|null */
    public function getPlaymethod(): ?array
    {
        return $this->get('playmethod');
    }

    public function setPlayend(PlaybackCessationMode $playend): static
    {
        return $this->set('playend', $playend);
    }

    public function getPlayend(): ?PlaybackCessationMode
    {
        return $this->get('playend');
    }

    public function setClktype(ClickType $clktype): static
    {
        return $this->set('clktype', $clktype);
    }

    public function getClktype(): ?ClickType
    {
        return $this->get('clktype');
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

    public function setMindur(int $mindur): static
    {
        return $this->set('mindur', $mindur);
    }

    public function getMindur(): ?int
    {
        return $this->get('mindur');
    }

    public function setMaxdur(int $maxdur): static
    {
        return $this->set('maxdur', $maxdur);
    }

    public function getMaxdur(): ?int
    {
        return $this->get('maxdur');
    }

    public function setMaxext(int $maxext): static
    {
        return $this->set('maxext', $maxext);
    }

    public function getMaxext(): ?int
    {
        return $this->get('maxext');
    }

    public function setMinbitr(int $minbitr): static
    {
        return $this->set('minbitr', $minbitr);
    }

    public function getMinbitr(): ?int
    {
        return $this->get('minbitr');
    }

    public function setMaxbitr(int $maxbitr): static
    {
        return $this->set('maxbitr', $maxbitr);
    }

    public function getMaxbitr(): ?int
    {
        return $this->get('maxbitr');
    }

    /** @param list<DeliveryMethod> $delivery */
    public function setDelivery(array $delivery): static
    {
        return $this->set('delivery', $delivery);
    }

    /** @return list<DeliveryMethod>|null */
    public function getDelivery(): ?array
    {
        return $this->get('delivery');
    }

    public function setMaxseq(int $maxseq): static
    {
        return $this->set('maxseq', $maxseq);
    }

    public function getMaxseq(): ?int
    {
        return $this->get('maxseq');
    }

    public function setLinear(Linearity $linear): static
    {
        return $this->set('linear', $linear);
    }

    public function getLinear(): ?Linearity
    {
        return $this->get('linear');
    }

    public function setBoxing(BoxingAllowed $boxing): static
    {
        return $this->set('boxing', $boxing);
    }

    public function getBoxing(): ?BoxingAllowed
    {
        return $this->get('boxing');
    }

    /** @param list<DisplayPlacement> $comp */
    public function setComp(array $comp): static
    {
        return $this->set('comp', $comp);
    }

    /** @return list<DisplayPlacement>|null */
    public function getComp(): ?array
    {
        return $this->get('comp');
    }

    /** @param list<CompanionType> $comptype */
    public function setComptype(array $comptype): static
    {
        return $this->set('comptype', $comptype);
    }

    /** @return list<CompanionType>|null */
    public function getComptype(): ?array
    {
        return $this->get('comptype');
    }
}
