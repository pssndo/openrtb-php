<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\SizeUnit;

class Placement implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'display' => DisplayPlacement::class,
        'video' => VideoPlacement::class,
        'audio' => AudioPlacement::class,
        'native' => NativePlacement::class,
        'displayfmt' => [DisplayFormat::class],
        'event' => [Event::class],
        'nativefmt' => NativeFormat::class,
        'unit' => SizeUnit::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setTagid(string $tagid): self
    {
        return $this->set('tagid', $tagid);
    }

    public function getTagid(): ?string
    {
        return $this->get('tagid');
    }

    public function setW(int $w): self
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): self
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setReward(int $reward): self
    {
        return $this->set('reward', $reward);
    }

    public function getReward(): ?int
    {
        return $this->get('reward');
    }

    public function setSsai(int $ssai): self
    {
        return $this->set('ssai', $ssai);
    }

    public function getSsai(): ?int
    {
        return $this->get('ssai');
    }

    public function setSdk(string $sdk): self
    {
        return $this->set('sdk', $sdk);
    }

    public function getSdk(): ?string
    {
        return $this->get('sdk');
    }

    public function setSdkver(string $sdkver): self
    {
        return $this->set('sdkver', $sdkver);
    }

    public function getSdkver(): ?string
    {
        return $this->get('sdkver');
    }

    public function setUnit(SizeUnit $unit): self
    {
        return $this->set('unit', $unit);
    }

    public function getUnit(): ?SizeUnit
    {
        return $this->get('unit');
    }

    public function setPriv(int $priv): self
    {
        return $this->set('priv', $priv);
    }

    public function getPriv(): ?int
    {
        return $this->get('priv');
    }

    public function setNative(NativePlacement $native): self
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?NativePlacement
    {
        return $this->get('native');
    }

    public function setDisplay(DisplayPlacement $display): self
    {
        return $this->set('display', $display);
    }

    public function getDisplay(): ?DisplayPlacement
    {
        return $this->get('display');
    }

    public function setVideo(VideoPlacement $video): self
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?VideoPlacement
    {
        return $this->get('video');
    }

    public function setAudio(AudioPlacement $audio): self
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?AudioPlacement
    {
        return $this->get('audio');
    }

    public function setNativefmt(NativeFormat $nativefmt): self
    {
        return $this->set('nativefmt', $nativefmt);
    }

    public function getNativefmt(): ?NativeFormat
    {
        return $this->get('nativefmt');
    }

    /**
     * @param list<DisplayFormat> $displayfmt
     */
    public function setDisplayfmt(array $displayfmt): self
    {
        return $this->set('displayfmt', $displayfmt);
    }

    /**
     * @return list<DisplayFormat>|null
     */
    public function getDisplayfmt(): ?array
    {
        return $this->get('displayfmt');
    }

    /**
     * @param list<Event> $event
     */
    public function setEvent(array $event): self
    {
        return $this->set('event', $event);
    }

    /**
     * @return list<Event>|null
     */
    public function getEvent(): ?array
    {
        return $this->get('event');
    }
}
