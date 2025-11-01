<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Display\Native;

class Display implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'banner' => Banner::class,
        'native' => Native::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setBanner(Banner $banner): self
    {
        return $this->set('banner', $banner);
    }

    public function getBanner(): ?Banner
    {
        return $this->get('banner');
    }

    public function setNative(Native $native): self
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?Native
    {
        return $this->get('native');
    }
}
