<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Placement\SizeUnit;

class Placement extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'unit' => SizeUnit::class,
        'display' => DisplayPlacement::class,
        'video' => VideoPlacement::class,
        'audio' => AudioPlacement::class,
        'displayfmt' => [DisplayFormat::class],
        'nativefmt' => NativeFormat::class,
        'event' => [Event::class],
    ];

    public function setTagid(string $tagid): static
    {
        return $this->set('tagid', $tagid);
    }

    public function getTagid(): ?string
    {
        return $this->get('tagid');
    }

    public function setSsai(int $ssai): static
    {
        return $this->set('ssai', $ssai);
    }

    public function getSsai(): ?int
    {
        return $this->get('ssai');
    }

    public function setSdk(string $sdk): static
    {
        return $this->set('sdk', $sdk);
    }

    public function getSdk(): ?string
    {
        return $this->get('sdk');
    }

    public function setSdkver(string $sdkver): static
    {
        return $this->set('sdkver', $sdkver);
    }

    public function getSdkver(): ?string
    {
        return $this->get('sdkver');
    }

    public function setReward(int $reward): static
    {
        return $this->set('reward', $reward);
    }

    public function getReward(): ?int
    {
        return $this->get('reward');
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

    public function setDisplay(DisplayPlacement $display): static
    {
        return $this->set('display', $display);
    }

    public function getDisplay(): ?DisplayPlacement
    {
        return $this->get('display');
    }

    public function setVideo(VideoPlacement $video): static
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?VideoPlacement
    {
        return $this->get('video');
    }

    public function setAudio(AudioPlacement $audio): static
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?AudioPlacement
    {
        return $this->get('audio');
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
